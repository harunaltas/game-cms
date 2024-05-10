<?php

namespace App\Http\Controllers;

use App\Models\PlayerNickHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PlayerNickHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('permission:show nick_histories', ['only' => ['index', 'show']]);
        // 'index' ve 'show' metodları için özel bir izin tanımlanmadı, genel erişim kontrolü için auth middleware kullanılabilir.
    }
    public function index(Request $request)
    {

        if ($request->ajax()) {
    $query = DB::table('player_nick_histories as current')
        ->leftJoin('player_nick_histories as previous', function ($join) {
            $join->on('current.gamer_id', '=', 'previous.gamer_id')
                 ->whereRaw('previous.created_at < current.created_at');
        })
        ->join('players', 'players.gamer_id', '=', 'current.gamer_id')
        ->select([
            'players.player_nick as default_nick',
            'previous.new_player_nick as last_nick',
            'current.new_player_nick as new_nick',
            'current.created_at',
            'current.gamer_id'
        ])
        ->orderBy('current.gamer_id')
        ->orderBy('current.created_at', 'desc');

    // DataTables için sorguyu yapılandır
    return DataTables::of($query)

        ->filterColumn('new_nick', function($query, $keyword) {
            $query->where('current.new_player_nick', 'like', "%{$keyword}%");
        })
        ->editColumn('last_nick', function ($row) {
            // Eğer last_nick boşsa, default_nick değerini döndür
            return $row->last_nick ?? $row->default_nick;
        })

        ->filter(function ($query) use ($request) {
            if ($request->has('search') && $request->search['value'] != '') {
                $keyword = $request->search['value'];
                $query->where(function($query) use ($keyword) {
                    $query->where('players.player_nick', 'LIKE', "%{$keyword}%")
                          ->orWhere('current.new_player_nick', 'LIKE', "%{$keyword}%");
                });
            }
        })
        ->make(true);
        }
    
        return view('pages.players.nickHistories');
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(PlayerNickHistory $playerNickHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlayerNickHistory $playerNickHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlayerNickHistory $playerNickHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PlayerNickHistory $playerNickHistory)
    {
        //
    }
}
