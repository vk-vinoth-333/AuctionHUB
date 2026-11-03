<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tournament extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "short_code",
        "description",
        "start_date",
        "end_date",
        "venue",
        "city",
        "total_teams",
        "prize_amount",
        "is_pr_free",
        "pr_amount",
        "status",
        "organizer_id",
        "logo",
    ];


    public function players()
    {
        return $this->hasMany(Player::class);
    }
}
