<?php
get_header(); ?>

    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">

                <?php
                while (have_posts()) : the_post();
                    get_template_part('template-parts/story/content', 'single');
                    // If comments are open or we have at least one comment, load up the comment template.
                    if (comments_open() || get_comments_number()) :
                        comments_template();
                    endif;
                endwhile; // End of the loop.
                ?>

            </main><!-- #main -->
            <?php
            $obj = fundor_get_post_link('osf_story_category', 'osf_story');
            $prev_ID   = $obj->previous;
            $prev_link = $obj->previous_post;
            $next_ID   = $obj->next;
            $next_link = $obj->next_post;

            $prev_title = isset($obj->previous_title) ? $obj->previous_title : '';
            $next_title = isset($obj->next_title) ? $obj->next_title : '';

            if (!empty($prev_link) || !empty($next_link)):
                ?>
                <nav class="navigation post-navigation" role="navigation">
                    <h3 class="screen-reader-text"><?php esc_html_e('Post navigation', 'fundor'); ?></h3>
                    <div class="nav-links clearfix">
                        <?php if (!empty($prev_link)): ?>
                            <div class="nav-links-inner prev 1">
                                <a href="<?php the_permalink($prev_ID); ?>" rel="prev">
                                    <div class="thumbnail-nav"> <i class="opal-icon-long-arrow-left"></i></div>
                                    <div class="nav-content">
                                        <div class="meta-nav"><?php esc_html_e('Previous','fundor'); ?></div>
                                        <div class="nav-title"><?php echo wp_kses_post($prev_title); ?></div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($next_link)): ?>
                            <div class="nav-links-inner next text-right">
                                <a href="<?php the_permalink($next_ID); ?>" rel="prev">
                                    <div class="nav-content">
                                        <div class="meta-nav"><?php esc_html_e('Next','fundor'); ?></div>
                                        <div class="nav-title"><?php echo wp_kses_post($next_title); ?></div>
                                    </div>
                                    <div class="thumbnail-nav"> <i class="opal-icon-long-arrow-right"></i></div>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </nav><!-- .navigation -->
            <?php endif;?>
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div><!-- .wrap -->


<?php get_footer();
