<!--
=========================================================
* Material Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com) & UPDIVISION (https://www.updivision.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by www.creative-tim.com & www.updivision.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
@props(['bodyClass'])
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ Storage::url($siteSettings['favicon']) }}">
    <title>
        AEFNET | Panel
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jszip-2.5.0/pdfmake-0.1.36/datatables.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!-- DataTables CSS -->


<!-- DataTables ve Buttons eklentisi JavaScript dosyaları -->
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jszip-2.5.0/pdfmake-0.1.36/datatables.min.js"></script>

<!-- Buttons eklentisi için CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets') }}/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            input,textarea,select {
                color:#fff !important;
            }
            option {
                color:#000 !important;
            }
           .dataTables_scroll {
            overflow: hidden !important;
            overflow-y: hidden !important;
          }
        
            .dataTables_scroll .dataTables_scrollBody {
                overflow: hidden !important;
                overflow-y: hidden !important;
                min-height: 500px;
            }
            .dataTables_wrapper {
                overflow: visible !important;
                
            }
            .select2-container--default .select2-selection--single,
            .select2-container--default .select2-selection--multiple {
                background-color: #202940; /* Yeni arka plan rengi */
                border:2px solid #fff;
   
                
            }
            .custom-right {
    right: 0;
    top: 20px; /* Üstten boşluk */
    position: fixed;
    left: auto; /* Bootstrap'in fixed-top'unun sol konumlandırmasını geçersiz kılar */
    width: auto; /* Gerekirse genişliği ayarlayın */
    z-index: 1050; /* Diğer sabitlenmiş içeriklerin üzerinde görünmesini sağlamak için */
}

        </style>
</head>
<body style="background: #212529;" class="dark-version g-sidenav-show">

<div id="notification-messages" data-success="{{ session('success') }}" 
     data-error="{{ session('error') }}">
</div>
{{ $slot }}
@include('components.modals.delete-confirm')
@include('components.modals.unban-confirm')
@include('components.modals.exception-update-confirm')
@include('components.modals.exception-update-modal')
@include('components.modals.ban-details-modal')
@include('components.modals.message-details-modal')
@include('components.modals.delete-donation-confirm')
@include('components.modals.delete-user-confirm')
@include('components.modals.delete-message-confirm')
@include('components.modals.show-sicil-modal')
@include('components.modals.photo-show-modal')
@include('components.modals.delete-sicil-confirm')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<!-- Select2 CSS -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">


<script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
<script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
<script src="{{ asset('assets') }}/js/plugins/smooth-scrollbar.min.js"></script>

@stack('js')

</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    fetchOnlinePlayers();
    fetchPeakPlayersLast24Hours();
});

function fetchOnlinePlayers() {
    fetch('https://api.aefnet.com/user_count.log', {
    mode: 'no-cors' // CORS'u devre dışı bırak
})
        .then(response => response.json())
        .then(data => {
            console.log(data,"data");
            document.getElementById('online-players').innerText = data.aefnet || '0';
        })
        .catch(() => document.getElementById('online-players').innerText = '0');
}

function fetchPeakPlayersLast24Hours() {
    fetch('api/peak-players-last-24-hours-endpoint')
        .then(response => response.json())
        .then(data => {
            document.getElementById('peak-players-last-24-hours').innerText = data.peakPlayers || '0';
        })
        .catch(() => document.getElementById('peak-players-last-24-hours').innerText = '0');
}
</script>
<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
            damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }

</script>
<script>
        $(document).on('click', '.message-detail', function(){
        id = $(this).data('id'); // Silinecek oyuncunun ID'sini değişkene ata
        $.ajax({
            url: `/messages/${id}`, // Resource route'a uygun URL
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
            if(response.success) {
                const details = response.data;
                // Modal içeriğini doldur
                $('#messageDetailModalLabel').html(`Mesaj İçeriği`);
                $('#message').text(details.message);
                $('#messageDetailModal').modal('show');
            } else {
                console.error('Mesaj detayları yüklenemedi.');
            }
            },
            error: function(error) {
            console.error('AJAX isteği başarısız.', error);
            }
         });
        $('#messageDetailModal').modal('show'); // Modalı göster
    });
