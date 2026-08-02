<?php
/**
 * Recipe Card Template Part
 */
if (!defined('ABSPATH')) exit;

$recipe_id = get_the_ID();
?>

<article class="recipe-card card" id="recipe-<?php the_ID(); ?>">
    <div class="recipe-card-image">
        <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('foodieland-card', array('loading' => 'lazy')); ?>
            <?php else : ?>
                <img src="<?php echo FOODIELAND_URI; ?>/assets/images/placeholder-recipe.jpg" alt="<?php the_title_attribute(); ?>" loading="lazy" />
            <?php endif; ?>
        </a>
        
        <button class="favorite-btn" data-post-id="<?php echo esc_attr($recipe_id); ?>" onclick="toggleFavorite(this)">
            <i class="icon-heart"></i>
        </button>
        
        <?php 
        $difficulty = get_the_terms($recipe_id, 'difficulty');
        if ($difficulty && !is_wp_error($difficulty)) :
        ?>
        <span class="recipe-badge badge-<?php echo esc_attr($difficulty[0]->slug); ?>"><?php echo esc_html($difficulty[0]->name); ?></span>
        <?php endif; ?>
    </div>
    
    <div class="recipe-card-content">
        <?php 
        $categories = get_the_terms($recipe_id, 'recipe_category');
        if ($categories && !is_wp_error($categories)) :
        ?>
        <span class="recipe-card-category"><?php echo esc_html($categories[0]->name); ?></span>
        <?php endif; ?>
        
        <h3 class="recipe-card-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        
        <div class="recipe-card-meta">
            <span class="meta-time" title="<?php _e('Total Time', 'foodieland'); ?>">
                <i class="icon-time"></i>
                <?php 
                $prep_time = get_post_meta($recipe_id, '_recipe_prep_time', true);
                $cook_time = get_post_meta($recipe_id, '_recipe_cook_time', true);
                $total_time = intval($prep_time) + intval($cook_time);
                echo esc_html(foodieland_format_time($total_time));
                ?>
            </span>
            
            <span class="meta-rating" title="<?php _e('Rating', 'foodieland'); ?>">
                <i class="icon-star"></i>
                <?php 
                $rating = get_post_meta($recipe_id, '_recipe_rating', true);
                if ($rating) {
                    echo number_format($rating, 1);
                } else {
                    echo '0';
                }
                ?>
            </span>
            
            <span class="meta-calories" title="<?php _e('Calories', 'foodieland'); ?>">
                <i class="icon-fire"></i>
                <?php 
                $calories = get_post_meta($recipe_id, '_recipe_calories', true);
                echo esc_html($calories ? $calories . ' kcal' : '--');
                ?>
            </span>
        </div>
        
        <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm"><?php _e('View Recipe', 'foodieland'); ?></a>
    </div>
</article>
