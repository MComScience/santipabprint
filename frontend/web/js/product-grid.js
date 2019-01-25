$('#pills-tab').on('click', 'a.nav-link', function (e) {
    e.preventDefault();
    $('#pills-tab').find('a.active').removeClass('active');
});

$('#pills-tabContent').on('click', 'a.product-link', function (e) {
    e.preventDefault();
    $('body').waitMe({
        effect: 'ios',
        text: 'Loading...',
        textPos: 'vertical',
    });
    var url = $(this).data('url');
    var modalProduct = $('#product-modal');
    $.ajax({
        method: "GET",
        url: url,
        dataType: "json",
        success: function (response) {
            modalProduct.find(".modal-footer").remove();
            modalProduct.find(".modal-body").html(response);
            modalProduct.modal('show');
            $('body').waitMe('hide');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $('body').waitMe('hide');
            Swal({
                type: 'error',
                title: textStatus,
                text: errorThrown,
            });
        }
    });
});