</script>
<script>
        $(document).on('click', '.show-sicil', function(){
        id = $(this).data('id'); 
        $.ajax({
            url: `sicils/${id}`, 
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
            if(response.success) {
                let sicils = response.data;
        let tableHtml = '<table class="table table-dark"><thead><tr><th>Gamer Adı</th><th>Admin</th><th>Uyarı Mesajı</th><th>Durum</th><th>Sicil Tarihi</th><th>Ban Süresi</th><th>Durum</th><th>İşlem</th></tr></thead><tbody>';
        
        sicils.forEach(function(sicil) {
            let infoText;
            switch(sicil.info) {
                case "1":
                    infoText = 'Uyarıldı';
                    break;
                case "2":
                    infoText = 'Süresi Bitmiş';
                    break;
                case "3":
                    infoText = 'Banlandı';
                    break;
                case "4":
                    infoText = 'Okundu';
                    break;
                default:
                    infoText = 'Gönderildi';
            }
            tableHtml += `<tr>

                            <td>${sicil.gamer_name}</td>
                            <td>${sicil.admin}</td>
                            <td>${sicil.warning_message}</td>
                            <td>${sicil.status}</td>
                            <td>${sicil.sicil_date}</td>
                            <td>${sicil.ban_time} GÜN</td>
                            <td>${infoText}</td>
                            <td>
                        <button class="btn btn-sm bg-gradient-dark delete-sicil" data-id="${sicil.id}">Sil</button>
                    </td>
                          </tr>`;
        });

        tableHtml += '</tbody></table>';
        $(document).on('click', '.delete-sicil', function() {
    const sicilId = $(this).data('id');
    $('#deleteSicilConfirmationModal').modal('show');

    $('#confirmSicilDelete').click(function() {
        $.ajax({
            url: `sicils/${sicilId}`,
            type: 'DELETE', // DELETE metodunu kullan
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token
            },
            success: function(response) {
                if(response.success) {
                    location.reload(); // Sayfayı yenileyerek değişiklikleri göster
                } else {
                    alert('Silme işlemi başarısız.');
                }
            },
            error: function(error) {
                console.error('Silme işlemi sırasında bir hata oluştu.', error);
            }
        });
    });
});
        $('#showSicilModal .modal-body').html(tableHtml); // Modal içeriğini doldur
            } else {
                console.error('Sicil İçeriği Yüklenemedi');
            }
            },
            error: function(error) {
            console.error('AJAX isteği başarısız.', error);
            }
         });
        $('#showSicilModal').modal('show'); // Modalı göster
    });
</script>
<script>
        $(document).on('click', '.ban-detail', function(){
        banId = $(this).data('id'); // Silinecek oyuncunun ID'sini değişkene ata
        $.ajax({
            url: `/banned-players/${banId}`, // Resource route'a uygun URL
            type: 'GET',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
            if(response.success) {
                const details = response.data;
                // Modal içeriğini doldur
                $('#banDetailModalLabel').html(`Oyuncu Ban Detayları - ${details.playerNick}`);
                $('#banPlayerNick').text(details.playerNick);
                $('#banPlayerEmail').text(details.email);
                $('#banIssuer').text(`${details.issuer}`);
                $('#banReason').text(`${details.description}`);
                $('#banType').text(`${details.banType}`);
                $('#banDuration').text(`${details.banDuration} gün`);
                $('#banDate').text(`${details.bannedDate}`);
                $('#banStatus').text(details.banStatus);
                $('#banDescription').text(details.banDescription);

 
                if(details.banImage != null) {
                    const imgHtml = `
                    <a href="${details.banImage}">
                    <img src="${details.banImage}" class="img-fluid rounded" alt="Ban Resmi">
                    </a>
                    `;
                      // Modal içindeki uygun yere <img> etiketini yerleştir
                   $('#banImageContainer').html(imgHtml);
                }else {
                // Resim yoksa, container'ı boşalt
                $('#banImageContainer').html("Resim Yok");
                }
        
     
                $('#banDetailModal').modal('show');
            } else {
                console.error('Ban detayları yüklenemedi.');
            }
            },
            error: function(error) {
            console.error('AJAX isteği başarısız.', error);
            }
         });
        $('#banDetailModal').modal('show'); // Modalı göster
    });
