function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();

    var id_token = googleUser.getAuthResponse().id_token;
    var email = profile.getEmail();
    var username = profile.getName();
    var form_data = {
        'id_token' : id_token,
        'email' : email,
        'name' : username
    };
    console.log(form_data)
    form_data = JSON.stringify(form_data);
    console.log(form_data)

    $.ajax({
        url: `${baseUrl}api/user/tokenlogin.php`,
        type: 'POST',
        data: form_data,
        dataType: "json",
        success: function (data, cname) {
            console.log(data)
            console.log(cname);
            if (data.status == true) {
                var token = data.token;
                setCookie('loginToken', token, 1);
                setCookie("username", username, 1)
                goTo(event, 'dashboard');
            } else if (data.status == false) {
                goTo(event, 'login');
            }
        }
    })
}
