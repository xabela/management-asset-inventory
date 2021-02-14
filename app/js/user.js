fullUrl = window.location
baseUrl = fullUrl.hostname == "localhost" ? `http://${fullUrl.host}/` : `https://${fullUrl.hostname}/`

async function showUser() {
    $('#table-user').empty();
    $.each(list_user, function (key, val) {
        $('#table-user').append(`
                <tr>
                    <td>${val.username == null ? "" : val.username}</td>
                    <td>${val.email}</td>
                    <td>
                        <a href="#" class="btn btn-danger btn-sm" id="delete-user-button"
                        data-id='` + val.id_user + `'><i class="fas fa-trash"></i></a></td>
                </tr>`);
    });
}

function buatUser() {
    var form_data = {
        'email': $("#email_user").val()
    };
    form_data = JSON.stringify(form_data);
    $.ajax({
        url: `${baseUrl}api/user/create.php`,
        type: "POST",
        contentType: "application/json",
        data: form_data,
        success: async function (result) {

            $('#modal-user').modal('hide');
            await getUser();
            await showUser();
            await clearField();
        },
        error: function (xhr, resp, text) {
            console.log(text);
        }
    });
};

function hapusUser(id_user) {
    Swal.fire({
        text: 'Yakin akan menghapus?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: `${baseUrl}api/user/delete.php`,
                type: "POST",
                dataType: "json",
                data: JSON.stringify({ id_user: id_user }),
                success: function (res) {
                    console.log(res)
                    getUser();
                    setTimeout(function () {
                        showUser()
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
    $("#email_user").val(null);
}

$(document).on('click', '#delete-user-button', function () {
    var id_user = $(this).attr('data-id');
    hapusUser(id_user);
})

changeTitle("List User");
showUser();