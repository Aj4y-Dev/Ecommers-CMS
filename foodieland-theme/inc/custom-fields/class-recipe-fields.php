<?php
/**
 * Register Recipe Custom Fields (Meta Boxes)
 */

if (!defined('ABSPATH')) exit;

class Foodieland_Recipe_Fields {
    
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post_recipe', array($this, 'save_meta_boxes'), 10, 2);
    }
    
    public function add_meta_boxes() {
        add_meta_box(
            'recipe_details',
            __('Recipe Details', 'foodieland'),
            array($this, 'render_details_box'),
            'recipe',
            'normal',
            'high'
        );
        
        add_meta_box(
            'recipe_nutrition',
            __('Nutrition Facts', 'foodieland'),
            array($this, 'render_nutrition_box'),
            'recipe',
            'normal',
            'default'
        );
        
        add_meta_box(
            'recipe_video',
            __('Video', 'foodieland'),
            array($this, 'render_video_box'),
            'recipe',
            'side',
            'default'
        );
        
        add_meta_box(
            'recipe_seo',
            __('SEO Settings', 'foodieland'),
            array($this, 'render_seo_box'),
            'recipe',
            'normal',
            'low'
        );
    }
    
    public function render_details_box($post) {
        wp_nonce_field('recipe_details_nonce', 'recipe_details_nonce');
        
        $prep_time = get_post_meta($post->ID, '_recipe_prep_time', true);
        $cook_time = get_post_meta($post->ID, '_recipe_cook_time', true);
        $servings = get_post_meta($post->ID, '_recipe_servings', true);
        $difficulty = get_post_meta($post->ID, '_recipe_difficulty', true);
        $cuisine = get_post_meta($post->ID, '_recipe_cuisine', true);
        $meal_type = get_post_meta($post->ID, '_recipe_meal_type', true);
        $rating = get_post_meta($post->ID, '_recipe_rating', true);
        
        $ingredients = get_post_meta($post->ID, '_recipe_ingredients', true);
        $directions = get_post_meta($post->ID, '_recipe_directions', true);
        
        ?>
        <div class="recipe-meta-box">
            <table class="form-table">
                <tr>
                    <th><label><?php _e('Prep Time (minutes)', 'foodieland'); ?></label></th>
                    <td><input type="number" name="recipe_prep_time" value="<?php echo esc_attr($prep_time); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label><?php _e('Cook Time (minutes)', 'foodieland'); ?></label></th>
                    <td><input type="number" name="recipe_cook_time" value="<?php echo esc_attr($cook_time); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label><?php _e('Servings', 'foodieland'); ?></label></th>
                    <td><input type="number" name="recipe_servings" value="<?php echo esc_attr($servings); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label><?php _e('Difficulty', 'foodieland'); ?></label></th>
                    <td>
                        <select name="recipe_difficulty" class="regular-text">
                            <option value=""><?php _e('Select...', 'foodieland'); ?></option>
                            <option value="easy" <?php selected($difficulty, 'easy'); ?>><?php _e('Easy', 'foodieland'); ?></option>
                            <option value="medium" <?php selected($difficulty, 'medium'); ?>><?php _e('Medium', 'foodieland'); ?></option>
                            <option value="hard" <?php selected($difficulty, 'hard'); ?>><?php _e('Hard', 'foodieland'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><label><?php _e('Cuisine', 'foodieland'); ?></label></th>
                    <td><input type="text" name="recipe_cuisine" value="<?php echo esc_attr($cuisine); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label><?php _e('Meal Type', 'foodieland'); ?></label></th>
                    <td><input type="text" name="recipe_meal_type" value="<?php echo esc_attr($meal_type); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label><?php _e('Rating (1-5)', 'foodieland'); ?></label></th>
                    <td><input type="number" min="1" max="5" name="recipe_rating" value="<?php echo esc_attr($rating); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th><label><?php _e('Ingredients (one per line)', 'foodieland'); ?></label></th>
                    <td><textarea name="recipe_ingredients" rows="6" class="large-text"><?php echo esc_textarea($ingredients); ?></textarea></td>
                </tr>
                <tr>
                    <th><label><?php _e('Directions/Steps', 'foodieland'); ?></label></th>
                    <td><textarea name="recipe_directions" rows="8" class="large-text"><?php echo esc_textarea($directions); ?></textarea></td>
                </tr>
            </table>
        </div>
        <?php
    }
    
    public function render_nutrition_box($post) {
        wp_nonce_field('recipe_nutrition_nonce', 'recipe_nutrition_nonce');
        
        $calories = get_post_meta($post->ID, '_recipe_calories', true);
        $protein = get_post_meta($post->ID, '_recipe_protein', true);
        $carbs = get_post_meta($post->ID, '_recipe_carbs', true);
        $fat = get_post_meta($post->ID, '_recipe_fat', true);
        $fiber = get_post_meta($post->ID, '_recipe_fiber', true);
        
        ?>
        <table class="form-table">
            <tr>
                <th><label><?php _e('Calories', 'foodieland'); ?></label></th>
                <td><input type="text" name="recipe_calories" value="<?php echo esc_attr($calories); ?>" class="regular-text" /> kcal</td>
            </tr>
            <tr>
                <th><label><?php _e('Protein', 'foodieland'); ?></label></th>
                <td><input type="text" name="recipe_protein" value="<?php echo esc_attr($protein); ?>" class="regular-text" /> g</td>
            </tr>
            <tr>
                <th><label><?php _e('Carbohydrates', 'foodieland'); ?></label></th>
                <td><input type="text" name="recipe_carbs" value="<?php echo esc_attr($carbs); ?>" class="regular-text" /> g</td>
            </tr>
            <tr>
                <th><label><?php _e('Fat', 'foodieland'); ?></label></th>
                <td><input type="text" name="recipe_fat" value="<?php echo esc_attr($fat); ?>" class="regular-text" /> g</td>
            </tr>
            <tr>
                <th><label><?php _e('Fiber', 'foodieland'); ?></label></th>
                <td><input type="text" name="recipe_fiber" value="<?php echo esc_attr($fiber); ?>" class="regular-text" /> g</td>
            </tr>
        </table>
        <?php
    }
    
    public function render_video_box($post) {
        wp_nonce_field('recipe_video_nonce', 'recipe_video_nonce');
        
        $video_url = get_post_meta($post->ID, '_recipe_video_url', true);
        ?>
        <p>
            <label for="recipe_video_url"><?php _e('Video URL (YouTube/Vimeo)', 'foodieland'); ?></label>
            <input type="url" name="recipe_video_url" id="recipe_video_url" value="<?php echo esc_url($video_url); ?>" class="widefat" />
        </p>
        <?php
    }
    
    public function render_seo_box($post) {
        wp_nonce_field('recipe_seo_nonce', 'recipe_seo_nonce');
        
        $seo_title = get_post_meta($post->ID, '_recipe_seo_title', true);
        $seo_description = get_post_meta($post->ID, '_recipe_seo_description', true);
        $seo_keywords = get_post_meta($post->ID, '_recipe_seo_keywords', true);
        
        ?>
        <table class="form-table">
            <tr>
                <th><label><?php _e('SEO Title', 'foodieland'); ?></label></th>
                <td><input type="text" name="recipe_seo_title" value="<?php echo esc_attr($seo_title); ?>" class="large-text" /></td>
            </tr>
            <tr>
                <th><label><?php _e('SEO Description', 'foodieland'); ?></label></th>
                <td><textarea name="recipe_seo_description" rows="3" class="large-text"><?php echo esc_textarea($seo_description); ?></textarea></td>
            </tr>
            <tr>
                <th><label><?php _e('SEO Keywords', 'foodieland'); ?></label></th>
                <td><input type="text" name="recipe_seo_keywords" value="<?php echo esc_attr($seo_keywords); ?>" class="large-text" /></td>
            </tr>
        </table>
        <?php
    }
    
    public function save_meta_boxes($post_id, $post) {
        // Verify nonces
        if (!isset($_POST['recipe_details_nonce']) || !wp_verify_nonce($_POST['recipe_details_nonce'], 'recipe_details_nonce')) return;
        if (!isset($_POST['recipe_nutrition_nonce']) || !wp_verify_nonce($_POST['recipe_nutrition_nonce'], 'recipe_nutrition_nonce')) return;
        if (!isset($_POST['recipe_video_nonce']) || !wp_verify_nonce($_POST['recipe_video_nonce'], 'recipe_video_nonce')) return;
        if (!isset($_POST['recipe_seo_nonce']) || !wp_verify_nonce($_POST['recipe_seo_nonce'], 'recipe_seo_nonce')) return;
        
        // Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        
        // Check permissions
        if (!current_user_can('edit_post', $post_id)) return;
        
        // Save details
        $fields = array(
            'recipe_prep_time' => '_recipe_prep_time',
            'recipe_cook_time' => '_recipe_cook_time',
            'recipe_servings' => '_recipe_servings',
            'recipe_difficulty' => '_recipe_difficulty',
            'recipe_cuisine' => '_recipe_cuisine',
            'recipe_meal_type' => '_recipe_meal_type',
            'recipe_rating' => '_recipe_rating',
            'recipe_ingredients' => '_recipe_ingredients',
            'recipe_directions' => '_recipe_directions',
            'recipe_calories' => '_recipe_calories',
            'recipe_protein' => '_recipe_protein',
            'recipe_carbs' => '_recipe_carbs',
            'recipe_fat' => '_recipe_fat',
            'recipe_fiber' => '_recipe_fiber',
            'recipe_video_url' => '_recipe_video_url',
            'recipe_seo_title' => '_recipe_seo_title',
            'recipe_seo_description' => '_recipe_seo_description',
            'recipe_seo_keywords' => '_recipe_seo_keywords',
        );
        
        foreach ($fields as $post_key => $meta_key) {
            if (isset($_POST[$post_key])) {
                update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$post_key]));
            }
        }
    }
}

new Foodieland_Recipe_Fields();
