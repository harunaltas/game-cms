<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="messages"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Mesaj Gönder"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"><strong>Mesaj Gönder</strong></h6>
                            </div>
                        </div>
                        <div class="me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{url()->previous()}}">İptal</a>
                        </div>
                        <div class="card-body px-0 pb-2">
                        <form method="post" action="{{ route('messages.store') }}" enctype="multipart/form-data">
                                @csrf
                            <div class="row px-5">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                    <label class="form-label">Mesaj Gönderilecek Oyuncular</label>
                                    <select name="player_ids[]" id="player_select" class="form-control" multiple="multiple" required>
                                        @foreach($players as $player)
                                            <option value="{{ $player->id }}">{{ $player->player_nick }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Mesaj İçeriği</label>
                                    <textarea name="message" class="form-control border border-2 p-2"></textarea>
                                </div>
                                </div>
                             </div> 
                             <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary mt-3">Mesaj Gönder</button>
                            </div>
                         </div>
                            </form>

                            <div class="table-responsive p-0">
                                <table id="messages-table" class="table align-items-center mb-0 display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                ID
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Mesaj Gönderen Yetkili</th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Mesaj Alan Oyuncu</th>
                                                <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                Durum</th>
                                            <th
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                Tarih</th>
                                                <th style="width:20%"
                                                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                İşlemler</th>
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
