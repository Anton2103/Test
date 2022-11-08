(function($) {

    $('body').on('updated_checkout', function() {

        console.log('updated_checkout');
        let buttonSubmit = $('#place_order');
        let required = document.forms.checkout.querySelectorAll(".validate-required");
        // let has_error = [];
        //    /* перебираем все обязательные поля (какие не заполнены, присваем has_error.push(item) ) */
        // for (let item of required) {
        //        if (item.parentNode.parentNode.querySelector("input, select, textarea").value=="") {
        //            has_error.push(item);
        //        }
        // }
        //    /* когда в форме есть error(не заполненое поле), кнопка не активна. когда нет error, кнопка активна */
        // if (has_error.length) {
        //     buttonSubmit.setAttribute("disabled", true);
        //    } else {
        //     buttonSubmit.removeAttribute("disabled");
        // }



        buttonSubmit.prop("disabled", true);
        let numRequired = required.length;
        let counter = 0;
        required.forEach(function(item) {
            let varRequired = item.querySelector("input, select, textarea").value;
            if (varRequired.length == 0){
                counter ++;
            }
        });
        if (counter == 0) {
            buttonSubmit.prop("disabled", false);
        };
        console.log()
    });

    $('.validate-required').find("input, select, textarea").on('change', function(e){
        $('body').trigger('updated_checkout');
    })
})(jQuery);










