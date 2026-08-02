<?php
if (!defined('ABSPATH')) exit;

class Foodieland_Videos_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_videos_cpt'));
    }
    
    public function register_videos_cpt() {
        $labels = array(
            'name' => _x('Videos', 'foodieland'),
            'singular_name' => _x('Video', 'foodieland'),
            'add_new_item' => __('Add New Video', 'foodieland'),
            'edit_item' => __('Edit Video', 'foodieland'),
            'all_items' => __('All Videos', 'foodieland'),
        );
        
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'rewrite' => array('slug' => 'video'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 12,
            'menu_icon' => 'dashicons-video-alt3',
            'supports' => array('title', 'editor', 'thumbnail'),
            'show_in_rest' => true,
        );
        
        register_post_type('video', $args);
    }
}

new Foodieland_Videos_CPT();
