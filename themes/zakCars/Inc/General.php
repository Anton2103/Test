<?php

namespace Inc;

class General
{
    /**
     * Init general commands and hooks
     */
    public static function init()
    {
        General::getInstance();
    }

    /**
     * Holds class single instance
     * @var null
     */
    private static $_instance = null;

    /**
     * Get instance
     * @return General|null
     */
    public static function getInstance()
    {
        if (null == static::$_instance) {
            static::$_instance = new self();
        }

        return static::$_instance;
    }

    /**
     * General constructor. Theme default options
     */
    private function __construct()
    {
        ################################################################################
        # setup theme
        ################################################################################

        add_action('init', [$this, 'registerScripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueScripts']);


        ################################################################################
        # Settings
        ################################################################################

        //create settings page
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page([
                'page_title' => 'Theme General Settings',
                'menu_title' => 'Theme Settings',
                'menu_slug' => 'theme-general-settings',
                'capability' => 'edit_posts',
                'redirect' => false,
            ]);
        }
    }

    /**
     * register js scripts for the theme
     */
    public function registerScripts()
    {
        wp_register_script(
            TEXTDOMAIN . '-cart-page-js',
            ASSETSURL . '/js/cart-page.js',
            ['jquery'],
            ASSETS_VERSION,
            true
        );
    }

    /**
     *  enqueue all styles and scripts
     */
    public function enqueueScripts()
    {
        wp_enqueue_script(
            'autocomplete-js-ui',
            'https://code.jquery.com/ui/1.12.1/jquery-ui.js',
            array('jquery'),
            '1.8.1',
            true
        );

        wp_enqueue_script(TEXTDOMAIN . '-cart-page-js');

        wp_localize_script(TEXTDOMAIN . '-cart-page-js', 'variables', [
            'ajaxurl' => admin_url('admin-ajax.php'),
        ]);
    }
}
