(function ($) {
    "use strict";
    var $q,
            $formData = {},
            $form = $("#form-quotation"),
            $paperSize = $('#tblquotationdetail-paper_size_id'),
            $paperSizeWidth = $('#tblquotationdetail-paper_size_width'),
            $paperSizeHeight = $('#tblquotationdetail-paper_size_height'),
            $paperHeight = $('#tblquotationdetail-paper_height'),
            $paperSizeUnit = $('#tblquotationdetail-paper_size_unit'),
            $opPaperSize = $('#op_paper_size_id'),
            $customPaper = $('.custom-paper-size'),
            $bookBinding = $('#tblquotationdetail-book_binding_id'),
            $opBookBinding = $('#op_book_binding_id'),
            $pageQty = $('#tblquotationdetail-page_qty'),
            $opPageQty = $('#op_page_qty'),
            $paperId = $('#tblquotationdetail-paper_id'),
            $opPaper = $('#op_paper_id'),
            $beforePrint = $('#tblquotationdetail-before_print'),
            $opBeforePrint = $('#op_before_print'),
            $afterPrint = $('#tblquotationdetail-after_print'),
            $opAfterPrint = $('#op_after_print'),
            $coatingId = $('#tblquotationdetail-coating_id'),
            $coatingOption = $('input[name="TblQuotationDetail[coating_option]"]'),
            $opCoating = $('#op_coating_id'),
            $diecut = $('input[name="TblQuotationDetail[diecut]"]'),
            $diecutId = $('#tblquotationdetail-diecut_id'),
            $opDiecut = $('#op_diecut_id'),
            $foldId = $('#tblquotationdetail-fold_id'),
            $opFold = $('#op_fold_id'),
            $foilSizeWidth = $('#tblquotationdetail-foil_size_width'),
            $foilSizeHeight = $('#tblquotationdetail-foil_size_height'),
            $foilSizeUnit = $('#tblquotationdetail-foil_size_unit'),
            $foilColorId = $('#tblquotationdetail-foil_color_id'),
            $opFoil = $('#op_foil_color_id'),
            $embossSizeWidth = $('#tblquotationdetail-emboss_size_width'),
            $emBossSizeHeight = $('#tblquotationdetail-emboss_size_height'),
            $emBossSizeUnit = $('#tblquotationdetail-emboss_size_unit'),
            $opEmbossing = $('#op_embossing'),
            $landOrient = $('input[name="TblQuotationDetail[land_orient]"]'),
            $opLandOrient = $('#op_land_orient'),
            $productId = $('#tblquotationdetail-product_id'),
            $perforateId = $('#tblquotationdetail-perforate'),
            $perforateOptionId = $('#tblquotationdetail-perforate_option_id'),
            $perforateOption = $('#op_perforate_option'),
            $nbsp = '&nbsp;';
    $q = {
        isEmpty: function (value, trim) {
            return value === null || value === undefined || value.length === 0 || (trim && $.trim(value) === '');
        },
        setInputValue: function ($elm = [], $value = null) {
            if ($elm.length > 0) {
                $.each($elm, function (index, value) {
                    $(this).val($value).change();
                });
        }
        },
        select2Options: function ($elementSelect2) {
            var options = {},
                    adapter = $elementSelect2.data().select2.dataAdapter,
                    self = this;
            $elementSelect2.children().each(function () {
                if (!$(this).is('option') && !$(this).is('optgroup')) {
                    return true;
                }
                var item = adapter.item($(this));
                if (item.children) {
                    $(this).children().each(function () {
                        var item = adapter.item($(this));
                        if (self.isEmpty(item.id)) {
                            return true;
                        }
                        options[item.id] = item.text.replace(/<p>(.*)<\/p>/g, "");
                    });
                } else {
                    if (self.isEmpty(item.id)) {
                        return true;
                    }
                    options[item.id] = item.text.replace(/<p>(.*)<\/p>/g, "");
                }
            });
            return options;
        }
    };

    // ###### Events #####

    // ขนาด
    $paperSize.on('change', function (e) {
        var options = $q.select2Options($(this));
        if (!$q.isEmpty($(this).val())) {
            if ($(this).val() === 'custom') { //กำหนดขนาดเอง
                $customPaper.show();
                $opPaperSize.html('-');
            } else { //ขนาดมาตรฐาน
                $customPaper.hide();
                $q.setInputValue([$paperSizeWidth, $paperSizeHeight]);
                $paperSizeUnit.val(null).trigger('change');
                $opPaperSize.html(options[$(this).val()]);
            }
        } else {
            $customPaper.hide();
            $q.setInputValue([$paperSizeWidth, $paperSizeHeight]);
            $paperSizeUnit.val(null).trigger('change');
        }
    });

    // กว้าง กำหนดเอง
    $paperSizeWidth.on('keyup change', function (e) {
        var unitOptions = $q.select2Options($paperSizeUnit); // หน่วย
        if (!$q.isEmpty(unitOptions[$paperSizeUnit.val()])) {
            // กว้าง x ยาว หน่วย
            if (!$q.isEmpty($paperHeight.val())) {
                $opPaperSize.html(
                        $paperSizeWidth.val() +
                        'x' + $paperSizeHeight.val() +
                        'x' + $paperHeight.val() +
                        $nbsp +
                        unitOptions[$paperSizeUnit.val()]
                        );
            } else {
                $opPaperSize.html($(this).val() + 'x' + $paperSizeHeight.val() + $nbsp + unitOptions[$paperSizeUnit.val()]);
            }
        } else {
            // กว้าง x ยาว
            $opPaperSize.html($(this).val() + 'x' + $paperSizeHeight.val());
        }
    });

    // ยาว กำหนดเอง
    $paperSizeHeight.on('keyup change', function (e) {
        var unitOptions = $q.select2Options($paperSizeUnit);
        if (!$q.isEmpty(unitOptions[$paperSizeUnit.val()])) {
            // กว้าง x ยาว หน่วย
            if (!$q.isEmpty($paperHeight.val())) {
                $opPaperSize.html(
                        $paperSizeWidth.val() +
                        'x' + $paperSizeHeight.val() +
                        'x' + $paperHeight.val() +
                        $nbsp +
                        unitOptions[$paperSizeUnit.val()]
                        );
            } else {
                $opPaperSize.html($paperSizeWidth.val() + 'x' + $(this).val() + $nbsp + unitOptions[$paperSizeUnit.val()]);
            }

        } else {
            // กว้าง x ยาว
            $opPaperSize.html($paperSizeWidth.val() + 'x' + $(this).val());
        }
    });

    // สูง กำหนดเอง
    $paperHeight.on('keyup change', function (e) {
        var unitOptions = $q.select2Options($paperSizeUnit);
        if (!$q.isEmpty(unitOptions[$paperSizeUnit.val()])) {
            // กว้าง x ยาว หน่วย
            $opPaperSize.html(
                    $paperSizeWidth.val() +
                    'x' + $paperSizeHeight.val() +
                    'x' + $(this).val() +
                    $nbsp +
                    unitOptions[$paperSizeUnit.val()]
                    );
        } else {
            // กว้าง x ยาว
            $opPaperSize.html(
                    $paperSizeWidth.val() +
                    'x' + $paperSizeHeight.val() +
                    'x' + $(this).val()
                    );
        }
    });

    // หน่วย กำหนดเอง
    $paperSizeUnit.on('change', function (e) {
        var options = $q.select2Options($(this));
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(options[$(this).val()])) {
            if (!$q.isEmpty($paperHeight.val())) {
                $opPaperSize.html(
                        $paperSizeWidth.val() +
                        'x' + $paperSizeHeight.val() +
                        'x' + $paperHeight.val() +
                        $nbsp +
                        options[$paperSizeUnit.val()]
                        );
            } else {
                $opPaperSize.html($paperSizeWidth.val() + 'x' + $paperSizeHeight.val() + $nbsp + options[$(this).val()]);
            }
        } else {
            $opPaperSize.html($paperSizeWidth.val() + 'x' + $paperSizeHeight.val());
        }
    });

    // เข้าเล่ม
    $bookBinding.on('change', function () {
        var options = $q.select2Options($(this));
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(options[$(this).val()])) {
            $opBookBinding.html(options[$(this).val()]);
        } else {
            $opBookBinding.html('-');
        }
    });

    // จำนวน
    $pageQty.on('keyup change', function () {
        if (!$q.isEmpty($(this).val())) {
            $opPageQty.html($(this).val());
        } else {
            $opPageQty.html('-');
        }
    });

    // กระดาษ
    $paperId.on('change', function () {
        var options = $q.select2Options($(this));
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(options[$(this).val()])) {
            $opPaper.html(options[$(this).val()]);
        } else {
            $opPaper.html('-');
        }
    });

    //พิมพ์ 2 หน้า
    $beforePrint.on('change', function () {
        var options = $q.select2Options($(this));
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(options[$(this).val()])) {
            $opBeforePrint.html(options[$(this).val()]);
        } else {
            $opBeforePrint.html('-');
        }
        if (!$q.isEmpty($afterPrint.val())) {
            $afterPrint.val(null).trigger('change');
        }

    });

    //หลังพิมพ์
    $afterPrint.on('change', function () {
        var options = $q.select2Options($(this));
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(options[$(this).val()])) {
            $opAfterPrint.html(options[$(this).val()]);
        } else {
            $opAfterPrint.html('-');
        }
        if (!$q.isEmpty($beforePrint.val())) {
            $beforePrint.val(null).trigger('change');
        }
    });

    //เคลือบ
    $coatingId.on('change', function () {
        var options = $q.select2Options($(this));
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(options[$(this).val()])) {
            if ($(this).val() === 'N') {
                $('.coating-option').hide();
                $('#tblquotationdetail-coating_option-0').prop('checked', false);
                $('#tblquotationdetail-coating_option-1').prop('checked', false);
            } else {
                $('.coating-option').show();
            }
            if ($('#tblquotationdetail-coating_option-0').is(':checked')) { //เคลือบด้านเดียว
                $opCoating.html(options[$(this).val()] + ' ด้านเดียว');
            } else if ($('#tblquotationdetail-coating_option-1').is(':checked')) { //เคลือบสองเดียว
                $opCoating.html(options[$(this).val()] + ' สองด้าน');
            }

        } else {
            $opCoating.html('-');
        }
    });

    //
    $coatingOption.on('change', function () {
        var options = $q.select2Options($coatingId);
        var text = '';
        if ($(this).val() === 'one_page') {
            text = 'ด้านเดียว';
        } else {
            text = 'สองด้าน';
        }
        if (!$q.isEmpty($coatingId.val()) && !$q.isEmpty(options[$coatingId.val()])) {
            $opCoating.html(options[$coatingId.val()] + ' (' + text + ')');
        } else {
            $opCoating.html('(' + text + ')');
        }
        $form.trigger("change");
    });

    //ไดคัท
    $diecut.on('change', function () {
        var options = $q.select2Options($diecutId);
        if ($(this).val() === 'Curve' && $('#tblquotationdetail-diecut-2').is(':checked')) {
            $('.diecut-id').show();
            if (!$q.isEmpty($diecutId.val()) && !$q.isEmpty(options[$diecutId.val()])) {
                $opDiecut.html('ไดคัทมุมมน ' + options[$diecutId.val()]);
            } else {
                $opDiecut.html('ไดคัทมุมมน');
            }
        } else {
            $('.diecut-id').hide();
            $diecutId.val(null).trigger('change');
            if ($(this).val() === 'Default') {
                $opDiecut.html('ไดตัทตามรูปแบบ');
            } else {
                $opDiecut.html('ไม่ไดคัท');
            }
        }
    });

    //ไดคัทมุมมน
    $diecutId.on('change', function () {
        var options = $q.select2Options($(this));
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(options[$(this).val()])) {
            if ($('#tblquotationdetail-diecut-2').val() === 'Curve') {
                $opDiecut.html('ไดคัทมุมมน ' + options[$(this).val()]);
            } else {
                $opDiecut.html(options[$(this).val()]);
            }
        } else {
            $opDiecut.html('-');
        }
    });

    //วิธีพับ
    $foldId.on('change', function () {
        var options = $q.select2Options($(this));
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(options[$(this).val()])) {
            $opFold.html(options[$(this).val()]);
        } else {
            $opFold.html('-');
        }
    });

    // กว้าง ฟอยล์
    $foilSizeWidth.on('keyup change', function () {
        var unitOptions = $q.select2Options($foilSizeUnit),
                colorOptions = $q.select2Options($foilColorId);
        $opFoil.html(
                $(this).val() + 'x' + $foilSizeHeight.val() +
                $nbsp +
                ($q.isEmpty(unitOptions[$foilSizeUnit.val()]) ? $nbsp : unitOptions[$foilSizeUnit.val()]) +
                $nbsp +
                ($q.isEmpty(colorOptions[$foilColorId.val()]) ? $nbsp : colorOptions[$foilColorId.val()])
                );
    });

    // ยาว ฟอยล์
    $foilSizeHeight.on('keyup change', function () {
        var unitOptions = $q.select2Options($foilSizeUnit),
                colorOptions = $q.select2Options($foilColorId);
        $opFoil.html(
                $foilSizeWidth.val() + 'x' + $(this).val() +
                $nbsp +
                ($q.isEmpty(unitOptions[$foilSizeUnit.val()]) ? $nbsp : unitOptions[$foilSizeUnit.val()]) +
                $nbsp +
                ($q.isEmpty(colorOptions[$foilColorId.val()]) ? $nbsp : colorOptions[$foilColorId.val()])
                );
    });

    // หน่วย ฟอยล์
    $foilSizeUnit.on('change', function () {
        var unitOptions = $q.select2Options($(this)),
                colorOptions = $q.select2Options($foilColorId);
        $opFoil.html(
                $foilSizeWidth.val() + 'x' + $foilSizeHeight.val() +
                $nbsp +
                ($q.isEmpty(unitOptions[$foilSizeUnit.val()]) ? $nbsp : unitOptions[$foilSizeUnit.val()]) +
                $nbsp +
                ($q.isEmpty(colorOptions[$foilColorId.val()]) ? $nbsp : colorOptions[$foilColorId.val()])
                );
    });

    //สี ฟอยล์
    $foilColorId.on('change', function () {
        var colorOptions = $q.select2Options($(this)),
                unitOptions = $q.select2Options($foilSizeUnit);
        $opFoil.html(
                $foilSizeWidth.val() + 'x' + $foilSizeHeight.val() +
                $nbsp +
                ($q.isEmpty(unitOptions[$foilSizeUnit.val()]) ? $nbsp : unitOptions[$foilSizeUnit.val()]) +
                $nbsp +
                ($q.isEmpty(colorOptions[$foilColorId.val()]) ? $nbsp : colorOptions[$foilColorId.val()])
                );
    });

    //กว้าง ปั๊มนูน
    $embossSizeWidth.on('keyup change', function () {
        var unitOptions = $q.select2Options($emBossSizeUnit);
        $opEmbossing.html(
                $(this).val() + 'x' + $emBossSizeHeight.val() +
                $nbsp +
                ($q.isEmpty(unitOptions[$emBossSizeUnit.val()]) ? '' : unitOptions[$emBossSizeUnit.val()])
                );
    });

    // ยาว ปั๊มนูน
    $emBossSizeHeight.on('keyup change', function () {
        var unitOptions = $q.select2Options($emBossSizeUnit);
        $opEmbossing.html(
                $embossSizeWidth.val() + 'x' + $(this).val() +
                $nbsp +
                ($q.isEmpty(unitOptions[$emBossSizeUnit.val()]) ? '' : unitOptions[$emBossSizeUnit.val()])
                );
    });

    // หน่วย ปั๊มนูน
    $emBossSizeUnit.on('change', function () {
        var unitOptions = $q.select2Options($(this));
        $opEmbossing.html(
                $embossSizeWidth.val() + 'x' + $emBossSizeHeight.val() +
                $nbsp +
                ($q.isEmpty(unitOptions[$emBossSizeUnit.val()]) ? '' : unitOptions[$emBossSizeUnit.val()])
                );
    });

    // แนวตั้ง แนวนอน
    $landOrient.on('change', function () {
        if ($(this).val() === '1') {
            $opLandOrient.html('แนวตั้ง');
        } else {
            $opLandOrient.html('แนวนอน');
        }
        $form.trigger("change");
    });

    //ตัด/เจาะ
    $perforateId.on('change', function () {
        var options = $q.select2Options($(this));
        var options2 = $q.select2Options($perforateOptionId);
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(options[$(this).val()])) {
            if ($(this).val() === '0') {
                $('.perforate-option').hide();
                $perforateOptionId.val(null).trigger('change');
                $perforateOption.html(options[$(this).val()]);
            } else {
                $('.perforate-option').show();
                if (!$q.isEmpty(options2[$($perforateOptionId).val()])) {
                    $perforateOption.html(options[$(this).val()] + ' ' + options2[$($perforateOptionId).val()]);
                } else {
                    $perforateOption.html(options[$(this).val()]);
                }
            }
        } else {
            $('.perforate-option').hide();
            $perforateOptionId.val(null).trigger('change');
            $perforateOption.html('-');
        }
    });
    //มุมที่เจาะ*
    $perforateOptionId.on('change', function () {
        var options = $q.select2Options($(this));
        var options2 = $q.select2Options($perforateId);
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(options[$(this).val()])) {
            $perforateOption.html(options2[$($perforateId).val()] + ' ' + options[$(this).val()]);
        } else {
            $perforateOption.html('-');
        }
    });

    $form.on('change', function () {
        var obj = {}, $pId = $productId.val(), key = 'formOptions';
        $form.serializeArray().map(function (x) {
            obj[x.name.replace('TblQuotationDetail[', '').replace(']', '')] = x.value;
        });
        $formData[$pId] = obj;
        if ('localStorage' in window && window.localStorage !== null) {
            var cacheData = localStorage.getItem(key);
            if (!$q.isEmpty(cacheData)) {
                var options = $.extend(JSON.parse(cacheData), $formData);
                localStorage.setItem(key, JSON.stringify(options));
            } else {
                localStorage.setItem(key, JSON.stringify($formData));
            }
        }
    });

    $(window).on('load', function () {
        if ('localStorage' in window && window.localStorage !== null) {
            var productOps = localStorage.getItem('formOptions'), $pId = $productId.val();
            if (!$q.isEmpty(productOps) && !$q.isEmpty(JSON.parse(productOps))) {
                var dataObj = JSON.parse(productOps);
                if (!$q.isEmpty(dataObj[$pId])) {
                    productOps = dataObj[$pId];
                    var input = $form.find('input'),
                            select2 = $form.find('select');
                    $.each(input, function () {
                        if (!$q.isEmpty($(this).attr('id'))) {
                            var inputId = $(this).attr('id'),
                                    fieldName = inputId.replace('tblquotationdetail-', '');
                            if (!$q.isEmpty(productOps[fieldName])) {
                                $('#' + inputId).val(productOps[fieldName]).change();
                            }
                        } else {
                            if ($(this).attr('name') === 'TblQuotationDetail[land_orient]') {
                                if (!$q.isEmpty(productOps['land_orient']) && productOps['land_orient'] === '1') {
                                    $('#tblquotationdetail-land_orient-0').prop('checked', true);
                                    $opLandOrient.html('แนวตั้ง');
                                }
                                if (!$q.isEmpty(productOps['land_orient']) && productOps['land_orient'] === '2') {
                                    $('#tblquotationdetail-land_orient-1').prop('checked', true);
                                    $opLandOrient.html('แนวนอน');
                                }
                            }
                            if ($(this).attr('name') === 'TblQuotationDetail[coating_option]') {
                                if (!$q.isEmpty(productOps['coating_option']) && productOps['coating_option'] === 'one_page') {
                                    $('#tblquotationdetail-coating_option-0').prop('checked', true);
                                    $('#tblquotationdetail-coating_option-0').change();
                                }
                                if (!$q.isEmpty(productOps['coating_option']) && productOps['coating_option'] === 'two_page') {
                                    $('#tblquotationdetail-coating_option-1').prop('checked', true);
                                    $('#tblquotationdetail-coating_option-1').change();
                                }
                            }
                            if ($(this).attr('name') === 'TblQuotationDetail[diecut]') {
                                if (!$q.isEmpty(productOps['diecut']) && productOps['diecut'] === 'N') {
                                    $('#tblquotationdetail-diecut-0').prop('checked', true);
                                    $('.diecut-id').hide();
                                }
                                if (!$q.isEmpty(productOps['diecut']) && productOps['diecut'] === 'Default') {
                                    $('#tblquotationdetail-diecut-1').prop('checked', true);
                                    $('.diecut-id').hide();
                                }
                                if (!$q.isEmpty(productOps['diecut']) && productOps['diecut'] === 'Curve') {
                                    $('#tblquotationdetail-diecut-2').prop('checked', true);
                                }
                                $diecut.change();
                            }
                        }
                    });
                    $.each(select2, function () {
                        if (!$q.isEmpty($(this).attr('id'))) {
                            var inputId = $(this).attr('id'),
                                    fieldName = inputId.replace('tblquotationdetail-', '');
                            if (!$q.isEmpty(productOps[fieldName])) {
                                $('#' + inputId).val(productOps[fieldName]).trigger('change');
                            }
                        }
                    });
                }
            }
            $('span.desc').hide();
        }
    });



})(window.jQuery);

