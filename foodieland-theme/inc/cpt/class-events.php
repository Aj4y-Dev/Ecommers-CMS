<?php
if (!defined('ABSPATH')) exit;

class Foodieland_Events_CPT {
    public function __construct() {
        add_action('init', array($this, 'register_events_cpt'));
    }
    
    public function register_events_cpt() {
        $labels = array(
            'name' => _x('Events', 'foodieland'),
            'singular_name' => _x('Event', 'foodieland'),
            'add_new_item' => __('Add New Event', 'foodieland'),
            'edit_item' => __('Edit Event', 'foodieland'),
            'all_items' => __('All Events', 'foodieland'),
        );
        
        $args = array(
            'labels' => $labels,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'rewrite' => array('slug' => 'event'),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'menu_position' => 10,
            'menu_icon' => 'dashicons-calendar-alt',
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'show_in_rest' => true,
        );
        
        register_post_type('event', $args);
    }
}

new Foodieland_Events_CPT();