</script>
<script>
$(document).ready(function() {
    var id; // Silinecek oyuncunun ID'sini saklamak için bir değişken

    // "Sil" butonuna tıklanma işleyicisi
    $(document).on('click', '.delete-donation', function(){
        id = $(this).data('id'); // Silinecek oyuncunun ID'sini değişkene ata
        $('#deleteDonationConfirmationModal').modal('show'); // Modalı göster
    });

    // Modal içindeki "Sil" onay butonuna tıklanınca silme işlemini gerçekleştir
    $('#confirmDonationDelete').click(function() {
        $.ajax({
            url: '/donations/' + id, // Silme işlemi için backend endpoint
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('#donations-table').DataTable().ajax.reload(null,false); // Tabloyu yenile
                $('#notification-messages').attr('data-success', result.success);
                $('#deleteDonationConfirmationModal').modal('hide'); // Modalı gizle
            },
            error: function(request, status, error) {
                alert('Bağışçı silinirken bir hata oluştu. Hata: ' + request.responseText);
                $('#deleteDonationConfirmationModal').modal('hide'); // Hata durumunda da modalı gizle
            }
        });
    });
});

</script>
<script>
$(document).ready(function() {
    var id; // Silinecek oyuncunun ID'sini saklamak için bir değişken

    // "Sil" butonuna tıklanma işleyicisi
    $(document).on('click', '.delete-user', function(){
        id = $(this).data('id'); // Silinecek oyuncunun ID'sini değişkene ata
        $('#deleteUserConfirmationModal').modal('show'); // Modalı göster
    });

    // Modal içindeki "Sil" onay butonuna tıklanınca silme işlemini gerçekleştir
    $('#confirmUserDelete').click(function() {
        $.ajax({
            url: '/users/' + id, // Silme işlemi için backend endpoint
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('#users-table').DataTable().ajax.reload(null,false); // Tabloyu yenile
                $('#notification-messages').attr('data-success', result.success);
                $('#deleteUserConfirmationModal').modal('hide'); // Modalı gizle
            },
            error: function(request, status, error) {
                alert('Kullanıcı silinirken bir hata oluştu. Hata: ' + request.responseText);
                $('#deleteUserConfirmationModal').modal('hide'); // Hata durumunda da modalı gizle
            }
        });
    });
});

</script>
<script>
$(document).ready(function() {
    var playerIdToDelete; // Silinecek oyuncunun ID'sini saklamak için bir değişken

    // "Sil" butonuna tıklanma işleyicisi
    $(document).on('click', '.player-delete', function(){
        playerIdToDelete = $(this).data('id'); // Silinecek oyuncunun ID'sini değişkene ata
        $('#deleteConfirmationModal').modal('show'); // Modalı göster
    });

    // Modal içindeki "Sil" onay butonuna tıklanınca silme işlemini gerçekleştir
    $('#confirmDelete').click(function() {
        $.ajax({
            url: '/players/' + playerIdToDelete, // Silme işlemi için backend endpoint
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('#players-table').DataTable().ajax.reload(null,false); // Tabloyu yenile
                
                $('#deleteConfirmationModal').modal('hide'); // Modalı gizle
            },
            error: function(request, status, error) {
                alert('Oyuncu silinirken bir hata oluştu. Hata: ' + request.responseText);
                $('#deleteConfirmationModal').modal('hide'); // Hata durumunda da modalı gizle
            }
        });
    });
});

