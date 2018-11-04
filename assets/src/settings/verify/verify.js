init();

function init() {
    var baseUrl = '/telegram-verify/web/api/';

    $('#bot-ok').on('click', function () {
        $.ajax({
            url: baseUrl + 'check-bot-subscribe',
            type: 'POST',
            data: {
                csrf: $('meta[name=csrf-token]').attr("content"),
            },
            success: function (data) {
                console.log(data);
                var json = $.parseJSON(data);
                $('#verification_container').empty().append(json.data);
            }
        })
    });

    $('#bot-subscribe-button').on('click', function () {
        $('#confirm-verify').show();
    });

    $('#tg-tfa-set').on('click', function () {
        $.ajax({
            url: baseUrl + $(this).data('url'),
            type: 'POST',
            data: {
                csrf: $('meta[name=csrf-token]').attr("content"),
            },
            success: function (data) {
                console.log(data);
                var json = $.parseJSON(data);
                $('#verification_container').empty().append(json.data);
                init();
            }
        })
    });

    $('#google-tfa-set').on('click', function () {
        $.ajax({
            url: baseUrl + $(this).data('url'),
            type: 'POST',
            data: {
                csrf: $('meta[name=csrf-token]').attr("content"),
            },
            success: function (data) {
                console.log(data);
                var json = $.parseJSON(data);
                $('#verification_container').empty().append(json.data);
                init();
            }
        })
    });
}
