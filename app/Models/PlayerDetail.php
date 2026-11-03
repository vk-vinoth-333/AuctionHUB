<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'city',
        'role',
        'batting_style',
        'bowling_style',
        'original_proof',
        'base_price',
        'sold_price',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ((int) $this->role) {
            1 => __('batsman'),
            2 => __('bowler'),
            3 => __('wicket_keeper'),
            4 => __('all_rounder'),
            default => 'N/A',
        };
    }
}
