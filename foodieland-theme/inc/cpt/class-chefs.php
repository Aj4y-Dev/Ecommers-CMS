<?php
/**
 * Register Chefs Custom Post Type
 *
 * @package Foodieland
 */

if (!defined('ABSPATH')) {
    exit;
}

class Foodieland_Chefs_CPT {
    
    public function __construct() {
        add_action('init', array($this, 'register_chefs_cpt'));
    }
    
    /**
     * Register Chefs CPT
     */
    public function register_chefs_cpt() {
        $labels = array(
            'name'                  => _x('Chefs', 'Post type general name', 'foodieland'),
            'singular_name'         => _x('Chef', 'Post type singular name', 'foodieland'),
            'menu_name'             => _x('Chefs', 'Admin Menu text', 'foodieland'),
            'add_new'               => __('Add New', 'foodieland'),
            'add_new_item'          => __('Add New Chef', 'foodieland'),
            'new_item'              => __('New Chef', 'foodieland'),
            'edit_item'             => __('Edit Chef', 'foodieland'),
            'view_item'             => __('View Chef', 'foodieland'),
            'all_items'             => __('All Chefs', 'foodieland'),
            'search_items'          => __('Search Chefs', 'foodieland'),
            'not_found'             => __('No chefs found.', 'foodieland'),
            'not_found_in_trash'    => __('No chefs found in Trash.', 'foodieland'),
            'featured_image'        => _x('Chef Photo', 'foodieland'),
            'set_featured_image'    => _x('Set chef photo', 'foodieland'),
            'remove_featured_image' => _x('Remove chef photo', 'foodieland'),
            'use_featured_image'    => _x('Use as chef photo', 'foodieland'),
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'chef'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 6,
            'menu_icon'          => 'dashicons-admin-users',
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'custom-fields'),
            'show_in_rest'       => true,
        );
        
        register_post_type('chef', $args);
    }
}

new Foodieland_Chefs_CPT();
