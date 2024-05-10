<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
     /**
     * Bu mesajı gönderen kullanıcıyla ilişki.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Bu mesajın gönderildiği oyuncuyla ilişki.
     */
    public function player()
    {
        return $this->belongsTo('App\Models\Player', 'player_id');
    }
}
