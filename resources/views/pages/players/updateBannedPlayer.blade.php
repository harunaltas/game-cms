<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="bannedplayers"></x-navbars.sidebar>
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
                            <a class="btn bg-gradient-dark mb-0" href="{{url()->previous()}}"">İptal</a>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <form method="post" action="{{ route('banned-players.update', $ban->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row px-5">
                                    <input type="hidden" name="player_id" value="{{ $player->id }}">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Ban Tipi</label>
                                            <select name="ban_type_id" class="form-control border border-2 p-2" required>
                                                @foreach($bantypes as $bantype) 
                                                    <option value="{{$bantype->id}}" {{ $ban->ban_type_id == $bantype->id ? 'selected' : '' }}>{{$bantype->title}}</option>
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
                                                    <div class="col">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="ban_time_id" value="{{$bantime->id}}" {{ $ban->ban_time_id == $bantime->id ? 'checked' : '' }} required>
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
                                            <textarea name="description" class="form-control border border-2 p-2">{{ $ban->description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Ban Resmi</label><br>
                                            <input type="file" name="ban_image" class="form-control-file p-2">
                                            @if($ban->ban_image)
                                                <img src="{{ Storage::url($ban->ban_image) }}" alt="Ban Image" class="img-thumbnail mt-2" style="max-height: 100px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Ban Tarihi</label>
                                            <input type="date" name="banned_date" class="form-control border border-2 p-2" value="{{ $ban->banned_date }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-center">
                                        <button type="submit" class="btn btn-primary mt-3">Güncelle</button>
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
