<article id="post-<?php the_ID(); ?>" <?php post_class('col-md-6'); ?>>
    <div class="post-inner">
        <?php if ('' !== get_the_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('large',[ 'alt' => esc_html ( get_the_title() ) ]); ?>
                </a>
            </div><!-- .post-thumbnail -->
        <?php endif; ?>
        <div class="post-content">
            <div class="entry-meta">
                <?php
                echo '<span class="entry-category" >' . wp_kses_post(get_the_category_list(', ')) . '</span>';
                ?>
            </div>
            <?php
                the_title('<h3 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h3>');
            ?>
        </div><!-- .post-content -->
    </div>
</article><!-- #post-## -->