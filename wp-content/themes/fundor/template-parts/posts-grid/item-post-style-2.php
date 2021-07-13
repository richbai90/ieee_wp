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
                <?php
                    the_title('<h4 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h4>');
                ?>
                <div class="entry-meta">
                    <?php fundor_posted_on(); ?>
                </div>
            </header><!-- .entry-header -->
        </div><!-- .post-content -->
    </div>
</div><!-- #post-## -->