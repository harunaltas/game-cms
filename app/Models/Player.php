<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Player extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = [
        'password',
    ];
    public $timestamps = false;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($player) {
            $player->gamer_id = Str::uuid(); // Her yeni kullanıcı için bir UUID atayın
        });
    }
            /**
         * Bu oyuncuya gönderilen mesajlarla ilişki.
         */
        public function messages()
        {
            return $this->hasMany('App\Models\Message', 'player_id');
        }
        public function bans()
        {
            return $this->hasMany(BannedPlayer::class);
        }
        public function sicils()
        {
            return $this->hasMany(PlayerSicil::class, 'gamer_id','gamer_id');
        }

// Banlı oyuncuları çeken bir sorgu kapsamı
public function scopeCurrentlyBanned($query)
{
    return $query->whereHas('bans', function ($query) {
        $query->where('status', true); // Aktif banları olan oyuncular
    })->with(['bans' => function ($query) {
        $query->where('status', true); // Oyuncuların aktif ban bilgilerini getir
    }]);
}
public function scopeNotCurrentlyBanned($query)
{
    return $query->whereDoesntHave('bans', function ($subQuery) {
        $subQuery->where('status', 1); // Şu anda aktif bir banı olmayan oyuncular
    });
}


// Banlı olmayan oyuncuları çeken bir sorgu kapsamı
public function scopeNotBanned($query)
{
    return $query->whereDoesntHave('bans', function ($query) {
        $query->where('status', true);
    });
}
        public function warnings()
        {
            return $this->hasMany(WarningPlayer::class);
        }
        public function nickHistories()
        {
            return $this->hasMany(PlayerNickHistory::class, 'gamer_id', 'gamer_id');
        }
}
