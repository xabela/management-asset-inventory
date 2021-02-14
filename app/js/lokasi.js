fullUrl = window.location
baseUrl = fullUrl.hostname == "localhost" ? `http://${fullUrl.host}/` : `https://${fullUrl.hostname}/`

async function showLokasi() {
    $('#table-lokasi').empty();
    $.each(list_lokasi, function (key, val) {
        $('#table-lokasi').append(`
                <tr>
                <td> <a href="" class="btn btn-success btn-sm" id="edit-lokasi-button" data-toggle="modal" 
                data-target="#modal-edit-lokasi" data-id='` + val.id_lokasi + `'><i class="fas fa-edit"></i></a>
                    <a href="#" class="btn btn-danger btn-sm" id="delete-lokasi-button" 
                    data-id='` + val.id_lokasi + `'><i class="fas fa-trash"></i></a></td>
                    <td>${val.lokasi}</td>
                    <td>${val.alamat}</td>
                </tr>`);
    });
}

function buatLokasi() {
    var form_data = {
        'lokasi': $("#nama-lokasi").val(),
        'alamat': $("#alamat").val()
    };
    form_data = JSON.stringify(form_data);
    $.ajax({
        url: `${baseUrl}api/lokasi/create.php`,
        type: "POST",
        contentType: "application/json",
        data: form_data,
        success: async function (result) {
            $('#modal-lokasi').modal('hide');
            await getLokasi();
            await showLokasi();
            await clearField();
        },
        error: function (xhr, resp, text) {
            console.log(text);
        }
    });
};

function editLokasi(id_lokasi) {
    $.getJSON(`${baseUrl}api/lokasi/read_one.php?id_lokasi=` + id_lokasi, function (data) {
        var lokasi = data.lokasi;
        var alamat = data.alamat;
        var id_lokasi = data.id_lokasi;

        $("#edit-nama-lokasi").val(lokasi);
        $("#edit-alamat").val(alamat);
        $('#id_lokasi').val(id_lokasi);

        $(document).on('click', '#edit-lokasi', function (e) {
            e.preventDefault();
            var form_data = {
                'lokasi': $("#edit-nama-lokasi").val(),
                'alamat': $("#edit-alamat").val(),
                'id_lokasi': $('#id_lokasi').val(),
            };
            form_data = JSON.stringify(form_data);
            $.ajax({
                url: `${baseUrl}api/lokasi/update.php`,
                type: "POST",
                contentType: "application/json",
                data: form_data,
                success: async function (result) {
                    $('#modal-edit-lokasi').modal('hide');
                    await getLokasi();
                    await showLokasi();
                    await clearField();
                },
                error: function (xhr, resp, text) {
                    console.log(text);
                }
            });
        });
    });
}

function hapusLokasi(id_lokasi) {
    Swal.fire({
        text: 'Yakin akan menghapus?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: `${baseUrl}api/lokasi/delete.php`,
                type: "POST",
                dataType: "json",
                data: JSON.stringify({ id_lokasi: id_lokasi }),
                success: function (res) {
                    console.log(res)
                    getLokasi();
                    setTimeout(function () {
                        showLokasi()
                    }, 100);
                },
                error: function (xhr, resp, text) {
                    console.log(text);
                }
            })
        }
    })
}

async function clearField() {
    $("#nama-lokasi").val(null);
    $("#alamat").val(null);
}


$(document).on('click', '#edit-lokasi-button', function () {
    var id_lokasi = $(this).attr('data-id');
    editLokasi(id_lokasi)
})
$(document).on('click', '#delete-lokasi-button', function () {
    var id_lokasi = $(this).attr('data-id');
    hapusLokasi(id_lokasi);
})

changeTitle("List Lokasi Tambak");
showLokasi();