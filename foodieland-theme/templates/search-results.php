<?php
/**
 * Search Results Template
 */
if (!defined('ABSPATH')) exit;

get_header();
?>

<div class="search-results-wrapper">
    <!-- Search Header -->
    <section class="search-header-section section-padding bg-light">
        <div class="container">
            <h1 class="search-title">
                <?php printf(__('Search Results for: %s', 'foodieland'), '<span class="text-primary">' . get_search_query() . '</span>'); ?>
            </h1>
            <p class="search-count">
                <?php printf(_n('%d result found', '%d results found', $wp_query->found_posts, 'foodieland'), $wp_query->found_posts); ?>
            </p>
        </div>
    </section>
    
    <!-- Search Content -->
    <section class="search-content-section section-padding">
        <div class="container">
            <div class="search-grid-layout">
                <!-- Main Content -->
                <div class="search-main">
                    <?php if (have_posts()) : ?>
                    <div class="results-grid grid grid-3">
                        <?php while (have_posts()) : the_post(); ?>
                        
                        <?php if (get_post_type() === 'recipe') : ?>
                            <?php get_template_part('template-parts/recipe', 'card'); ?>
                            
                        <?php elseif (get_post_type() === 'product') : ?>
                            <?php wc_get_template_part('content', 'product'); ?>
                            
                        <?php else : ?>
                        <article class="post-card card" id="post-<?php the_ID(); ?>">
                            <div class="post-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('foodieland-card', array('loading' => 'lazy')); ?>
                                    <?php else : ?>
                                        <img src="<?php echo FOODIELAND_URI; ?>/assets/images/placeholder.jpg" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                    <?php endif; ?>
                                </a>
                            </div>
                            <div class="post-card-content">
                                <span class="post-type-badge"><?php echo esc_html(get_post_type_object(get_post_type())->labels->singular_name); ?></span>
                                <h2 class="post-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <p class="post-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-sm"><?php _e('View', 'foodieland'); ?></a>
                            </div>
                        </article>
                        <?php endif; ?>
                        
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="search-pagination">
                        <?php
                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'prev_text' => __('Previous', 'foodieland'),
                            'next_text' => __('Next', 'foodieland'),
                        ));
                        ?>
                    </div>
                    <?php else : ?>
                    <div class="no-results text-center">
                        <i class="icon-search-empty"></i>
                        <h2><?php _e('No results found', 'foodieland'); ?></h2>
                        <p><?php printf(__('Try searching for "%s" or use different keywords.', 'foodieland'), get_search_query()); ?></p>
                        
                        <!-- Suggested Search -->
                        <div class="suggested-search">
                            <h3><?php _e('Search instead for:', 'foodieland'); ?></h3>
                            <div class="suggested-tags">
                                <?php
                                $keywords = explode(' ', get_search_query());
                                foreach ($keywords as $keyword) {
                                    if (strlen($keyword) > 3) {
                                        echo '<a href="' . esc_url(home_url('/?s=' . urlencode($keyword))) . '" class="tag-link">' . esc_html($keyword) . '</a>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        
                        <!-- Browse Categories -->
                        <div class="browse-categories mt-2">
                            <h3><?php _e('Or browse categories:', 'foodieland'); ?></h3>
                            <div class="category-links">
                                <a href="<?php echo esc_url(get_post_type_archive_link('recipe')); ?>" class="btn btn-outline"><?php _e('All Recipes', 'foodieland'); ?></a>
                                <a href="<?php echo esc_url(get_post_type_archive_link('product')); ?>" class="btn btn-outline"><?php _e('Shop', 'foodieland'); ?></a>
                                <a href="<?php echo esc_url(get_permalink(get_option('blog_page'))); ?>" class="btn btn-outline"><?php _e('Blog', 'foodieland'); ?></a>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar -->
                <aside class="search-sidebar">
                    <!-- Search Form Widget -->
                    <div class="widget card">
                        <h4 class="widget-title"><?php _e('Refine Search', 'foodieland'); ?></h4>
                        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="search" class="search-field" placeholder="<?php _e('Search...', 'foodieland'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                            <button type="submit" class="search-submit"><i class="icon-search"></i></button>
                        </form>
                    </div>
                    
                    <!-- Recipe Categories Widget -->
                    <?php if (isset($_GET['post_type']) && $_GET['post_type'] === 'recipe' || is_post_type_archive('recipe')) : ?>
                    <div class="widget card mt-2">
                        <h4 class="widget-title"><?php _e('Recipe Categories', 'foodieland'); ?></h4>
                        <ul class="category-list">
                            <?php
                            $categories = get_terms(array(
                                'taxonomy' => 'recipe_category',
                                'hide_empty' => true,
                            ));
                            if ($categories && !is_wp_error($categories)) :
                                foreach ($categories as $category) :
                            ?>
                            <li>
                                <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                    <span>(<?php echo esc_html($category->count); ?>)</span>
                                </a>
                            </li>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Product Categories Widget -->
                    <?php if (function_exists('is_woocommerce') && (isset($_GET['post_type']) && $_GET['post_type'] === 'product' || is_post_type_archive('product') || is_product_category())) : ?>
                    <div class="widget card mt-2">
                        <h4 class="widget-title"><?php _e('Product Categories', 'foodieland'); ?></h4>
                        <ul class="category-list">
                            <?php
                            $product_categories = get_terms(array(
                                'taxonomy' => 'product_cat',
                                'hide_empty' => true,
                            ));
                            if ($product_categories && !is_wp_error($product_categories)) :
                                foreach ($product_categories as $category) :
                            ?>
                            <li>
                                <a href="<?php echo esc_url(get_term_link($category)); ?>">
                                    <?php echo esc_html($category->name); ?>
                                    <span>(<?php echo esc_html($category->count); ?>)</span>
                                </a>
                            </li>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Popular Tags Widget -->
                    <div class="widget card mt-2">
                        <h4 class="widget-title"><?php _e('Popular Tags', 'foodieland'); ?></h4>
                        <div class="tags-cloud">
                            <?php
                            $tags = get_tags(array(
                                'number' => 15,
                                'orderby' => 'count',
                                'order' => 'DESC',
                            ));
                            if ($tags && !is_wp_error($tags)) :
                                foreach ($tags as $tag) :
                            ?>
                            <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" class="tag-link"><?php echo esc_html($tag->name); ?></a>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</div>

<?php
get_footer();
