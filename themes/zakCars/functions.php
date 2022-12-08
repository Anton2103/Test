<?php

use Inc\Cashback;
use Inc\General;

################################################################################
# Constants
################################################################################


define('THEMEURL', get_stylesheet_directory_uri());
const THEMEDIR = __DIR__;

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
Cashback::getInstance();

function true_include_myscript()
{
    wp_enqueue_script(
        'checkout-page',
        get_stylesheet_directory_uri() . '/assets/js/checkout-page.js',
        array(),
        '3.4',
        true
    );
}

add_action('wp_enqueue_scripts', 'true_include_myscript');
