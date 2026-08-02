<?php
/**
 * Single Recipe Template
 */
if (!defined('ABSPATH')) exit;

get_header();
?>

<div class="recipe-single-wrapper">
    <?php while (have_posts()) : the_post(); ?>
    
    <!-- Recipe Hero -->
    <section class="recipe-hero" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'foodieland-hero')); ?>');">
        <div class="recipe-hero-overlay"></div>
        <div class="container">
            <div class="recipe-hero-content">
                <?php 
                $categories = get_the_terms(get_the_ID(), 'recipe_category');
                if ($categories && !is_wp_error($categories)) :
                ?>
                <span class="recipe-category"><?php echo esc_html($categories[0]->name); ?></span>
                <?php endif; ?>
                
                <h1 class="recipe-title"><?php the_title(); ?></h1>
                
                <?php if (get_the_subtitle()) : ?>
                <p class="recipe-subtitle"><?php echo esc_html(get_the_subtitle()); ?></p>
                <?php endif; ?>
                
                <div class="recipe-meta-grid">
                    <div class="recipe-meta-item">
                        <i class="icon-time"></i>
                        <span class="label"><?php _e('Prep Time', 'foodieland'); ?></span>
                        <span class="value"><?php echo esc_html(foodieland_format_time(get_post_meta(get_the_ID(), '_recipe_prep_time', true))); ?></span>
                    </div>
                    <div class="recipe-meta-item">
                        <i class="icon-fire"></i>
                        <span class="label"><?php _e('Cook Time', 'foodieland'); ?></span>
                        <span class="value"><?php echo esc_html(foodieland_format_time(get_post_meta(get_the_ID(), '_recipe_cook_time', true))); ?></span>
                    </div>
                    <div class="recipe-meta-item">
                        <i class="icon-clock"></i>
                        <span class="label"><?php _e('Total Time', 'foodieland'); ?></span>
                        <span class="value"><?php echo esc_html(foodieland_format_time(get_post_meta(get_the_ID(), '_recipe_prep_time', true) + get_post_meta(get_the_ID(), '_recipe_cook_time', true))); ?></span>
                    </div>
                    <div class="recipe-meta-item">
                        <i class="icon-users"></i>
                        <span class="label"><?php _e('Servings', 'foodieland'); ?></span>
                        <span class="value"><?php echo esc_html(get_post_meta(get_the_ID(), '_recipe_servings', true) ?: '4'); ?></span>
                    </div>
                    <div class="recipe-meta-item">
                        <i class="icon-star"></i>
                        <span class="label"><?php _e('Rating', 'foodieland'); ?></span>
                        <span class="value"><?php foodieland_star_rating(get_post_meta(get_the_ID(), '_recipe_rating', true)); ?></span>
                    </div>
                    <div class="recipe-meta-item">
                        <i class="icon-chart"></i>
                        <span class="label"><?php _e('Calories', 'foodieland'); ?></span>
                        <span class="value"><?php echo esc_html(get_post_meta(get_the_ID(), '_recipe_calories', true)); ?> kcal</span>
                    </div>
                </div>
                
                <div class="recipe-actions">
                    <button class="btn btn-primary" onclick="window.print()">
                        <i class="icon-print"></i> <?php _e('Print Recipe', 'foodieland'); ?>
                    </button>
                    <button class="btn btn-outline" data-alpine="favoriteToggle" data-post-id="<?php echo get_the_ID(); ?>">
                        <i class="icon-heart"></i> <?php _e('Add to Favorites', 'foodieland'); ?>
                    </button>
                    <button class="btn btn-outline" data-aline="shareToggle">
                        <i class="icon-share"></i> <?php _e('Share', 'foodieland'); ?>
                    </button>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Recipe Content -->
    <section class="recipe-content-section section-padding">
        <div class="container">
            <div class="recipe-content-grid">
                <div class="recipe-main-content">
                    <!-- Recipe Description -->
                    <div class="recipe-description">
                        <h2><?php _e('Description', 'foodieland'); ?></h2>
                        <?php the_content(); ?>
                    </div>
                    
                    <!-- Recipe Video -->
                    <?php if ($video_url = get_post_meta(get_the_ID(), '_recipe_video', true)) : ?>
                    <div class="recipe-video">
                        <h2><?php _e('Video Tutorial', 'foodieland'); ?></h2>
                        <div class="video-container">
                            <?php echo wp_oembed_get($video_url); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Ingredients -->
                    <div class="recipe-ingredients">
                        <h2><?php _e('Ingredients', 'foodieland'); ?></h2>
                        <?php 
                        $ingredients = get_post_meta(get_the_ID(), '_recipe_ingredients', true);
                        if ($ingredients) :
                            $ingredient_list = explode("\n", $ingredients);
                        ?>
                        <ul class="ingredients-list">
                            <?php foreach ($ingredient_list as $ingredient) : if (trim($ingredient)) : ?>
                            <li>
                                <span class="ingredient-check"></span>
                                <span class="ingredient-text"><?php echo esc_html(trim($ingredient)); ?></span>
                            </li>
                            <?php endif; endforeach; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Directions -->
                    <div class="recipe-directions">
                        <h2><?php _e('Directions', 'foodieland'); ?></h2>
                        <?php 
                        $directions = get_post_meta(get_the_ID(), '_recipe_directions', true);
                        if ($directions) :
                            $direction_list = explode("\n", $directions);
                        ?>
                        <ol class="directions-list">
                            <?php foreach ($direction_list as $index => $direction) : if (trim($direction)) : ?>
                            <li class="direction-step">
                                <span class="step-number"><?php echo esc_html($index + 1); ?></span>
                                <div class="step-content">
                                    <p><?php echo esc_html(trim($direction)); ?></p>
                                </div>
                            </li>
                            <?php endif; endforeach; ?>
                        </ol>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Nutrition Facts -->
                    <?php 
                    $nutrition = get_post_meta(get_the_ID(), '_recipe_nutrition', true);
                    if ($nutrition) :
                    ?>
                    <div class="recipe-nutrition">
                        <h2><?php _e('Nutrition Facts', 'foodieland'); ?></h2>
                        <div class="nutrition-grid">
                            <?php foreach ($nutrition as $key => $value) : if ($value) : ?>
                            <div class="nutrition-item">
                                <span class="nutrition-label"><?php echo esc_html(ucfirst(str_replace('_', ' ', $key))); ?></span>
                                <span class="nutrition-value"><?php echo esc_html($value); ?></span>
                            </div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Comments -->
                    <?php 
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                    ?>
                </div>
                
                <div class="recipe-sidebar">
                    <!-- Recipe Info Card -->
                    <div class="recipe-info-card card">
                        <h3><?php _e('Recipe Information', 'foodieland'); ?></h3>
                        
                        <?php 
                        $cuisine = get_the_terms(get_the_ID(), 'cuisine');
                        if ($cuisine && !is_wp_error($cuisine)) :
                        ?>
                        <div class="recipe-info-row">
                            <span class="label"><?php _e('Cuisine', 'foodieland'); ?></span>
                            <span class="value"><?php echo esc_html($cuisine[0]->name); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php 
                        $difficulty = get_the_terms(get_the_ID(), 'difficulty');
                        if ($difficulty && !is_wp_error($difficulty)) :
                        ?>
                        <div class="recipe-info-row">
                            <span class="label"><?php _e('Difficulty', 'foodieland'); ?></span>
                            <span class="value"><?php echo esc_html($difficulty[0]->name); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php 
                        $meal_type = get_the_terms(get_the_ID(), 'meal_type');
                        if ($meal_type && !is_wp_error($meal_type)) :
                        ?>
                        <div class="recipe-info-row">
                            <span class="label"><?php _e('Meal Type', 'foodieland'); ?></span>
                            <span class="value"><?php echo esc_html($meal_type[0]->name); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php 
                        $diet = get_the_terms(get_the_ID(), 'diet');
                        if ($diet && !is_wp_error($diet)) :
                        ?>
                        <div class="recipe-info-row">
                            <span class="label"><?php _e('Diet', 'foodieland'); ?></span>
                            <span class="value"><?php echo esc_html($diet[0]->name); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="recipe-info-row">
                            <span class="label"><?php _e('Author', 'foodieland'); ?></span>
                            <span class="value"><?php the_author(); ?></span>
                        </div>
                        
                        <div class="recipe-info-row">
                            <span class="label"><?php _e('Published', 'foodieland'); ?></span>
                            <span class="value"><?php echo get_the_date(); ?></span>
                        </div>
                    </div>
                    
                    <!-- Table of Contents -->
                    <div class="recipe-toc card">
                        <h3><?php _e('Contents', 'foodieland'); ?></h3>
                        <ul class="toc-list">
                            <li><a href="#description"><?php _e('Description', 'foodieland'); ?></a></li>
                            <?php if ($video_url) : ?><li><a href="#video"><?php _e('Video', 'foodieland'); ?></a></li><?php endif; ?>
                            <li><a href="#ingredients"><?php _e('Ingredients', 'foodieland'); ?></a></li>
                            <li><a href="#directions"><?php _e('Directions', 'foodieland'); ?></a></li>
                            <?php if ($nutrition) : ?><li><a href="#nutrition"><?php _e('Nutrition', 'foodieland'); ?></a></li><?php endif; ?>
                        </ul>
                    </div>
                    
                    <!-- Related Products -->
                    <?php if (function_exists('is_woocommerce')) : ?>
                    <div class="recipe-products card">
                        <h3><?php _e('Related Products', 'foodieland'); ?></h3>
                        <?php
                        $product_ids = get_post_meta(get_the_ID(), '_recipe_products', true);
                        if ($product_ids && is_array($product_ids)) :
                            foreach ($product_ids as $product_id) :
                                $product = wc_get_product($product_id);
                                if ($product) :
                        ?>
                        <div class="related-product">
                            <?php echo $product->get_image('thumbnail'); ?>
                            <div class="related-product-info">
                                <h4><?php echo $product->get_name(); ?></h4>
                                <span class="price"><?php echo $product->get_price_html(); ?></span>
                                <a href="<?php echo $product->get_permalink(); ?>" class="btn btn-sm btn-primary"><?php _e('View', 'foodieland'); ?></a>
                            </div>
                        </div>
                        <?php 
                                endif;
                            endforeach;
                        endif;
                        ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Related Recipes -->
    <section class="related-recipes section-padding bg-light">
        <div class="container">
            <h2 class="section-title text-center"><?php _e('Related Recipes', 'foodieland'); ?></h2>
            <div class="recipes-grid grid grid-4">
                <?php
                $categories = get_the_terms(get_the_ID(), 'recipe_category');
                $category_ids = array();
                if ($categories && !is_wp_error($categories)) {
                    foreach ($categories as $cat) {
                        $category_ids[] = $cat->term_id;
                    }
                }
                
                $related_args = array(
                    'post_type' => 'recipe',
                    'posts_per_page' => 4,
                    'post__not_in' => array(get_the_ID()),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'recipe_category',
                            'field' => 'term_id',
                            'terms' => $category_ids,
                        ),
                    ),
                );
                
                $related_query = new WP_Query($related_args);
                
                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) : $related_query->the_post();
                        get_template_part('template-parts/recipe', 'card');
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>' . __('No related recipes found.', 'foodieland') . '</p>';
                endif;
                ?>
            </div>
        </div>
    </section>
    
    <?php endwhile; ?>
</div>

<?php
get_footer();
