<?php
/**
 * Main Template File
 */
if (!defined('ABSPATH')) exit;

get_header();
?>

<div class="page-wrapper">
    <?php if (is_home() && !is_front_page()) : ?>
    <div class="container">
        <header class="page-header">
            <h1 class="page-title"><?php single_post_title(); ?></h1>
        </header>
    </div>
    <?php endif; ?>
    
    <?php if (is_archive() || is_search()) : ?>
    <div class="container">
        <header class="archive-header">
            <?php the_archive_title('<h1 class="archive-title">', '</h1>'); ?>
            <?php the_archive_description('<div class="archive-description">', '</div>'); ?>
        </header>
    </div>
    <?php endif; ?>
    
    <div class="content-area">
        <div class="container">
            <div class="site-content">
                <?php if (is_singular('recipe')) : ?>
                    <?php get_template_part('templates/single', 'recipe'); ?>
                <?php elseif (is_post_type_archive('recipe') || is_tax(array('recipe_category', 'cuisine', 'difficulty'))) : ?>
                    <?php get_template_part('templates/archive', 'recipe'); ?>
                <?php elseif (is_singular('chef')) : ?>
                    <?php get_template_part('templates/single', 'chef'); ?>
                <?php elseif (is_singular()) : ?>
                    <?php get_template_part('templates/single', 'page'); ?>
                <?php elseif (is_home()) : ?>
                    <?php get_template_part('templates/blog', 'index'); ?>
                <?php elseif (is_search()) : ?>
                    <?php get_template_part('templates/search', 'results'); ?>
                <?php else : ?>
                    <?php
                    if (have_posts()) :
                        echo '<div class="posts-grid grid grid-3">';
                        while (have_posts()) : the_post();
                            get_template_part('template-parts/content', get_post_type());
                        endwhile;
                        echo '</div>';
                        the_posts_pagination();
                    else :
                        get_template_part('template-parts/content', 'none');
                    endif;
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
