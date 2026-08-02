<?php
/**
 * Register Recipe Taxonomies
 */

if (!defined('ABSPATH')) exit;

class Foodieland_Recipe_Taxonomies {
    
    public function __construct() {
        add_action('init', array($this, 'register_taxonomies'));
    }
    
    public function register_taxonomies() {
        // Recipe Categories
        $this->register_taxonomy('recipe_category', array('recipe'), array(
            'labels' => array(
                'name' => _x('Recipe Categories', 'foodieland'),
                'singular_name' => _x('Recipe Category', 'foodieland'),
            ),
            'hierarchical' => true,
            'rewrite' => array('slug' => 'recipe-category'),
            'show_in_rest' => true,
        ));
        
        // Cuisine
        $this->register_taxonomy('cuisine', array('recipe'), array(
            'labels' => array(
                'name' => _x('Cuisines', 'foodieland'),
                'singular_name' => _x('Cuisine', 'foodieland'),
            ),
            'hierarchical' => true,
            'rewrite' => array('slug' => 'cuisine'),
            'show_in_rest' => true,
        ));
        
        // Difficulty
        $this->register_taxonomy('difficulty', array('recipe'), array(
            'labels' => array(
                'name' => _x('Difficulty Levels', 'foodieland'),
                'singular_name' => _x('Difficulty', 'foodieland'),
            ),
            'hierarchical' => false,
            'rewrite' => array('slug' => 'difficulty'),
            'show_in_rest' => true,
        ));
        
        // Ingredients
        $this->register_taxonomy('ingredient', array('recipe'), array(
            'labels' => array(
                'name' => _x('Ingredients', 'foodieland'),
                'singular_name' => _x('Ingredient', 'foodieland'),
            ),
            'hierarchical' => false,
            'rewrite' => array('slug' => 'ingredient'),
            'show_in_rest' => true,
        ));
        
        // Meal Type
        $this->register_taxonomy('meal_type', array('recipe'), array(
            'labels' => array(
                'name' => _x('Meal Types', 'foodieland'),
                'singular_name' => _x('Meal Type', 'foodieland'),
            ),
            'hierarchical' => true,
            'rewrite' => array('slug' => 'meal-type'),
            'show_in_rest' => true,
        ));
        
        // Diet
        $this->register_taxonomy('diet', array('recipe'), array(
            'labels' => array(
                'name' => _x('Diets', 'foodieland'),
                'singular_name' => _x('Diet', 'foodieland'),
            ),
            'hierarchical' => false,
            'rewrite' => array('slug' => 'diet'),
            'show_in_rest' => true,
        ));
    }
    
    private function register_taxonomy($taxonomy, $post_types, $args) {
        $defaults = array(
            'public' => true,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
        );
        
        $args = wp_parse_args($args, $defaults);
        register_taxonomy($taxonomy, $post_types, $args);
    }
}

new Foodieland_Recipe_Taxonomies();
