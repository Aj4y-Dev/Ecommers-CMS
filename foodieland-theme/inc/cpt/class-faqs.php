<?php
if (!defined('ABSPATH')) exit;

class Foodieland_FAQs_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_faqs_cpt'));
    }
    
    public function register_faqs_cpt() {
        $labels = array(
            'name' => _x('FAQs', 'foodieland'),
            'singular_name' => _x('FAQ', 'foodieland'),
            'add_new_item' => __('Add New FAQ', 'foodieland'),
            'edit_item' => __('Edit FAQ', 'foodieland'),
            'all_items' => __('All FAQs', 'foodieland'),
        );
        
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'rewrite' => array('slug' => 'faq'),
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => 8,
            'menu_icon' => 'dashicons-editor-help',
            'supports' => array('title', 'editor'),
            'show_in_rest' => true,
        );
        
        register_post_type('faq', $args);
    }
}

new Foodieland_FAQs_CPT();
