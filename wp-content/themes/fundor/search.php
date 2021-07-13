<?php
get_header(); ?>
    <header class="page-header search-page-header">
        <h1 class="page-title"><?php printf(esc_html__('Search Results for:', 'fundor').'&nbsp;<span>%s</span>', esc_html(get_search_query())); ?></h1>
    </header><!-- .page-header -->
    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">

                <?php
                if (isset($_GET['post_type'])) {
                    $post_type = $_GET['post_type'];
                }
                if (have_posts()) :
                    /* Start the Loop */
                    if (isset($post_type) && $post_type == "give_forms") {
                        echo '<div class="give-wrap"><div class="give-grid give-grid--3">';
                    }
                    while (have_posts()) : the_post();

                        /**
                         * Run the loop for the search to output the results.
                         * If you want to overload this in a child theme then include a file
                         * called content-search.php and that will be used instead.
                         */
                        if (isset($post_type) && $post_type == "give_forms") {

                            get_template_part('template-parts/give/content', 'form');

                        } else {

                            get_template_part('template-parts/post/content', 'excerpt');
                            
                        }

                    endwhile; // End of the loop.
                    if (isset($post_type) && $post_type == "give_forms") {
                        echo '</div></div>';
                    }

                    the_posts_pagination(array(
                        'prev_text'          => '<span class="opal-icon-long-arrow-left"></span><span class="screen-reader-text">' . esc_html__('Previous', 'fundor') . '</span>',
                        'next_text'          => '<span class="screen-reader-text">' . esc_html__('Next', 'fundor') . '</span><span class="opal-icon-long-arrow-right"></span>',
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__('Page', 'fundor') . ' </span>',
                    ));

                else : ?>

                    <p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'fundor'); ?></p>
                <?php
                endif;
                ?>

            </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div><!-- .wrap -->

<?php get_footer();
