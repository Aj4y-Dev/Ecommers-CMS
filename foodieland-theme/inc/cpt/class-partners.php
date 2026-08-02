<?php
if (!defined('ABSPATH')) exit;

class Foodieland_Partners_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_partners_cpt'));
    }
    
    public function register_partners_cpt() {
        $labels = array(
            'name' => _x('Partners', 'foodieland'),
            'singular_name' => _x('Partner', 'foodieland'),
            'add_new_item' => __('Add New Partner', 'foodieland'),
            'edit_item' => __('Edit Partner', 'foodieland'),
            'all_items' => __('All Partners', 'foodieland'),
        );
        
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'rewrite' => array('slug' => 'partner'),
            'capability_type' => 'post',
            'has_archive' => false,
            'hierarchical' => false,
            'menu_position' => 9,
            'menu_icon' => 'dashicons-businessman',
            'supports' => array('title', 'thumbnail'),
            'show_in_rest' => true,
        );
        
        register_post_type('partner', $args);
    }
}

new Foodieland_Partners_CPT();
