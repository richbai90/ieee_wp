<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
$current_user = wp_get_current_user();
global $wp;
?>

<div class="my-account">
    <h3 class="account-title"><?php echo esc_html__('My Information', 'fundor-core'); ?></h3>
    <form action="<?php echo admin_url('admin-post.php') ?>" method="post">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <label><?php echo esc_html__('Username', 'fundor-core'); ?></label>
                <input type="text" name="username" value="<?php echo esc_attr($current_user->display_name);?>">
            </div>
            <div class="col-lg-6 col-md-12">
                <label><?php echo esc_html__('Email', 'fundor-core'); ?></label>
                <input type="email" name="email" value="<?php echo esc_attr($current_user->user_email);?>">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <label><?php echo esc_html__('First Name', 'fundor-core'); ?></label>
                <input type="text" name="first_name" value="<?php echo esc_attr($current_user->user_firstname);?>">
            </div>
            <div class="col-lg-6 col-md-12">
                <label><?php echo esc_html__('Last Name', 'fundor-core'); ?></label>
                <input type="text" name="last_name" value="<?php echo esc_attr($current_user->user_lastname);?>">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <label><?php echo esc_html__('Location', 'fundor-core'); ?></label>
                <input type="text" name="user_location" value="<?php echo esc_attr($current_user->user_location);?>">
            </div>
            <div class="col-lg-6 col-md-12">
                <label><?php echo esc_html__('Company', 'fundor-core'); ?></label>
                <input type="text" name="user_company" value="<?php echo esc_attr($current_user->user_company);?>">
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <label><?php echo esc_html__('Phone', 'fundor-core'); ?></label>
                <input type="text" name="user_phone" value="<?php echo esc_attr($current_user->user_phone);?>">
            </div>
            <div class="col-lg-6 col-md-12">
                <label><?php echo esc_html__('Fax', 'fundor-core'); ?></label>
                <input type="text" name="user_fax" value="<?php echo esc_attr($current_user->user_fax);?>">
            </div>
        </div>

        <div>
            <label><?php echo esc_html__('Website', 'fundor-core'); ?></label>
            <input type="url" name="website" value="<?php echo esc_attr($current_user->user_url);?>">
        </div>
        <div>
            <label><?php echo esc_html__('Info', 'fundor-core'); ?></label>
            <textarea name="info" id="" cols="30" rows="10"><?php echo esc_attr($current_user->description);?></textarea>
        </div>
        <div>
            <button class="button-secondary" type="submit"><?php echo esc_html__('Edit', 'fundor-core'); ?></button>
        </div>
        <input type="hidden" name="action" value="opal_edit_user_creator">
        <input type="hidden" name="redirect" value="<?php echo esc_url(home_url($wp->request)) ?>">
    </form>
</div>
