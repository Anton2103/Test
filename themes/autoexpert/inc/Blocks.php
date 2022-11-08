<?php

namespace Inc;

class Blocks {
    /**
     * Init general commands and hooks
     */
    public static function init()
    {
        Blocks::getInstance();
    }

    /**
     * Holds class single instance
     * @var null
     */
    private static $_instance = null;

    /**
     * Get instance
     * @return Blocks|null
     */
    public static function getInstance()
    {

        if (null == static::$_instance) {
            static::$_instance = new self();
        }

        return static::$_instance;
    }

    /**
     * A dummy magic method to prevent General from being cloned.
     *
     */
    public function __clone()
    {
        throw new \Exception('Cloning '.__CLASS__.' is forbidden');
    }


    /**
     * General constructor. Theme default options
     */
    private function __construct()
    {
        add_action('acf/init',  [$this, 'registerBlocks'], 20);
    }

    public function registerBlocks() {

        $this->registerAuto();
        
    }

    public function registerAuto() {

        acf_register_block_type([
            'name' => 'Auto',
            'title' => __('Page Auto'),
            'description' => __('A custom page Auto.'),
            'render_template' => 'template-parts/auto-cart.php',
            'category' => 'layout',
            'post_types' => ['post', 'page'],
            'mode' => 'auto',
            'supports' => array('mode' => true),
            'keywords' => array('header'),
            'align' => array('center', 'wide', 'full'),
            'enqueue_style' => '',
            'enqueue_assets' => function () {
            },
        ]);
    }
    
}