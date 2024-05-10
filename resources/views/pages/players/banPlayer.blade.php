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
                                            <form method="post" action="{{ route('banned-players.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row px-5">
                            <div class="col-md-6">
                                <input type="hidden" name="player_id" value="{{ $player->id }}">
                                <div class="mb-3">
                                    <label class="form-label">Ban Tipi</label>
                                    <select name="ban_type_id" class="form-control border border-2 p-2" required>
                                    <option value="0">Ban Tipi Seçin</option>
                                    @foreach($bantypes as $bantype) 
                                        <option value="{{$bantype->id}}">{{$bantype->title}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="mb-3">
                        <label class="form-label">Ban Süresi</label>
                        <div class="row">
    @foreach($bantimes as $bantime)
        @if(!(auth()->user()->hasRole('Moderatör') && $bantime->title == 'Süresiz'))
            <div class="col-1">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="ban_time_id" value="{{$bantime->id}}" required>
                    <label class="form-check-label">{{$bantime->title}}</label>
                </div>
            </div>
        @endif
    @endforeach
</div>

                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ban Açıklaması</label>
                                    <textarea name="description" class="form-control border border-2 p-2"></textarea>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ban Resmi</label><br>
                                    @if(auth()->user()->hasRole('Kurucu'))
                                        {{-- Kurucu için ban resmi zorunlu değil --}}
                                        <input type="file" name="ban_image" class="form-control-file p-2">
                                    @else
                                        {{-- Kurucu hariç herkes için ban resmi zorunlu --}}
                                        <input type="file" name="ban_image" class="form-control-file p-2" required>
                                    @endif
                                </div>
                            </div>

                            @if((auth()->user()->hasRole('Kurucu')))
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Ban Tarihi</label>
                                    <input type="date" name="banned_date" class="form-control border border-2 p-2" required>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col text-center">
                                <button type="submit" class="btn btn-primary mt-3">Banla</button>
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
