var dynamicWrapper = jQuery(".dynamicform_wrapper")
var s2options = {
  "themeCss": ".select2-container--bootstrap",
  "sizeCss": "",
  "doReset": true,
  "doToggle": true,
  "doOrder": false
};
window.select2Opts = {
  "allowClear": true,
  "theme": "bootstrap",
  "width": "100%",
  "placeholder": "Select a state ...",
  "language": "th",
  "multiple": true
}
window.bootstrapSwitch = {"size":"mini","onText":"Active","offText":"Inactive","animate":true,"indeterminate":false,"disabled":false,"readonly":false};
dynamicWrapper.on("afterInsert", function (e, item) {
  jQuery(".dynamicform_wrapper .title-field").each(function (index) {
    jQuery(this).html("ตัวเลือกที่: " + (index + 1))
    jQuery('#dynamicsettingmodel-' + index + '-field_name').on('change', function (e) {
      handleChangeFieldName(e)
    });
    jQuery('#dynamicsettingmodel-' + index + '-field_option').on('change', function (e) {
      handleChangeFieldOption(e)
    });

    var fieldActiveElm = jQuery('#dynamicsettingmodel-'+ index +'-filed_active')
    if (fieldActiveElm.data('bootstrapSwitch')) { fieldActiveElm.bootstrapSwitch('destroy'); }
    fieldActiveElm.bootstrapSwitch(bootstrapSwitch);

    var select2Values = jQuery('#dynamicsettingmodel-' + index + '-field_option_values');
    // if (select2Values.data('select2')) {
    //   select2Values.select2('destroy');
    // }
    // select2Values.attr('data-s2-options', 'select2Opts')
    // select2Values.attr('data-krajee-select2', 's2options')
    // jQuery.when(select2Values.select2(select2Opts)).done(initS2Loading('dynamicsettingmodel-'+ index +'-field_option_values','s2options'));
    // select2Values.on('select2:open', function(e) {
    //   //initS2ToggleAll()
    // });
  });
  // hiddenAction();
  $('.box').boxWidget({})
}).on("afterDelete", function (e) {

  jQuery(".dynamicform_wrapper .title-field").each(function (index) {
    // jQuery(this).html("Address: " + (index + 1))
  });
  // hiddenAction();
});

function hiddenAction() {
  var elmLength = jQuery(".dynamicform_wrapper .title-field").length;
  jQuery(".dynamicform_wrapper .action-control").each(function (index, el) {
    if((index + 1) < elmLength) {
      $(el).hide();
    } else {
      $(el).show();
    }
  });
}

function handleChangeFieldName(e) {
  if (!e.target.value) return;
  var inputIndex = e.target.id.replace(/[^0-9]/g, '')
  $.ajax({
    method: "GET",
    url: "/app/setting/get-attribute-label",
    data: {
      attribute: e.target.value
    },
    dataType: "json",
    success: function (res) {
      $('#dynamicsettingmodel-' + inputIndex + '-field_label').val(res.label)
      var select2Element = $('#dynamicsettingmodel-' + inputIndex + '-field_option_values')
      select2Element.empty()
      // select2Element.val(null).trigger('change');
      for (let i = 0; i < res.options.length; i++) {
        var data = res.options[i]
        var newOption = new Option(data.name, data.id, false, false);
        select2Element.append(newOption).trigger('change');
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert(errorThrown)
    }
  });
}

function handleChangeFieldOption(e) {
  if (!e.target.value) return;
  var inputIndex = e.target.id.replace(/[^0-9]/g, '')
  $.ajax({
    method: "GET",
    url: "/app/setting/child-option",
    data: {
      option: e.target.value
    },
    dataType: "json",
    success: function (res) {
      var select2Element = $('#dynamicsettingmodel-' + inputIndex + '-field_option_values')
      select2Element.empty()
      // select2Element.val(null).trigger('change');
      for (let i = 0; i < res.output.length; i++) {
        var data = res.output[i]
        var newOption = new Option(data.name, data.id, false, false);
        select2Element.append(newOption).trigger('change');
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      alert(errorThrown)
    }
  });
}

// window.initSelect2Loading = function(id, optVar){
//   console.log(optVar)
// 	initS2Loading(id, optVar)
// };
window.initSelect2DropStyle = function (id, kvClose, ev) {
  initS2Change($('#' + id)) // CHANGE HERE
};

var $form = $('#dynamic-form');
$form.on('beforeSubmit', function () {
  var data = $form.serialize();
  var $btn = $("#" + $form[0].id + ' button[type="submit"]').button("loading");
  var formData = {};
  $form.serializeArray().map(function (x) {
    formData[x.name] = x.value;
  });
  $.ajax({
    url: $form.attr('action'),
    type: $form.attr('method'),
    data: data,
    dataType: 'json',
    success: function (response) {
      // Implement successful
      $btn.button("reset");
      if (response.success) {
        Swal({
          type: "success",
          title: response.message,
          showConfirmButton: false,
          timer: 2000
        });
        if (response.action === "create-dynamic-form") {
          setTimeout(function () {
            window.location.href = response.data.url;
          }, 2000);
        }
      } else {
        $.each(response.validate, function (key, val) {
          $($form).yiiActiveForm("updateAttribute", key, [val]);
        });
      }
    },
    error: function (jqXHR, textStatus, errorThrown) {
      $btn.button("reset");
      Swal({
        type: "error",
        title: textStatus,
        text: errorThrown
      });
    }
  });
  return false; // prevent default submit
});
$('tbody').sortable();
/*
$(window).on('load', function () {
  hiddenAction();
});*/
