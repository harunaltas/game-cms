<div class="dropdown">
    <button class="btn bg-gradient-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        İşlemler
    </button>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('players.show', $row) }}">Detay</a></li>
        <li><a class="dropdown-item" href="{{ route('banned-players.createWithPlayer', $row) }}">Ban At</a></li>
        <li><a class="dropdown-item" href="{{ route('warning-players.createWithPlayer', $row) }}">Uyarı Ver</a></li>
        <li><a class="dropdown-item" href="{{ route('players.edit', $row) }}">Düzenle</a></li>
        <li><a class="dropdown-item player-delete" href="javascript:void(0);" data-id="{{ $row->id }}">Sil</a></li>
    </ul>
</div>
