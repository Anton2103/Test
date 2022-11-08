<?php

function true_include_myscript() {
    wp_enqueue_script( 'checkout-page', get_stylesheet_directory_uri() . '/assets/js/checkout-page.js', array(), '3.4', true );
}
add_action( 'wp_enqueue_scripts', 'true_include_myscript' );




    function wc_cart_cashback_html() {
        $value = '<strong>' . WC()->cart->get_total() . '</strong> ';

        pr($value);


        echo apply_filters( 'woocommerce_cart_totals_order_total_html', $value );
    };


