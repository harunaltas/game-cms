<?php

namespace App\Http\Controllers;

use App\Models\PlayerSicil;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PlayerSicilController extends Controller
{
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
    public function show($id)
    {   
            $data = PlayerSicil::where('gamer_id',$id)->get();
            return response()->json([
                'success' => true,
                'data' => $data
            ],200);
      
    }
    public function showWithPlayer(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = PlayerSicil::with('player')->orderBy('id','desc');
            return DataTables::eloquent($data)
                ->make(true);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PlayerSicil $playerSicil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PlayerSicil $playerSicil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
       $sicil = PlayerSicil::findorFail($id);
       $sicil->delete();
       if ($request->ajax()) {
        // AJAX isteği için JSON yanıtı dön
        return response()->json(['success' => 'Sicil başarıyla silindi.']);
    } else {
        // AJAX olmayan istek için önceki sayfaya yönlendir ve başarı mesajı göster
        return redirect()->back()->with('success', 'Sicil başarıyla silindi.');
    }
    }
}
