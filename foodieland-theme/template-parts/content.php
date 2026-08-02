<?php
/**
 * Content Template Part (Default post content)
 */
if (!defined('ABSPATH')) exit;
?>

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
