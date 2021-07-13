<?php
get_header('404'); ?>
    <div class="wrap">
        <div id="primary" class="content-area">
            <main id="main" class="site-main">
                <?php if (get_theme_mod('osf_page_404_page_enable') != 'default' && !empty(get_theme_mod('osf_page_404_page_custom'))): ?>
                    <?php $query = new WP_Query('page_id=' . esc_attr(get_theme_mod('osf_page_404_page_custom')));
                    if ($query->have_posts()):
                        while ($query->have_posts()) : $query->the_post();
                            the_content();
                        endwhile;
                    endif; ?>
                <?php else: ?>
                    <section class="error-404 not-found">
                        <div class="page-content">
                            <div class="error-404-title">
                                <h1 class="p-0 m-0"><?php esc_html_e('404', 'fundor'); ?></h1>
                                <h2 class="error-404-subtitle">
                                    <?php esc_html_e('oops! page not found.', 'fundor'); ?>
                                </h2>
                            </div>
                            <div class="error-content">
                                <div class="error-text">
                                    <span><?php esc_html_e( "It looks like nothing was found at this location. You can either go back to the last page or go to homepage.", 'fundor' ) ?></span>
                                </div>
                                <div class="error-btn-bh">
                                    <a href="javascript: history.go(-1)" class="go-back btn-link button-md button-primary"><?php esc_html_e( 'go back', 'fundor' ); ?></a>
                                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="return-home btn-link button-md button-light"><?php esc_html_e( 'homepage', 'fundor' ); ?></a>
                                </div>
                            </div>
                        </div>
                    </section><!-- .error-404 -->
                <?php endif; ?>
            </main><!-- #main -->
        </div><!-- #primary -->
    </div><!-- .wrap -->

<?php get_footer();
