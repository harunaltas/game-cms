<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannedPlayer extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function banType()
    {
            return $this->belongsTo(BanType::class, 'ban_type_id');
    }
    public function banTime()
    {
            return $this->belongsTo(BanTime::class, 'ban_time_id');
    }
    

}
