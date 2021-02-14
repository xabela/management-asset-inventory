fullUrl = window.location
baseUrl = fullUrl.hostname == "localhost" ? `http://${fullUrl.host}/` : `https://${fullUrl.hostname}/`

async function showKategori() {
    $('#table-kategori').empty();
    $.each(list_kategori, function (key, val) {
        $('#table-kategori').append(`
                <tr>
                    <td>${val.kategori}</td>
                    <td> <a href="" class="btn btn-success btn-sm" id="edit-kategori-button" data-toggle="modal" 
                    data-target="#modal-edit-kategori" data-id='` + val.id_kategori + `'><i class="fas fa-edit"></i></a>
                        <a href="#" class="btn btn-danger btn-sm" id="delete-kategori-button" 
                        data-id='` + val.id_kategori + `'><i class="fas fa-trash"></i></a></td>
                </tr>`);
    });
}

function buatKategori() {
    var form_data = {
        'kategori': $("#buat-kategori").val()
    };
    form_data = JSON.stringify(form_data);
    $.ajax({
        url: `${baseUrl}api/kategori/create.php`,
        type: "POST",
        contentType: "application/json",
        data: form_data,
        success: async function (result) {
            console.log(result)
            $('#modal-kategori').modal('hide');
            await getKategori();
            await showKategori();
            await clearField();
        },
        error: function (xhr, resp, text) {
            console.log(text);
        }
    });
};

function editKategori(id_kategori) {
    console.log(id_kategori)
    $.getJSON(`${baseUrl}api/kategori/read_one.php?id_kategori=` + id_kategori, function (data) {
        console.log(data)
        var kategori = data.kategori;
        var id_kategori = data.id_kategori;

        $("#edit-nama-kategori").val(kategori);
        $('#id_kategori').val(id_kategori);

        $(document).on('click', '#edit-kategori', function (e) {
            e.preventDefault();
            var form_data = {
                'kategori': $("#edit-nama-kategori").val(),
                'id_kategori': $('#id_kategori').val(),
            };
            form_data = JSON.stringify(form_data);
            $.ajax({
                url: `${baseUrl}api/kategori/update.php`,
                type: "POST",
                contentType: "application/json",
                data: form_data,
                success: async function (result) {
                    $('#modal-edit-kategori').modal('hide');
                    await getKategori();
                    await showKategori();
                    await clearField();
                },
                error: function (xhr, resp, text) {
                    console.log(text);
                }
            });
        });
    });
}

function hapusKategori(id_kategori) {
    Swal.fire({
        text: 'Yakin akan menghapus?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: `${baseUrl}api/kategori/delete.php`,
                type: "POST",
                dataType: "json",
                data: JSON.stringify({ id_kategori: id_kategori }),
                success: function (res) {
                    console.log(res)
                    getKategori();
                    setTimeout(function () {
                        showKategori()
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
    $("#buat-kategori").val(null);
}

$(document).on('click', '#edit-kategori-button', function () {
    var id_kategori = $(this).attr('data-id');
    console.log(id_kategori)
    editKategori(id_kategori)
})
$(document).on('click', '#delete-kategori-button', function () {
    var id_kategori = $(this).attr('data-id');
    console.log(id_kategori)
    hapusKategori(id_kategori);
})

changeTitle("List Kategori Asset");
showKategori();


