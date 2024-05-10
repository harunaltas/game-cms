<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayerSicil extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public function players()
    {
        return $this->belongsTo(Player::class, 'gamer_id','gamer_id');
    }
}
