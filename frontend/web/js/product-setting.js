(function ($) {
    "use strict";

    var $form = $('#form-product'), isEmpty;
    isEmpty = function (v) {
        return v === undefined || v === null || v.length === 0;
    };
    $form.on('beforeSubmit', function () {
        var paperSizeKeys = $('#grid-paper-size').yiiGridView('getSelectedRows'),
            beforePrintKeys = $('#grid-before-print').yiiGridView('getSelectedRows'),
            afterPrintKeys = $('#grid-after-print').yiiGridView('getSelectedRows'),
            paperKeys = $('#grid-paper').yiiGridView('getSelectedRows'),
            coatingKeys = $('#grid-coating').yiiGridView('getSelectedRows'),
            dieCutKeys = $('#grid-diecut').yiiGridView('getSelectedRows'),
            foldKeys = $('#grid-fold').yiiGridView('getSelectedRows'),
            foilColorKeys = $('#grid-foil-color').yiiGridView('getSelectedRows'),
            bookBindingKeys = $('#grid-book-binding').yiiGridView('getSelectedRows'),
            perforateKeys = $('#grid-perforate').yiiGridView('getSelectedRows');
        //var data = \$form.serialize();
        var formData = {};
        $form.serializeArray().map(function (x) {
            formData[x.name] = x.value;
        });
        var $btn = $('#' + $form[0].id + ' button[type="submit"]').button('loading');
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            data: $.extend(formData, {
                paperSizeKeys: paperSizeKeys,
                beforePrintKeys: beforePrintKeys,
                afterPrintKeys: afterPrintKeys,
                paperKeys: paperKeys,
                coatingKeys: coatingKeys,
                dieCutKeys: dieCutKeys,
                foldKeys: foldKeys,
                foilColorKeys: foilColorKeys,
                bookBindingKeys: bookBindingKeys,
                perforateKeys: perforateKeys
            }),
            success: function (response) {
                // Implement successful
                $btn.button('reset');
                if (response.success) {
                    Swal({
                        type: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    if (response.action === 'create-product') {
                        setTimeout(function () {
                            window.location.href = response.data.url;
                        }, 2000);
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
    //options clicked
    var $inputChk = $form.find('input.checkbox-option');
    $('input.checkbox-option').on('click', function (e) {
        if ($(this).is(":checked") && !isEmpty($(this).data('clicked'))) {
            $('li.' + $(this).data('clicked')).show();
        } else if(!isEmpty($(this).data('clicked'))){
            $('li.' + $(this).data('clicked')).hide();
        }
    });
    //hide , show tab
    $inputChk.each(function( index ) {
        if ($(this).is(":checked") && !isEmpty($(this).data('clicked'))) {
            $('li.' + $(this).data('clicked')).show();
        } else if(!isEmpty($(this).data('clicked'))){
            $('li.' + $(this).data('clicked')).hide();
        }
    });
})(window.jQuery);