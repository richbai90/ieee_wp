<div class="column-item">
    <div class="post-inner">
        <?php if (has_post_thumbnail() && '' !== get_the_post_thumbnail()) : ?>
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
                    echo '<span class="entry-category" >' . get_the_category_list(', ') . '</span>';
                    ?>
                </div>
                <?php
                    the_title('<h4 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h4>');
                ?>
            </header><!-- .entry-header -->
            <div class="entry-content">
                <?php
                /* translators: %s: Name of current post */
                the_content(sprintf(esc_html__('Read More', 'fundor') . '<span class="screen-reader-text"> "%s"</span>', get_the_title()));
                wp_link_pages(array(
                    'before'      => '<div class="page-links">' . esc_html__('Pages:', 'fundor'),
                    'after'       => '</div>',
                    'link_before' => '<span class="page-number">',
                    'link_after'  => '</span>',
                ));
                ?>
            </div><!-- .entry-content -->
        </div><!-- .post-content -->
    </div>
</div><!-- #post-## -->