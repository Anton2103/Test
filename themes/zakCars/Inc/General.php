<?php

namespace Inc;

class General {

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
}