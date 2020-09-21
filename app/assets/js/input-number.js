function appendArrowInputNumber() {
    $('.form-group .number').append("<img src=\"/ecommerce/app/assets/icons/action/chevron_left.svg\" alt=\"\" class=\"arrow minus\">" +
        "<img src =\"/ecommerce/app/assets/icons/action/chevron_right.svg\" alt=\"\" class=\"arrow add\">");

    $('.arrow.minus').click(function() {
        var inputTypeNumber = $(this).siblings(':input[type="number"]');
        if (inputTypeNumber.val() > 1) { inputTypeNumber.val(parseInt(inputTypeNumber.val()) - 1).change(); }
    });

    $('.arrow.add').click(function() {
        var inputTypeNumber = $(this).siblings(':input[type="number"]');
        inputTypeNumber.val(parseInt(inputTypeNumber.val()) + 1).change();
    })
}