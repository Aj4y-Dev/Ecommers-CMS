<?php
/**
 * WooCommerce Support
 */

if (!defined('ABSPATH')) exit;

class Foodieland_WooCommerce_Support {
    
    public function __construct() {
        add_action('after_setup_theme', array($this, 'woocommerce_support'));
        add_filter('woocommerce_product_tabs', array($this, 'custom_product_tabs'));
        add_action('wp_enqueue_scripts', array($this, 'woocommerce_scripts'), 20);
        add_filter('body_class', array($this, 'woocommerce_body_class'));
    }
    
    public function woocommerce_support() {
        add_theme_support('woocommerce', array(
            'thumbnail_image_width' => 300,
            'single_image_width'    => 600,
            'product_grid'          => array(
                'default_rows'    => 4,
                'min_rows'        => 1,
                'max_rows'        => 10,
                'default_columns' => 4,
                'min_columns'     => 1,
                'max_columns'     => 6,
            ),
        ));
    }
    
    public function custom_product_tabs($tabs) {
        $tabs['reviews']['priority'] = 5;
        return $tabs;
    }
    
    public function woocommerce_scripts() {
        if (is_woocommerce()) {
            wp_enqueue_style('foodieland-woo', 
                FOODIELAND_URI . '/assets/css/woocommerce.css', 
                array(), 
                FOODIELAND_VERSION
            );
        }
    }
    
    public function woocommerce_body_class($classes) {
        if (is_woocommerce()) {
            $classes[] = 'foodieland-shop';
        }
        return $classes;
    }
}

new Foodieland_WooCommerce_Support();
