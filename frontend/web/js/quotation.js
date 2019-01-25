(function ($) {
    "use strict";
    var $q,
        $formData = {},
        $form = $("#form-quotation"),
        $productPanel = '.product-panel span.',
        $elmPaperSize = $('#tblquotationdetail-paper_size_id'),
        $elmPaperWidth = $('#tblquotationdetail-custom_paper_width'),
        $elmPaperHeight = $('#tblquotationdetail-custom_paper_height'),
        $elmCustomPaperUnit = $('#tblquotationdetail-custom_paper_unit'),
        $elmCustomPaper = $('.custom-paper-size'),
        $elmQuQty = $('#tblquotationdetail-quotation_qty'),
        $elmPrintOps = $('#tblquotationdetail-print_option_id'),
        $elmPaperType = $('#tblquotationdetail-paper_type_id'),
        $elmCoatingOps = $('#tblquotationdetail-coating_option_id'),
        $elmDicutOps = $('#tblquotationdetail-dicut_option_id'),
        $elmFoldOps = $('#tblquotationdetail-fold_option_id'),
        $elmFoilingSize = $('#tblquotationdetail-foiling_size'),
        $elmFoilingOps = $('#tblquotationdetail-foiling_option_id'),
        $elmFoilingUnit = $('#tblquotationdetail-foiling_unit_id'),
        $elmEmBosser = $('#tblquotationdetail-embosser'),
        $elmEmBosserUnit = $('#tblquotationdetail-embosser_unit_id'),
        $elmProductId = $('#tblquotationdetail-product_id'),
        $elmFirstPage = $('#tblquotationdetail-first_page'),
        $elmLastPage = $('#tblquotationdetail-last_page'),
        $elmFoilingWidth = $('#tblquotationdetail-foiling_width'),
        $elmFoilingHeight = $('#tblquotationdetail-foiling_height'),
        $elmEmBosserWidth = $('#tblquotationdetail-embosser_width'),
        $elmEmBosserHeight = $('#tblquotationdetail-embosser_height');
    $q = {
        isEmpty: function (v) {
            return v === undefined || v === null || v.length === 0;
        },
        //แสดงรายละเอียดสินค้า
        previewOptions: function (type, elmId, elmClass, conditionTxt = '') {
            var self = this, content = '-';
            if (type === 'select') {
                var data = $(elmId).select2('data');
                if (!self.isEmpty($(elmId).val()) && !self.isEmpty(data[0].text) && data[0].text !== conditionTxt) {
                    content = data[0].text.replace(/<p>(.*)<\/p>/g, "");
                }
            } else if (type === 'input') {
                if (!self.isEmpty($(elmId).val())) {
                    content = $(elmId).val();
                }
            }
            $($productPanel + elmClass).html(content);
        },
        hiddenDesc: function () {
            $('span.desc').hide();
        }
    };

    //ขนาด
    $elmPaperSize.on('change', function () {
        var self = $q, data = $(this).select2('data'), content = '-';
        if (!self.isEmpty($(this).val()) && !self.isEmpty(data[0].text) && data[0].text !== 'เลือกขนาด') {
            if ($(this).val() === 'custom_size') {
                $elmCustomPaper.show();
            } else {
                $elmPaperWidth.val(null);
                $elmPaperHeight.val(null);
                $elmCustomPaperUnit.val(null).trigger('change');
                $elmCustomPaper.hide();
            }
            if ($(this).val() !== 'custom_size') {
                content = data[0].text.replace(/<p>(.*)<\/p>/g, "");

            }
        } else if (self.isEmpty($(this).val())) {
            console.log('else')
            $elmPaperWidth.val(null);
            $elmPaperWidth.val(null);
            $elmCustomPaperUnit.val(null).trigger('change');
            $elmCustomPaper.hide();
        }
        $('span.op_paper_size').html(content);
    });
    //จำนวน
    $elmQuQty.on('change keyup', function () {
        $q.previewOptions('input', '#' + $(this)[0].id, 'op_qty');
    });
    //รูปแบบ
    $elmPrintOps.on('change', function () {
        $q.previewOptions('select', '#' + $(this)[0].id, 'op_format', 'เลือกแบบการพิมพ์');
    });
    //หน้าแรก
    $elmFirstPage.on('change', function () {
        $q.previewOptions('select', '#' + $(this)[0].id, 'op_first_page', 'เลือกรูปแบบ');
    });
    //หน้าหลัง
    $elmLastPage.on('change', function () {
        $q.previewOptions('select', '#' + $(this)[0].id, 'op_last_page', 'เลือกรูปแบบ');
    });
    //ประเภทกระดาษ
    $elmPaperType.on('change', function () {
        $q.previewOptions('select', '#' + $(this)[0].id, 'op_paper', 'เลือกประเภทกระดาษ');
    });
    //เคลือบ
    $elmCoatingOps.on('change', function () {
        $q.previewOptions('select', '#' + $(this)[0].id, 'op_refinement', 'เลือกการเคลือบ');
    });
    //ไดคัท
    $elmDicutOps.on('change', function () {
        $q.previewOptions('select', '#' + $(this)[0].id, 'op_dicut', 'เลือกไดคัท');
    });
    //การพับ
    $elmFoldOps.on('change', function () {
        $q.previewOptions('select', '#' + $(this)[0].id, 'op_book_binding', 'เลือกวิธีพับ');
    });
    //ขนาดฟอยล์
    $elmFoilingSize.on('change keyup', function () {
        var dataColor = $elmFoilingOps.select2('data'),
            dataUnit = $elmFoilingUnit.select2('data'),
            txt = '-';
        if (!$q.isEmpty($(this).val())) {
            if (dataColor[0].text !== 'เลือกสีฟอยล์' && dataUnit[0].text !== 'เลือกหน่วยฟอยล์') {
                txt = 'ขนาด ' + $(this).val() +
                    '&nbsp;' + dataUnit[0].text.replace(/<p>(.*)<\/p>/g, "") +
                    ',&nbsp;' + dataColor[0].text.replace(/<p>(.*)<\/p>/g, "");
            } else {
                txt = 'ขนาด ' + $(this).val();
            }
        }
        $('span.op_foiling').html(txt);
    });
    //หน่วยฟอยล์
    $elmFoilingUnit.on('change', function () {
        var data = $(this).select2('data'),
            dataColor = $elmFoilingOps.select2('data'),
            w = $elmFoilingWidth.val(),
            h = $elmFoilingHeight.val(),
            txt = '-';
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(data[0].text) && data[0].text !== 'เลือกหน่วยฟอยล์') {
            if (dataColor[0].text !== 'เลือกสีฟอยล์') {//ถ้าเลือกสีฟอยล์
                txt = 'ขนาด ' + w + 'x' + h +
                    '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "") +
                    ',&nbsp;' + dataColor[0].text.replace(/<p>(.*)<\/p>/g, "");
            } else {
                txt = 'ขนาด ' + w + 'x' + h +
                    '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
            }
        } else {
            if (!$q.isEmpty(dataColor[0].text) && dataColor[0].text !== 'เลือกสีฟอยล์') {//ถ้าเลือกสีฟอยล์
                txt = 'ขนาด ' + w + 'x' + h +
                    ',&nbsp;' + dataColor[0].text.replace(/<p>(.*)<\/p>/g, "");
            } else {
                txt = 'ขนาด ' + w + 'x' + h;
            }
        }
        $('span.op_foiling').html(txt);
    });
    //สีฟอยล์
    $elmFoilingOps.on('change', function () {
        var data = $(this).select2('data'),
            w = $elmFoilingWidth.val(),
            h = $elmFoilingHeight.val(),
            dataUnit = $elmFoilingUnit.select2('data'),
            txt = '-';
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(data[0].text) && data[0].text !== 'เลือกสีฟอยล์') {
            if (dataUnit[0].text !== 'เลือกหน่วยฟอยล์') {
                txt = 'ขนาด ' + w + 'x' + h +
                    '&nbsp;' + dataUnit[0].text.replace(/<p>(.*)<\/p>/g, "") +
                    ',&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
            } else {
                txt = 'ขนาด ' + w + 'x' + h +
                    '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
            }
        } else {
            if (!$q.isEmpty(dataUnit[0].text) && dataUnit[0].text !== 'เลือกหน่วยฟอยล์') {//ถ้าเลือกหน่วยฟอยล์
                txt = 'ขนาด ' + w + 'x' + h +
                    '&nbsp;' + dataUnit[0].text.replace(/<p>(.*)<\/p>/g, "");
            } else {
                txt = 'ขนาด ' + w + 'x' + h;
            }
        }
        $('span.op_foiling').html(txt);
    });
    //ปั๊มนูน กว้าง
    $elmEmBosserWidth.on('change keyup', function () {
        var dataUnit = $elmEmBosserUnit.select2('data'),
            h = $elmEmBosserHeight.val(),
            txt = '-';
        if (!$q.isEmpty($(this).val())) {
            if (dataUnit[0].text !== 'เลือกหน่วย') {
                txt = 'ขนาด ' + $(this).val() + 'x' + h +
                    '&nbsp;' + dataUnit[0].text.replace(/<p>(.*)<\/p>/g, "");
            } else {
                txt = 'ขนาด ' + $(this).val() + 'x' + h;
            }
        }
        $('span.op_embosser').html(txt);
    });
    //ปั๊มนูน กว้ยาว
    $elmEmBosserHeight.on('change keyup', function () {
        var dataUnit = $elmEmBosserUnit.select2('data'),
            w = $elmEmBosserWidth.val(),
            txt = '-';
        if (!$q.isEmpty($(this).val())) {
            if (dataUnit[0].text !== 'เลือกหน่วย') {
                txt = 'ขนาด ' + w + 'x' + $(this).val() +
                    '&nbsp;' + dataUnit[0].text.replace(/<p>(.*)<\/p>/g, "");
            } else {
                txt = 'ขนาด ' + w + 'x' + $(this).val();
            }
        }
        $('span.op_embosser').html(txt);
    });
    //หน่วยปั๊มนูน
    $elmEmBosserUnit.on('change', function () {
        var data = $(this).select2('data'),
            w = $elmEmBosserWidth.val(),
            h = $elmEmBosserHeight.val(),
            txt = '-';
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(data[0].text) && data[0].text !== 'เลือกหน่วย') {
            txt = 'ขนาด ' + w + 'x' + h +
                '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
        } else {
            txt = 'ขนาด ' + w + 'x' + h;
        }
        $('span.op_embosser').html(txt);
    });
    //กว้าง
    $elmPaperWidth.on('change keyup', function () {
        var data = $elmCustomPaperUnit.select2('data'), w = $(this).val(), h = $elmCustomPaperUnit.val(), txt = '';
        if (!$q.isEmpty(w) && !$q.isEmpty(data[0].text) && data[0].text !== 'เลือกหน่วย') {
            txt = w + 'x' + h + '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
        } else if (!$q.isEmpty(w)) {
            txt = w + 'x' + h;
        }
        $('span.op_paper_size').html(txt);
    });
    //หน่วยปั๊มนูน
    $elmCustomPaperUnit.on('change', function () {
        var data = $(this).select2('data'), w = $elmPaperWidth.val(), h = $elmPaperHeight.val(), txt = '';
        if (!$q.isEmpty($(this).val()) && !$q.isEmpty(data[0].text) && data[0].text !== 'เลือกหน่วย') {
            txt = w + '*' + h + '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
        } else {
            txt = w + '*' + h;
        }
        $('span.op_paper_size').html(txt);
    });
    //สูง
    $elmPaperHeight.on('change keyup', function () {
        var data = $elmCustomPaperUnit.select2('data'), h = $(this).val(), w = $elmPaperWidth.val(), txt = '';
        if (!$q.isEmpty(w) && !$q.isEmpty(data[0].text) && data[0].text !== 'เลือกหน่วย') {
            txt = w + '*' + h + '&nbsp;' + data[0].text.replace(/<p>(.*)<\/p>/g, "");
        } else if (!$q.isEmpty(w)) {
            txt = w + '*' + h;
        }
        $('span.op_paper_size').html(txt);
    });

    //ความกว้างฟอยล์
    $elmFoilingWidth.on('change keyup', function () {
        var dataColor = $elmFoilingOps.select2('data'),
            dataUnit = $elmFoilingUnit.select2('data'),
            h = $elmFoilingHeight.val(),
            txt = '-';
        if (!$q.isEmpty($(this).val())) {
            if (dataColor[0].text !== 'เลือกสีฟอยล์' && dataUnit[0].text !== 'เลือกหน่วยฟอยล์') {
                txt = 'ขนาด ' + $(this).val() + 'x' + h +
                    '&nbsp;' + dataUnit[0].text.replace(/<p>(.*)<\/p>/g, "") +
                    ',&nbsp;' + dataColor[0].text.replace(/<p>(.*)<\/p>/g, "");
            } else {
                if (!$q.isEmpty(h)){
                    txt = 'ขนาด ' + $(this).val() + 'x' + h;
                } else {
                    txt = 'ขนาด ' + $(this).val();
                }
            }
        }
        $('span.op_foiling').html(txt);
    });

    $elmFoilingHeight.on('change keyup', function () {
        var dataColor = $elmFoilingOps.select2('data'),
            dataUnit = $elmFoilingUnit.select2('data'),
            w = $elmFoilingWidth.val(),
            txt = '-';
        if (!$q.isEmpty($(this).val())) {
            if (dataColor[0].text !== 'เลือกสีฟอยล์' && dataUnit[0].text !== 'เลือกหน่วยฟอยล์') {
                txt = 'ขนาด ' + w + 'x' + $(this).val() +
                    '&nbsp;' + dataUnit[0].text.replace(/<p>(.*)<\/p>/g, "") +
                    ',&nbsp;' + dataColor[0].text.replace(/<p>(.*)<\/p>/g, "");
            } else {
                txt = 'ขนาด ' + w + 'x' + $(this).val();
            }
        }
        $('span.op_foiling').html(txt);
    });

    $form.on('change', function () {
        var obj = {}, $productId = $elmProductId.val();
        $form.serializeArray().map(function (x) {
            obj[x.name.replace('TblQuotationDetail[', '').replace(']', '')] = x.value;
        });
        $formData[$productId] = obj;
        if ('localStorage' in window && window.localStorage !== null) {
            var cacheData = localStorage.getItem('productOptions');
            if (!$q.isEmpty(cacheData)) {
                var options = $.extend(JSON.parse(cacheData), $formData);
                localStorage.setItem('productOptions', JSON.stringify(options));
            } else {
                localStorage.setItem('productOptions', JSON.stringify($formData));
            }
        }
    });

    $(window).on('load', function () {
        if ('localStorage' in window && window.localStorage !== null) {
            var productOps = localStorage.getItem('productOptions'), $productId = $elmProductId.val();
            if (!$q.isEmpty(productOps) && !$q.isEmpty(JSON.parse(productOps))) {
                var dataObj = JSON.parse(productOps);
                if (!$q.isEmpty(dataObj[$productId])) {
                    productOps = dataObj[$productId];
                    //หน่วย (กำหนดเอง)
                    $elmCustomPaperUnit.val(productOps['custom_paper_unit']).trigger('change');
                    //จำนวน
                    $elmQuQty.val(productOps['quotation_qty']).change();
                    //หน้าแรก
                    $elmFirstPage.val(productOps['first_page']).trigger('change');
                    //หน้าหลัง
                    $elmLastPage.val(productOps['last_page']).trigger('change');
                    //กระดาษ
                    $elmPaperType.val(productOps['paper_type_id']).trigger('change');
                    //เคลือบ
                    $elmCoatingOps.val(productOps['coating_option_id']).trigger('change');
                    //ไดคัท
                    $elmDicutOps.val(productOps['dicut_option_id']).trigger('change');
                    //การพับ
                    $elmFoldOps.val(productOps['fold_option_id']).trigger('change');
                    //ขนาดฟอยล์ W
                    $elmFoilingWidth.val(productOps['foiling_width']).change();
                    //ขนาดฟอยล์ H
                    $elmFoilingHeight.val(productOps['foiling_height']).change();
                    //หน่วยฟอยล์
                    $elmFoilingUnit.val(productOps['foiling_unit_id']).trigger('change');
                    //สีฟอยล์
                    $elmFoilingOps.val(productOps['foiling_option_id']).trigger('change');
                    //ขนาดปั๊มนูน W
                    $elmEmBosserWidth.val(productOps['embosser_width']).change();
                    //ขนาดปั๊มนูน H
                    $elmEmBosserHeight.val(productOps['embosser_height']).change();
                    //หน่วยปั๊มนูน
                    $elmEmBosserUnit.val(productOps['embosser_unit_id']).trigger('change');
                    //ขนาด
                    $elmPaperSize.val(productOps['paper_size_id']).trigger('change');
                    //กำหนดขนาดเอง
                    if (productOps['paper_size_id'] === 'custom_size') {
                        //กว้าง กำหนดขนาดเอง
                        $elmPaperWidth.val(productOps['custom_paper_width']).change();
                        //สูง กำหนดขนาดเอง
                        $elmPaperHeight.val(productOps['custom_paper_height']).change();
                        $('.custom-paper-size').show();
                    } else {
                        $('.custom-paper-size').hide();
                    }
                    $q.hiddenDesc();
                }
            }
        }
    });

    /*$('button.custom-paper-size').on('click', function () {
        var data = {
            id: 1,
            text: 'Barn owl'
        };

        var newOption = new Option(data.text, data.id, false, false);
        $('#tblquotationdetail-paper_size_id').append(newOption).trigger('change');
        $('#tblquotationdetail-paper_size_id').val(data.id).trigger('change');
    });*/

    if ('localStorage' in window && window.localStorage !== null) {
        if ($q.isEmpty(localStorage.getItem('productOptions'))) {
            $form.trigger("change");
        }
    }
})(window.jQuery);