function showNotify(message) {
    let toast = new bootstrap.Toast(qId("infoToast"), {});
    qSel('#infoToast .toast-body').innerHTML = message;
    toast.show();
}