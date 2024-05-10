<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="players"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Oyuncular"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"><strong>Oyuncu Listesi</strong> </h6>
                            </div>
                        </div>
                        <div class=" me-3 my-3 text-end">
                        <a class="btn bg-gradient-dark mb-0" href="{{route('messages.index') }}"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Mesaj Gönder</a>
                            <a class="btn bg-gradient-dark mb-0" href="{{route('players.create') }}"><i
                                    class="material-icons text-sm">add</i>&nbsp;&nbsp;Yeni Oyuncu</a>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table id="players-table" class="table align-items-center mb-0 display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                ID
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                GAMER ID</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                OYUNCU ADI</th>
                                                <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                EMAIL</th>
                                                <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Son Giriş Tarihi</th>
                                                <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Nick Güncelleme Tarihi</th>
                                             <th style="width:14%"
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                </th>
                                        </tr>
                                    </thead>
                                   <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </main>
    <x-plugins></x-plugins>

</x-layout>
