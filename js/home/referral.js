qId("referral_link").value = 'http://localhost/?ref='+window.username;
makeGetRequest(baseUrl + '/bank/referrals/', {}, function(data) {
    if(data.status !== 1) {
        showNotify("Konnte Refs nicht laden.");
    } else {
        let tgt = qId("userReferrals");
        tgt.innerHTML = '';
        data.referrals.forEach(function(item) {
            let li = document.createElement("li");
            li.innerHTML = `${item.username} (${item.amount_total} Cuneros)`;
            tgt.appendChild(li);
        })
    }

})
window.app.finishRender();
