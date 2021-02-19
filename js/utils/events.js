/**
 * event tools
 * (c) 2021 bastie.space
 */


function addDirectEvent(selector, evtName, eventFunc) {
    let iOS = navigator.platform && /iPad|iPhone|iPod/.test(navigator.platform);
    let touchEvent = ('ontouchstart' in window && iOS) ? 'touchstart' : 'click';
    let eventName = 'click' === evtName ? touchEvent : evtName;

    document.querySelectorAll(selector).forEach(function (item) {
        item.addEventListener(eventName, function (event) {
            if (eventFunc(item, event) === false) {
                event.preventDefault();
            }
        });
    })
}