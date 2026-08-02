<?php
/**
 * Blog Index Template
 */
if (!defined('ABSPATH')) exit;

get_header();
?>

<div class="blog-index-wrapper">
    <!-- Blog Header -->
    <section class="blog-header-section section-padding bg-light">
        <div class="container">
            <h1 class="page-title"><?php single_post_title(); ?></h1>
            <?php 
            $blog_description = get_option('blog_description');
            if ($blog_description) :
            ?>
            <p class="page-description"><?php echo esc_html($blog_description); ?></p>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- Blog Content -->
    <section class="blog-content-section section-padding">
        <div class="container">
            <div class="blog-grid-layout">
                <!-- Main Content -->
                <div class="blog-main">
                    <!-- Search and Filters -->
                    <div class="blog-toolbar">
                        <form role="search" method="get" class="blog-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="search" class="search-field" placeholder="<?php _e('Search articles...', 'foodieland'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
                            <button type="submit" class="search-submit"><i class="icon-search"></i></button>
                        </form>
                        <div class="blog-categories">
                            <?php
                            wp_list_categories(array(
                                'title_li' => '',
                                'style' => 'list',
                                'show_count' => true,
                            ));
                            ?>
                        </div>
                    </div>
                    
                    <!-- Posts Grid -->
                    <?php if (have_posts()) : ?>
                    <div class="posts-grid grid grid-3">
                        <?php while (have_posts()) : the_post(); ?>
                        <article class="post-card card" id="post-<?php the_ID(); ?>">
                            <div class="post-card-image">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('foodieland-card', array('loading' => 'lazy')); ?>
                                    <?php else : ?>
                                        <img src="<?php echo FOODIELAND_URI; ?>/assets/images/placeholder.jpg" alt="<?php the_title_attribute(); ?>" loading="lazy" />
                                    <?php endif; ?>
                                </a>
                                <div class="post-card-category">
                                    <?php 
                                    $categories = get_the_category();
                                    if ($categories && !is_wp_error($categories)) {
                                        echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="post-card-content">
                                <div class="post-card-meta">
                                    <span class="post-date"><i class="icon-calendar"></i> <?php echo get_the_date(); ?></span>
                                    <span class="post-author"><i class="icon-user"></i> <?php the_author(); ?></span>
                                </div>
                                <h2 class="post-card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <p class="post-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                <a href="<?php the_permalink(); ?>" class="btn btn-outline btn-sm"><?php _e('Read More', 'foodieland'); ?></a>
                            </div>
                        </article>
                        <?php endwhile; ?>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="blog-pagination">
                        <?php
                        the_posts_pagination(array(
                            'mid_size' => 2,
                            'prev_text' => __('Previous', 'foodieland'),
                            'next_text' => __('Next', 'foodieland'),
                        ));
                        ?>
                    </div>
                    <?php else : ?>
                    <div class="no-posts text-center">
                        <i class="icon-article-empty"></i>
                        <h2><?php _e('No articles found', 'foodieland'); ?></h2>
                        <p><?php _e('Try searching for something else or check back later.', 'foodieland'); ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar -->
                <aside class="blog-sidebar">
                    <!-- About Widget -->
                    <div class="widget card">
                        <h4 class="widget-title"><?php _e('About Foodieland', 'foodieland'); ?></h4>
                        <p><?php echo esc_html(get_option('blog_about_text', 'Welcome to Foodieland - your source for delicious recipes and cooking inspiration.')); ?></p>
                    </div>
                    
                    <!-- Categories Widget -->
                    <div class="widget card mt-2">
                        <h4 class="widget-title"><?php _e('Categories', 'foodieland'); ?></h4>
                        <ul class="category-list">
                            <?php
                            $categories = get_categories(array(
                                'number' => 10,
                                'orderby' => 'count',
                                'order' => 'DESC',
                            ));
                            if ($categories && !is_wp_error($categories)) :
                                foreach ($categories as $category) :
                            ?>
                            <li>
                                <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
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
                    
                    <!-- Popular Posts Widget -->
                    <div class="widget card mt-2">
                        <h4 class="widget-title"><?php _e('Popular Posts', 'foodieland'); ?></h4>
                        <?php
                        $popular_args = array(
                            'posts_per_page' => 5,
                            'meta_key' => '_post_views',
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC',
                            'post_status' => 'publish',
                        );
                        $popular_query = new WP_Query($popular_args);
                        
                        if ($popular_query->have_posts()) :
                            while ($popular_query->have_posts()) : $popular_query->the_post();
                        ?>
                        <div class="popular-post-item">
                            <?php if (has_post_thumbnail()) : ?>
                            <div class="popular-post-thumb">
                                <?php the_post_thumbnail('thumbnail'); ?>
                            </div>
                            <?php endif; ?>
                            <div class="popular-post-info">
                                <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                            </div>
                        </div>
                        <?php 
                            endwhile;
                            wp_reset_postdata();
                        endif;
                        ?>
                    </div>
                    
                    <!-- Tags Widget -->
                    <div class="widget card mt-2">
                        <h4 class="widget-title"><?php _e('Tags', 'foodieland'); ?></h4>
                        <div class="tags-cloud">
                            <?php
                            $tags = get_tags(array(
                                'number' => 15,
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
                    
                    <!-- Newsletter Widget -->
                    <div class="widget card mt-2 bg-primary text-white">
                        <h4 class="widget-title"><?php _e('Newsletter', 'foodieland'); ?></h4>
                        <p><?php _e('Subscribe to get the latest articles!', 'foodieland'); ?></p>
                        <?php echo do_shortcode('[foodieland_newsletter]'); ?>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</div>

<?php
get_footer();
