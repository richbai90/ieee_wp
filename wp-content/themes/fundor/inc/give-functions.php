<?php
if (!function_exists('fundor_single_give_donor_wall')) {
    /**
     * Single Give Donor Wall
     */
    function fundor_single_give_donor_wall() {
        ?>
        <div class="sidebar-donor-wall">
            <?php
            echo '<h2 class="widget-title">' . esc_html__('Backers', 'fundor') . '</h2>';
            echo do_shortcode('[give_donor_wall form_id="' . get_the_ID() . '" comment_length="20" donors_per_page="5"]');
            ?>
        </div>
        <?php
    }
}

if (!function_exists('fundor_single_give_creator')) {
    /**
     * Single Give Creator
     */
    function fundor_single_give_creator() {
        $creator_id = get_the_author_meta('ID');
        $creator    = new Opal_Give_Creator($creator_id);

        if( $creator->get_donner_count() != 0 ){
        ?>
            <div class="sidebar-creator">
                <?php
                echo '<h2 class="widget-title">' . esc_html__('Creator.', 'fundor') . '</h2>';
                ?>
                <div class="d-flex align-items-center flex-column">
                    <div class="creator-avatar"><?php echo wp_kses_post($creator->get_avatar(190)); ?></div>
                    <div class="creator-info text-center">
                        <span class="author-name"><?php the_author(); ?></span>
                        <span class="campaigns-count"><?php echo esc_html($creator->get_donner_count()) . esc_html__(' campaigns', 'fundor'); ?></span>
                    </div>
                </div><!-- .entry-meta -->
                <div class="creator-description text-center">
                    <?php echo wp_kses_post($creator->description); ?>
                </div>
            </div>
            <?php
        }else{
            return;
        }
    }
}
remove_all_actions('hooks_after_sidebar');
add_action('fundor_hooks_after_sidebar', 'give_show_goal_progress', 10);
add_action('fundor_hooks_after_sidebar', 'fundor_single_give_creator', 20);
add_action('fundor_hooks_after_sidebar', 'fundor_single_give_donor_wall', 30);
function fundor_hooks_after_sidebar() {
    do_action('fundor_hooks_after_sidebar', get_the_ID());
}
add_action('give_before_single_form_summary', 'fundor_hooks_after_sidebar', 10);