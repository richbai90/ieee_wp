
<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'fundor' ); ?></h1>
    </header>
    <div class="page-content">
        <?php
        if (is_home() && current_user_can( 'publish_posts' )) : ?>

            <p>
                <?php echo esc_html__('Ready to publish your first post?','fundor').'&nbsp;<a href="'.esc_url( admin_url( 'post-new.php' ) ).'">'.esc_html__('Get started here','fundor').'</a>'; ?>
            </p>

        <?php else : ?>

            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'fundor' ); ?></p>
            <?php
            get_search_form();

        endif; ?>
    </div><!-- .page-content -->
</section><!-- .no-results -->
