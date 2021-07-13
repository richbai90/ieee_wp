<?php

/**
 * The template for displaying product content in the archive-osf_speakers.php template
 *
 * This template can be overridden by copying it to yourtheme/archive-osf_speakers.php.
 *
 */

defined( 'ABSPATH' ) || exit;

get_header(); ?>

    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <?php if (have_posts()) :
                    echo '<div class="row speaker-style-3" data-opal-columns="3">';

                    while (have_posts()) : the_post();

                        $template = locate_template('template-parts/speakers/content-speakers.php') ? locate_template('template-parts/speakers/content-speakers.php'): trailingslashit(FUNDOR_CORE_PLUGIN_DIR).'templates/speakers/content-speakers.php';
                        include $template;

                    endwhile;

                    the_posts_pagination(array(
                        'prev_text' => '<span class="fa fa-angle-left"></span><span class="screen-reader-text">' . esc_html__('Previous', 'fundor-core') . '</span>',
                        'next_text' => '<span class="screen-reader-text">' . esc_html__('Next', 'fundor-core') . '</span><span class="fa fa-angle-right"></span>',
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__('Page', 'fundor-core') . ' </span>',
                    ));
                    echo '</div>';
                else :
                    get_template_part('template-parts/post/content', 'none');

                endif; ?>

            </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div><!-- .wrap -->

<?php get_footer();
