<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-inner">
        <?php if ('' !== get_the_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('fundor-featured-image-full'); ?>
                </a>
            </div><!-- .post-thumbnail -->
        <?php endif; ?>
        <div class="post-content">
            <header class="entry-header">
                <div class="entry-meta">
                    <?php
                    echo '<span class="entry-category" >' . wp_kses_post(get_the_category_list(', ')) . '</span>';
                    fundor_posted_on();
                    ?>
                </div>
                <?php
                if (!is_single()) {
                    the_title('<h4 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h4>');
                }
                ?>
            </header><!-- .entry-header -->
            <?php if (is_single()) : ?>
                <div class="entry-avatar">
                    <?php echo wp_kses_post(get_avatar(get_the_author_meta('email'), 38)); ?>
                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>"><?php the_author() ?></a>
                </div><!-- .entry-meta -->
            <?php endif; ?>

            <div class="entry-content">
                <?php the_excerpt(); ?>
            </div><!-- .entry-summary -->
        </div>
        <?php
        if (is_single()) {
            fundor_entry_footer();
        }
        ?>
    </div>
</article><!-- #post-## -->
