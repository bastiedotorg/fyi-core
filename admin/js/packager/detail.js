
makeGetRequest(baseUrl + `/admin_packager/detail/${window.clickedItem.dataset.item}/`, {}, function (data) {
    qId("packageName").innerHTML = data.package.friendly_name;
    qId("packageCode").innerHTML = data.package.name;
    let tgt = qId("packageFiles");
    data.package.files.forEach(function(item) {
        let li = document.createElement("li");
        li.innerHTML = item.filename;

        if (item.exists === true && item.current === true) {
            li.classList.add("bg-success");
        } else if(item.exists === true) {
            li.classList.add("bg-danger");
        } else {
            li.classList.add("bg-warning");

        }
        tgt.appendChild(li);
    })
    window.app.finishRender();
})