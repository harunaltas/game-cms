<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage=""></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage=""></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <strong>Erişim Reddedildi!</strong>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">Üzgünüz, bu işlemi gerçekleştirmek için yetkiniz yok.</h5>
                    <p class="card-text">Eğer bir yanlışlık olduğunu düşünüyorsanız, lütfen sistem yöneticisi ile iletişime geçin.</p>
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Geri Dön</a>
                </div>
            </div>
        </div>
    </div>
</div>

    </main>
    <x-plugins></x-plugins>

</x-layout>
