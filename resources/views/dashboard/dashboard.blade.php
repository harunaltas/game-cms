<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="dashboard"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navigation bar, titlePage örneğin "Dashboard" olarak değiştirildi -->
        <x-navbars.navs.auth titlePage="Dashboard"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <!-- Toplam Oyuncu Sayısı -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Toplam Oyuncu Sayısı</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPlayers }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Toplam Yetkili Sayısı -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Toplam Yetkili Sayısı</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAdmins }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-shield fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Online Oyuncu Sayısı (JavaScript ile Güncellenen) -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Online Oyuncu Sayısı</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="online-players">Yükleniyor...</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-clock fa-2x text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Son 24 Saatte En Yüksek Oyuncu Sayısı (JavaScript ile Güncellenen) -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Son 24 Saatte En Yüksek Oyuncu Sayısı</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="peak-players-last-24-hours">Yükleniyor...</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Toplam Banlanan Oyuncu Sayısı -->
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1">Toplam Banlanan Oyuncu Sayısı</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBannedPlayers }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-slash fa-2x text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-plugins></x-plugins>
</x-layout>
