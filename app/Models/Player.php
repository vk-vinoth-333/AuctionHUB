<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'tournament_id',
        'name',
        'player_number',
        'photo',
        'role',
        'bowling_style',
        'original_proof',
        'payment_screenshot',
        'player_status',
        'payment_status',
        'status',
        'description',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function detail()
    {
        return $this->hasOne(PlayerDetail::class);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'batsman'       => __('Batsman'),
            'bowler'        => __('Bowler'),
            'wicket_keeper' => __('Wicket Keeper'),
            'all_rounder'   => __('All-Rounder'),
            default         => '-',
        };
    }

    public function getBowlingStyleLabelAttribute(): string
    {
        return match ($this->bowling_style) {
            'right' => __('Right'),
            'left'  => __('Left'),
            default => 'N/A',
        };
    }
}
