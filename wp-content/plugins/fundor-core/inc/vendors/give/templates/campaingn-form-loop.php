<?php


$form_id          = get_the_ID(); // Form ID.

$enable_category = give_is_setting_enabled(give_get_option('categories', 'disabled'));
if ($enable_category) {
    $term_list = wp_get_post_terms($form_id, 'give_forms_category', array('fields' => 'names'));
}
$form                = new Give_Donate_Form($form_id);
$goal_progress_stats = give_goal_progress_stats($form);
$income              = $goal_progress_stats['raw_actual'];
$goal                = $goal_progress_stats['raw_goal'];
$progress            = $goal ? round(($income / $goal) * 100, 2) : 0;
?>

<div class="profile-campaign__item">
    <div class="campaign-item-wrap">
        <div class="campaign-thumbnail">
            <?php if (has_post_thumbnail()) {
                the_post_thumbnail('fundor-featured-image-full');
            }
            else {
                echo '<img class="img-placeholder" src="' . fundor_get_placeholder_image() . '">';
            }
            ?>
        </div>
        <div class="campaign-body">
            <div class="campaign-title-group">
                <?php
                // Maybe display the form title.

                the_title('<h3 class="give-card__title"><a href="' . esc_attr(get_the_permalink()) . '">', '</a></h3>');

                ?>
            </div>
            <div class="campaign-meta">
                <?php if (!empty($term_list)): ?>
                    <span class="give-card__category"><?php if (is_array($term_list)): echo '<span class="title">' . esc_html__('in', 'fundor-core') . '</span> ' . get_the_term_list( $form_id, 'give_forms_category','',',' ); endif; ?></span>
                <?php endif; ?>

            </div>

            <?php
            echo '<div class="give-card__progress"><div class="give-goal-progress"><div class="raised">';
            /**
             * Filter the give currency.
             *
             * @since 1.8.17
             */
            $form_currency = apply_filters('give_goal_form_currency', give_get_currency($form_id), $form_id);

            /**
             * Filter the income formatting arguments.
             *
             * @since 1.8.17
             */
            $income_format_args = apply_filters('give_goal_income_format_args', array(
                'sanitize' => false,
                'currency' => $form_currency,
                'decimal'  => false,
            ), $form_id);

            /**
             * Filter the goal formatting arguments.
             *
             * @since 1.8.17
             */
            $goal_format_args = apply_filters('give_goal_amount_format_args', array(
                'sanitize' => false,
                'currency' => $form_currency,
                'decimal'  => false,
            ), $form_id);

            // Get formatted amount.
            $income = give_human_format_large_amount(give_format_amount($income, $income_format_args), array('currency' => $form_currency));
            $goal   = give_human_format_large_amount(give_format_amount($goal, $goal_format_args), array('currency' => $form_currency));

            echo sprintf(
                __('<div class="percentage">%s%%</div>', 'fundor-core'), round($progress));

            echo sprintf(
                __('<div class="income"><span class="label">Current</span><span class="value">%1$s</span></div>', 'fundor-core'), give_currency_filter($income, array('form_id' => $form_id)));

            echo sprintf(
                __('<div class="goal"><span class="label">Taget</span><span class="value">%1$s</span></div>', 'fundor-core'), give_currency_filter($goal, array('form_id' => $form_id)));

            echo sprintf( /* translators: %s: percentage of the amount raised compared to the goal target */
                __('<div class="donors"><span class="label">Donors</span><span class="value">%1$s</span></div>', 'fundor-core'), give_get_form_donor_count($form_id));

            echo '</div></div></div>';

            ?>
            <div class="campaign-action">
            <a class="edit-campaign" href="<?php echo esc_url(osf_give_get_dashboard_link('edit-campaign/') . $form_id); ?>"><?php echo esc_html__('edit', 'fundor-core'); ?></a>
            <a class="delete-campaign" href=""><?php echo esc_html__('delete', 'fundor-core'); ?></a>
            </div>
        </div>
    </div>

</div>
