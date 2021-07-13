<?php


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!class_exists('Give')) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;

/**
 * Class OSF_Elementor_Give_Campain_Feature
 */
class OSF_Elementor_Give_Campain_Feature extends OSF_Elementor_Carousel_Base {

    public function get_name() {
        return 'opal-give-campain-feature';
    }

    public function get_title() {
        return __('Opal Give Grid Feature', 'fundor-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return array('opal-addons');
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_query',
            [
                'label' => __('Query', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'   => __('Posts Per Page', 'fundor-core'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );


        $this->add_control(
            'advanced',
            [
                'label' => __('Advanced', 'fundor-core'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => __('Order By', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'post_date',
                'options' => [
                    'post_date'  => __('Date', 'fundor-core'),
                    'post_title' => __('Title', 'fundor-core'),
                    'menu_order' => __('Menu Order', 'fundor-core'),
                    'rand'       => __('Random', 'fundor-core'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => __('Order', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc'  => __('ASC', 'fundor-core'),
                    'desc' => __('DESC', 'fundor-core'),
                ],
            ]
        );

        $enable_category = give_is_setting_enabled(give_get_option('categories', 'disabled'));
        if ($enable_category) {
            $this->add_control(
                'categories',
                [
                    'label'    => __('Categories', 'fundor-core'),
                    'type'     => Controls_Manager::SELECT2,
                    'options'  => $this->get_form_taxonomy(),
                    'multiple' => true,
                ]
            );
        }

        $this->add_control(
            'cat_operator',
            [
                'label'     => __('Category Operator', 'fundor-core'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => __('AND', 'fundor-core'),
                    'IN'     => __('IN', 'fundor-core'),
                    'NOT IN' => __('NOT IN', 'fundor-core'),
                ],
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );

//        $this->add_control(
//            'layout',
//            [
//                'label' => __('Layout', 'fundor-core'),
//                'type'  => Controls_Manager::HEADING,
//            ]
//        );
//
//
//        $this->add_responsive_control(
//            'column',
//            [
//                'label'   => __('Columns', 'fundor-core'),
//                'type'    => Controls_Manager::SELECT,
//                'default' => 1,
//                'options' => [1 => 1, 2 => 2, 3 => 3],
//
//            ]
//        );

//        $this->add_control(
//            'style',
//            [
//                'label'   => __('Style', 'fundor-core'),
//                'type'    => Controls_Manager::SELECT,
//                'options' => [
//                    '1' => __('Style 1', 'fundor-core'),
//                    '2' => __('Style 2', 'fundor-core')
//                ],
//                'default' => 1,
//            ]
//        );

        $this->end_controls_section();

        $this->add_control_carousel();
    }

    private function get_form_taxonomy() {
        $enable_category = give_is_setting_enabled(give_get_option('categories', 'disabled'));
        if ($enable_category) {
            $args               = array(
                'hide_empty' => false,
                'orderby'    => 'name',
                'order'      => 'ASC',
                'number'     => 0,
            );
            $terms              = get_terms('give_forms_category', $args);
            $give_form_taxonomy = array();
            foreach ($terms as $term) {
                $give_form_taxonomy[$term->term_id] = $term->name;
            }
            return $give_form_taxonomy;
        }
    }


    protected function render() {
        $settings = $this->get_settings_for_display();

        $query_args = [
            'post_type'      => 'give_forms',
            'post_status'    => 'publish',
            'posts_per_page' => $settings['posts_per_page'],
        ];

        if (!empty($settings['categories'])) {
            $categories = array();
            foreach ($settings['categories'] as $category) {
                $cat = get_term_by('id', $category, 'give_forms_category');
                if (!is_wp_error($cat) && is_object($cat)) {
                    $categories[] = $cat->term_id;
                }
            }

            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'give_forms_category',
                    'field'    => 'id',
                    'terms'    => $categories,
                    'operator' => $settings['cat_operator']
                )
            );
        }

        $loop = new WP_Query($query_args);

        $this->add_render_attribute('wrapper', 'class', 'elementor-campaign-feature-wrapper');
//        $this->add_render_attribute('wrapper', 'class', 'style-' . $settings['style']);


        if ($settings['enable_carousel'] === 'yes') {
            $this->add_render_attribute('row', 'class', 'owl-carousel owl-theme');
            $carousel_settings = array(
                'navigation'         => $settings['navigation'],
                'autoplayHoverPause' => $settings['pause_on_hover'] === 'yes' ? 'true' : 'false',
                'autoplay'           => $settings['autoplay'] === 'yes' ? 'true' : 'false',
                'autoplayTimeout'    => $settings['autoplay_speed'],
                'items'              => empty($settings['column']) ? 1 : $settings['column'],
                'items_tablet'       => empty($settings['column_tablet']) ? 1 : $settings['column_tablet'],
                'items_mobile'       => empty($settings['column_mobile']) ? 1 : $settings['column_mobile'],
                'loop'               => $settings['infinite'] === 'yes' ? 'true' : 'false',
                'margin'             => 30,

            );
            $this->add_render_attribute('row', 'data-settings', wp_json_encode($carousel_settings));
        } else {
            $this->add_render_attribute('row', 'class', 'row');
            if (!empty($settings['column'])) {
                $this->add_render_attribute('row', 'data-elementor-columns', $settings['column']);
            }

            if (!empty($settings['column_tablet'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-tablet', $settings['column_tablet']);
            }
            if (!empty($settings['column_mobile'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-mobile', $settings['column_mobile']);
            }
        }

        if ($loop->have_posts()):
            ?>
            <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                <div <?php echo $this->get_render_attribute_string('row') ?>>
                    <?php
                    while ($loop->have_posts()) :
                        $loop->the_post();
                        $form_id = get_the_ID(); // Form ID.

                        $form                = new Give_Donate_Form($form_id);
                        $goal_progress_stats = give_goal_progress_stats($form);
                        $income              = $goal_progress_stats['raw_actual'];
                        $goal                = $goal_progress_stats['raw_goal'];
                        $progress            = $goal ? round(($income / $goal) * 100, 2) : 0;
                        $date                = get_the_date(DATE_W3C, $form_id);
                        $date                = strtotime($date);
                        $diff                = $date - time();
                        $days                = floor(-$diff / (60 * 60 * 24));
                        $stripped_content = '';
                        ?>

                        <div class="feature-campaign__item column-item give-wrap">
                            <div class="campaign-item-wrap">
                                <div class="campaign-media">
                                    <div class="campaign-thumbnail">
                                        <?php if (has_post_thumbnail()) {
                                            the_post_thumbnail('fundor-featured-image-large');
                                        } ?>
                                    </div>
                                    <?php
                                    if ($income >= $goal) {
                                        echo '<div class="label success">' . esc_html__('Successful', 'fundor-core') . '</div>';
                                    } else {
                                        echo '<div class="label unsuccess">' . esc_html__('Unsuccessful', 'fundor-core') . '</div>';
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
                                </div>
                                <div class="campaign-body">
                                    <div class="campaign-body-wrap d-flex">
                                        <div class="give-card__progress">
                                            <div class="give-goal-progress">
                                                <div class="barometer-wrap">
                                                    <div class="barometer" data-progress="<?php echo round($progress); ?>"
                                                         data-width="160" data-height="160" data-strokewidth="10"
                                                         data-stroke="#fff"
                                                         data-progress-stroke="<?php echo get_theme_mod('osf_colors_general_primary', '#fed857'); ?>">
                                                        <span><?php printf(_x("%s", 'x percent funded', 'fundor-core'), '<span class="funded">' . round($progress) . '<sup>%</sup></span>') ?></span>
                                                    </div>
                                                    <?php
                                                    /* translators: %s: percentage of the amount raised compared to the goal target */
                                                    echo '<div class="time-left"><span class="label">'.esc_html__('Publish on','fundor-core').'</span><span class="value">'.esc_html($days).'&nbsp;'.esc_html__('days ago','fundor-core').'</span></div>';
                                                    ?>
                                                </div>
                                                <div class="raised">

                                                    <?php

                                                    $form_currency = apply_filters('give_goal_form_currency', give_get_currency($form_id), $form_id);

                                                    $income_format_args = apply_filters('give_goal_income_format_args', array(
                                                        'sanitize' => false,
                                                        'currency' => $form_currency,
                                                        'decimal'  => false,
                                                    ), $form_id);

                                                    $goal_format_args = apply_filters('give_goal_amount_format_args', array(
                                                        'sanitize' => false,
                                                        'currency' => $form_currency,
                                                        'decimal'  => false,
                                                    ), $form_id);

                                                    // Get formatted amount.
                                                    $income = give_human_format_large_amount(give_format_amount($income, $income_format_args), array('currency' => $form_currency));
                                                    $goal   = give_human_format_large_amount(give_format_amount($goal, $goal_format_args), array('currency' => $form_currency));

                                                    echo '<div class="income"><span class="label">'.esc_html__('Current','fundor-core').'</span><span class="value">'.give_currency_filter($income, array('form_id' => $form_id)).'</span></div>';

                                                    /* translators: %s: percentage of the amount raised compared to the goal target */
                                                    echo '<div class="goal"><span class="label">'.esc_html__('Target','fundor-core').'</span><span class="value">'.give_currency_filter($goal, array('form_id' => $form_id)).'</span></div>';

                                                    /* translators: %s: percentage of the amount raised compared to the goal target */
                                                    echo '<div class="donors"><span class="label">'.esc_html__('Donors','fundor-core').'</span><span class="value">'.give_get_form_donor_count($form_id).'</span></div>';

                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="campaign-head">
                                            <?php
                                            $enable_category = give_is_setting_enabled(give_get_option('categories', 'disabled'));
                                            if ($enable_category) {
                                                $term_list = wp_get_post_terms($form_id, 'give_forms_category', array('fields' => 'names'));
                                            }
                                            if (!empty($term_list)): ?>
                                                <span class="give-card__category"><?php if (is_array($term_list)): echo get_the_term_list( $form_id, 'give_forms_category','',', ','' ); endif; ?></span>
                                            <?php endif; ?>
                                            <?php
                                            the_title('<h3 class="give-card__title"><a href="' . esc_attr(get_the_permalink()) . '">', '</a></h3>');
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

                                            $excerpt = wp_trim_words($stripped_content, 50);


                                            printf('<p class="give-card__text">%s</p>', $excerpt);


                                            printf(
                                                '<a id="give-card-%1$s" class=" button-donate button-primary mt-3 d-block w-100" data-effect="mfp-zoom-out" href="%2$s">%3$s</a>',
                                                $form_id,get_the_permalink($form_id),esc_html__('donate now', 'fundor-core')
                                            );

//                                            printf(
//                                                '<a id="give-card-%1$s" class="js-give-grid-modal-launcher button-donate button-primary mt-3 d-block w-100" data-effect="mfp-zoom-out" href="#give-modal-form-%1$s">%2$s</a>',
//                                                esc_attr($form_id),esc_html__('donate now', 'fundor-core')
//                                            );
//                                            printf(
//                                                '<div id="give-modal-form-%1$s" class="give-donation-grid-item-form give-modal--slide mfp-hide">',
//                                                $form_id
//                                            );
//                                            give_get_donation_form($form_id);
//                                            echo '</div>';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    <?php

                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        <?php
        endif;
    }

}

$widgets_manager->register_widget_type(new OSF_Elementor_Give_Campain_Feature());