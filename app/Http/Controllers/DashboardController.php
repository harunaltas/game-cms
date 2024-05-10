<?php

namespace App\Http\Controllers;

use App\Models\BannedPlayer;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPlayers = Player::count();
        $totalAdmins = User::count(); // 'role' sütunu varsayım üzerine eklenmiştir, gerçek sütun adına göre değiştirin.
        $totalBannedPlayers = BannedPlayer::where('status', 1)->count();

        return view('dashboard.dashboard', compact('totalPlayers', 'totalAdmins', 'totalBannedPlayers'));
    }
}
