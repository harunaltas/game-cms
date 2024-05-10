<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = SiteSetting::all();
        return view('pages.site_settings.site_settings', compact('settings'));
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
    public function show(SiteSetting $siteSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteSetting $siteSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);
    
        foreach ($data as $key => $value) {
            $setting = SiteSetting::where('key', $key)->first();
    
            if ($setting) {
                if($request->hasFile($key)) {
                    // Mevcut dosyayı sil
                    if($setting->value) Storage::delete($setting->value);
    
                    // Yeni dosyayı kaydet
                    $path = $request->file($key)->store('public/site_settings');
                    $setting->value = $path;
                } elseif (!$request->hasFile($key) && !in_array($key, ['favicon', 'logo'])) {
                    // Dosya yükleme olmayan alanlar için
                    $setting->value = $value;
                }
    
                $setting->save();
            }
        }
    
        return redirect()->back()->with('success', 'Site ayarları başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiteSetting $siteSetting)
    {
        //
    }
}
