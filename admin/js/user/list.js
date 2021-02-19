function loadUsers() {
    let target = qSel("#users_table > tbody");
    target.innerHTML = '';

    makeGetRequest(`${baseUrl}/admin_user/list/`, {}, function (data) {
        data.users.forEach(function (item) {
            let tr = document.createElement("tr");
            //    <tr><th>Username</th><th>Kontostand</th><th>Zuletzt online</th><th>Registriert seit</th><th>Aktion</th></tr>
            let date_login = item.date_last_login === null ? "Nie" : dayjs.unix(item.date_last_login).format('DD.MM.YYYY HH:mm');
            let tr_cnt = `<td>${item.username} `;
            if(item.status === 25) {
                tr_cnt += '<span class="info-admin">(ADMIN)</span>';
            }
            else if(item.status === -1) {
                tr_cnt += '<span class="info-blocked">(GESPERRT)</span>';
            }
            tr_cnt += `</td><td>${formatNumber(item.balance)}</td><td>${date_login}</td>
                            <td>${dayjs.unix(item.date_registered).format('DD.MM.YYYY HH:mm')}</td><td>${item.ref_name}</td>
                            <td>
                                <a class="btn js-btn js-btn-store" data-user="${item.username}" data-field="status" data-value="0" data-target="/admin_user/delete/${item.username}/"><i class="bi bi-trash"></i></a>
                                <input type="text" value="${item.information_user}" id="information_user_${item.username}"/>
                                <a class="btn js-btn-save" data-user="${item.username}" data-field="information_user" data-value="#information_user_${item.username}" data-target="/admin_user/update/${item.username}/"><i class="bi bi-save"></i></a>`;
                                if(item.status === 25) {
                                    tr_cnt +=`<a class="btn js-btn-store" data-user="${item.username}" data-field="status" data-value="0" data-target="/admin_user/update/${item.username}/" title="Zum User machen"><i class="bi bi-eye-slash"></i></a>`;
                                } else {
                                    tr_cnt +=`<a class="btn js-btn-store" data-user="${item.username}" data-field="status" data-value="25" data-target="/admin_user/update/${item.username}/" title="Zum Admin machen"><i class="bi bi-eye"></i></a>`;
                                }
                            tr_cnt+=`</td>`;
            tr.innerHTML = tr_cnt;
            target.appendChild(tr);
        })
        addDirectEvent('.js-btn-save', 'click', function(item) {
            data = {};
            data[item.dataset.field] = qSel(item.dataset.value).value;
            makePostRequest(baseUrl + item.dataset.target, data, function(data) {
                if(data.status === 1)
                    showNotify("Gespeichert!");
                else
                    showNotify("Nicht gespeichert!")
            });
        });
        addDirectEvent('.js-btn-store', 'click', function(item) {
            data = {};
            data[item.dataset.field] = item.dataset.value;
            let user = item.dataset.user;
            let m = confirm(`Bist du sicher? Nutzer: ${user}`);
            if(m) {
                makePostRequest(baseUrl + item.dataset.target, data, function (data) {
                    if (data.status === 1)
                        showNotify("Gespeichert!");
                    else
                        showNotify("Nicht gespeichert!")
                    window.app.redirect('admin:users');
                });
            }
        })
        window.app.finishRender();
    })
}

loadUsers();