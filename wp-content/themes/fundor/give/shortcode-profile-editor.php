<?php
/**
 * Profile Editor
 *
 * This template is used to display the profile editor with [give_profile_editor]
 *
 * @copyright    Copyright (c) 2016, WordImpress
 * @license      https://opensource.org/licenses/gpl-license GNU Public License
 */

$current_user = wp_get_current_user();

if (is_user_logged_in()) :
    $user_id        = get_current_user_id();
    $first_name     = get_user_meta($user_id, 'first_name', true);
    $last_name      = get_user_meta($user_id, 'last_name', true);
    $last_name      = get_user_meta($user_id, 'last_name', true);
    $display_name   = $current_user->display_name;
    $donor          = new Give_Donor($user_id, true);
    $address        = $donor->get_donor_address(array('address_type' => 'personal'));
    $company_name   = $donor->get_meta('_give_donor_company', true);

    if (isset($_GET['updated']) && 'true' === $_GET['updated'] && !give_get_errors()) {
        if (isset($_GET['update_code'])) {
            if (1 === absint($_GET['update_code'])) {
                printf('<p class="give_success"><strong>%1$s</strong> %2$s</p>', esc_html__('Success:', 'fundor'), esc_html__('Your profile has been updated.', 'fundor'));
            }
        }
    }

    Give()->notices->render_frontend_notices(0);

    /**
     * Fires in the profile editor shortcode, before the form.
     *
     * Allows you to add new elements before the form.
     *
     * @since 1.0
     */
    do_action('give_profile_editor_before');
    ?>

    <form id="give_profile_editor_form" class="give-form" action="<?php echo esc_url(give_get_current_page_url()); ?>"
          method="post">
        <fieldset>
            <legend id="give_profile_name_label"><?php esc_html_e('Profile', 'fundor'); ?><i class="opal-icon-after-hedding"></i></legend>
            <div class="row">
                <div class="col-sm-6">
                    <h3 id="give_personal_information_label" class="give-section-break"><?php esc_html_e('Change your Name', 'fundor'); ?></h3>
                    <p id="give_profile_first_name_wrap" class="form-row form-row-first form-row-responsive">
                        <label for="give_first_name">
                            <?php esc_html_e('First Name', 'fundor'); ?>
                            <span class="give-required-indicator  ">*</span>
                        </label>
                        <input name="give_first_name" id="give_first_name" class="text give-input" type="text" value="<?php echo esc_attr($first_name); ?>"/>
                    </p>

                    <p id="give_profile_last_name_wrap" class="form-row form-row-last form-row-responsive">
                        <label for="give_last_name"><?php esc_html_e('Last Name', 'fundor'); ?></label>
                        <input name="give_last_name" id="give_last_name" class="text give-input" type="text" value="<?php echo esc_attr($last_name); ?>"/>
                    </p>

                    <?php if (!empty($company_name)) : ?>
                        <p id="give_profile_company_name_wrap" class="form-row form-row-wide">
                            <label for="give_company_name"><?php esc_html_e('Company Name', 'fundor'); ?></label>
                            <input name="give_company_name" id="give_company_name" class="text give-input" type="text" value="<?php echo esc_attr($company_name); ?>"/>
                        </p>
                    <?php endif; ?>

                    <p id="give_profile_display_name_wrap" class="form-row form-row-first form-row-responsive">
                        <label for="give_display_name"><?php esc_html_e('Display Name', 'fundor'); ?></label>
                        <select name="give_display_name" id="give_display_name" class="select give-select">
                            <?php if (!empty($current_user->first_name)): ?>
                                <option <?php selected($display_name, $current_user->first_name); ?> value="<?php echo esc_attr($current_user->first_name); ?>">
                                    <?php echo esc_html($current_user->first_name); ?>
                                </option>
                            <?php endif; ?>
                            <option <?php selected($display_name, $current_user->user_nicename); ?> value="<?php echo esc_attr($current_user->user_nicename); ?>">
                                <?php echo esc_html($current_user->user_nicename); ?>
                            </option>
                            <?php if (!empty($current_user->last_name)): ?>
                                <option <?php selected($display_name, $current_user->last_name); ?> value="<?php echo esc_attr($current_user->last_name); ?>">
                                    <?php echo esc_html($current_user->last_name); ?>
                                </option>
                            <?php endif; ?>
                            <?php if (!empty($current_user->first_name) && !empty($current_user->last_name)): ?>
                                <option <?php selected($display_name, $current_user->first_name . ' ' . $current_user->last_name); ?> value="<?php echo esc_attr($current_user->first_name . ' ' . $current_user->last_name); ?>">
                                    <?php echo esc_html($current_user->first_name . ' ' . $current_user->last_name); ?>
                                </option>
                                <option <?php selected($display_name, $current_user->last_name . ' ' . $current_user->first_name); ?> value="<?php echo esc_attr($current_user->last_name . ' ' . $current_user->first_name); ?>">
                                    <?php echo esc_html($current_user->last_name . ' ' . $current_user->first_name); ?>
                                </option>
                            <?php endif; ?>
                        </select>
                        <?php
                        /**
                         * Fires in the profile editor shortcode, to the name section.
                         *
                         * Allows you to add new elements to the name section.
                         *
                         * @since 1.0
                         */
                        do_action('give_profile_editor_name');
                        ?>
                    </p>
                    <?php
                    /**
                     * Fires in the profile editor shortcode, after the name field.
                     *
                     * Allows you to add new fields after the name field.
                     *
                     * @since 1.0
                     */
                    do_action('give_profile_editor_after_name');
                    ?>
                    <p class="form-row form-row-last form-row-responsive">
                        <label for="give_email">
                            <?php esc_html_e('Email Address', 'fundor'); ?>
                            <span class="give-required-indicator  ">*</span>
                        </label>
                        <input name="give_email" id="give_email" class="text give-input required" type="email" value="<?php echo esc_attr($current_user->user_email); ?>" required aria-required="true"/>
                        <?php
                        /**
                         * Fires in the profile editor shortcode, to the email section.
                         *
                         * Allows you to add new elements to the email section.
                         *
                         * @since 1.0
                         */
                        do_action('give_profile_editor_email');
                        ?>
                    </p>
                    <?php
                    /**
                     * Fires in the profile editor shortcode, after the email field.
                     *
                     * Allows you to add new fields after the email field.
                     *
                     * @since 1.0
                     */
                    do_action('give_profile_editor_after_email');
                    ?>
                </div>
                <div class="col-sm-6">
                    <h3 id="give_profile_password_label" class="give-section-break"><?php esc_html_e('Change your Password', 'fundor'); ?></h3>
                    <div id="give_profile_password_wrap" class="give-clearfix">
                        <p id="give_profile_password_wrap_1" class="form-row form-row-first form-row-responsive">
                            <label for="give_new_user_pass1"><?php esc_html_e('New Password', 'fundor'); ?></label>
                            <input name="give_new_user_pass1" id="give_new_user_pass1" class="password give-input" type="password"/>
                        </p>
                        <p id="give_profile_password_wrap_2" class="form-row form-row-last form-row-responsive">
                            <label for="give_new_user_pass2"><?php esc_html_e('Re-enter Password', 'fundor'); ?></label>
                            <input name="give_new_user_pass2" id="give_new_user_pass2" class="password give-input" type="password"/>
                            <?php
                            /**
                             * Fires in the profile editor shortcode, to the password section.
                             *
                             * Allows you to add new elements to the password section.
                             *
                             * @since 1.0
                             */
                            do_action('give_profile_editor_password');
                            ?>
                        </p>
                    </div>
                    <p class="give_password_change_notice"><?php esc_html_e('Please note after changing your password, you must log back in.', 'fundor'); ?></p>
                    <?php
                    /**
                     * Fires in the profile editor shortcode, after the password field.
                     *
                     * Allows you to add new fields after the password field.
                     *
                     * @since 1.0
                     */
                    do_action('give_profile_editor_after_password');
                    ?>
                </div>
            </div>
            <p id="give_profile_submit_wrap">
                <input type="hidden" name="give_profile_editor_nonce" value="<?php echo esc_attr(wp_create_nonce('give-profile-editor-nonce')); ?>"/>
                <input type="hidden" name="give_action" value="edit_user_profile"/>
                <input type="hidden" name="give_redirect" value="<?php echo esc_url(give_get_current_page_url()); ?>"/>
                <input name="give_profile_editor_submit" id="give_profile_editor_submit" type="submit" class="give_submit" value="<?php esc_html_e('Submit', 'fundor'); ?>"/>
            </p>
        </fieldset>
    </form><!-- #give_profile_editor_form -->
    <?php
    /**
     * Fires in the profile editor shortcode, after the form.
     *
     * Allows you to add new elements after the form.
     *
     * @since 1.0
     */
    do_action('give_profile_editor_after');

else :
    if (isset($_GET['updated']) && 'true' === $_GET['updated'] && !give_get_errors()) {
        if (isset($_GET['update_code'])) {
            switch ($_GET['update_code']) {
                case '2':
                    printf('<p class="give_success"><strong>%1$s</strong> %2$s</p>', esc_html__('Success:', 'fundor'), esc_html__('Your profile and password has been updated.', 'fundor'));
                    esc_html_e('Login with your new credentials.', 'fundor');
                    echo wp_kses_post(give_login_form());
                    break;
                case '3':
                    printf('<p class="give_success"><strong>%1$s</strong> %2$s</p>', esc_html__('Success:', 'fundor'), esc_html__('Your password has been updated.', 'fundor'));
                    esc_html_e('Login with your new credentials.', 'fundor');
                    echo wp_kses_post(give_login_form());
                    break;

                default:
                    break;
            }
        }
    } else {
        esc_html_e('You need to login to edit your profile.', 'fundor');
        echo wp_kses_post(give_login_form());
    }
endif;
