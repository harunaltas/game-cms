<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Player;
use Illuminate\Support\Facades\File;

class LogViewerController extends Controller
{
    public function index()
    {
        $logPaths = [
            'user_actions' => storage_path('logs/user_actions.log'),
            'login_logout' => storage_path('logs/login_logout.log'),
            'system_logs' => storage_path('logs/system_logs.log'),
            'ban_operations' => storage_path('logs/ban_operations.log'),
            'exception_operations' => storage_path('logs/exception_operations.log'),
        ];
    
        $logs = [];
        foreach ($logPaths as $key => $path) {
            if (File::exists($path)) {
                $fileLines = explode("\n", File::get($path));
                foreach ($fileLines as $line) {
                    if (empty($line)) continue;
                    
                    // Esnek regex ile hem string hem integer, hem var hem yok durumlarını ele al
                    $matches = [];
                    preg_match('/user_id":("?\d+"?)/', $line, $userMatches);
                    preg_match('/player_id":("?\d+"?)/', $line, $playerMatches);
    
                    $userId = $userMatches[1] ?? null;
                    $playerId = $playerMatches[1] ?? null;
    
                    // String olarak alınan ID'leri integer'a çevir
                    $userId = trim($userId, '"');
                    $playerId = trim($playerId, '"');
    
                    $user = $userId ? User::find($userId) : null;
                    $player = $playerId ? Player::find($playerId) : null;
    
                    $userName = $user ? $user->name : 'Bilinmeyen Kullanıcı';
                    $playerNick = $player ? $player->player_nick : '- Oyuncu İşlemi Yok';
    
                    // Eğer kullanıcı veya oyuncu bilgisi varsa log mesajını formatla
                    if ($user || $player) {
                        $formattedLine = preg_replace('/\{.*\}/', "- $userName - $playerNick", $line);
                        $logs[$key][] = $formattedLine;
                    } else {
                        $logs[$key][] = $line;
                    }
                }
            }
        }
    
        return view('pages.logs.logs', compact('logs'));
    }
    
}
