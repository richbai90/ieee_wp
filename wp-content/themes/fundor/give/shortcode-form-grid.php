<?php
/**
 * This template is used to display the donation grid with [donation_grid]
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$form_id          = get_the_ID(); // Form ID.
$give_settings    = $args[0]; // Give settings.
$atts             = $args[1]; // Shortcode attributes.
$raw_content      = ''; // Raw form content.
$stripped_content = ''; // Form content stripped of HTML tags and shortcodes.
$excerpt          = ''; // Trimmed form excerpt ready for display.

$enable_category = give_is_setting_enabled(give_get_option('categories', 'disabled'));
if ($enable_category) {
    $term_list = wp_get_post_terms($form_id, 'give_forms_category', array('fields' => 'names'));
}
$form                = new Give_Donate_Form($form_id);
$goal_progress_stats = give_goal_progress_stats($form);
$income              = $goal_progress_stats['raw_actual'];
$goal                = $goal_progress_stats['raw_goal'];
$creator             = new Opal_Give_Creator(get_post_field('post_author', $form_id));
?>

<div class="give-grid__item">
    <div class="give-card__inner">
        <?php
        // Print the opening anchor tag based on display style.
        printf(
            '<a id="give-card-%1$s" class="give-card" href="%2$s">',
            esc_attr($form_id),
            esc_attr(get_the_permalink())
        );
        ?>

        <div class="give-card__body">
            <?php
            // Maybe display the form title.
            if ($income >= $goal) {
                echo '<div class="wrap-label"><div class="label success">' . esc_html__('Successful', 'fundor') . '</div></div>';
            } else {
                echo '<div class="wrap-label"><div class="label unsuccess">' . esc_html__('Unsuccessful', 'fundor') . '</div></div>';
            }
            // Maybe display the goal progess bar.
            if (
                give_is_setting_enabled(get_post_meta($form_id, '_give_goal_option', true))
                && true === $atts['show_goal']
            ) {
                echo '<div class="give-card__progress top">';
                give_show_goal_progress($form_id);
                echo '</div>';
            }
            ?>
        </div>

        <?php
        // Maybe display the featured image.
        if (
            give_is_setting_enabled($give_settings['form_featured_img'])
            && has_post_thumbnail()
        ) {
            /*
             * Filters the image size used in card layouts.
             *
             * @param string The image size.
             * @param array  Form grid attributes.
             */
            $image_size = apply_filters('give_form_grid_image_size', $atts['image_size'], $atts);
            $image_attr = '';

            echo '<div class="give-card__media">';
            if ('auto' !== $atts['image_height']) {
                $image_attr = array(
                    'style' => 'height: ' . $atts['image_height'],
                );
            }
            echo '<div class="give-card__thumbnail">';
            the_post_thumbnail($image_size, $image_attr);
            echo '</div>';

            if ($income >= $goal) {
                echo '<div class="label success">' . esc_html__('Successful', 'fundor') . '</div>';
            } else {
                echo '<div class="label unsuccess">' . esc_html__('Unsuccessful', 'fundor') . '</div>';
            }

            $video   = get_post_meta($form_id, 'osf_give_video', true);
            $gallery = get_post_meta($form_id, 'osf_give_gallery', true);
            ?>

            <div class="opal-popup-wrapper">
                <?php if ($gallery) { ?>
                    <div class="opal-image-popup">
                        <div data-fundor-id="<?php echo esc_html($form_id) ?>" data-toogle="fundor-gallery">
                            <i class="opal-icon-image"></i>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($video) { ?>
                    <div class="opal-video-popup">
                        <div data-fundor-id="<?php echo esc_html($form_id) ?>" data-toogle="fundor-video">
                            <i class="opal-icon-video"></i>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <?php
            echo '</div>';
        }
        ?>
        </a>
    </div>

    <div class="give-card__meta">

        <?php if (!empty($term_list)): ?>
        <span class="give-card__category"><?php if (is_array($term_list)): echo wp_kses_post(get_the_term_list( $form_id, 'give_forms_category','',', ','' )); endif; ?></span>
        <?php endif; ?>

        <?php
        if (true === $atts['show_title']) {?>
        <h3 class="give-card__title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
        <?php
        }
        // Maybe display the form excerpt.
        if (true === $atts['show_excerpt']) {
            if (has_excerpt($form_id)) {
                // Get excerpt from the form post's excerpt field.
                $raw_content      = get_the_excerpt($form_id);
                $stripped_content = wp_strip_all_tags(
                    strip_shortcodes($raw_content)
                );
            } else {
                // Get content from the form post's content field.
                $raw_content = give_get_meta($form_id, '_give_form_content', true);

                if (!empty($raw_content)) {
                    $stripped_content = wp_strip_all_tags(
                        strip_shortcodes($raw_content)
                    );
                }
            }

            // Maybe truncate excerpt.
            if (0 < $atts['excerpt_length']) {
                $excerpt = wp_trim_words($stripped_content, $atts['excerpt_length']);
            } else {
                $excerpt = $stripped_content;
            }

            printf('<p class="give-card__text">%s</p>', $excerpt);
        } ?>

        <!--Get Author-->
        <span class="give-card__author"><?php echo wp_kses_post($creator->get_avatar(50)); ?><span class="label"><?php esc_html_e('by', 'fundor') ?></span><span class="author-name"><?php the_author(); ?></span></span>

        <?php
        if (
            give_is_setting_enabled(get_post_meta($form_id, '_give_goal_option', true))
            && true === $atts['show_goal']
        ) {
            echo '<div class="give-card__progress bottom">';
            give_show_goal_progress($form_id);
            echo '</div>';
        }

        ?>
    </div>
</div>
