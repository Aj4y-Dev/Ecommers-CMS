<?php
/**
 * Register Testimonials Custom Post Type
 */

if (!defined('ABSPATH')) {
    exit;
}

class Foodieland_Testimonials_CPT {
    
    public function __construct() {
        add_action('init', array($this, 'register_testimonials_cpt'));
    }
    
    public function register_testimonials_cpt() {
        $labels = array(
            'name'                  => _x('Testimonials', 'foodieland'),
            'singular_name'         => _x('Testimonial', 'foodieland'),
            'add_new_item'          => __('Add New Testimonial', 'foodieland'),
            'edit_item'             => __('Edit Testimonial', 'foodieland'),
            'all_items'             => __('All Testimonials', 'foodieland'),
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'rewrite'            => array('slug' => 'testimonial'),
            'capability_type'    => 'post',
            'has_archive'        => false,
            'hierarchical'       => false,
            'menu_position'      => 7,
            'menu_icon'          => 'dashicons-format-quote',
            'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'show_in_rest'       => true,
        );
        
        register_post_type('testimonial', $args);
    }
}

new Foodieland_Testimonials_CPT();
