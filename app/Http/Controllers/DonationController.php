<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Player;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DonationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show donations', ['only' => ['index', 'show']]);
        $this->middleware('permission:add donations', ['only' => ['create', 'store']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Donation::with('player')->orderBy('id','desc');
            return DataTables::eloquent($data)
            ->addColumn('actions', function($row){
                $donationId = $row->id;
                $button = <<<HTML
                        <button class='btn btn-sm bg-gradient-dark delete-donation' data-id='{$donationId}'  data-exception-value='3'>Kaldır</button>
                        HTML;
                return $button;

        })
        ->rawColumns(['actions'])
                ->make(true);
        }
        $players = Player::all();
        return view('pages.players.donations', compact('players'));
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

        foreach ($request->player_ids as $player_id) {
            $player = Player::findOrFail($player_id);
        Donation::create([
            'player_id' => $player_id,
            'gamer_id'=>$player->gamer_id,
            'donation_rank' => $request->donation_rank,
        ]);
    }
        return redirect()->back()->with('success', 'Bağışçı Kaydedildi');
    }

    /**
     * Display the specified resource.
     */
    public function show(Donation $donation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Donation $donation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Donation $donation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $donation = Donation::find($id);
        if ($donation) {
            $donation->delete();
            return response()->json(['success' => 'Bağışçı başarıyla silindi.']);
        } else {
            return response()->json(['error' => 'Bağışçı bulunamadı.'], 404);
        }
    }
}
