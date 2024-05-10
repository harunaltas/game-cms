<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="logs"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Log Kayıtları"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-body p-3">
                        @foreach($logs as $logCategory => $logEntries)
    <div class="card mb-3">
        <div class="card-header bg-gradient-primary text-white">{{ $logCategory }}</div>
        <div class="card-body bg-light" style="max-height: 300px; overflow-y: auto;">
            <ul class="list-group list-group-flush">
                @foreach($logEntries as $entry)
                    <li class="list-group-item" style="border-left: 3px solid #5e72e4; margin-bottom: 10px; background-color: #f8f9fa;">
                        <code>{{ $entry }}</code>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
