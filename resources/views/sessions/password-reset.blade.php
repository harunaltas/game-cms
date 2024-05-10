<x-layout bodyClass="bg-gray-200">
    <div class="container position-sticky z-index-sticky top-0">
        <!-- Navbar içeriği gerekirse -->
    </div>
    <main class="main-content mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container mt-5">
                <div class="row">
                    <div class="col-lg-4 col-md-8 col-12 mx-auto">
                        <div class="card z-index-0 fadeIn3 fadeInBottom">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                                    <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Şifre Sıfırla</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <form role="form" method="POST" action="{{ route('password-reset-process') }}" class="text-start">
                                    @csrf
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div><br>
                                    <label class="form-label">Güvenlik Sorusu</label>
                                    <div class="input-group input-group-outline mt-3">
                                        
                                        <div>
                                            @foreach($questions as $question)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="security_question" id="question_{{ $question->id }}" value="{{ $question->id }}">
                                                    <label class="form-check-label" for="question_{{ $question->id }}">
                                                        {{ $question->question }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Güvenlik Cevabı</label>
                                        <input type="text" class="form-control" name="security_answer">
                                    </div>
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Yeni Şifre</label>
                                        <input type="password" class="form-control" name="password" >
                                    </div>
                                    <div class="input-group input-group-outline mt-3">
                                        <label class="form-label">Yeni Şifre Tekrar</label>
                                        <input type="password" class="form-control" name="password_confirmation">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Şifreyi Sıfırla</button>
                                    </div>
                                </form>
                                @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        
                        <!-- Hata mesajları -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @push('js')
    <script src="{{ asset('assets') }}/js/jquery.min.js"></script>
    <script>
        $(function() {
            $(".input-group input").focus(function() {
                $(this).parent().addClass('is-filled');
            }).blur(function() {
                if ($(this).val() === "") {
                    $(this).parent().removeClass('is-filled');
                }
            });
        });
    </script>
    @endpush
</x-layout>
