function fetch_list() {
    makeGetRequest(baseUrl + '/admin_packager/list/', {}, function(data) {
        if(data.status !== 1) {
            showNotify(data.message);
        } else {
            let tgt = qSel("#packageList tbody");
            data.packages.forEach(function(item) {
                let tr = document.createElement("tr");
                tr.innerHTML = `<td><a data-href="packager:detail" data-item="${item.name}" class="js-link">${item.friendly_name}</a></td>
<td><a href="${item.author.website}" target="_blank">${item.author.name}</a> <a href="mailto:${item.author.email}"><i class="bi bi-mailbox"></i></a></td>
<td>${item.license}</td>
<td>${item.name} Version ${item.version}</td>`;
                tgt.appendChild(tr);
            })
            addDirectEvent('#packageList .js-link', 'click', (item) => {window.app.handleLink(item)});

        }
    });
    window.app.finishRender();
}

fetch_list();