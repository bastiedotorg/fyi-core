function loadConfigurationForm() {
    makeGetRequest(baseUrl + '/admin_config/get/', {}, function (data) {
        let template = qId('formRow').innerHTML;
        let target = qId('formContent');
        for (const [key, value] of Object.entries(data.items)) { // top entries
            let div = document.createElement("div");
            div.classList.add("mb-3","row");
            div.innerHTML = key;
            target.appendChild(div);
            value.forEach(function (item) {
                let row = document.createElement("div");
                row.innerHTML = template;
                row.innerHTML = row.innerHTML.replaceAll(/%%FIELD_ID%%/g, item.field_id)
                                             .replaceAll(/%%FIELD_VALUE%%/g, item.current_value)
                                             .replaceAll(/%%FIELD_HELP%%/g, item.help_text)
                                             .replaceAll(/%%FIELD_DEFAULT%%/g, item.default_value)
                                             .replaceAll(/%%FIELD_LABEL%%/g, item.label);

                target.appendChild(row);
            })
        }
        window.app.finishRender();
    })
}

addDirectEvent('#configurationForm', 'submit', function() {
    const FD = new FormData( qId('configurationForm') );

    makePostRequest(baseUrl + '/admin_config/set/', FD, function(data) {
        if(data.status === 1) {
            showNotify("Konfiguration gespeichert!");
            window.app.redirect("home:home");
        } else {
            showNotify(data.message);
        }
    }, function (data) {
        showNotify('Server error');
    }, true);

    return false;
})

loadConfigurationForm();