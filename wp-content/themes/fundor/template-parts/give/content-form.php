<?php

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}

$form_id            = get_the_ID(); // Form ID.

$enable_category    = give_is_setting_enabled(give_get_option('categories', 'disabled'));

$form                = new Give_Donate_Form($form_id);
$goal_progress_stats = give_goal_progress_stats($form);
$income              = $goal_progress_stats['raw_actual'];
$goal                = $goal_progress_stats['raw_goal'];
$creator             = new Opal_Give_Creator(get_post_field('post_author', $form_id));

?>

<div class="give-grid__item">
    <div class="give-card__inner">
        <?php
        printf(
            '<a id="give-card-%1$s" class="give-card" href="%2$s">',
            esc_attr($form_id),
            esc_url(get_the_permalink())
        );
        ?>

        <div class="give-card__body">
            <?php

            echo '<div class="give-card__progress">';
            give_show_goal_progress($form_id);
            echo '</div>';

            ?>
        </div>

        <?php

        // Maybe display the featured image.
        echo '<div class="give-card__media">';

        echo '<div class="give-card__thumbnail">';
        the_post_thumbnail('fundor-featured-image-large');
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
                        <div data-fundor-id="<?php echo esc_attr($form_id) ?>" data-toogle="fundor-gallery">
                            <i class="opal-icon-image"></i>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($video) { ?>
                    <div class="opal-video-popup">
                        <div data-fundor-id="<?php echo esc_attr($form_id) ?>" data-toogle="fundor-video">
                            <i class="opal-icon-video"></i>
                        </div>
                    </div>
                <?php } ?>
            </div>

        <?php
        echo '</div>';/*end give-card__media*/
        ?>
        </a>
        <?php
        echo '<a class="btn-donate-now js-give-grid-modal-launcher" data-effect="mfp-zoom-out" href="#give-modal-form-'.esc_attr($form_id).'">'.esc_html__('Donate Now','fundor').'</a>';
        ?>
    </div>

    <div class="give-card__meta">

        <?php if ($enable_category):
            echo wp_kses_post(get_the_term_list( $form_id, 'give_forms_category', '<div class="give-card__category">', ', ', '</div>' ));
        endif; ?>

        <h3 class="give-card__title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>

        <?php

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


        $excerpt = $stripped_content;


        printf('<p class="give-card__text">%s</p>', $excerpt);
        ?>

        <span class="give-card__author"><?php echo wp_kses_post($creator->get_avatar(50)); ?><span class="label"><?php echo esc_html__('by', 'fundor') ?></span><span class="author-name"><?php the_author(); ?></span></span>

    </div>

    <?php
    // If modal, print form in hidden container until it is time to be revealed.
    printf(
        '<div id="give-modal-form-%1$s" class="give-donation-grid-item-form give-modal--slide mfp-hide">',
        $form_id
    );
    give_get_donation_form($form_id);
    echo '</div>';
    ?>
</div>
