$(function() {
  $('[data-toggle="popover"]').popover()
})
isEmpty = function(v) {
  return v === undefined || v === null || v.length === 0
}
var $form = $("#form-product")
$form.on("change", function(e) {
  if (
    !isEmpty($("#tblproduct-product_type_id").val()) &&
    !isEmpty($("#tblproduct-product_name").val()) &&
    !isEmpty($("#tblproduct-product_status").val()) &&
    action === "create"
  ) {
    Product.onSubmit()
  }
})
Product = {
  onSubmit: function() {
    var data = $form.serialize()
    var $btn = $("#form-product a.on-submit").button("loading")
    $.ajax({
      url: $form.attr("action"),
      type: $form.attr("method"),
      data: data,
      success: function(response) {
        // Implement successful
        if (response.success) {
          swal({
            type: "success",
            title: response.message,
            showConfirmButton: false,
            timer: 2000
          })
          $btn.button("reset")
          if (action === "create") {
            setTimeout(function() {
              window.location.href = response.data.url
            }, 2000)
          }
        } else {
          $btn.button("reset")
          $.each(response.validate, function(key, val) {
            $($form).yiiActiveForm("updateAttribute", key, [val])
          })
          $("html, body").animate({ scrollTop: 0 }, "slow")
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        Swal({
          type: "error",
          title: textStatus,
          text: errorThrown
        })
      }
    })
  }
}

//dialog
;(function() {
  "use strict"
  yii.confirm = function(message, ok, cancel) {
    var ajaxId = $(this).data("ajax-reload"),
      url = $(this).attr("href")
    Swal({
      title: message + "?",
      text: "",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      confirmButtonText: "ยืนยัน",
      cancelButtonText: "ยกเลิก",
      showLoaderOnConfirm: true,
      allowOutsideClick: false,
      preConfirm: function() {
        return new Promise(function(resolve) {
          $.ajax({
            method: "POST",
            url: url,
            dataType: "json",
            success: function(response) {
              if (!isEmpty(ajaxId)) {
                var table = $("#" + ajaxId).DataTable()
                table.ajax.reload()
              }
              resolve()
            },
            error: function(jqXHR, textStatus, errorThrown) {
              Swal({
                type: "error",
                title: textStatus,
                text: errorThrown
              })
            }
          })
        })
      }
    }).then(result => {
      if (result.value) {
        Swal("Deleted!", "Your has been deleted.", "success")
      }
    })
    return false
  }
})()
