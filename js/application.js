class FyiApplication {
    csrfToken = null;
    username = null;
    currencyDisplay = null;

    handleLink(item) {
        if (window.location.href.indexOf("#") > 0) {
            let data = window.location.href.split("#");
            window.location.href = window.location.href.replace(data[1], item.dataset.href);
        } else {
            window.location.href += '#' + item.dataset.href;
        }
        window.clickedItem = item;
        this.getTemplate(item.dataset.href);
    }

    getTemplate(target) {
        let self = this;
        this.startRender();
        let data = target.split(":");
        let xmlHttp = new XMLHttpRequest();
        let templateDir = window.isAdmin === true ? '/admin/templates' : '/templates';
        let scriptDir = window.isAdmin === true ? '/admin/js' : '/js';
        xmlHttp.open("GET", `${templateDir}/${data.join("/")}.html`, true); // false for synchronous request
        xmlHttp.send(null);
        xmlHttp.onreadystatechange = function () {
            if (xmlHttp.readyState === 4 && xmlHttp.status === 200) {
                qId('main-container').innerHTML = xmlHttp.responseText;
                let el = document.createElement('script');
                qId("add-script").innerHTML = '';
                el.src = `${scriptDir}/${data.join("/")}.js`;
                qId("add-script").appendChild(el);
                addDirectEvent('#main-container .js-link', 'click', (item) => {self.handleLink(item)});
                qAll('.currency-display').forEach(function (item) {
                    item.innerText = self.currencyDisplay;
                })
            }
        }
    }

    redirect(target, duration = 1000) {
        let self=this;
        window.setTimeout(function () {
            self.getTemplate(target);
        }, duration);
    }

    checkLogin() {
        makeGetRequest(baseUrl + '/home/status/', {}, (data) => {
            this.csrfToken = data.csrfToken;
            if (data.status === 1) { // user loggedin
                qAll('.user-link').forEach((item) => {
                    item.classList.remove("d-none");
                });
                qAll('.guest-link').forEach((item) => {
                    item.classList.add("d-none");
                });
                if (data.user.is_admin !== true) {
                    qAll('.admin-link').forEach((item) => {
                        item.classList.add("d-none");
                    });
                }
                qId("userInfo-name").innerHTML = data.user.username;
                self.username = data.user.username;
            } else {
                qAll('.user-link').forEach((item) => {
                    item.classList.add("d-none");
                });
                qAll('.guest-link').forEach((item) => {
                    item.classList.remove("d-none");
                });
                qId("userInfo-name").innerHTML = "Gast";
            }
        });
    }

    findGetParameter(parameterName) {
        let result = null,
            tmp = [];
        location.search
            .substr(1)
            .split("&")
            .forEach(function (item) {
                tmp = item.split("=");
                if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
            });
        return result;
    }

    checkRefParameter() {
        let ref = this.findGetParameter("ref");
        if (ref) {
            localStorage.setItem("cun_referral_name", ref);
        }
    }

    getConfig() {
        this.currencyDisplay = "Cuneros";
    }

    finishRender() {
        qId("main-container").classList.remove("loading");
    }

    startRender() {
        qId("main-container").classList.add("loading");
    }

    initialize() {
        let self = this;
        this.checkRefParameter();
        this.getConfig();
        this.checkLogin();
        this.getTemplate(this.checkAdressbar());
        addDirectEvent('.js-link', 'click', (item) => {self.handleLink(item)});
    }

    checkAdressbar() {
        if (window.location.href.indexOf("#") > 0) {
            return window.location.href.split("#")[1];
        } else {
            return "home:home";
        }
    }
}

window.onload = () => {
    window.app = new FyiApplication();
    window.app.initialize();
}