</script>
<script>
    // "Ban Kaldır" butonuna tıklanma işleyicisi
    $('#bannedplayers-table').on('click', '.unban-player', function() {
    var banId = $(this).data('id');
    
    // Modalı göster
    $('#unbanConfirmationModal').modal('show');

    // "Ban Kaldır" onay butonuna tıklanınca işlemi gerçekleştir
    $('#confirmUnban').off('click').on('click', function() {
        $.ajax({
            url: '/banned-players/unban/' + banId, // Backend route'unuz
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: banId
            },
            success: function(response) {
                // İşlem başarılıysa, modalı kapat
                $('#unbanConfirmationModal').modal('hide');
                // DataTable'ı yenile
                $('#bannedplayers-table').DataTable().ajax.reload();
            },
            error: function(error) {
                console.log(error);
                alert('Ban kaldırılırken bir hata oluştu.');
                $('#unbanConfirmationModal').modal('hide');
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    function updatePlayerException(playerId, exceptionValue) {
    $.ajax({
        url: '/exceptions/update/' + playerId,
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            exception: exceptionValue
        },
        success: function(result) {
            $('#exceptions-table').DataTable().ajax.reload(null,false);
            $('#notification-messages').attr('data-success', result.success);
            $('#exceptionUpdateConfirmationModal').modal('hide');
            $('#nickSettingsModal').modal('hide');
            // Başarı mesajını data-success attribute'üne ata
        },
        error: function(request, status, error) {
            alert('Oyuncu ayarları güncellenirken bir hata oluştu. Hata: ' + request.responseText);
            $('#exceptionUpdateConfirmationModal').modal('hide');
            $('#nickSettingsModal').modal('hide');
        }
    });
}

    var playerId; // Silinecek oyuncunun ID'sini saklamak için bir değişken
    var exceptionValue;
    // "Sil" butonuna tıklanma işleyicisi
    $(document).on('click', '.exception-update', function(){
        playerId = $(this).data('id'); // Silinecek oyuncunun ID'sini değişkene ata
        exceptionValue = $(this).data('exception-value');
        $('#exceptionUpdateConfirmationModal').modal('show'); // Modalı göster
    });
    // Nick Ayarları butonuna tıklanma olayı
    $(document).on('click', '.nick-settings', function(){
        playerId = $(this).data('id'); // Butondan oyuncu ID'sini al
        $('#modalPlayerId').val(playerId); // Gizli input'a oyuncu ID'sini ata
        // Modalı göster
        $('#nickSettingsModal').modal('show');
    });

    $('.confirmException').click(function() {
        var selectedException = $('input[name=exception]:checked');
        if (selectedException.length > 0) {
        exceptionValue = selectedException.val();
        }
        updatePlayerException(playerId, exceptionValue)
    });

    $(document).on('click', '.exception-update-modal', function(){
        playerId = $(this).data('id'); // Butondan oyuncu ID'sini al
        $('#modalPlayerId').val(playerId); // Gizli input'a oyuncu ID'sini ata
        // Modalı göster
        $('#nickSettingsModal').modal('show');
        $('.confirmException').click(function() {
        var selectedException = $('input[name=exception]:checked');
        if (selectedException.length > 0) {
        exceptionValue = selectedException.val();
        }
        updatePlayerException(playerId, exceptionValue)
    });
    });


});
</script>
<script>
         var id;
        $(document).on('click', '.delete-message', function(){
        id = $(this).data('id'); // Butondan oyuncu ID'sini al
        // Modalı göster
        $('#deleteMessageConfirmationModal').modal('show');

    });
    $('#confirmMessageDelete').click(function() {
        $.ajax({
            url: '/messages/' + id, // Silme işlemi için backend endpoint
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(result) {
                $('#deleteMessageConfirmationModal').modal('hide'); // Modalı gizle
                $('#messages-table').DataTable().ajax.reload(null,false); // Tabloyu yenile
            },
            error: function(request, status, error) {
                $('#deleteMessageConfirmationModal').modal('hide'); // Hata durumunda da modalı gizle
                alert('Mesaj silinirken bir hata oluştu. Hata: ' + request.responseText);
            }
        });
    });
</script>
<script>

</script>
<script>
$(document).ready(function() {
    $('#player_select').select2({
        placeholder: "Oyuncuları seçin",
        allowClear: true,
        templateSelection: function (data) {
            // Seçilen öğeler için özel görünüm
            return data.text; // Bu örnekte, sadece metni döndürüyoruz.
        }
    });
});
</script>
<script>
    $(document).ready(function() {
    $('.donation_player_select').select2({
        placeholder: "Oyuncu seçiniz",
        allowClear: true,
        multiple:true,
    });
});
</script>
<script>
    $(document).ready(function() {
    $('.user-roles').select2({
        placeholder: "Rol Seçiniz",
        allowClear: true,
    });
});
</script>
<script>
    function removeTurkishChars() {
    const inputElement = document.getElementById("player_nick");
    const turkishChars = /[ğüşıöçĞÜŞİÖÇ]/g;
    inputElement.value = inputElement.value.replace(turkishChars, '');
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


<script src="{{ asset('assets') }}/js/notification.js"></script>
<script src="{{ asset('assets') }}/js/datatable/datatable.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<!-- Chosen JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js"></script>
<!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('assets') }}/js/material-dashboard.js?v=3.0.0"></script>
<script>
    window.Laravel = {
        csrfToken: '{{ csrf_token() }}',
        routes: {
            playersIndex: '{{ route("players.index") }}',
            notbannedIndex: '{{ route("banned-players.not-banned-players") }}',
            bannedIndex: '{{ route("banned-players.index") }}',
            messagesIndex: '{{ route("messages.index") }}',
            exceptionsIndex: '{{ route("exceptions.index") }}',
            donationsIndex: '{{ route("donations.index") }}',
            nickHistoriesIndex: '{{ route("nick-histories.index") }}',
            usersIndex: '{{ route("users.index") }}',
     
        }
    };
</script>


</body>
</html>
