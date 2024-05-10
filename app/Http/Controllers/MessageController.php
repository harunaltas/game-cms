<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Player;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show message', ['only' => ['index', 'show']]);
        $this->middleware('permission:add message', ['only' => ['create', 'store']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Message::with('user', 'player')->orderBy('id','desc');
            return DataTables::eloquent($data)
                ->addColumn('user', function ($message) {
                    return $message->user ? $message->user->name : '';
                })
                ->addColumn('player', function ($message) {
                    return $message->player ? $message->player->player_nick : '';
                })
                ->editColumn('created_at', function ($message) {
                    return $message->date ? Carbon::parse($message->date)->format('d-m-Y') : '';
                })
                ->addColumn('status', function($row){
                    if ($row->status == 1) {
                        return 'Gönderildi';
                    } elseif ($row->status == 2) {
                        return 'Okundu';
                    }
                    // Opsiyonel: Diğer durumlar için varsayılan bir değer belirleyebilirsiniz
                    return 'Bilinmiyor';
                })
                ->addColumn('actions', function($row){
                    $actions = ''; // Başlangıçta actions boş bir string
                    $actions .= "<a href='javascript:void(0);' class='btn btn-sm bg-gradient-dark message-detail' data-id='{$row->id}'>Mesajı Göster</a>";    
                    $actions .= "<a href='javascript:void(0);' class='btn btn-sm bg-gradient-dark delete-message' data-id='{$row->id}'>Mesajı Sil</a>";
                    return $actions;
                    })
                ->rawColumns(['status','actions'])
                ->make(true);
        }
        $players = Player::all();
        // Eğer AJAX isteği değilse, blade view'ı döndür
        return view('pages.players.messages', compact('players'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'player_ids' => 'required|array',
            'player_ids.*' => 'exists:players,id',
            'message' => 'required|string',
        ]);
    
        foreach ($request->player_ids as $player_id) {
            $player = Player::findOrFail($player_id);
            Message::create([
                'user_id' => auth()->id(),
                'player_id' => $player_id,
                'gamer_id' =>  $player->gamer_id,
                'message' => $request->message,
                'date' => Carbon::now()->format('d-m-Y')
            ]);
        }
    
        return redirect()->back()->with('success', 'Mesajlar başarıyla gönderildi.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $message = Message::findorFail($id);
        return response()->json([
            'success' => true,
            'data' => [
                    'message' => $message->message,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        $message = Message::findOrFail($id);
    
        // Mesajı sil
        $message->delete();
    
        // İstek tipini kontrol et
        if ($request->ajax()) {
            // AJAX isteği için JSON yanıtı dön
            return response()->json(['success' => 'Mesaj başarıyla silindi.']);
        } else {
            // AJAX olmayan istek için önceki sayfaya yönlendir ve başarı mesajı göster
            return redirect()->back()->with('success', 'Mesaj başarıyla silindi.');
        }
    }
    
}
