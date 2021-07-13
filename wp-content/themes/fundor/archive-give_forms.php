<?php get_header(); ?>

    <div class="wrap archive-give-forms">
        <div id="primary" class="content-area">
            <main id="main" class="site-main" >

                <?php if (have_posts()) :
                    echo '<div class="give-wrap"><div class="give-grid">';

                    while (have_posts()) : the_post();

                        get_template_part( 'template-parts/give/content', 'form');

                    endwhile;
                    echo '</div></div>';

                    the_posts_pagination( array(
                        'prev_text'          => '<span class="fa fa-angle-left"></span><span class="screen-reader-text">' . esc_html__( 'Previous', 'fundor' ) . '</span>',
                        'next_text'          => '<span class="screen-reader-text">' . esc_html__( 'Next', 'fundor' ) . '</span><span class="fa fa-angle-right"></span>',
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'fundor' ) . ' </span>',
                    ) );

                else :
                    get_template_part( 'template-parts/post/content', 'none' );

                endif; ?>

            </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div><!-- .wrap -->

<?php get_footer();
