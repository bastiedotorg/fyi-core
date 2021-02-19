makePostRequest(baseUrl + '/home/logout/',
    {}, function (data) {
        window.app.checkLogin();
    }, function (data) {
        alert("fail!");
    });

window.app.finishRender();
