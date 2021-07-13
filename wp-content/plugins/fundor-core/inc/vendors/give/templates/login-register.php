<?php
// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="login-profile">
    <h2 class="login-form-title mb-5"><?php esc_attr_e('Login with your site account', 'fundor-core') ?></h2>

    <form class="opal-login-form-ajax" data-toggle="validator">
        <p>
            <label><?php esc_attr_e('Username or email', 'fundor-core'); ?>
                <span class="required">*</span></label>
            <input name="username" type="text" required placeholder="<?php esc_attr_e('Username', 'fundor-core') ?>">
        </p>
        <p>
            <label><?php esc_attr_e('Password', 'fundor-core'); ?> <span class="required">*</span></label>
            <input name="password" type="password" required placeholder="<?php esc_attr_e('Password', 'fundor-core') ?>">
        </p>
        <p class="login-remember pull-left"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" checked="checked"/><?php echo  esc_html__('Remember me','fundor-core');?></label></p>
        <a href="<?php echo wp_lostpassword_url(get_permalink()); ?>" class="lostpass-link pull-right" title="<?php esc_attr_e('Lost your password?', 'fundor-core'); ?>"><?php esc_attr_e('Lost your password?', 'fundor-core'); ?></a>
        <button type="submit" data-button-action class="btn btn-primary btn-block w-100 mt-1 mb-3"><?php esc_html_e('Login', 'fundor-core') ?></button>
        <input type="hidden" name="action" value="osf_login">
        <?php wp_nonce_field('ajax-osf-login-nonce', 'security-login'); ?>
    </form>
    <div class="login-form-bottom text-center">
        <div class="text-register"><?php echo esc_html__('Not a member yet?', 'fundor-core'); ?> <a class="register-link" href="<?php echo esc_url(wp_registration_url()); ?>" title="<?php esc_attr_e('Register', 'fundor-core'); ?>"><?php esc_attr_e('Register now', 'fundor-core'); ?></a></div>
    </div>
</div>