$(document).ready(function() {
    $.extend(true, $.fn.dataTable.defaults, {
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Turkish.json"
        },
       
        buttons: [
            'excelHtml5',
        ],
    });

    $('#players-table').DataTable({
        processing: true,
        serverSide: true,
        scrollY: false,
        ajax: window.Laravel.routes.playersIndex,
        columns: [
        { data: 'id', name: 'id' },
        { data: 'gamer_id', name: 'gamer_id' },
        {
            data: null, // null, çünkü bu sütun birden fazla veri alanından oluşturulacak
            name: 'display_nick',
            orderable: true,
            searchable: true,
            render: function(data, type, row) {
                if (row.updated_nick) {
                    // `updated_nick` varsa, bu nicki vurgulayarak ve `player_nick`'i alt metin olarak göster
                    return `<div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm" style="color: #007bff;">${row.updated_nick}</h6> <!-- Vurgulu görünüm için mavi renk -->
                                    <p class="text-xs text-secondary mb-0">Eski: ${row.player_nick}</p>
                                </div>
                            </div>`;
                } else {
                    // `updated_nick` yoksa, sadece `player_nick`'i göster
                    return `<div class="d-flex px-2 py-1">
                                <div class="d-flex flex-column justify-content-center">
                                    <h6 class="mb-0 text-sm">${row.player_nick}</h6>
                                </div>
                            </div>`;
                }
            }
        },
        { data: 'email', name: 'email'},
        { data: 'last_login_dates', name: 'last_login_dates', orderable: false, searchable: false },
        { data: 'nick_update_dates', name: 'nick_updated_dates', orderable: false, searchable: false },
        { data: 'actions', name: 'actions', orderable: false, searchable: false }
    ]
    });
    $('#bannedplayers-table').DataTable({
        processing: true,
        serverSide: true,
        scrollY: false,
        ajax: window.Laravel.routes.bannedIndex,
        columns: [
            { data: 'id', name: 'id' },
            { data: 'player.gamer_id', name: 'player.gamer_id',orderable: false, searchable: false }, 
            { data: 'user.name', name: 'username'}, 
            { data: 'ban_type.title', name: 'bantypes'}, 
            { data: 'ban_time.title', name: 'bantimes'}, 
            { 
                data: 'player_nick', 
                name: 'player_nick',
                // Bu kısımda render fonksiyonu ile özel bir gösterim sağlıyoruz.
                render: function(data, type, row) {
                    // Eğer updated_nick varsa updated_nick'i, yoksa player_nick'i kullan.
                    return row.updated_nick ? row.updated_nick : data;
                }
            },
          
            { data: 'banned_date', name: 'banned_date' }, // Ban tarihi için sütun
            { data: 'status', name: 'status' }, // Ban durumu için sütun
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],

    });
    $('#nick-histories-table').DataTable({
        processing: true,
        serverSide: true,
        scrollY: false,
        ajax: window.Laravel.routes.nickHistoriesIndex, // Laravel tarafında tanımlı bir rota
        columns: [
            { data: 'gamer_id', name: 'gamer_id', title: 'GAMER ID' },
            { data: 'last_nick', name: 'last_nick', title: 'Eski Nick' },
            { data: 'new_nick', name: 'new_nick', title: 'Yeni Nick' },
            { data: 'created_at', name: 'created_at', title: 'Değiştirilme Tarihi', render: function(data, type, row) {
                return moment(data).format('DD.MM.YYYY'); // Tarih formatınızı burada belirleyebilirsiniz
            }},
        ],
        order: [[3, 'desc']],
    });
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        scrollY: false,
        ajax: window.Laravel.routes.usersIndex, // Laravel tarafında tanımlı bir rota
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role', name: 'role' }, 
            { data: 'actions', name: 'actions' }, 
        ],

    });

    $('#not-banned-players-table').DataTable({
        processing: true,
        serverSide: true,
        scrollY: false,
        ajax: window.Laravel.routes.notbannedIndex,
        columns: [
        { data: 'id', name: 'id' },
        { 
            data: 'player_nick', 
            name: 'player_nick',
            // Bu kısımda render fonksiyonu ile özel bir gösterim sağlıyoruz.
            render: function(data, type, row) {
                // Eğer updated_nick varsa updated_nick'i, yoksa player_nick'i kullan.
                return row.updated_nick ? row.updated_nick : data;
            }
        },
        { data: 'email', name: 'email', orderable: false, searchable: false },
        
        { data: 'actions', name: 'actions', orderable: false, searchable: false},
    ]
    });

    $('#messages-table').DataTable({
        processing: true,
        serverSide: true,
        scrollY: false,
        ajax: window.Laravel.routes.messageIndex,
        columns: [
            {data: 'id', name: 'id'},
            {data: 'user', name: 'user.name'},
            {data: 'player', name: 'player.player_nick'},
            {data: 'status', name: 'status'},
            {data: 'created_at', name: 'created_at', searchable: false},
            {data: 'actions', name: 'actions'}
        ],
       
    });
    $('#donations-table').DataTable({
        processing: true,
        serverSide: true,
        scrollY: false,
        ajax: window.Laravel.routes.donationsIndex,
        columns: [
            {data: 'gamer_id', name: 'gamer_id'},
            {data: 'player.player_nick', name: 'player_nick'},
            {data: 'player.email', name: 'email'},
            {data: 'donation_rank', name: 'donation_rank'},
            {data: 'actions', name: 'actions'},
        ],
       
    });
    $('#exceptions-table').DataTable({
        processing: true,
        serverSide: true,
        scrollY: false,
        ajax: window.Laravel.routes.exceptionsIndex,
        columns: [
            {data: 'id', name: 'id'},
            { 
                data: 'player_nick', 
                name: 'player_nick',
                // Bu kısımda render fonksiyonu ile özel bir gösterim sağlıyoruz.
                render: function(data, type, row) {
                    // Eğer updated_nick varsa updated_nick'i, yoksa player_nick'i kullan.
                    return row.updated_nick ? row.updated_nick : data;
                }
            },
            { data: 'exception_status', name: 'exception_status'},
            { data: 'actions', name: 'actions', orderable: false, searchable: false },
        ],
       
    });
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': window.Laravel.csrfToken
    }
    });
});