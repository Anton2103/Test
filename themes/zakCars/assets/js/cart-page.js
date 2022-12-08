(function ($) {
    $(document).ready(function () {

        $(document).on('change', '.in-cb', (event) => {
            $("[name='update_cart']").prop( 'disabled', false );
        });


        // console.log('Script cart-page.js init');
        // $(document).on('click', '.btn-cb', (event) => {
        //     event.preventDefault();
        //
        //
        //     let isChecked = $('.in-cb').is(':checked');
        //
        //     console.log(isChecked)
        //         let ajax_data = {
        //             action: 'apply_cashback',
        //             checked: isChecked ? 1 : 0,
        //     };
        //         $.ajax({
        //             url: variables.ajaxurl,
        //             method: 'post',
        //             data: ajax_data,
        //             dataType: 'json',
        //             success: function (response) {
        //                 console.log('response:', response);
        //                 $("[name='update_cart']").prop('disabled', false).trigger("click");
        //             }
        //         });
        //     return false;
        // });

    })
})(jQuery);
