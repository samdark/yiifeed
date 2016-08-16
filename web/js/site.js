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
