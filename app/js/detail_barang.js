var url = new URL(window.location.href)
var id = url.searchParams.get("id")

fullUrl = window.location
baseUrl = fullUrl.hostname == "localhost" ? `http://${fullUrl.host}/` : `https://${fullUrl.hostname}/`

function detailBarang(id) {
    $.getJSON(`${baseUrl}api/barang/read_one.php?id_barang=` + id, function(data){
        $('#kode_inventaris').html(data.kode_inventaris)
        $('#nama').html(data.nama)
        $('#jumlah').html(data.jumlah)
        $('#harga').html(data.harga)
        $('#total').html(data.jumlah*data.harga)
        $('#tanggal_beli').html(data.tanggal_beli)
        $('#lokasi').html(data.nama_lokasi)
        $('#kategori').html(data.nama_kategori)
        $('#status').html(data.harga)
    });
}
detailBarang(id);
