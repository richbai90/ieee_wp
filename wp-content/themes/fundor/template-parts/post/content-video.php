<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-inner">

        <?php
        $content = apply_filters('the_content', get_the_content());
        $video = false;

        // Only get video from the content if a playlist isn't present.
        if (false === strpos($content, 'wp-playlist-script')) {
            $video = get_media_embedded_in_content($content, array('video', 'object', 'embed', 'iframe'));
        }
        ?>

        <?php if ('' !== get_the_post_thumbnail() && !is_single() && empty($video)) : ?>
            <div class="post-thumbnail">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('fridominimal-featured-image-full'); ?>
                </a>
            </div><!-- .post-thumbnail -->
        <?php else:
            // If not a single post, highlight the video file.
            if (!empty($video)) {
                echo '<div class="entry-video embed-responsive embed-responsive-16by9">';
                echo do_shortcode($video[0]);
                echo '</div>';
            };

        endif; ?>
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

            <div class="entry-content">

                <?php
                if (is_single() || empty($video)) {

                    /* translators: %s: Name of current post */
                    the_content(sprintf(esc_html__('Read More', 'fundor') . '<span class="screen-reader-text"> "%s"</span>', get_the_title()));

                    wp_link_pages(array(
                        'before' => '<div class="page-links">' . esc_html__('Pages:', 'fundor'),
                        'after' => '</div>',
                        'link_before' => '<span class="page-number">',
                        'link_after' => '</span>',
                    ));
                };
                ?>
            </div><!-- .entry-content -->

        </div><!-- .post-content -->
        <?php
        if (is_single()) {
            fundor_entry_footer();
        }
        ?>
    </div>
</article><!-- #post-## -->
