
fullUrl = window.location
baseUrl = fullUrl.hostname == "localhost" ? `http://${fullUrl.host}/` : `https://${fullUrl.hostname}/`

function showInventory(){
    $('#tabel-inventory').empty();
    $.each(list_barang, function(key,val) {
        $('#tabel-inventory').append(`
            <tr>
                <td>
                    <div class="btn-group btn-group-sm">
                        <button id="read-button" data-id='` + val.id_barang +`' class="btn btn-info"><i class="fas fa-eye"></i></button>
                        <button id="edit-button" data-id='` + val.id_barang +`' class="btn btn-success"><i class="fas fa-edit"></i></button>
                        <button id="delete-button" data-id='` + val.id_barang +`' class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </div>
                </td>
                <td>${val.nama}</td>
                <td>${val.kode_inventaris}</td>
                <td>${val.jumlah}</td>
                <td>Rp ${val.harga}</td>
                <td>Rp ${val.jumlah * val.harga}</td>
                <td>${val.tanggal_beli}</td>
                <td>${val.nama_lokasi}</td>
                <td>${val.nama_kategori}</td>
                <td>${val.status}</td>
            </tr>`);
    });
    changeTitle("Data Inventaris Asset")
}

function hapusBarang(id_barang) {
    Swal.fire({
        text: 'Yakin akan menghapus?',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: `${baseUrl}api/barang/delete.php`,
                type: "POST",
                dataType: "json",
                data: JSON.stringify({id_barang : id_barang}),
                success : function(res) {
                    console.log(res)
                    getBarang();
                    setTimeout(function(){ 
                        showInventory()
                    }, 2000);
                },
                error: function(xhr,resp, text) {
                    console.log(text);
                }
            })
        }
    })
}

showInventory();

$(document).off('click', '#edit-button')
$(document).off('click', '#delete-button')
$(document).off('click', '#read-button')
$(document).on('click', '#edit-button', function() {
    var id = $(this).attr('data-id');
    console.log(id);
    goTo(null, 'edit_barang?id=' + id);
})
$(document).on('click', '#delete-button', function() {
    var id_barang = $(this).attr('data-id');
    hapusBarang(id_barang)
})
$(document).on('click', '#read-button', function() {
    var id = $(this).attr('data-id');
    goTo(null, 'detail_barang?id=' + id);
})


