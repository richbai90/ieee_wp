<?php
$post_count = $post->post_count;

if ($post->loop == 0) {
    $class_col = 'col-lg-5 col-md-12';
    if ($post->loop == $post_count - 1) {
        $class_col = 'col-12';
    }?>
    <div class="<?php echo esc_attr($class_col) ?>">
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
<?php
    if ($post->loop != $post->post_count - 1){
        echo '<div class="col-lg-3 col-md-6 col-sm-12">';
        echo '<div class="post-wrapper-inner">';
    }
}elseif ($post->loop == 1 || $post->loop == 2) { ?>

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
            </div><!-- .post-content -->
        </div>
    <?php
    if ($post->loop == 2) {
        echo "</div></div>"; // close col
        echo '<div class="col-lg-4 col-md-6 col-sm-12">';
        echo '<div class="post-wrapper-inner post-normal">';
    }
}elseif ($post->loop >= 3){ ?>

    <div class="post-inner">
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
<?php
    if ($post->loop == 5) {
        echo "</div></div>"; // close col
    }
}
?>