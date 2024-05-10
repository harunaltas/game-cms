<?php

namespace App\Http\Controllers;

use App\Models\BannedPlayer;
use App\Models\BanTime;
use App\Models\BanType;
use App\Models\Player;
use App\Models\PlayerSicil;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class BannedPlayerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show banned_player', ['only' => ['index', 'show']]);
        $this->middleware('permission:add banned_player', ['only' => ['store','createWithPlayer']]);
        $this->middleware('permission:delete banned_player', ['only' => ['destroy']]);
        $this->middleware('permission:update banned_player', ['only' => ['edit', 'update']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $query = BannedPlayer::with(['player','user', 'banType', 'banTime'])->where("status",1)->orderBy('id','desc');
    
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('player_nick', function ($ban) {
                    return $ban->player ? $ban->player->player_nick : 'Oyuncu Bulunamadı';
                })
   
                ->addColumn('description', function ($ban) {
                    // Ban açıklaması
                    return $ban->description;
                })
   
                ->addColumn('banned_date', function ($ban) {
                    // Ban tarihi
                    return Carbon::parse($ban->banned_date)->format('d.m.y');
                })
                ->addColumn('status', function ($ban) {
                    // Ban durumu
                    return $ban->status ? 'Banlı' : 'Ban Süresi Geçmiş';
                })
                ->addColumn('actions', function ($ban) {
                    $editUrl = route('banned-players.edit', $ban);
                    // İşlemler için butonlar
                    $actions = "<div class='d-flex align-items-end justify-content-start gap-2'>"; // Başlangıçta actions boş bir string

                    // Ban durumuna göre buton ekleyelim
                    if ($ban->status == 1) {
                        // Eğer ban aktifse, "Ban Kaldır" butonunu ekleyelim
                        $actions .= "<button class='btn btn-sm btn-primary unban-player bg-gradient-dark' data-id='{$ban->id}'>Ban Kaldır</button>";
                    }
                    else {
                        $actions .= "<button class='btn btn-sm  bg-gradient-dark' disabled>Ban Kaldır</button>";
                    }
                    // Her durumda "Ban Detay" butonunu ekleyelim
                    $actions .= "<button class='btn btn-sm btn-info ban-detail bg-gradient-dark' data-id='{$ban->id}'>Ban Detay</button>";
                    $actions .= "<a href='{$editUrl}' class='btn btn-sm bg-gradient-dark' data-id='{$ban->id}'>Güncelle</a>";
                    $actions .= "</div>";
                    return $actions;   
                })
                ->rawColumns(['actions','banned_date'])
                ->make(true);
        }
        Log::channel('ban_operations')->info('Banlanan oyuncular listelendi', ['user_id' => auth()->id()]);
        return view('pages.players.bannedPlayers');
    }

    
    public function showBannedPlayers()
    {
        $bannedPlayers = Player::banned()->get();
        Log::channel('ban_operations')->info('Banlanan oyuncular listelendi', ['user_id' => auth()->id()]);
        return view('players.banned', compact('bannedPlayers'));
    }

    // Banlı olmayan oyuncuları gösteren metod
    public function showNotBannedPlayers(Request $request)
    {
        if ($request->ajax()) {
            $notBannedPlayers = Player::get();
            return DataTables::of($notBannedPlayers)
                ->addIndexColumn()
                ->addColumn('actions', function($row){
            
                        $banUrl = route('banned-players.createWithPlayer', $row);
                        $warningUrl = route('warning-players.createWithPlayer', $row);
                        $dropdown = <<<HTML
                                <div class="">
                                <a href={$banUrl} class="btn bg-gradient-dark " >
                                    Ban At
                                </a> 
                                <a href={$warningUrl} class="btn bg-gradient-dark ">
                                    Uyarı Ver
                                </a>
                                <Button class="btn bg-gradient-dark show-sicil" data-id='{$row->gamer_id}'>
                                    Sicil Görüntüle
                                </Button>
                                </div>
                                HTML;
                        return $dropdown;
                })
               ->rawColumns(['actions'])
                ->make(true);
        }
        Log::channel('ban_operations')->info('Banlanmayan oyuncular listelendi', ['user_id' => auth()->id()]);
        return view('pages.players.not-banned-players');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $bantypes = BanType::all();
        $players = Player::all();
        Log::channel('ban_operations')->info('Oyuncu banlama sayfası açıldı', ['user_id' => auth()->id()]);
        return view('pages.players.banPlayer', compact('players','bantypes'));
    }
    public function createWithPlayer(Player $player) {
        $bantypes = BanType::all();
        $bantimes = BanTime::all();
        $players = Player::all();
        Log::channel('ban_operations')->info('Oyuncu banlama sayfası açıldı', ['user_id' => auth()->id()]);
        return view('pages.players.banPlayer', compact('players','bantypes','bantimes','player'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
 

        $request->validate([
            'ban_type_id' => 'required',
            'ban_time_id' => 'required',
            'description' => 'nullable|string',
            'ban_image' => 'nullable|image',
        ]);
        // Oyuncunun zaten banlanıp banlanmadığını kontrol et
        $isAlreadyBanned = BannedPlayer::where('player_id', $request->player_id)
        ->where('status', true)
        ->exists();

        if ($isAlreadyBanned) {
        return redirect()->back()->with('error', 'Bu Oyuncu Zaten Banlı.');
        }
        if($request->ban_type_id == "0") {
            return redirect()->back()->with('error', 'Geçerli bir ban türü seçin');
        }
        $player = Player::find($request->player_id);
        $nickName = $player->updated_nick ?? $player->player_nick;
        $bannedDateInput = $request->input('banned_date');

        $bannedDate = $bannedDateInput ? Carbon::parse($bannedDateInput)->format('d.m.y') : Carbon::now()->format('d.m.y');
    
        // Resim ismini oluştur
        $imageName = null;
        if ($request->hasFile('ban_image')) {
            $extension = $request->file('ban_image')->getClientOriginalExtension();
            $imageName = $nickName . '_' . $bannedDate . '.' . $extension;
            // Resmi kaydet
            $path = $request->file('ban_image')->storeAs('public/ban_images', $imageName);
            $imageName = 'ban_images/' . $imageName; // Veritabanında saklamak için yolu düzenle
        }
        BannedPlayer::create([
            'user_id' => auth()->id(),
            'player_id' => $request->player_id,
            'gamer_id' => $player->gamer_id,
            'ban_type_id' => $request->ban_type_id,
            'ban_time_id' => $request->ban_time_id,
            'description' => $request->description,
            'ban_image' => $imageName,
             'banned_date' => $bannedDate,
        ]);
      
        $bantime = BanTime::find($request->ban_time_id);
        $status = BanType::find($request->ban_type_id);
        PlayerSicil::create([
            'admin' => auth()->user()->name,
            'gamer_id' => $player->gamer_id,
            'gamer_name' => $player->updated_nick ?? $player->player_nick,
            'ban_time' => $bantime->title,
            'warning_message' => $request->description,
            'sicil_date' => $request->banned_date ?? Carbon::now(),
            'status' => $status->title,
            'info' => 3,
        ]);
        Log::channel('ban_operations')->info('Oyuncu banlandı', ['user_id' => auth()->id(), 'player_id' => $request->player_id]);
        return redirect()->route('players.show',$player->id)->with('success', 'Oyuncu başarıyla banlandı.');
    }

    /**
     * Display the specified resource.
     */


    public function show($id)
    {
        $bannedPlayer = BannedPlayer::with(['player', 'user', 'banType', 'banTime'])
                            ->findOrFail($id);
    
        // Ban tarihi ve süresini kullanarak banın bitiş tarihini hesaplayalım
        $banStartDate = Carbon::parse($bannedPlayer->banned_date);
        $banEndDate = $banStartDate->copy()->addDays($bannedPlayer->banTime->duration ?? 0);
        $currentDate = Carbon::now();
    
        // Banın durumunu kontrol edelim
        $isBanActive = $bannedPlayer->status == 1 && $banEndDate->isFuture();
    
        return response()->json([
            'success' => true,
            'data' => [
                'playerNick' => $bannedPlayer->player->updated_nick ?? $bannedPlayer->player->player_nick,
                'email' => $bannedPlayer->player->email ?? "Email Yok",
                'banImage' => $bannedPlayer->ban_image ? Storage::url($bannedPlayer->ban_image) : null,
                'issuer' => $bannedPlayer->user->name ?? 'Bilinmiyor',
                'description' => $bannedPlayer->description,
                'banType' => $bannedPlayer->banType->title ?? 'Bilinmiyor',
                'banDuration' => $bannedPlayer->banTime->title ?? 'Bilinmiyor',
                'bannedDate' => $bannedPlayer->banned_date,
                'isBanActive' => $isBanActive,
                'banStatus' => $isBanActive ? 'Ban Aktif' : 'Ban Süresi Geçmiş/Kaldırılmış',
                'banDescription' => $bannedPlayer->description,
            ]
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BannedPlayer $bannedPlayer)
    {
        // İlişkili Player modelini direkt olarak al
        $player = $bannedPlayer->player;
    
        $bantypes = BanType::all();
        $bantimes = BanTime::all();
    
        // $bannedPlayer zaten parametre olarak alındığı için tekrar sorgulamaya gerek yok
        $ban = $bannedPlayer;
        Log::channel('ban_operations')->info('Ban düzenleme sayfası açıldı', ['user_id' => auth()->id(), 'player_id' => $player->id]);
        return view('pages.players.updateBannedPlayer', compact('player', 'bantypes', 'bantimes', 'ban'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, BannedPlayer $bannedPlayer)
    {
        $validatedData = $request->validate([
            'ban_type_id' => 'required',
            'ban_time_id' => 'required',
            'description' => 'nullable',
            'banned_date' => 'required|date',
            'ban_image' => 'nullable|image|max:2048', // Örnek dosya boyutu sınırlaması
        ]);
    
        // Ban resmi varsa işle
        if ($request->hasFile('ban_image')) {
            // Eski resmi sil
            if ($bannedPlayer->ban_image) {
                Storage::delete($bannedPlayer->ban_image);
            }
            
            // Yeni resmi kaydet
          
            $validatedData['ban_image'] = $request->file('ban_image')->store('public/ban_images');
        }
    
        // Güncelleme işlemini gerçekleştir
        $bannedPlayer->update([
            'ban_type_id' => $validatedData['ban_type_id'],
            'ban_time_id' => $validatedData['ban_time_id'],
            'description' => $validatedData['description'],
            'banned_date' => $validatedData['banned_date'],
            // Eğer yeni bir resim yüklenmediyse, 'ban_image' anahtarını güncelleme dizisine eklemeyin
        ] + (isset($validatedData['ban_image']) ? ['ban_image' => $validatedData['ban_image']] : []));
    
        // İşlem başarılıysa, ilgili sayfaya yönlendir
        Log::channel('ban_operations')->info('Oyuncu Banlandı', ['user_id' => auth()->id(), 'player_id' => $bannedPlayer->id]);
        return redirect()->back()->with('success', 'Ban bilgileri başarıyla güncellendi.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
public function unban(Request $request, $id)
{
    $ban = BannedPlayer::findOrFail($id);
    $ban->status = 0;
    $ban->save();

    Log::channel('ban_operations')->info('Oyuncu ban kaldırıldı', ['user_id' => auth()->id(), 'player_id' => $id]);

    // AJAX isteği kontrolü
    if($request->ajax()) {
        return response()->json(['message' => 'Ban başarıyla kaldırıldı.']);
    }

    // Normal istek için geri yönlendirme
    return redirect()->back()->with('success', 'Ban başarıyla kaldırıldı.');
}
    public function destroy(BannedPlayer $bannedPlayer)
    {
        //
    }
}
