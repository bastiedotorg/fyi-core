/**
 * http tools
 * (c) 2021 bastie.space
 */


function makePostRequest(targetUrl, data, successFunction, failFunction = null, hasFormData = false) {
    let xhr = new XMLHttpRequest();
    let urlEncodedData = "",
        urlEncodedDataPairs = [],
        name;

    for (name in data) {
        urlEncodedDataPairs.push(encodeURIComponent(name) + '=' + encodeURIComponent(data[name]));
    }
    urlEncodedData = urlEncodedDataPairs.join('&').replace(/%20/g, '+');
    xhr.open('POST', targetUrl, true);
    xhr.setRequestHeader('X-CSRFToken', window.csrfToken);
    xhr.onreadystatechange = function () {
        if (this.readyState !== 4) return;
        if (this.status === 200 || this.status === 201 || this.status === 202) {
            let data = JSON.parse(this.responseText);
            successFunction(data);
        } else {
            if (failFunction)
                failFunction();
        }
    };

    if (hasFormData) {
        xhr.send(data);
    } else {
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.send(urlEncodedData);
    }
}

function makeGetRequest(targetUrl, data, successFunction, failFunction) {
    let xhr = new XMLHttpRequest();
    let urlEncodedData = "",
        urlEncodedDataPairs = [],
        name;

    for (name in data) {
        urlEncodedDataPairs.push(encodeURIComponent(name) + '=' + encodeURIComponent(data[name]));
    }
    urlEncodedData = urlEncodedDataPairs.join('&').replace(/%20/g, '+');
    xhr.open('GET', targetUrl + '?' + urlEncodedData, true);
    xhr.onreadystatechange = function () {
        if (this.readyState !== 4) return;
        if (this.status === 200 || this.status === 201 || this.status === 202) {
            let data = JSON.parse(this.responseText);
            successFunction(data);
        } else {
            if (typeof failFunction === "undefined") {
                console.log("Could not contact server.");
            } else {
                failFunction();
            }
        }
    };
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Finally, send our data.
    xhr.send();
}