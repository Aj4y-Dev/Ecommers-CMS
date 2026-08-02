<?php
/**
 * Register Recipes Custom Post Type
 *
 * @package Foodieland
 */

if (!defined('ABSPATH')) {
    exit;
}

class Foodieland_Recipes_CPT {
    
    public function __construct() {
        add_action('init', array($this, 'register_recipes_cpt'));
        add_filter('manage_recipe_posts_columns', array($this, 'custom_columns'));
        add_action('manage_recipe_posts_custom_column', array($this, 'custom_column_content'), 10, 2);
    }
    
    /**
     * Register Recipes CPT
     */
    public function register_recipes_cpt() {
        $labels = array(
            'name'                  => _x('Recipes', 'Post type general name', 'foodieland'),
            'singular_name'         => _x('Recipe', 'Post type singular name', 'foodieland'),
            'menu_name'             => _x('Recipes', 'Admin Menu text', 'foodieland'),
            'name_admin_bar'        => _x('Recipe', 'Add New on Toolbar', 'foodieland'),
            'add_new'               => __('Add New', 'foodieland'),
            'add_new_item'          => __('Add New Recipe', 'foodieland'),
            'new_item'              => __('New Recipe', 'foodieland'),
            'edit_item'             => __('Edit Recipe', 'foodieland'),
            'view_item'             => __('View Recipe', 'foodieland'),
            'all_items'             => __('All Recipes', 'foodieland'),
            'search_items'          => __('Search Recipes', 'foodieland'),
            'parent_item_colon'     => __('Parent Recipe:', 'foodieland'),
            'not_found'             => __('No recipes found.', 'foodieland'),
            'not_found_in_trash'    => __('No recipes found in Trash.', 'foodieland'),
            'featured_image'        => _x('Featured Image', 'Overrides the "Featured Image" phrase', 'foodieland'),
            'set_featured_image'    => _x('Set featured image', 'Overrides the "Set featured image" phrase', 'foodieland'),
            'remove_featured_image' => _x('Remove featured image', 'Overrides the "Remove featured image" phrase', 'foodieland'),
            'use_featured_image'    => _x('Use as featured image', 'Overrides the "Use as featured image" phrase', 'foodieland'),
            'archives'              => _x('Recipe archives', 'The post type archive label', 'foodieland'),
            'insert_into_item'      => _x('Insert into recipe', 'Overrides the "Insert into post" phrase', 'foodieland'),
            'uploaded_to_this_item' => _x('Uploaded to this recipe', 'Overrides the "Uploaded to this post" phrase', 'foodieland'),
            'filter_items_list'     => _x('Filter recipes list', 'Screen reader text', 'foodieland'),
            'items_list_navigation' => _x('Recipes list navigation', 'Screen reader text', 'foodieland'),
            'items_list'            => _x('Recipes list', 'Screen reader text', 'foodieland'),
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'recipe'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 5,
            'menu_icon'          => 'dashicons-restaurant',
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields'),
            'show_in_rest'       => true,
            'rest_base'          => 'recipes',
            'taxonomies'         => array('recipe_category', 'cuisine', 'difficulty', 'ingredient', 'meal_type', 'diet'),
        );
        
        register_post_type('recipe', $args);
    }
    
    /**
     * Add custom columns
     */
    public function custom_columns($columns) {
        $new_columns = array();
        
        foreach ($columns as $key => $value) {
            if ('title' === $key) {
                $new_columns['thumbnail'] = __('Image', 'foodieland');
            }
            $new_columns[$key] = $value;
            
            if ('date' === $key) {
                $new_columns['recipe_difficulty'] = __('Difficulty', 'foodieland');
                $new_columns['recipe_time'] = __('Time', 'foodieland');
                $new_columns['recipe_rating'] = __('Rating', 'foodieland');
            }
        }
        
        return $new_columns;
    }
    
    /**
     * Custom column content
     */
    public function custom_column_content($column, $post_id) {
        switch ($column) {
            case 'thumbnail':
                if (has_post_thumbnail($post_id)) {
                    echo get_the_post_thumbnail($post_id, 'thumbnail', array('style' => 'width:50px;height:50px;object-fit:cover;border-radius:4px;'));
                } else {
                    echo '<span style="color:#999;">' . __('No Image', 'foodieland') . '</span>';
                }
                break;
                
            case 'recipe_difficulty':
                $difficulty = get_post_meta($post_id, '_recipe_difficulty', true);
                if ($difficulty) {
                    echo esc_html(ucfirst($difficulty));
                } else {
                    echo '-';
                }
                break;
                
            case 'recipe_time':
                $prep_time = get_post_meta($post_id, '_recipe_prep_time', true);
                $cook_time = get_post_meta($post_id, '_recipe_cook_time', true);
                $total_time = intval($prep_time) + intval($cook_time);
                if ($total_time > 0) {
                    printf(__('%d min', 'foodieland'), $total_time);
                } else {
                    echo '-';
                }
                break;
                
            case 'recipe_rating':
                $rating = get_post_meta($post_id, '_recipe_rating', true);
                if ($rating) {
                    echo '<span style="color:#FFB400;">';
                    for ($i = 0; $i < 5; $i++) {
                        echo $i < $rating ? '★' : '☆';
                    }
                    echo '</span>';
                } else {
                    echo '-';
                }
                break;
        }
    }
}

new Foodieland_Recipes_CPT();
