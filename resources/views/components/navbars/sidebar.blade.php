@props(['activePage'])

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href="/dashboard">
            <img src="{{ Storage::url($siteSettings['logo']) }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">{{$siteSettings['title']}}</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
        <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Giriş</h6>
            </li>
        <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-dark' : '' }} "
                    href="{{ route('dashboard.index')}}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-chart-line fa-lg ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Giriş</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Oyuncu İşlemleri</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'players' ? ' active bg-gradient-dark' : '' }} "
                    href="{{ route('players.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-users fa-lg ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Oyuncular</span>
                </a>
            </li>
                        <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'not-banned-players' ? ' active bg-gradient-dark' : '' }} "
                    href="{{ route('banned-players.not-banned-players') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-ban fa-lg fa-lg ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Oyuncu Banla</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'bannedplayers' ? ' active bg-gradient-dark' : '' }} "
                    href="{{ route('banned-players.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-user-slash fa-lg ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Banlı Oyuncular</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'exceptions' ? ' active bg-gradient-dark' : '' }} "
                    href="{{ route('exceptions.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-exclamation-triangle fa-lg ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">İstisnalar</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'nick-histories' ? ' active bg-gradient-dark' : '' }} "
                    href="{{ route('nick-histories.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-edit fa-lg ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Nick Değiştirenler</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'donations' ? ' active bg-gradient-dark' : '' }} "
                    href="{{ route('donations.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-donate fa-lg ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Bağış Yapanlar</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'messages' ? ' active bg-gradient-dark' : '' }} "
                    href="{{ route('messages.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-comments ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Mesajlar</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Ayarlar</h6>
            </li>

            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'game_settings' ? ' active bg-gradient-dark' : '' }} "
                    href="{{ route('game_settings.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-gamepad ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Oyun Ayarları</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'site_settings' ? ' active bg-gradient-dark' : '' }} "
                    href="{{ route('site-settings.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-tools ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Site Ayarları</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Kullanıcı İşlemleri</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'users' ? ' active bg-gradient-dark' : '' }} "
                    href="{{ route('users.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-user-friends ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Kullanıcılar</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Kayıtlar</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'logs' ? ' active bg-gradient-dark' : '' }} "
                    href="{{ route('logs.all') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;" class="fas fa-clipboard-list ps-2 pe-2 text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">Log Kayıtları</span>
                </a>
            </li>
            
        </ul>

    </div>


</aside>
