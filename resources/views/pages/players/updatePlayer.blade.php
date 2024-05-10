<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-navbars.sidebar activePage="players"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Oyuncu Güncelle"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"><strong>Oyuncu Güncelle</strong></h6>
                            </div>
                        </div>
                        <div class=" me-3 my-3 text-end">
                            <a class="btn bg-gradient-dark mb-0" href="{{url()->previous()}}">İptal</a>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <form method="POST" action="{{ route('players.update', $player->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="row px-5">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Oyuncu Adı</label>
                                            <input type="text" name="player_nick" value="{{ old('player_nick', $player->player_nick) }}" class="form-control border border-2 p-2" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">E-Mail</label>
                                            <input type="email" name="email" value="{{ old('email', $player->email) }}" class="form-control border border-2 p-2" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Şifre</label>
                                            <input type="password" name="password" class="form-control border border-2 p-2">
                                            <small>Şifreyi değiştirmek istemiyorsanız bu alanı boş bırakın.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label>Güvenlik Sorusu Seçin</label>
                                            @foreach($questions as $key => $question)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="security_question" id="question{{ $key }}" value="{{ $key }}" {{ $player->security_question == $key ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="question{{ $key }}">{{ $question->question }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Güvenlik Sorusu Cevabı</label>
                                            <input type="text" name="security_answer" value="{{ old('security_answer', $player->security_answer) }}" class="form-control border border-2 p-2" required>
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
