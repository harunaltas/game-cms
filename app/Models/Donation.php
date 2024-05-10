<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public function player()
    {
        return $this->belongsTo(Player::class);
    }

}
