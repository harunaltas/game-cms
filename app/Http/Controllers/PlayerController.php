<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlayerStoreRequest;
use App\Http\Requests\PlayerUpdateRequest;
use App\Models\Player;
use App\Models\PlayerNickHistory;
use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Config;
class PlayerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:add players', ['only' => ['create', 'store']]);
        $this->middleware('permission:update players', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete players', ['only' => ['destroy']]);
        $this->middleware('permission:show exceptions', ['only' => ['ExceptionsIndex']]);
        $this->middleware('permission:add exceptions', ['only' => ['updateException']]);
        // 'index' ve 'show' metodları için özel bir izin tanımlanmadı, genel erişim kontrolü için auth middleware kullanılabilir.
    }
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Player::with('bans')->orderBy('id','desc');
    
            $dataTable = DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('display_nick', function ($player) {
                    // Eğer updated_nick varsa bu değeri, yoksa player_nick'i kullan
                    return $player->updated_nick ?? $player->player_nick;
                })
                ->addColumn('is_banned', function($row){
                    // Oyuncunun ban kaydını kontrol et
                    return $row->bans->isNotEmpty() ? 'Banlı' : 'Banlı Değil';
                })
                ->addColumn('actions', function($row){
                    // Önceden belirlenen işlem URL'leri
                    $editUrl = route('players.edit', $row);
                    $banUrl = route('banned-players.createWithPlayer', $row);
                    $warningUrl = route('warning-players.createWithPlayer', $row);
                    $showUrl = route('players.show',$row);
                    $playerId = $row->id;
    
                    // Dropdown menüsü için HTML
                    $dropdown = <<<HTML
                            <div class="dropdown">
                            <button class="btn bg-gradient-dark dropdown-toggle" type="button" id="dropdownMenuButton{$playerId}" data-bs-toggle="dropdown" aria-expanded="false">
                                İşlemler
                            </button>
                            <ul class="dropdown-menu text-white" aria-labelledby="dropdownMenuButton{$playerId}">
                            <li><a class="dropdown-item text-white" href="{$showUrl}">Detay</a></li>
                            <li><button class="dropdown-item nick-settings text-white" data-id="{$playerId}">Nick Ayarları</button></li>
                                <li><a class="dropdown-item text-white" href="{$editUrl}">Düzenle</a></li>
                                <li><a class="dropdown-item player-delete text-white" href="javascript:void(0);" data-id="{$playerId}">Sil</a></li>
                            </ul>
                            </div>
                            HTML;
                    return $dropdown;
                })
                ->addColumn('last_login_dates', function ($row) {
                    // Tarihi istediğiniz formata dönüştürün
                    return Carbon::parse($row->last_login_dates)->format('d.m.Y');
                })
                ->addColumn('nick_update_dates', function ($row) {
                    // Tarihi istediğiniz formata dönüştürün
                    if($row->nick_update_dates)
                    {
                        return Carbon::parse($row->nick_update_dates)->format('d.m.Y');
                    }
                 
                })
                ->rawColumns(['actions','display_nick','nick_update_dates']);
    
            // display_nick üzerinde özel arama filtresi ekleyin
            if ($searchValue = $request->get('search')['value']) {  
                $dataTable->filter(function ($query) use ($searchValue) {
                    $query->where('player_nick', 'like', "%{$searchValue}%")
                          ->orWhere('updated_nick', 'like', "%{$searchValue}%");
                    // Diğer alanlarda arama yapmak için ek where koşulları ekleyebilirsiniz
                });
            }
    
            return $dataTable->make(true);
        }
    
        return view('pages.players.players');
    }
    
    public function ExceptionsIndex(Request $request) {
        if($request->ajax()) {
            $players = Player::where('exception', '!=', '3')->get();
            return DataTables::of($players)
            ->addIndexColumn()
            ->addColumn('exception_status', function($row){
                switch ($row->exception) {
                    case 1:
                        return 'Tek kullanımlık';
                    case 2:
                        return 'Sınırsız';
                    default:
                        return 'İstisna Yok'; // Varsayılan değer olarak "Normal" kullanıldı
                }
            })
            ->addColumn('actions', function($row){
                $editUrl = route('players.edit', $row->id); // Düzenleme sayfasının URL'si
                return "<a class='btn btn-sm bg-gradient-dark exception-update-modal' data-id='{$row->id}'>Düzenle</a> " .
                       "<button class='btn btn-sm bg-gradient-dark exception-update' data-id='{$row->id}' data-exception-value='3'>Kaldır</button>";
            })
            ->rawColumns(['exception_status', 'actions'])
            ->make(true);
        }
        Log::channel('exception_operations')->info('İstisnalar Görüntülendi', ['user_id' => auth()->id()]);
        return view('pages.players.exceptions');
    }
    
    public function updateException(Request $request, $id)
{
    // Güvenlik için, istisna değerinin doğrulanması gerekir
    $player = Player::findOrFail($id);
    // İstisna alanını güncelle
    $player->update([
        'exception' => $request->exception, // 'exception_field' alanını request'ten gelen değerle güncelle
    ]);
    // İşlem başarılıysa, bir yanıt döndür
    Log::channel('exception_operations')->info('İstisna Eklendi', ['user_id' => auth()->id(),'player_id' => $player->id]);
    return response()->json(['success' => $player->player_nick.' Nickli Oyuncunun Nick İstisnası Güncellendi']);
}
    
    
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $questions = Question::all();
        return view('pages.players.addPlayer',compact('questions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function AefnetHash($Veri)
    {
        $plaintext = $Veri;
        $password = Config::get('AefnetConfig.WebHashPassword'); //'RedAlert2AefnetTR-2023';
        $method = 'aes-256-cbc';
        $key = substr(hash('sha256', $password, true), 0, 32);
        $pad = null;
        $iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
        $encrypted = openssl_encrypt($plaintext, $method, $key, OPENSSL_RAW_DATA, $iv);
        $Veri1 = $encrypted;
        $Data = str_replace(array('/', '+'), array('_', '$'), base64_encode($Veri1));
        if (!$pad) {
            $Data = rtrim($Data, '=');
        }
        return $Data;
    }
    public function store(PlayerStoreRequest $request)
    {
        // Doğrulanmış verileri al
        $validated = $request->validated();
    
        // Şifreyi AefnetHash fonksiyonu ile hash'le
        $hashedPassword = $this->AefnetHash($validated['password']);
    
        // Oyuncuyu veritabanına kaydet
        $player = Player::create([
            'player_nick' => $validated['player_nick'],
            'updated_name' => $validated['player_nick'],
            'nick_update_dates' => Carbon::now()->format('d.m.Y h:i:s'),
            'email' => $validated['email'],
            'password' => $hashedPassword,
            'security_question' => $validated['security_question'],
            'security_answer' => $validated['security_answer'],
        ]);
        $playerNickHistory = PlayerNickHistory::create([
            'gamer_id' => $player->gamer_id,
            'new_player_nick' => $player->player_nick,
        ]);
        // Başarılı kayıttan sonra kullanıcıyı yönlendir
        Log::channel('user_actions')->info('Player eklendi', ['user_id' => auth()->id(), 'player_id' => $player->id]);
        return redirect()->route('players.index')->with('success', 'Kullanıcı başarıyla kaydedildi.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $player)
    {
              // Player modelini ve ilişkili tüm modelleri çek
              $player = Player::with(['bans' => function($query){
                $query->where('status', 1)->with('banType', 'banTime');
            }, 'warnings', 'messages.user', 'nickHistories', 'sicils'])
        ->findOrFail($player->id);
 
            // $player ve ilişkili verileri view'a döndür
            Log::channel('user_actions')->info('Player Detay Görüntülendi', ['user_id' => auth()->id(), 'player_id' => $player->id]);
            return view('pages.players.showPlayer', compact('player'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $player)
    {
        $questions = Question::all();
        Log::channel('user_actions')->info('Player Güncelleme Sayfası Açıldı', ['user_id' => auth()->id(), 'player_id' => $player->id]);
        return view('pages.players.updatePlayer', compact('player', 'questions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlayerUpdateRequest $request, Player $player)
    {
        $validatedData = $request->validated();
    
        if (!empty($validatedData['password'])) {
            // Şifre alanı doluysa, AefnetHash fonksiyonu ile hash'le
            $validatedData['password'] = $this->AefnetHash($validatedData['password']);
        } else {
            // Şifre alanı boşsa, şifreyi güncelleme listesinden çıkar
            unset($validatedData['password']);
        }
    
        // Nick değişikliğini kontrol et
        if (isset($validatedData['player_nick']) && $validatedData['player_nick'] != $player->player_nick) {
            // Nick değişikliği varsa, tarihçeye ekle
            PlayerNickHistory::create([
                'gamer_id' => $player->gamer_id, // veya 'gamer_id' => $player->gamer_id, eğer 'id' yerine 'gamer_id' kullanılıyorsa
                'new_player_nick' => $validatedData['player_nick'],
            ]);
            $validatedData['nick_update_dates'] = Carbon::now()->format('d.m.Y h:i:s');
        }
    
        // Diğer güncellenen verilerle birlikte oyuncu bilgilerini güncelle
        $player->update($validatedData);
    
        Log::channel('user_actions')->info('Player Güncellendi', ['user_id' => auth()->id(), 'player_id' => $player->id]);
    
        return redirect()->route('players.edit', $player)->with('success', 'Oyuncu başarıyla güncellendi.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $player)
    {
        $player = Player::find($player->id);
        
        if ($player) {
            $player->delete();
            Log::channel('user_actions')->info('Player Silindi', ['user_id' => auth()->id(), 'player_name' => $player->id]);
            return response()->json(['success' => 'Kullanıcı başarıyla silindi.']);
        } else {
            return response()->json(['error' => 'Kullanıcı bulunamadı.'], 404);
        }
    }
}
