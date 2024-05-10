<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="profile"></x-navbars.sidebar>
    <div class="main-content position-relative bg-gray-100 max-height-vh-100 h-100">
        <x-navbars.navs.auth titlePage='Oyuncu Profili'></x-navbars.navs.auth>
        <div class="container-fluid px-2 px-md-4">
            <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n6">
            <div class="row gx-4 mb-2">
    <div class="col-auto">
        <div class="avatar avatar-xl position-relative">
            <img src="{{ asset('assets/img/profile.png') }}" alt="profile_image" class="w-100 border-radius-lg shadow-sm">
        </div>
    </div>
    <div class="col-auto my-auto">
        <div class="h-100">
            <h5 class="mb-1">{{ $player->player_nick }}</h5>
            <p class="mb-0 font-weight-normal text-sm">{{ $player->email }}</p>
        </div>
    </div>
    <div class="col d-flex justify-content-end align-items-center">
        <a href="{{ route('banned-players.createWithPlayer', $player) }}" class="btn bg-gradient-dark me-2">Banla</a>
        <a href="{{ route('warning-players.createWithPlayer', $player) }}" class="btn bg-gradient-dark">Uyarı Ver</a>
    </div>
</div>
                <!-- Oyuncu Bilgileri ve Nick Değişiklikleri -->
                <div class="row mb-4">
                <div class="col-lg-6">
    <div class="card border-2 border-dark">
        <div class="card-body">
            <h6 class="card-title mb-3">Oyuncu Bilgileri</h6>
            <dl class="row">
                <dt class="col-sm-5">Gamer ID:</dt>
                <dd class="col-sm-7">{{ $player->gamer_id }}</dd>

                <dt class="col-sm-5">Email:</dt>
                <dd class="col-sm-7">{{ $player->email }}</dd>

                <dt class="col-sm-5">Son Giriş:</dt>
                <dd class="col-sm-7">{{ $player->last_login_dates }}</dd>

                <dt class="col-sm-5">Nick Güncelleme Tarihi:</dt>
                <dd class="col-sm-7">{{ \Carbon\Carbon::parse($player->nick_update_dates)->format('d.m.Y') }}</dd>

                <dt class="col-sm-5">İstisna:</dt>
                <dd class="col-sm-7">{{ $player->exception == 1 ? 'Tek Kullanımlık' : ($player->exception == 2 ? 'Sınırsız' : 'İstisna Yok') }}</dd>

                <dt class="col-sm-5">Bilgisayar Bilgileri:</dt>
                <dd class="col-sm-7">{{ $player->pc_user_info }}</dd>
            </dl>
        </div>
    </div>
</div>
<div class="col-lg-6">
    <div class="card border-2 border-dark py-3">
        <div class="card-body">
            <h6 class="card-title mb-1">Nick Değişiklikleri</h6>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Yeni Nick</th>
                            <th>Değişiklik Tarihi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($player->nickHistories as $nickHistory)
                            <tr>
                                <td>{{ $nickHistory->new_player_nick }}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $nickHistory->created_at)->format('d.m.Y')}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">Nick Değişikliği Yok</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




                </div>
                <!-- Banlar ve Uyarılar -->
                <div class="row d-flex justify-content-center w-full">
                 <div class="col-lg-6">
                <div class="card border border-2 border-dark">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Banlar</h6>

                    </div>
                    <div class="card-body">
                    @forelse ($player->bans as $ban)
                            <div class="d-flex justify-content-between align-items-center">
                                <div>           
                                    <span>{{ $ban->banTime->title }} Gün - {{ $ban->banType->title }} - {{ $ban->description }}</span>

                                </div>
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                @if($ban->status)
    <form action="{{ route('banned-players.unban', $ban->id) }}" method="POST" class="d-inline">
        @csrf
        @method('POST')
        <button type="submit" class="btn btn-sm bg-gradient-dark">Ban Kaldır</button>
    </form>
