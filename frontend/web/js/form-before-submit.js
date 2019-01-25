(function ($) {
    "use strict";
    var FromOps;

    function isEmpty(value, trim) {
        return value === null || value === undefined || value.length === 0 || (trim && $.trim(value) === '');
    }

    FromOps = {
        swal: false,
        pjax: {id: ''},
        modal: {id: ''}
    };

    $.fn.formBeforeSubmit = function (options) {
        var args = Array.apply(null, arguments);
        args.shift();
        var $form = this;
        $form.on('beforeSubmit', function () {
            var data = $form.serialize();
            var $btn = $('#' + $form[0].id + ' button[type="submit"]').button('loading');
            $.ajax({
                url: $form.attr('action'),
                type: $form.attr('method'),
                data: data,
                success: function (response) {
                    // Implement successful
                    $btn.button('reset');
                    if (response.success) {
                        if (!isEmpty(options.swal) && options.swal === true) {
                            Swal({
                                type: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                        if (!isEmpty(options.modal.id)) {
                            $(options.modal.id).modal('hide');
                        }
                        if (!isEmpty(options.pjax.id)) {
                            $.pjax.reload({container: options.pjax.id});
                        }
                    } else {
                        $.each(response.validate, function (key, val) {
                            $($form).yiiActiveForm('updateAttribute', key, [val]);
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $btn.button('reset');
                    Swal({
                        type: 'error',
                        title: textStatus,
                        text: errorThrown,
                    });
                }
            });
            return false; // prevent default submit
        });
        return this;
    };
    $.fn.formBeforeSubmit.defaults = FromOps;
})(window.jQuery);