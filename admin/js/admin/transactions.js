function loadTransactions() {
    let target = qSel("#transaction_table > tbody");
    target.innerHTML = '';

    makeGetRequest(`${baseUrl}/admin/transactions/`, {}, function (data) {
        data.transactions.forEach(function (item) {
            let tr = document.createElement("tr");
            //    <tr><th>Username</th><th>Kontostand</th><th>Zuletzt online</th><th>Registriert seit</th><th>Aktion</th></tr>
            tr.innerHTML = `<td>${item.username}</td><td>${formatNumber(item.amount)}</td><td>${item.subject}</td><td>${dayjs.unix(item.date_transfer).format('DD.MM.YYYY HH:mm')}</td>`;

            target.appendChild(tr);
        })

    })
}

loadTransactions();