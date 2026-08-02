<?php
if (!defined('ABSPATH')) exit;

class Foodieland_Gallery_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_gallery_cpt'));
    }
    
    public function register_gallery_cpt() {
        $labels = array(
            'name' => _x('Gallery', 'foodieland'),
            'singular_name' => _x('Image', 'foodieland'),
            'add_new_item' => __('Add New Image', 'foodieland'),
            'edit_item' => __('Edit Image', 'foodieland'),
            'all_items' => __('All Images', 'foodieland'),
        );
        
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'rewrite' => array('slug' => 'gallery'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 11,
            'menu_icon' => 'dashicons-format-gallery',
            'supports' => array('title', 'thumbnail', 'excerpt'),
            'show_in_rest' => true,
        );
        
        register_post_type('gallery', $args);
    }
}

new Foodieland_Gallery_CPT();
