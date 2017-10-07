jQuery(function($) {
    if ($('.news-add').length) {
        initEditor($('.news-add form textarea'));
    }

    if ($('.news-update').length) {
        initEditor($('.news-update form textarea'));
    }

    if ($('#comment-text').length) {
        initEditor($('#comment-text'));
    }
});

// popup window used for facebook and twitter share
function popupWindow(url, title, w, h) {
    var y = window.outerHeight / 2 + window.screenY - ( h / 2)
    var x = window.outerWidth / 2 + window.screenX - ( w / 2)
    return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + y + ', left=' + x);
} 