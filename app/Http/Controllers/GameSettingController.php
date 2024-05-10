<?php

namespace App\Http\Controllers;

use App\Models\GameSetting;
use Illuminate\Http\Request;

class GameSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show gamesettings', ['only' => ['index', 'show']]);
        $this->middleware('permission:send gamesettings', ['only' => ['update']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = GameSetting::all();

        return view('pages.game_settings.game_settings', compact('settings'));    
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
    public function show(GameSetting $gameSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GameSetting $gameSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // İlgili GameSetting kaydını bul

        $setting = GameSetting::findOrFail($id);
    
        // Validasyon
        $request->validate([
            'text' => 'required|string',

        ]);
    
        // Güncelleme işlemi
        $setting->update([
  
            'text' => $request->text,
            'is_active' => $request->has('is_active') ? true : false,
        ]);
    
        // İşlem başarılıysa, ilgili sayfaya yönlendir ve başarı mesajı göster
        return redirect()->back()->with('success', 'Ayar başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GameSetting $gameSetting)
    {
        //
    }
}
