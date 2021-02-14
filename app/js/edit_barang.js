var url = new URL(window.location.href)
var id = url.searchParams.get("id")

fullUrl = window.location
baseUrl = fullUrl.hostname == "localhost" ? `http://${fullUrl.host}/` : `https://${fullUrl.hostname}/`

function editBarang(id) {
    $.getJSON(`${baseUrl}api/barang/read_one.php?id_barang=` + id, function (data) {
        var kode_inventaris = data.kode_inventaris;
        var nama = data.nama;
        var jumlah = data.jumlah;
        var harga = data.harga;
        var tanggal_beli = data.tanggal_beli;
        var status = data.status;
        var id_kategori = data.id_kategori;
        var id_lokasi = data.id_lokasi;
        var id_barang = data.id_barang;

        $("#kode_inventaris").val(kode_inventaris);
        $("#nama").val(nama);
        $("#jumlah").val(jumlah);
        $("#harga").val(harga);
        $("#tanggal_beli").val(tanggal_beli);
        $("#status").val(status);
        $("#id_barang").val(id_barang);

        // ambil lokasi 
        let lok = '';
        $.each(list_lokasi, function(key, val) {
            if(val.id_lokasi == id_lokasi) {lok += `<option value='` + val.id_lokasi + `' selected>` + val.lokasi + `</option>`;}
            else {lok += `<option value=' ` + val.id_lokasi + `'>` + val.lokasi + `</option>`;}
        });
        $('#lokasi').html(lok);
        // ambil kategori 
        let kat = '';
        $.each(list_kategori, function(key, val) {
            if(val.id_kategori == id_kategori) {kat += `<option value='` + val.id_kategori + `' selected>` + val.kategori + `</option>`;}
            else {kat += `<option value=' ` + val.id_kategori + `'>` + val.kategori + `</option>`;}
        });
        $('#kategori').html(kat);
        $(document).on('click', '#submit-edit', function(e) {
            var form_data = {
                'kode_inventaris' : $("#kode_inventaris").val(),
                'nama' : $("#nama").val(),
                'jumlah' : $("#jumlah").val(),
                'harga' : $("#harga").val(),
                'tanggal_beli' : $("#tanggal_beli").val(),
                'id_kategori' : $("#kategori").val(),
                'id_lokasi' : $("#lokasi").val(),
                'id_barang' : $("#id_barang").val(),
                'status' : $("#status").val()
            };
            console.log(form_data)
            form_data = JSON.stringify(form_data);
            console.log(form_data)
            $.ajax({
                url: `${baseUrl}api/barang/update.php`,
                type: "POST",
                contentType: "application/json",
                data: form_data,
                success: function(result){
                    console.log(result)
                    getBarang()
                    showInventory()
                    goTo(null, 'inventory')
                }, 
                error: function(xhr, resp, text) {
                    console.log(text);
                }
            });
        });
        
    });
}

editBarang(id);

