addDirectEvent('#loginForm', 'submit', function () {
    if(qId("idAgbChecked").checked === true) {
        makePostRequest(baseUrl + '/home/login',
            {
                "username": qId('inputUsername').value,
                "password": qId('inputPassword').value,
            }, function (data) {
                window.checkLogin();
                if (data.status === 1) {
                    showNotify("Login erfolgreich!");
                    window.app.redirect('home:home');
                }
                else {
                    showNotify("Login fehlgeschlagen!");
                }

            }, function (data) {
                showNotify("Login fehlgeschlagen!");
            });
    } else {
        showNotify("Du musst die Allgemeinen Geschäftsbedingungen akzeptieren.");
    }
    return false;
});
window.app.finishRender();
