fullUrl = window.location
baseUrl = fullUrl.hostname == "localhost" ? `http://${fullUrl.host}/` : `https://${fullUrl.hostname}/`

$("#total_barang").html(list_barang.length)
$("#total_lokasi").html(list_lokasi.length)
$("#total_kategori").html(list_kategori.length)
$("#total_member").html(list_user.length)


changeTitle("DASHBOARD")