fullUrl = window.location
baseUrl = fullUrl.hostname == "localhost" ? `http://${fullUrl.host}/` : `http://${fullUrl.hostname}/`

var list_barang = [];
var list_lokasi = [];
var list_kategori = [];
var list_user = [];

function init() {
    let pathName = window.location.pathname.split('/')
    let page = pathName[1] == "" ? "login" : pathName[1];
    console.log(pathName[1]);
    var url = new URL(window.location.href)
    var id = url.searchParams.get("id")
    if(id != null){
        goTo(null, `${page}?id=${id}`)
    } else {
        getBarang();
        getLokasi();
        getKategori();
        getUser();
        goTo(null, page)
    }
}

init();
// fungsi back
window.addEventListener("popstate", function() {
    goTo(null, window.location.pathname.split('/')[1])
})

function goTo(e, page) {
    console.log('you go to ', page);
    if (e != null) {
        e.preventDefault();
    }
    if (page == 'login' || page == '') {
        window.history.pushState("object or string", "", '/');
        getTemplateLogin(page)
    } else {
        console.log('masuk sini');
        window.history.pushState("object or string", "", `/${page}`);
        var url = new URL(window.location.href)
        var id = url.searchParams.get("id")
        if(id != null){
            getTemplate(window.location.pathname.split('/')[1])
        } else {
            getTemplate(page)
        }
    }
}

async function getTemplate(page) {
    if(!await isUserLoggedIn()){
        goTo(null, 'login')
        return;
    }     
    $.ajax({
        url: `${baseUrl}route.php?page=${page}`,
        type: "GET",
        // "content-type": "application/json",
        data: {},
        success: function(res) {
            let data = JSON.parse(res);
            $('#header').html(data.header);
            $('#app').html(data.content);
            $('#nama_admin').html(getCookie('username'));

        }, error: function(res) {
            console.log(res.responseText);
        }
    });
}

async function isUserLoggedIn(){
    let token = getCookie('loginToken');
    let dataAjax = {
        token
    }
    dataAjax = JSON.stringify(dataAjax)

    let resData = await $.ajax({
        url: `${baseUrl}api/user/validate_token.php`,
        type: 'POST',
        data: dataAjax,
    })
    console.log(resData.message);
    return resData.message;
}

function getTemplateLogin(page) {
    $.ajax({
        url: `${baseUrl}route_login.php?page=${page}`,
        type: "GET",
        // "content-type": "application/json",
        data: {},
        success: function(res) {
            let data = JSON.parse(res);
            $('#header').html(data.content)
        }, error: function(res) {
            console.log(res.responseText);
        }
    });
}

function changeTitle(page_title){
    $('#page-title').text(page_title);
    document.title = page_title;
}

function getBarang() {
    $.getJSON(`${baseUrl}api/barang/read.php`, function(data) {
        list_barang = data;
    });
}

async function getKategori() {
    await $.getJSON(`${baseUrl}api/kategori/read.php`, function(data) {
        list_kategori = data;
    });
}

async function getLokasi() {
    await $.getJSON(`${baseUrl}api/lokasi/read.php`, function(data) {
        list_lokasi = data;
    });
}

async function getUser() {
    await $.getJSON(`${baseUrl}api/user/read.php`, function(data) {
        list_user = data;
    });
}

function signOut() {
                    
    var auth2 = gapi.auth2.getAuthInstance();
    var token = getCookie('loginToken')
    var form_data = {
        'token' : token
    };
    form_data = JSON.stringify(form_data);
        $.ajax({
            url: `${baseUrl}api/user/logout.php`,
            type :'POST',
            dataType : "JSON",
            data : form_data,
            success: function(x,name){
                setCookie('loginToken', '', 0)
                auth2.signOut();
                goTo(event,'login');
            }
        });
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname){
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' '){
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}