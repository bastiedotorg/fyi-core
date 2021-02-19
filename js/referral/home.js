qId("referral_link").value = 'https://cuneroverdienst.de/?ref='+window.username;
makeGetRequest(baseUrl + '/referral/list/', {}, function(data) {
    if(data.status !== 1) {
        showNotify("Konnte Refs nicht laden.");
    } else {
        let tgt = qId("userReferrals");
        if(data.referrals.length) {
            tgt.innerHTML = '';
            data.referrals.forEach(function (item) {
                let li = document.createElement("li");
                li.innerHTML = `${item.username} <a class="btn btn-danger btn-js-delete" data-username="${item.username}" data-user-id="${item.child_id}" data-target="/referral/delete_ref/">Freigeben</a>
<input type="text" value="${item.ref_back}" id="id_ref_back_${item.child_id}" aria-valuemin="0" aria-valuemax="100" size="5" /> <a class="btn btn-primary btn-js-post" data-field="ref_back" data-value="#id_ref_back_${item.child_id}" data-user-id="${item.child_id}" data-target="/referral/alter_ref/" data-message-success="Refback wurde eingetragen!">Refback Eintragen</a>
`;
                tgt.appendChild(li);
            });
            deleteButtons();
        }


        let tgt2 = qId("userParent");
        tgt2.innerHTML = "";
        if(data.parent.hasOwnProperty("username")) {
            tgt2.innerHTML = `<li>${data.parent.username} (${data.parent.ref_back}% Refback)</li>`;
        } else {
            tgt2.innerHTML = `<li><input type="text" value="" id="new_parent_input" placeholder="Neuen Werber eintragen" /> <a class="btn btn-primary btn-js-post" data-field="username" data-value="#new_parent_input" data-target="/referral/new_parent/" data-user-id="0" data-message-success="Werber wurde eingetragen!">Eintragen</a></li>`;
        }
        jsPostButtons();
    }
    window.app.finishRender();
})

function deleteButtons() {
    addDirectEvent('.btn-js-delete', 'click', function (item) {
        let m = confirm(`Bist du sicher? Nutzer: ${item.dataset.username}`);
        if(m) {
            makePostRequest(baseUrl + item.dataset.target, {"user_id": item.dataset.userId}, function (data) {
                if(data.status === 1) {
                    showNotify("Referral freigegeben.");
                    window.app.redirect("home:referral");
                } else {
                    showNotify("Ein Fehler ist aufgetreten: " + data.message);
                }
            })
        }
    });
}

function jsPostButtons() {
    addDirectEvent('.btn-js-post', 'click', function(item) {
        let post_data = {};
        post_data[item.dataset.field] = qSel(item.dataset.value).value;
        post_data["user_id"] = item.dataset.userId;
        makePostRequest(baseUrl + item.dataset.target, post_data, function(data) {
            if(data.status === 0)
                showNotify(data.message);
            if(data.status === 1) {
                showNotify(item.dataset.messageSuccess);
                window.app.redirect("home:referral");
            }
        }, function(data) {
            showNotify("Konnte Server nicht erreichen.");
        })
    })
}