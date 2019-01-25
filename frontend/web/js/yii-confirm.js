isEmpty = function (v) {
    return v === undefined || v === null || v.length === 0;
};
(function () {
    "use strict";
    yii.confirm = function (message, ok, cancel) {
        var pjaxId = $(this).data('pjax-reload'),
            url = $(this).attr('href');
        Swal({
            title: message + '?',
            text: '',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            preConfirm: function () {
                return new Promise(function (resolve) {
                    $.ajax({
                        method: "POST",
                        url: url,
                        dataType: "json",
                        success: function (response) {
                            if (!isEmpty(pjaxId)) {
                                $.pjax.reload({container: pjaxId});
                            }
                            resolve();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            Swal({
                                type: 'error',
                                title: textStatus,
                                text: errorThrown,
                            });
                        }
                    });
                });
            }
        }).then((result) => {
            if (result.value) {
                Swal(
                    'Deleted!',
                    '',
                    'success'
                );
            }
        });
        return false;
    }
})();
