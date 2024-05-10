<?php

namespace App\Http\Controllers;

use App\Models\{PlayerSicil, BannedPlayer, WarningPlayer, Message, Player, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataResetController extends Controller
{
    public function resetPlayerSicils()
    {
        PlayerSicil::truncate();
        return redirect()->back()->with('success', 'Tüm Sicil Kayıtları Sıfırlandı.');
    }

    public function resetBannedPlayers()
    {
        BannedPlayer::truncate();
        return redirect()->back()->with('success', 'Tüm Ban Kayıtları Sıfırlandı.');
    }

    public function unbanAllPlayers()
    {
        BannedPlayer::query()->update(['status' => 0]);
        return redirect()->back()->with('success', 'Tüm Banlar Kaldırıldı.');
    }

    public function resetWarningPlayers()
    {
        WarningPlayer::truncate();
        return redirect()->back()->with('success', 'Tüm Uyarı Kayıtları Sıfırlandı.');
    }

    public function resetMessages()
    {
        Message::truncate();
        return redirect()->back()->with('success', 'Tüm Mesajlar Sıfırlandı.');
    }

    public function deleteUserExceptAdmin()
    {
        User::where('id', '!=', 1)->delete();
        return redirect()->back()->with('success', 'Tüm Kullanıcılar Silindi (Admin Hariç).');

    }
    


    public function resetPlayers()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Player::truncate();
        // Diğer ilişkili tabloları da burada truncate edebilirsiniz.
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        return redirect()->back()->with('success', 'Tüm Oyuncular Silindi.');
    }
    

}

