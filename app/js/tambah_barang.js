function tambahBarang() {    
    var form_data = {
        'kode_inventaris' : $("#kode_inventaris").val(),
        'nama' : $("#nama").val(),
        'jumlah' : $("#jumlah").val(),
        'harga' : $("#harga").val(),
        'tanggal_beli' : $("#tanggal_beli").val(),
        'id_kategori' : $("#kategori").val(),
        'id_lokasi' : $("#lokasi").val(),
        'status' : $("#status").val()
    };
    form_data = JSON.stringify(form_data);
    $.ajax({
        url: `${baseUrl}api/barang/create.php`,
        type: "POST",
        contentType: "application/json",
        data: form_data,
        success: function(result){
            console.log(result)
            getBarang()
            showInventory()
            goTo(event, 'inventory')
        }, 
        error: function(xhr, resp, text) {
            console.log(text);
        }
    });
};

function ambilData() {
    // ambil lokasi 
    let lok = '';
    $.each(list_lokasi, function(key, val) {
        lok += `<option value=' ` + val.id_lokasi + `'>` + val.lokasi + `</option>`;
    });
    $('#lokasi').html(lok);
    // ambil kategori 
    let kat = '';
    $.each(list_kategori, function(key, val) {
        kat += `<option value=' ` + val.id_kategori + `'>` + val.kategori + `</option>`;
    });
    $('#kategori').html(kat);
    // return;
}
ambilData();
// tambahBarang(); 
