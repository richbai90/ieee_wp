<?php
if (!function_exists('fundor_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function fundor_posted_on() {
        echo '<div class="entry-meta-inner">';

        echo ' <span class="post-date">' . fundor_time_link() . ' </span>';// WPCS: xss ok.

        // Get the author name; wrap it in a link.
        echo sprintf(
        /* translators: %s: post author */
            __('<span class="author vcard" >%s </span>', 'fundor'),
            '<a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '"><i class="opal-icon-user"></i>' . esc_html(get_the_author()) . '</a>'
        );

        echo '</div>';
    }
endif;


if (!function_exists('fundor_time_link')) :
    /**
     * Gets a nicely formatted string for the published date.
     */
    function fundor_time_link() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf($time_string,
            get_the_date(DATE_W3C),
            get_the_date(),
            get_the_modified_date(DATE_W3C),
            get_the_modified_date()
        );

        // Wrap the time string in a link, and preface it with 'Posted on'.
        return '<a href="' . esc_url(get_permalink()) . '" rel="bookmark"><i class="opal-icon-calendar"></i>' . $time_string . '</a>';// WPCS: xss ok.
    }
endif;


if (!function_exists('fundor_entry_footer')):
    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function fundor_entry_footer() {

        // Get Tags for posts.
        $tags_list = get_the_tag_list('', ' ');

        // We don't want to output .entry-footer if it will be empty, so make sure its not.

        if (fundor_is_osf_framework_activated() && get_theme_mod('osf_socials') || $tags_list) {
            echo '<footer class="entry-footer">';

            if ('post' === get_post_type()) {

                if ($tags_list) {
                    echo '<div class="cat-tags-links">';

                    echo '<span class="tags-links">' . wp_kses_post($tags_list) . '</span>';

                    echo '</div>';
                }
            }

            fundor_social_share();

            echo '</footer> <!-- .entry-footer -->';
        }

    }
endif;


if (!function_exists('fundor_edit_link')) :
    /**
     * Returns an accessibility-friendly link to edit a post or page.
     *
     * This also gives us a little context about what exactly we're editing
     * (post or page?) so that users understand a bit more where they are in terms
     * of the template hierarchy and their content. Helpful when/if the single-page
     * layout with multiple posts/pages shown gets confusing.
     */
    function fundor_edit_link() {
        edit_post_link(
            sprintf(
            /* translators: %s: Name of current post */
                __('Edit<span class="screen-reader-text"> "%s"</span>', 'fundor'),
                get_the_title()
            ),
            '<span class="edit-link">',
            '</span>'
        );
    }
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function fundor_categorized_blog() {
    $category_count = get_transient('fundor_categories');

    if (false === $category_count) {
        // Create an array of all the categories that are attached to posts.
        $categories = get_categories(array(
            'fields'     => 'ids',
            'hide_empty' => 1,
            // We only need to know if there is more than one category.
            'number'     => 2,
        ));

        // Count the number of categories that are attached to the posts.
        $category_count = count($categories);

        set_transient('fundor_categories', $category_count);
    }

    // Allow viewing case of 0 or 1 categories in post preview.
    if (is_preview()) {
        return true;
    }

    return $category_count > 1;
}


/**
 * Flush out the transients used in fundor_categorized_blog.
 */
function fundor_category_transient_flusher() {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('fundor_categories');
}

add_action('edit_category', 'fundor_category_transient_flusher');
add_action('save_post', 'fundor_category_transient_flusher');