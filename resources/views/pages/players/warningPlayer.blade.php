<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="players"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Oyuncuyu Banla"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"><strong>Oyuncuyu Banla</strong></h6>
                            </div>
                        </div>
                        <div class="me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{url()->previous()}}">İptal</a>
                        </div>
                        <div class="card-body px-0 pb-2">
                        <form method="post" action="{{ route('warning-players.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="player_id" value="{{ $player->id }}">
                                <div class="row px-5">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Uyarı Açıklaması</label>
                                            <textarea name="description" class="form-control border border-2 p-2" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Uyarı Resmi</label><br>
                                            <input type="file" name="warning_image" class="form-control-file p-2">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-center">
                                        <button type="submit" class="btn btn-primary mt-3">Uyarı Ver</button>
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
   
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