@endif
@if($ban->ban_image)
<a class="btn bg-gradient-dark" href="javascript:void(0);" onclick="openImagePopup('{{ Storage::url($ban->ban_image) }}')">Resmi Gör</a>
@endif
</div>
                            </div>
                        @empty
                        <div class="text-center">
                            <span>Bu Oyuncunun Banı Yok.</span>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
    <div class="card border border-2 border-dark">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Uyarılar</h6>
            @if($player->warnings->isNotEmpty())
                <a href="#" class="btn btn-sm btn-danger">Tüm Uyarıları Kaldır</a>
            @endif
        </div>
        <div class="card-body">
            @forelse ($player->warnings as $warning)
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="text-wrap d-inline-block" style="max-width: 50%;" title="{{ $warning->description }}">
                        {{ $warning->description }}
                    </div>
                    <span>{{ $warning->status == "1" ? "Gönderildi" : "Okundu" }}</span>
                    <form action="{{ route('warning-players.destroy', $warning->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm bg-gradient-dark">Uyarı Kaldır</button>
                    </form>
                </div>
            @empty
                <div class="text-center">
                    <span>Bu Oyuncunun Uyarısı Yok.</span>
                </div>
            @endforelse
        </div>
    </div>
</div>

      <div class="col-lg-12 mt-5">

      <div class="card border border-2 border-dark p-2" >
      <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">Siciller</h6>
        </div>
        <div class="card-body"  style="max-height: 200px; overflow-x:auto">
             <table id="" class="display responsive nowrap" style="width:100%; border-radius:10px;">
            <thead >
            <tr>
             
                <th>Gamer ID</th>
                <th>Gamer Adı</th>
                <th>Admin</th>
                <th>Uyarı Mesajı</th>
                <th>Durum</th>
                <th>Sicil Tarihi</th>
                <th>Ban Süresi</th>
                <th>Durum</th>
                <th>İşlem</th>
            </tr>
        </thead>
        <tbody class="p-5" >
            @forelse ($player->sicils as $sicil)
                <tr>
                 
                    <td>{{ $sicil->gamer_id }}</td>
                    <td>{{ $sicil->gamer_name }}</td>
              
                    <td>{{ $sicil->admin }}</td>
                    <td style="width:250px;">{{ $sicil->warning_message }}</td>
                    <td>{{ $sicil->status}}</td>
                    <td>{{ date('d.m.y', strtotime($sicil->sicil_date)) }}</td>
                    <td>{{ $sicil->ban_time }} GÜN</td>
                    <td>
                        {{ $sicil->info == 1 ? 'Uyarıldı' : 
                        ($sicil->info == 2 ? 'Süresi Bitmiş' : 
                        ($sicil->info == 3 ? 'Banlandı' : 
                        ($sicil->info == 4 ? 'Okundu' : 'Gönderildi'))) }}
                    </td>
                    <td>
                    <form action="{{ route('sicils.destroy', $sicil->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-md bg-gradient-dark m-2">Sil</button>
                    </form></td>
              
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">Bu Kullanıcının Sicili Yok</td>
                </tr>
            @endforelse
        </tbody>
    </table>
        </div>
      </div>
</div>
                <div class="col-lg-12 mt-5">
                    <div class="card border border-2 border-dark">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Mesajlar</h6>
                        </div>
                        <div class="card-body">
    @forelse ($player->messages as $message)
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">Gönderen: {{ $message->user->name ?? 'Bilinmiyor' }}</h5>
                <p class="card-text">{{ $message->message }}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="badge {{ $message->status == 1 ? 'bg-primary' : ($message->status == 2 ? 'bg-success' : 'bg-secondary') }}">
                        {{ $message->status == 1 ? 'Gönderildi' : ($message->status == 2 ? 'Okundu' : 'Bilinmiyor') }}
                    </span>
                    <form action="{{ route('messages.destroy', $message->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm bg-gradient-dark">Mesajı Sil</button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="text-center">
            <p>Gönderilmiş Mesaj Yok</p>
        </div>
    @endforelse
</div>


                    </div>
                </div>


<script>
function openImage(url) {
    window.open(url, '_blank');
}
</script>
<script>
function openImagePopup(imageUrl) {
    // Resim URL'sini modal içindeki img tag'ına ata
    document.getElementById('banImage').src = imageUrl;
    // Modalı göster
    $('#photoShowModal').modal('show');
}
</script>
                </div>
            </div>
        </div>

    </div>
    <x-plugins></x-plugins>
</x-layout>