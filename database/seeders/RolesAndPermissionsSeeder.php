<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'add players', // OYUNCU EKLE
            'update players', // OYUNCU GÜNCELLE
            'delete players', // OYUNCU SİL
            'update site_settings', // SİTE AYARLARINI GÜNCELLE
            'show site_settings', // SİTE AYARLARINI GÖRÜNTÜLE
            'add users', // KULLANICI EKLE
            'show users', // KULLANICILARI GÖRÜNTÜLE
            'update users', // KULLANICILARI GÜNCELLE
            'delete users', // KULLANICIYI SİL
            'show donations', // BAĞIŞÇILARI GÖSTER
            'add donations', // BAĞIŞÇI EKLE
            'show logs', // LOGLARI GÖSTER
            'show banned_player', // BANLI OYUNCULARI GÖSTER
            'add banned_player', // BANLI OYUNCU EKLE
            'delete banned_player', // BANLI OYUNCU SİL
            'update banned_player', // BANLI OYUNCU GÜNCELLE
            'show banned_player_detail', // BANLI OYUNCU DETAY GÖRÜNTÜLE
            'show exceptions', // İSTİSNALARI GÖRÜNTÜLE
            'add exceptions', // İSTİSNA EKLE
            'show nick_histories', // NİCK DEĞİŞMELERİNİ GÖSTER
            'show message', // MESAJLARI GÖSTER
            'add message', // MESAJ EKLE
            'show warning',
            'delete warning',
            'send warning',
            'show gamesettings',
            'send gamesettings'
            ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        $permissions = Permission::all();
        //YÖNETİCİ
        $role = Role::create(['name' => 'Kurucu']);
        $role->syncPermissions($permissions);
        $role = Role::create(['name' => 'Yönetici']);
        $role->givePermissionTo(['update players','show site_settings','show donations','add exceptions','show exceptions','show nick_histories','show message','add message','show banned_player_detail','update banned_player','delete banned_player','show banned_player'
        ,'show donations','show logs','add donations','show users','show warning','delete warning','send warning','show gamesettings','send gamesettings','show site_settings']);
        //MODERATOR YETKİLERİ
        $role = Role::create(['name' => 'Moderatör']);
        $role->givePermissionTo(['update players', 'show users','show banned_player_detail','update banned_player','delete banned_player','show banned_player','send warning','delete warning','show message','add message','show nick_histories','show exceptions']);
        
    }
}
