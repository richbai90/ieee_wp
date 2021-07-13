<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Repeater;

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class  OSF_Elementor_Schedules extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-schedules';
    }


    public function get_title() {
        return __('Opal Schedules', 'fundor-core');
    }

    public function get_icon() {
        return 'eicon-bullet-list';
    }

    public function get_script_depends() {
        return [
            'tooltipster-bundle-js',
        ];
    }

    public function get_style_depends() {
        return [
            'tooltipster-bundle',
        ];
    }


    protected function _register_controls() {
        $this->start_controls_section(
            'section_schedules',
            [
                'label' => __('Schedules', 'fundor-core'),
            ]
        );
        $this->add_control(
            'schedules_type',
            [
                'label'   => __('Layout', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'style-2',
                'options' => [
                    'style-1' => __('Carousel', 'fundor-core'),
                    'style-2' => __('List', 'fundor-core'),
                    'style-3' => __('Tab', 'fundor-core'),
                ],
            ]
        );

        $repeater = new Repeater();

        $option = $this->getAllevents();
        $repeater->add_control(
            'event_day_item',
            [
                'label'   => __('Select Event Day', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => $option,
            ]
        );

        $this->add_control(
            'event_day',
            [
                'label'  => __('Schedules Item', 'fundor-core'),
                'type'   => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_carousel_options',
            [
                'label'     => __('Carousel Options', 'fundor-core'),
                'type'      => Controls_Manager::SECTION,
                'condition' => [
                    'schedules_type' => 'style-1'
                ],
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'           => __('Columns', 'fundor-core'),
                'type'            => Controls_Manager::SELECT,
                'options'         => [1 => 1, 2 => 2, 3 => 3],
                'desktop_default' => 2,
                'tablet_default'  => 1,
                'mobile_default'  => 1,
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label'   => __('Navigation', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'dots',
                'options' => [
                    'both'   => __('Arrows and Dots', 'fundor-core'),
                    'arrows' => __('Arrows', 'fundor-core'),
                    'dots'   => __('Dots', 'fundor-core'),
                    'none'   => __('None', 'fundor-core'),
                ],
            ]
        );
        $this->add_control(
            'nav_position',
            [
                'label'        => __('Nav Position', 'fundor-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'top',
                'options'      => [
                    'top'    => __('Top', 'fundor-core'),
                    'center' => __('Center', 'fundor-core'),
                    'bottom' => __('Bottom', 'fundor-core'),
                ],
                'conditions'   => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'none',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'dots',
                        ],
                    ],
                ],
                'prefix_class' => 'owl-nav-position-',
            ]
        );
        $this->add_control(
            'nav_align',
            [
                'label'        => __('Nav Align', 'fundor-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'right',
                'options'      => [
                    'left'   => __('Left', 'fundor-core'),
                    'center' => __('Center', 'fundor-core'),
                    'right'  => __('Right', 'fundor-core'),
                ],
                'conditions'   => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'none',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'dots',
                        ],
                        [
                            'name'     => 'nav_position',
                            'operator' => '!==',
                            'value'    => 'center',
                        ],
                    ],
                ],
                'prefix_class' => 'owl-nav-align-',
            ]
        );
        $this->add_responsive_control(
            'nav_spacing_vertical',
            [
                'label'      => __('Nav Spacing Vertical', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.owl-nav-position-top .owl-nav'    => 'top: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.owl-nav-position-bottom .owl-nav' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'none',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'dots',
                        ],
                        [
                            'name'     => 'nav_position',
                            'operator' => '!==',
                            'value'    => 'center',
                        ],
                    ],
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_spacing_horizontal',
            [
                'label'      => __('Nav Spacing Horizontal', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.owl-nav-align-left .owl-nav'  => 'left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.owl-nav-align-right .owl-nav' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms'    => [
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'none',
                        ],
                        [
                            'name'     => 'navigation',
                            'operator' => '!==',
                            'value'    => 'dots',
                        ],
                        [
                            'name'     => 'nav_position',
                            'operator' => '!==',
                            'value'    => 'center',
                        ],
                    ],
                ],
            ]
        );


        $this->add_control(
            'pause_on_hover',
            [
                'label'   => __('Pause on Hover', 'fundor-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label'   => __('Autoplay', 'fundor-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label'     => __('Autoplay Speed', 'fundor-core'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label'   => __('Infinite Loop', 'fundor-core'),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_carousel_style',
            [
                'label'     => __('Carousel', 'fundor-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'schedules_type' => 'style-1'
                ],
            ]
        );
        $this->start_controls_tabs('tabs_nav_style');


        $this->start_controls_tab(
            'tab_nav_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );

        $this->add_control(
            'carousel_nav_color',
            [
                'label'     => __('Arrow Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav [class*="owl-"]:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_nav_bg_color',
            [
                'label'     => __('Arrow Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav [class*="owl-"]:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_nav_border_color',
            [
                'label'     => __('Arrow Border Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav [class*="owl-"]:before' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dot_color',
            [
                'label'     => __('Dot Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-dots .owl-dot span' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dot_bgcolor',
            [
                'label'     => __('Dot Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-dots .owl-dot' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dot_bdcolor',
            [
                'label'     => __('Dot Border Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-dots .owl-dot' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_nav_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'carousel_nav_color_hover',
            [
                'label'     => __('Arrow Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav [class*="owl-"]:hover:before' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_nav_bg_color_hover',
            [
                'label'     => __('Arrow Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav [class*="owl-"]:hover:before' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_nav_border_color_hover',
            [
                'label'     => __('Arrow Border Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-nav [class*="owl-"]:hover:before' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dot_bgcolor_hover',
            [
                'label'     => __('Dot Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-dots .owl-dot:hover,
                    {{WRAPPER}} .owl-theme.owl-carousel .owl-dots .owl-dot.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dot_bdcolor_hover',
            [
                'label'     => __('Dot Border Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .owl-theme.owl-carousel .owl-dots .owl-dot:hover,
                    {{WRAPPER}} .owl-theme.owl-carousel .owl-dots .owl-dot.active' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();
    }


    protected function render() {
        $settings = $this->get_settings_for_display();

        if ($settings['schedules_type'] == 'style-1') {
            $carousel_settings = array(
                'navigation'         => $settings['navigation'],
                'autoplayHoverPause' => $settings['pause_on_hover'] === 'yes' ? 'true' : 'false',
                'autoplay'           => $settings['autoplay'] === 'yes' ? 'true' : 'false',
                'autoplayTimeout'    => $settings['autoplay_speed'],
                'items'              => empty($settings['column']) ? 1 : $settings['column'],
                'items_tablet'       => empty($settings['column_tablet']) ? 1 : $settings['column_tablet'],
                'items_mobile'       => empty($settings['column_mobile']) ? 1 : $settings['column_mobile'],
                'loop'               => $settings['infinite'] === 'yes' ? 'true' : 'false',
                'margin'             => 30
            );
            $this->add_render_attribute('row', 'class', 'owl-carousel owl-theme');
            $this->add_render_attribute('row', 'data-settings', wp_json_encode($carousel_settings));
        } else {
            $this->add_render_attribute('row', 'class', 'row');
            $this->add_render_attribute('row', 'data-elementor-columns', '1');
        }

        $this->add_render_attribute('schedules-wrapper', 'class', [
            'elementor-schedules-wrapper',
            'schedules-' . $settings['schedules_type'],
        ]);

        ?>
        <div <?php echo $this->get_render_attribute_string('schedules-wrapper') ?>>
            <?php
            $events_day = $settings['event_day'];
            if ($settings['schedules_type'] !== 'style-3') {
                ?>
                <div <?php echo $this->get_render_attribute_string('row') ?>>
                    <?php
                    foreach ((array)$events_day as $index => $item) {
                        $event_item_id = $item['event_day_item'];
                        if (is_array($event_item_id)) {
                            $event_item_id = $event_item_id[0];
                        }
                        if (get_post_status($event_item_id) == 'publish') {
                            ?>
                            <div class="column-item">
                                <div class="elementor-schedules-item">
                                    <div class="elementor-schedules-inner-day">
                                        <?php $this->get_header_event_item($event_item_id); ?>
                                    </div>
                                    <div class="elementor-schedules-inner-item">
                                        <?php $this->get_content_event_item($event_item_id); ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }

                    }
                    ?>
                </div>
                <?php
            } else {
                ?>
                <div class="elementor-schedules-tabs">
                    <?php
                    foreach ((array)$events_day as $index => $item) {
                        $event_item_id = $item['event_day_item'];
                        if (get_post_status($event_item_id) == 'publish') {
                            $this->add_render_attribute('tab-' . $index, 'class', 'elementor-schedules-tab');
                            $this->add_render_attribute('tab-' . $index, 'data-tab', '.elementor-schedules-tab-content-' . $index);
                            if ($index == 0) {
                                $this->add_render_attribute('tab-' . $index, 'class', 'elementor-active');
                            }
                            ?>
                            <div <?php echo $this->get_render_attribute_string('tab-' . $index) ?>>
                                <?php
                                $this->get_header_event_item($event_item_id);
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="elementor-schedules-content">
                    <?php
                    foreach ((array)$events_day as $index => $item) {
                        $event_item_id = $item['event_day_item'];
                        if (get_post_status($event_item_id) == 'publish') {
                            $this->add_render_attribute('tab-content-' . $index, 'class', 'elementor-schedules-tab-content elementor-schedules-tab-content-' . $index);
                            ?>
                            <div <?php echo $this->get_render_attribute_string('tab-content-' . $index) ?>>
                                <?php
                                $this->get_content_event_item($event_item_id);
                                ?>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
                <?php
            }
            ?>
        </div>
        <?php

    }

    public function get_header_event_item($event_id = '') {
        ?>
        <div class="schedules-day">
            <div class="schedules-day-name"><?php echo get_the_title($event_id) ?></div>
            <div class="schedules-day-time"><?php echo date(get_option('date_format'), strtotime(osf_get_metabox($event_id, 'osf_event_date'))); ?></div>
        </div>
        <?php
    }


    public function get_content_event_item($event_id = '') {

        $entries = get_post_meta($event_id, 'osf_event_repeat_group', true);

        foreach ((array)$entries as $key => $entry) {
//            $speaker_id = $time_start = $time_end = $desc = $title = '';
            $speaker_id = $entry['speaker'];
            ?>
            <div class="schedules-item">
                <div class="item-schedules_items">

                    <div class="item-meta">
                        <div class="time-schedules">
                            <span><i class="opal-icon-clock2"></i></span>
                            <?php if (isset($entry['osf_event_time_start'])):echo date('h:ia', strtotime($entry['osf_event_time_start']));endif;
                            if (isset($entry['osf_event_time_start'])):echo ' - ' . date('h:ia', strtotime($entry['osf_event_time_end']));endif;
                            ?>
                        </div>
                        <div class="location-schedules">
                            <span><i class="opal-icon-map-marker-alt"></i></span><span><?php if (isset($entry['osf_event_room'])): echo esc_html__($entry['osf_event_room'], 'fundor-core'); endif; ?></span>
                        </div>
                        <?php if (isset($entry['speaker']) && !empty($entry['speaker'])) { ?>
                            <div class="author-schedules">
                                <span><i class="opal-icon-microphone-alt"></i></span>
                                <?php if (!empty($speaker_id)): echo '<span>' . esc_html__('By ', 'fundor-core') . '</span>'; ?>
                                    <span class="author-schedules-group">
                            <?php
                            foreach ((array)$speaker_id as $k => $v) {
                                echo '<a href="' . get_permalink($v) . '">' . get_the_title($v) . '</a>';
                            }
                            ?>
                                </span>
                                <?php endif; ?>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="item-wrapper">
                        <h3 class="title-schedules"><?php if (isset($entry['title'])): echo esc_html__($entry['title'], 'fundor-core'); endif; ?></h3>
                        <?php if ($speaker_id && !empty($speaker_id)) {

                            ?>
                            <div class="item-image-wrapper">
                                <?php foreach ((array)$speaker_id as $k => $v) { ?>
                                    <div class="item-image tooltipster-wrap">
                                        <?php if (has_post_thumbnail($v)): echo get_the_post_thumbnail($v, 'thumbnail'); endif; ?>
                                        <div class="tooltipster-speaker-content">
                                            <div class="name"><?php echo get_the_title($v) ?></div>
                                            <div class="job"><?php echo osf_get_metabox($v, 'osf_speakers_job', ''); ?></div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php
                        } ?>
                        <div class="description-schedules"><?php if (isset($entry['description'])): echo wpautop($entry['description']); endif; ?></div>
                        <?php if (isset($entry['speaker']) && !empty($entry['speaker'])) { ?>
                            <div class="button-schedules"><i class="opal-icon-times"></i></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    public function getAllevents() {

        $results = array();
        $args    = array(
            'post_type'   => 'osf_event',
            'post_status' => 'publish',
        );

        $loop = new WP_Query($args);
        while ($loop->have_posts()) : $loop->the_post();
            $results[get_the_ID()] = get_the_title();
        endwhile;
        wp_reset_postdata();

        return $results;
    }
}

$widgets_manager->register_widget_type(new OSF_Elementor_Schedules());