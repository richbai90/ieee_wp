<article id="post-<?php the_ID(); ?>" <?php post_class('osf-story-single'); ?>>
    <div class="post-inner">
        <?php if (has_post_thumbnail()) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail('full'); ?>
            </div><!-- .post-thumbnail -->
        <?php endif; ?>

        <div class="entry-content">
            <?php the_content(); ?>
        </div><!-- .entry-content -->

    </div>

</article><!-- #post-## -->