<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tournament extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'short_code',
        'description',
        'start_date',
        'end_date',
        'venue',
        'city',
        'total_teams',
        'total_pools',
        'players_per_team',
        'prize_amount',
        'base_point',
        'is_pr_free',
        'pr_amount',
        'status',
        'registration_open',
        'registration_ends_at',
        'payment_qr_code',
        'upi_id',
        'contact_phone',
        'organizer_id',
        'logo',
    ];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function players()
    {
        return $this->hasMany(Player::class);
    }
}
