addDirectEvent('#loginForm', 'submit', function () {
    if(qId("idAgbChecked").checked === true) {
        makePostRequest(baseUrl + '/home/login',
            {
                "username": qId('inputUsername').value,
                "password": qId('inputPassword').value,
                "referral": localStorage.getItem("cun_referral_name"),
            }, function (data) {
                window.app.checkLogin();
                if (data.status === 1) {
                    showNotify("Login erfolgreich!");
                    window.app.redirect('home:home');
                }
                else
                    showNotify("Login fehlgeschlagen!");

            }, function (data) {
                showNotify("Login fehlgeschlagen!");
            });
    } else {
        showNotify("Du musst die Allgemeinen Geschäftsbedingungen akzeptieren.");
    }
    return false;
});
window.app.finishRender();
