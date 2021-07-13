<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * @var $user_slug bool|string
 */
if (!$user_slug) {
    return;
}

$user = get_user_by('slug', $user_slug);

if (!$user) {
    // Khong co gi
    return;
}

$creator = new Opal_Give_Creator($user);

?>
    <div class="author-profile-wrap">
        <div class="author-profile-sidebar">
            <div class="author-profile-avata"><?php echo $creator->get_avatar(); ?></div>

            <ul class="author-profile-meta">
                <li>
                    <label><?php echo esc_html__('Location', 'fundor-core'); ?></label><span><?php echo esc_html($creator->user_location); ?></span>
                </li>
                <li>
                    <label><?php echo esc_html__('Company', 'fundor-core'); ?></label><span><?php echo esc_html($creator->user_company); ?></span>
                </li>
                <li>
                    <label><?php echo esc_html__('Email', 'fundor-core'); ?></label><span><?php echo esc_html($creator->user_email); ?></span>
                </li>
                <li>
                    <label><?php echo esc_html__('Phone', 'fundor-core'); ?></label><span><?php echo esc_html($creator->user_phone); ?></span>
                </li>
                <li>
                    <label><?php echo esc_html__('Fax', 'fundor-core'); ?></label><span><?php echo esc_html($creator->user_fax); ?></span>
                </li>
            </ul>
        </div>
        <div class="author-profile-content">
            <h2 class="author-profile-name"><?php echo esc_html($creator->display_name); ?></h2>
            <div class="author-profile-description"><?php echo esc_html($creator->description); ?></div>
        </div>
    </div>

<?php

$args = array(
    'post_type' => 'give_forms',
    'author'    => $creator->ID,
    'showposts' => -1
);

$custom_posts = new WP_Query($args);

if ($custom_posts->have_posts()):
    echo '<h3 class="author-profile-campaign-title">' . esc_html__('Campaigns', 'fundor-core') . '</h3>';
    echo '<div class="give-wrap"><div class="give-grid give-grid--3">';
    while ($custom_posts->have_posts()) : $custom_posts->the_post();

        get_template_part('template-parts/give/content', 'form');

    endwhile;

    echo '</div></div>';

    wp_reset_postdata();

else:

    get_template_part('template-parts/post/content', 'none');

endif;
