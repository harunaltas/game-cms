<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="site_settings"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-navbars.navs.auth titlePage="Site Ayarları"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                                <h6 class="text-white mx-3"><strong>Site Ayarları</strong></h6>
                            </div>
                        </div>
                        <div class="card-body p-0 pb-2">
                         
                            <div class="row m-0">
                            
                                <div class="col-md-12">
                             
                                    <div class="card m-3">
                                        <div class="card-body">

                                        <form method="post" action="{{ route('site-settings.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @foreach($settings as $setting)
        <div class="mb-3">
           
            @if($setting->key == 'favicon' || $setting->key == 'logo')
                 <label class="form-label text-uppercase">{{ $setting->key }}</label> <br>
                <input type="file" name="{{ $setting->key }}" class="form-control-file p-2">
                @if($setting->value)
                    <img src="{{ Storage::url($setting->value) }}" width="100" class="img-preview mt-2">
                @endif
            @else
            <label class="form-label">{{ $setting->description }}</label>
                <input type="text" name="{{ $setting->key }}" class="form-control border border-2 p-2" value="{{ $setting->value }}">
            @endif
        </div>
    @endforeach
    <button type="submit" class="btn btn-primary">Ayarları Güncelle</button>
</form>
                                        </div>
                                    </div>
                                </div>
                              
                            </div>
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
