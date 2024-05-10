<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="game_settings"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Oyun Ayarları"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"><strong>Oyun Ayarları</strong></h6>
                            </div>
                        </div>
                        <div class="me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{ route('players.index') }}">İptal</a>
                        </div>
                        <div class="card-body p-0 pb-2">
                        <div class="mb-3 d-flex align-items-center justify-content-around flex-wrap">
        <!-- Tüm Sicil Kayıtlarını Sıfırla -->
        <form method="POST" action="{{ route('reset.player-sicils') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn bg-gradient-dark mb-2">Tüm Sicil Kayıtlarını Sıfırla</button>
        </form>

        <!-- Tüm Ban Kayıtlarını Sıfırla -->
        <form method="POST" action="{{ route('reset.banned-players') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn bg-gradient-dark mb-2">Tüm Ban Kayıtlarını Sıfırla</button>
        </form>

        <!-- Tüm Banları Kaldır -->
        <form method="POST" action="{{ route('unban.all-players') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn bg-gradient-dark mb-2">Tüm Banları Kaldır</button>
        </form>

        <!-- Tüm Uyarı Kayıtlarını Sıfırla -->
        <form method="POST" action="{{ route('reset.warning-players') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn bg-gradient-dark mb-2">Tüm Uyarı Kayıtlarını Sıfırla</button>
        </form>

        <!-- Tüm Mesajları Sıfırla -->
        <form method="POST" action="{{ route('reset.messages') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn bg-gradient-dark mb-2">Tüm Mesajları Sıfırla</button>
        </form>

        <!-- Tüm Kullanıcıları Sil (Admin Hariç) -->
        <form method="POST" action="{{ route('delete.users-except-admin') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn bg-gradient-dark mb-2">Tüm Kullanıcıları Sil</button>
        </form>
         <!-- Tüm Oyuncuları Sil-->
         <form method="POST" action="{{ route('reset.players') }}" class="d-inline">
            @csrf
            <button type="submit" class="btn bg-gradient-dark mb-2">Tüm Oyuncuları Sil</button>
        </form>
    </div>
                            <div class="row m-0">
                            @foreach($settings as $setting)
                                <div class="col-md-6">
                             
                                    <div class="card m-3  border border-2 border-dark">
                                        <div class="card-body">
                                        <h5 class="ms-1">{{$setting->title}}</h5>
                                            <form method="post" action="{{ route('game_settings.update', $setting->id) }}">
                                                @csrf
                                                @method('PUT')
                                               
                                                <div class="mb-3">
                                                 
                                                    <textarea name="text" class="form-control border p-3" required>{{ $setting->text }}</textarea>
                                                </div>
                                                <div class="mb-3 form-check">
                                                    <input type="checkbox" id='{{$setting->id}}' name="is_active" class="form-check-input" {{ $setting->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label" for='{{$setting->id}}'>Aktif</label>
                                                </div>
                                                <div class="text-center">
                                                    <button type="submit" class="btn btn-primary">Güncelle</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
