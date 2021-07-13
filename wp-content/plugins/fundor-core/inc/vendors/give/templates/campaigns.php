<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
/**
 * @var $creator Opal_Give_Creator
 */


$loop = new WP_Query($creator->get_campaigns_query());


if ($loop->have_posts()):
    ?>
    <div class="give-profile-grid">
        <?php
        while ($loop->have_posts()) : $loop->the_post();

            osf_give_get_template('campaingn-form-loop.php');

        endwhile;
        osf_give_the_paginate($loop);

        wp_reset_postdata();
        ?>
    </div>
<?php
else:
    ?>
    <div class="profile-notification">
        <h3 class="account-title"><?php esc_html_e('User Notification', 'fundor-core');?></h3>
        <p><?php esc_html_e('There are no campaigns available', 'fundor-core');?></p>
    </div>
<?php
endif;