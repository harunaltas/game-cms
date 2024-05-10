<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage="donations"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Bağış Yapanlar"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"><strong>Bağış Yapanlar</strong> </h6>
                            </div>
                        </div>
                        
                        <div class="card-body px-0 pb-2">
                        <form method="post" action="{{ route('donations.store') }}" enctype="multipart/form-data">
                                @csrf
                            <div class="row px-5">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                    <label class="form-label">Oyuncu Seçiniz</label>
                                    <select  name="player_ids[]" multiple="multiple" class="form-control border border-2 p-2 donation_player_select" required>
                                        @foreach($players as $player)
                                            <option value="{{ $player->id }}">{{ $player->player_nick }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Rütbe</label>
                                    <select name="donation_rank"  class="form-control border border-2 p-2" required>
                                            <option value="Bağışçı">Bağışçı</option>
                                            <option value="Vip">Vip</option>
                                            <option value="Vip++">Vip++</option>
                                            <option value="Premium">Premium</option>
                                    </select>
                                    </div>
                                </div>
                             </div> 
                             <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary mt-3">Kaydet</button>
                            </div>
                         </div>
                            </form>
                            <div class="table-responsive p-0">
                                <table id="donations-table" class="table align-items-center mb-0 display" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                GAMER ID
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                PLAYER NICK
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                EMAIL
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                RÜTBE
                                            </th>
                                            <th
                                                class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                İşlemler
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
