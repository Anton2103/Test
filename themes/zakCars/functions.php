<?php

use Inc\General;

################################################################################
# Constants
################################################################################


define('THEMEURL', get_stylesheet_directory_uri());
define('THEMEDIR', __DIR__);

define('TEXTDOMAIN', 'freshmarket');

define('ASSETSURL', THEMEURL . '/assets');
define('ASSETSDIR', THEMEDIR . '/assets');

define('INCDIR', THEMEDIR . DIRECTORY_SEPARATOR . 'Inc');
define('VENDORDIR', THEMEDIR . DIRECTORY_SEPARATOR . 'vendor');

define('ADMINDIR', THEMEDIR . DIRECTORY_SEPARATOR . 'Admin');
define('ADMINURI', THEMEURL . '/Admin');

define('VERSION', '1.2.1');
define('ASSETS_VERSION', '1.3.8');

################################################################################
# Includes
################################################################################

require_once VENDORDIR . '/autoload.php';

################################################################################
# Init
################################################################################

General::init();



function true_include_myscript()
{
    wp_enqueue_script('checkout-page', get_stylesheet_directory_uri() . '/assets/js/checkout-page.js', array(), '3.4', true);
}
add_action('wp_enqueue_scripts', 'true_include_myscript');

function get_cashback($total)
{
    $min_amount = get_field('min_total_cashback', 'option');
    $cashback_percent = get_field('cashback_percent', 'option');
    $min_amount = get_field('min_total_cashback', 'option');
    if ($total < $min_amount) {
         $cashback = 0;
    } else {
         $cashback = $total * $cashback_percent / 100;
    }
    return ['cashback' => $cashback, 'min_amount' => $min_amount];
}


function wc_cart_cashback_html()
{
    $totals = WC()->cart->get_totals();
    $sum_cashback = get_cashback($totals['total']);
    if ($sum_cashback['cashback'] == 0) {
        echo __('minimum order amount is ', 'zakCars'), wc_price($cashback['min_amount']), __(' to get cashback', 'zakCars');
    } else {
        $value = '<strong>' . wc_price($sum_cashback['cashback'])  . '</strong> ';
        echo apply_filters('woocommerce_cart_totals_order_total_html', $value);
    }
}

// create new menu item 'wallet' in my account
add_filter('woocommerce_account_menu_items', 'my_wallet_link', 40);
function my_wallet_link($menu_links)
{
    $menu_links = array_slice($menu_links, 0, 5, true)
        + array('my-wallet' => 'wallet')
        + array_slice($menu_links, 5, null, true);
    return $menu_links;
}

add_action('init', 'add_endpoint');
function add_endpoint()
{
    add_rewrite_endpoint('my-wallet', EP_PAGES);
}


add_action('woocommerce_account_my-wallet_endpoint', 'my_wallet_endpoint_content');
function my_wallet_endpoint_content()
{
    $current_user = wp_get_current_user();
    $user_id = get_current_user_id();
    ?>
    <h3>ГАМАНЕЦЬ</h3>
    <p> Cashback: <?php echo  wc_price(get_user_meta($user_id, 'cashback', true));?></p>
    <?php
}

add_action('woocommerce_order_status_completed', 'get_customer_total_order', 10);
function get_customer_total_order($order_id)
{
    $order = wc_get_order($order_id);
    $total = $order->get_total();
    $sum_cashback = get_cashback($total);
    $user_id = get_current_user_id();

    if ($sum_cashback['cashback'] != 0) {
        $cur_cashback =  get_user_meta($user_id, 'cashback', true);
        $cur_cashback += $sum_cashback['cashback'];
        update_user_meta($user_id, 'cashback ', $cur_cashback);
    }
}





