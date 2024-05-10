<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\PlayerSicil;
use App\Models\WarningPlayer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WarningPlayerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show warning', ['only' => ['index', 'show']]);
        $this->middleware('permission:delete warning', ['only' => ['destroy']]);
        $this->middleware('permission:send warning', ['only' => ['create', 'store']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('pages.players.warningPlayer');
    }
    public function createWithPlayer(Player $player){
        return view('pages.players.warningPlayer', compact('player'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'warning_image' => 'nullable|image',
        ]);
        $isAlreadyWarned = WarningPlayer::where('player_id', $request->player_id)
                                     ->where('status', 1)
                                     ->exists();

    if ($isAlreadyWarned) {
        // Eğer oyuncunun aktif bir uyarısı varsa, işlemi durdur ve geri dön
        return redirect()->back()->with('error', 'Bu Oyuncu Zaten Uyarılmış ve Uyarı Aktif.');
    }
        $warningImage = $request->hasFile('warning_image') ? $request->file('warning_image')->store('public/warning_images') : null;
        $player = Player::find($request->player_id);
        WarningPlayer::create([
            'user_id' => auth()->id(),
            'player_id' => $request->player_id,
            'gamer_id' => $player->gamer_id,
            'description' => $request->description,
            'warning_image' => $warningImage,
        ]);

        PlayerSicil::create([
            'admin' => auth()->user()->name,
            'gamer_id' => $player->gamer_id,
            'gamer_name' => $player->updated_nick ?? $player->player_nick,
            'ban_time' => "Süresiz",
            'warning_message' => $request->description,
            'sicil_date' => Carbon::now(),
            'status' => "Uyarı",
            'info' => 1,
        ]);
    
        return redirect()->route('players.show',$player)->with('success', 'Uyarı başarıyla verildi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $warning = WarningPlayer::findOrFail($id);
        
        // Uyarıyı silme işlemi
        if ($warning->delete()) {   
            // AJAX isteği kontrolü
            if ($request->ajax()) {
                return response()->json(['message' => 'Uyarı başarıyla kaldırıldı.']);
            }
    
            // Normal istek için geri yönlendirme ve başarı mesajı
            return redirect()->back()->with('success', 'Uyarı başarıyla kaldırıldı.');
        } else {
            // Silme işlemi başarısız olursa
            if ($request->ajax()) {
                return response()->json(['message' => 'Uyarı silinirken bir hata oluştu.'], 500);
            }
    
            return redirect()->back()->with('error', 'Uyarı silinirken bir hata oluştu.');
        }
    }
    
}
