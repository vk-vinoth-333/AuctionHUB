<?php

namespace App\Jobs;

use App\Models\RSS;
use App\Services\XMLService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchRssFeedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $timeout = 10;
    public $tries = 3;
    protected $rss;

    /**
     * Create a new job instance.
     */
    public function __construct(RSS $rss)
    {
        $this->rss = $rss;
    }

    /**
     * Execute the job.
     */
    public function handle(): Collection
    {
        $items = collect();

        if (!$this->rss || !$this->rss->feed_url) {
            Log::warning('RSS feed missing or invalid', ['rss_id' => $this->rss->id ?? null]);
            return $items;
        }

        $this->fetchFeedItems($this->rss, $items);

        return $items;
    }

    /**
     * Fetch feed items from RSS source
     */
    private function fetchFeedItems(RSS $rss, Collection &$items): void
    {
        try {
            $response = Http::timeout(10)->get($rss->feed_url);

            if (!$response->successful()) {
                Log::warning('RSS request failed', ['url' => $rss->feed_url, 'rss_id' => $rss->id]);
                return;
            }

            $contentType = $response->header('Content-Type');
            if (!str_contains($contentType, 'xml')) {
                Log::warning('Invalid RSS content type', ['url' => $rss->feed_url, 'rss_id' => $rss->id]);
                return;
            }

            // Clean XML content before parsing
            $xmlContent = XMLService::cleanXmlContent($response->body());
            $xml = simplexml_load_string(
                $xmlContent,
                'SimpleXMLElement',
                LIBXML_NOCDATA
            );

            if (!isset($xml->channel->item)) {
                return;
            }

            // Load relationships
            $rss->load(['category', 'sub_category', 'language']);

            foreach ($xml->channel->item as $item) {
                $image = $this->extractImage($item);
                $pubDate = isset($item->pubDate) ? (string) $item->pubDate : null;
                $date = $pubDate ? date('Y-m-d H:i:s', strtotime($pubDate)) : date('Y-m-d H:i:s');
                $publishedDate = $pubDate ? date('Y-m-d H:i:s', strtotime($pubDate)) : null;

                $items->push([
                    'id' => null,
                    'rss_feed_id' => $rss->id,
                    'rss_feed_name' => $rss->feed_name ?? '',
                    'title' => (string) $item->title,
                    'description' => (string) $item->description,
                    'link' => (string) $item->link,
                    'pubDate' => $pubDate,
                    'image' => $image,
                    'content_type' => 'rss_feed',
                    'content_value' => (string) $item->link,
                    'category_id' => $rss->category_id ?? 0,
                    'category_name' => $rss->category && $rss->category->category_name ? $rss->category->category_name : '',
                    'subcategory_id' => $rss->subcategory_id ?? 0,
                    'subcategory_name' => $rss->sub_category && $rss->sub_category->subcategory_name ? $rss->sub_category->subcategory_name : '',
                    'language_id' => $rss->language_id ?? 0,
                    'date' => $date,
                    'published_date' => $publishedDate,
                    'status' => 1,
                    'is_draft' => 0,
                    'is_comment' => 0,
                    'location_id' => 0,
                    'total_like' => 0,
                    'total_views' => 0,
                    'total_comments' => 0,
                    'is_bookmark' => 0,
                    'images' => [],
                ]);
            }

            // Cache individual RSS feed items for 30 minutes
            // This allows queue-dispatched jobs to also cache their results
            Cache::store(config('cache.default'))->put(
                "rss_feed_{$rss->id}",
                $items->values(),
                now()->addMinutes(30)
            );

        } catch (\Throwable $e) {
            Log::error('RSS parsing error', [
                'url' => $rss->feed_url,
                'rss_id' => $rss->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Extract image from RSS item
     */
    private function extractImage($item): string
    {
        if (isset($item->enclosure)) {
            $type = (string) $item->enclosure->attributes()->type;
            if (in_array($type, ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'])) {
                return (string) $item->enclosure->attributes()->url;
            }
        }

        return '';
    }
}
