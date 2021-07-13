<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class OSF_Elementor_Image_Hotspots_Widget extends Widget_Base {

    public function get_name() {
        return 'opal-image-hotspots';
    }

    public function is_reload_preview_required() {
        return true;
    }

    public function get_title() {
        return 'Opal Image Hotspots';
    }

    public function get_script_depends() {
        return [
            'tooltipster-bundle-js',
            'scrollbar'
        ];
    }

    public function get_style_depends() {
        return [
            'tooltipster-bundle',
            'scrollbar'
        ];
    }

    public function get_categories() {
        return array('opal-addons');
    }

    protected function _register_controls() {

        $this->start_controls_section('image_hotspots_infomation_section',
            [
                'label' => esc_html__('Layout', 'fundor-core'),
            ]
        );

        $this->add_control('image_hotspots_infomation_show',
            [
                'label' => esc_html__('Show Infomation', 'fundor-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control('image_hotspots_all_tooltip',
            [
                'label' => esc_html__('Show All Tooltip', 'fundor-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();

        /**START Background Image Section  **/
        $this->start_controls_section('image_hotspots_image_section',
            [
                'label' => esc_html__('Image', 'fundor-core'),
            ]
        );

        $this->add_control('image_hotspots_image',
            [
                'label'       => __('Choose Image', 'fundor-core'),
                'type'        => Controls_Manager::MEDIA,
                'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'label_block' => true
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'background_image', // Actually its `image_size`.
                'default' => 'full'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('image_hotspots_icons_settings',
            [
                'label' => esc_html__('Hotspots', 'fundor-core'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_responsive_control('opal_image_hotspots_main_icons_horizontal_position',
            [
                'label'      => esc_html__('Horizontal Position', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default'    => [
                    'size' => 50,
                    'unit' => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.opal-image-hotspots-main-icons' => 'left: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $repeater->add_responsive_control('opal_image_hotspots_main_icons_vertical_position',
            [
                'label'      => esc_html__('Vertical Position', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default'    => [
                    'size' => 50,
                    'unit' => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.opal-image-hotspots-main-icons' => 'top: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $repeater->add_control('image_hotspots_content',
            [
                'label'   => esc_html__('Content to Show', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'text_editor'         => esc_html__('Text Editor', 'fundor-core'),
                    'elementor_templates' => esc_html__('Elementor Template', 'fundor-core'),
                ],
                'default' => 'text_editor'
            ]
        );

        $repeater->add_control('image_hotspots_tooltips_title',
            [
                'label'       => esc_html__('Title', 'fundor-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Title',
                'label_block' => true,
                //                'condition' => [
                //                    'image_hotspots_infomation_show!' => '',
                //                ]
            ]);

        $repeater->add_control('image_hotspots_tooltips_texts',
            [
                'type'        => Controls_Manager::WYSIWYG,
                'default'     => 'Lorem ipsum',
                'dynamic'     => ['active' => true],
                'label_block' => true,
                'condition'   => [
                    'image_hotspots_content' => 'text_editor'
                ]
            ]);

        $repeater->add_control('image_hotspots_tooltips_temp',
            [
                'label'     => esc_html__('Teamplate ID', 'fundor-core'),
                'type'      => Controls_Manager::NUMBER,
                'condition' => [
                    'image_hotspots_content' => 'elementor_templates'
                ],
            ]);

        $repeater->add_control('image_hotspots_link_switcher',
            [
                'label'       => esc_html__('Link', 'fundor-core'),
                'type'        => Controls_Manager::SWITCHER,
                'description' => esc_html__('Add a custom link or select an existing page link', 'fundor-core'),
            ]);

        $repeater->add_control('image_hotspots_link_type',
            [
                'label'       => esc_html__('Link/URL', 'fundor-core'),
                'type'        => Controls_Manager::SELECT,
                'options'     => [
                    'url'  => esc_html__('URL', 'fundor-core'),
                    'link' => esc_html__('Existing Page', 'fundor-core'),
                ],
                'default'     => 'url',
                'condition'   => [
                    'image_hotspots_link_switcher' => 'yes',
                ],
                'label_block' => true,
            ]);

        $repeater->add_control('image_hotspots_url',
            [
                'label'       => esc_html__('URL', 'fundor-core'),
                'type'        => Controls_Manager::URL,
                'condition'   => [
                    'image_hotspots_link_switcher' => 'yes',
                    'image_hotspots_link_type'     => 'url',
                ],
                'placeholder' => 'https://wpopal.com/',
                'label_block' => true
            ]);

        $repeater->add_control('image_hotspots_link_text',
            [
                'label'       => esc_html__('Link Title', 'fundor-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'condition'   => [
                    'image_hotspots_link_switcher' => 'yes',
                ],
                'label_block' => true
            ]);

        $this->add_control('image_hotspots_icons',
            [
                'label'  => esc_html__('Hotspots', 'fundor-core'),
                'type'   => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );

        $this->add_control('image_hotspots_icons_animation',
            [
                'label' => esc_html__('Radar Animation', 'fundor-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('image_hotspots_tooltips_section',
            [
                'label' => esc_html__('Tooltips', 'fundor-core'),
            ]
        );

        $this->add_control(
            'image_hotspots_trigger_type',
            [
                'label'   => esc_html__('Trigger', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'click' => esc_html__('Click', 'fundor-core'),
                    'hover' => esc_html__('Hover', 'fundor-core'),
                ],
                'default' => 'hover'
            ]
        );

        $this->add_control(
            'image_hotspots_arrow',
            [
                'label'     => esc_html__('Show Arrow', 'fundor-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Show', 'fundor-core'),
                'label_off' => esc_html__('Hide', 'fundor-core'),
            ]
        );

        $this->add_control(
            'image_hotspots_tooltips_position',
            [
                'label'       => esc_html__('Positon', 'fundor-core'),
                'type'        => Controls_Manager::SELECT2,
                'options'     => [
                    'top'    => esc_html__('Top', 'fundor-core'),
                    'bottom' => esc_html__('Bottom', 'fundor-core'),
                    'left'   => esc_html__('Left', 'fundor-core'),
                    'right'  => esc_html__('Right', 'fundor-core'),
                ],
                'description' => esc_html__('Sets the side of the tooltip. The value may one of the following: \'top\', \'bottom\', \'left\', \'right\'. It may also be an array containing one or more of these values. When using an array, the order of values is taken into account as order of fallbacks and the absence of a side disables it', 'fundor-core'),
                'default'     => ['top', 'bottom'],
                'label_block' => true,
                'multiple'    => true
            ]
        );

        $this->add_control('image_hotspots_tooltips_distance_position',
            [
                'label'   => esc_html__('Spacing', 'fundor-core'),
                'type'    => Controls_Manager::NUMBER,
                'title'   => esc_html__('The distance between the origin and the tooltip in pixels, default is 6', 'fundor-core'),
                'default' => 6,
            ]
        );

        $this->add_control('image_hotspots_min_width',
            [
                'label'       => esc_html__('Min Width', 'fundor-core'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 800,
                    ],
                ],
                'description' => esc_html__('Set a minimum width for the tooltip in pixels, default: 0 (auto width)', 'fundor-core'),
            ]
        );

        $this->add_control('image_hotspots_max_width',
            [
                'label'       => esc_html__('Max Width', 'fundor-core'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 800,
                    ],
                ],
                'description' => esc_html__('Set a maximum width for the tooltip in pixels, default: null (no max width)', 'fundor-core'),
            ]
        );

        $this->add_responsive_control('image_hotspots_tooltips_wrapper_height',
            [
                'label'       => esc_html__('Height', 'fundor-core'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', 'em', '%'],
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                    ]
                ],
                'label_block' => true,
                'selectors'   => [
                    '.tooltipster-box.tooltipster-box-{{ID}}' => 'height: {{SIZE}}{{UNIT}} !important;'
                ]
            ]
        );

        $this->add_control('image_hotspots_anim',
            [
                'label'       => esc_html__('Animation', 'fundor-core'),
                'type'        => Controls_Manager::SELECT,
                'options'     => [
                    'fade'  => esc_html__('Fade', 'fundor-core'),
                    'grow'  => esc_html__('Grow', 'fundor-core'),
                    'swing' => esc_html__('Swing', 'fundor-core'),
                    'slide' => esc_html__('Slide', 'fundor-core'),
                    'fall'  => esc_html__('Fall', 'fundor-core'),
                ],
                'default'     => 'fade',
                'label_block' => true,
            ]
        );

        $this->add_control('image_hotspots_anim_dur',
            [
                'label'   => esc_html__('Animation Duration', 'fundor-core'),
                'type'    => Controls_Manager::NUMBER,
                'title'   => esc_html__('Set the animation duration in milliseconds, default is 350', 'fundor-core'),
                'default' => 350,
            ]
        );

        $this->add_control('image_hotspots_delay',
            [
                'label'   => esc_html__('Delay', 'fundor-core'),
                'type'    => Controls_Manager::NUMBER,
                'title'   => esc_html__('Set the animation delay in milliseconds, default is 10', 'fundor-core'),
                'default' => 10,
            ]
        );

        $this->add_control('image_hotspots_hide',
            [
                'label'        => esc_html__('Hide on Mobiles', 'fundor-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => 'Show',
                'label_off'    => 'Hide',
                'description'  => esc_html__('Hide tooltips on mobile phones', 'fundor-core'),
                'return_value' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('image_hotspots_image_style_settings',
            [
                'label' => esc_html__('Image', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_hotspots_image_border',
                'selector' => '{{WRAPPER}} .opal-image-hotspots-container .opal-addons-image-hotspots-ib-img',
            ]
        );

        $this->add_control('image_hotspots_image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .opal-image-hotspots-container .opal-addons-image-hotspots-ib-img' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control('image_hotspots_image_padding',
            [
                'label'      => esc_html__('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .opal-image-hotspots-container .opal-addons-image-hotspots-ib-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->add_responsive_control(
            'image_hotspots_image_align',
            [
                'label'     => __('Text Alignment', 'fundor-core'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'fundor-core'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'fundor-core'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'fundor-core'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .opal-image-hotspots-container' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('image_hotspots_tooltips_style_settings',
            [
                'label' => esc_html__('Tooltips', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control('image_hotspots_tooltips_wrapper_color',
            [
                'label'     => esc_html__('Text Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.tooltipster-box.tooltipster-box-{{ID}} .opal-image-hotspots-tooltips-text' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'image_hotspots_tooltips_wrapper_typo',
                'selector' => '.tooltipster-box.tooltipster-box-{{ID}} .opal-image-hotspots-tooltips-text, .opal-image-hotspots-tooltips-text-{{ID}}'
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'image_hotspots_tooltips_content_text_shadow',
                'selector' => '.tooltipster-box.tooltipster-box-{{ID}} .opal-image-hotspots-tooltips-text'
            ]
        );

        $this->add_control('image_hotspots_tooltips_wrapper_background_color',
            [
                'label'     => esc_html__('Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.tooltipster-box.tooltipster-box-{{ID}} .tooltipster-content'                                 => 'background: {{VALUE}};',
                    '.tooltipster-base.tooltipster-top .tooltipster-arrow-{{ID}} .tooltipster-arrow-background'    => 'border-top-color: {{VALUE}};',
                    '.tooltipster-base.tooltipster-bottom .tooltipster-arrow-{{ID}} .tooltipster-arrow-background' => 'border-bottom-color: {{VALUE}};',
                    '.tooltipster-base.tooltipster-right .tooltipster-arrow-{{ID}} .tooltipster-arrow-background'  => 'border-right-color: {{VALUE}};',
                    '.tooltipster-base.tooltipster-left .tooltipster-arrow-{{ID}} .tooltipster-arrow-background'   => 'border-left-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_hotspots_tooltips_wrapper_border',
                'selector' => '.tooltipster-box.tooltipster-box-{{ID}} .tooltipster-content'
            ]
        );

        $this->add_control('image_hotspots_tooltips_wrapper_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.tooltipster-box.tooltipster-box-{{ID}} .tooltipster-content' => 'border-radius: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'image_hotspots_tooltips_wrapper_box_shadow',
                'selector' => '.tooltipster-box.tooltipster-box-{{ID}} .tooltipster-content'
            ]
        );

        $this->add_responsive_control('image_hotspots_tooltips_wrapper_margin',
            [
                'label'      => esc_html__('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.tooltipster-box.tooltipster-box-{{ID}} .tooltipster-content, .tooltipster-arrow-{{ID}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('image_hotspots_button_section',
            [
                'label'     => esc_html__('Button', 'fundor-core'),
                'condition' =>
                    [
                        'image_hotspots_infomation_show' => 'yes',
                    ]
            ]
        );

        $this->add_control(
            'button',
            [
                'label'   => __('Button', 'fundor-core'),
                'default' => 'Download Brochure',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => __('Link to', 'fundor-core'),
                'placeholder' => __('https://your-link.com', 'fundor-core'),
                'default'     => [
                    'url' => '#',
                ],
                'type'        => Controls_Manager::URL,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('img_hotspots_infomation_style',
            [
                'label'     => esc_html__('Infomation', 'fundor-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' =>
                    [
                        'image_hotspots_infomation_show' => 'yes',
                    ]
            ]
        );

        $this->add_responsive_control('img_hotspots_infomation_width',
            [
                'label'      => esc_html__('Infomation Width', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .opal-image-hotspots-accordion' => 'flex: 0 0 {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control('img_hotspots_infomation_padding',
            [
                'label'      => esc_html__('Paddding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .opal-image-hotspots-accordion' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('img_hotspots_container_style',
            [
                'label' => esc_html__('Container hotspots', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control('img_hotspots_container_width',
            [
                'label'      => esc_html__('Infomation Width', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .opal-image-hotspots-container' => 'flex: 0 0 {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  =>
                    [
                        'image_hotspots_infomation_show' => 'yes',
                    ]
            ]
        );

        $this->add_control('img_hotspots_container_background',
            [
                'label'     => esc_html__('Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .opal-image-hotspots-container' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'img_hotspots_container_border',
                'selector' => '{{WRAPPER}} .opal-image-hotspots-container',
            ]
        );

        $this->add_control('img_hotspots_container_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .opal-image-hotspots-container' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'img_hotspots_container_box_shadow',
                'selector' => '{{WRAPPER}} .opal-image-hotspots-container',
            ]
        );

        $this->add_responsive_control('img_hotspots_container_margin',
            [
                'label'      => esc_html__('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .opal-image-hotspots-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control('img_hotspots_container_padding',
            [
                'label'      => esc_html__('Paddding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .opal-image-hotspots-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }


    protected function render($instance = []) {
        // get our input from the widget settings.
        $settings        = $this->get_settings_for_display();
        $animation_class = '';
        if ($settings['image_hotspots_icons_animation'] == 'yes') {
            $animation_class = 'opal-image-hotspots-anim';
        }

        $image_src = $settings['image_hotspots_image'];

        $image_src_size = Group_Control_Image_Size::get_attachment_image_src($image_src['id'], 'background_image', $settings);
        if (empty($image_src_size)) : $image_src_size = $image_src['url'];
        else: $image_src_size = $image_src_size; endif;

        $image_hotspots_settings = [
            'anim'        => $settings['image_hotspots_anim'],
            'animDur'     => !empty($settings['image_hotspots_anim_dur']) ? $settings['image_hotspots_anim_dur'] : 350,
            'delay'       => !empty($settings['image_hotspots_anim_delay']) ? $settings['image_hotspots_anim_delay'] : 10,
            'arrow'       => ($settings['image_hotspots_arrow'] == 'yes') ? true : false,
            'distance'    => !empty($settings['image_hotspots_tooltips_distance_position']) ? $settings['image_hotspots_tooltips_distance_position'] : 6,
            'minWidth'    => !empty($settings['image_hotspots_min_width']['size']) ? $settings['image_hotspots_min_width']['size'] : 0,
            'maxWidth'    => !empty($settings['image_hotspots_max_width']['size']) ? $settings['image_hotspots_max_width']['size'] : 'null',
            'side'        => !empty($settings['image_hotspots_tooltips_position']) ? $settings['image_hotspots_tooltips_position'] : array(
                'right',
                'left'
            ),
            'hideMobiles' => ($settings['image_hotspots_hide'] == true) ? true : false,
            'trigger'     => $settings['image_hotspots_trigger_type'],
            'id'          => $this->get_id()
        ];
        $check_all_tooltip = (!empty($settings['image_hotspots_all_tooltip'] && $settings['image_hotspots_all_tooltip'] == 'yes'));
        ?>
        <?php if ($settings['image_hotspots_infomation_show'] == 'yes'): ?>
            <div class="opal-image-hotspots-accordion">
                <div class="opal-image-hotspots-accordion-inner">
                    <div class="elementor-hotspots" role="tablist">
                        <?php
                        foreach ($settings['image_hotspots_icons'] as $index => $item) :
                            $tab_count = $index + 1;

                            $tab_title_setting_key = $this->get_repeater_setting_key('image_hotspots_tooltips_texts', 'image_hotspots_icons', $index);

                            $this->add_render_attribute($tab_title_setting_key, [
                                'id'       => 'elementor-hotspots-tab-title-' . $item['_id'],
                                'class'    => ['elementor-hotspots-tab-title'],
                                'tabindex' => $item['_id'],
                                'data-tab' => '.opal-image-hotspots-main-icons-' . $item['_id'],
                                'role'     => 'tab',
                            ]);

                            ?>
                            <div class="elementor-hotspots-item">
                                <div <?php echo $this->get_render_attribute_string($tab_title_setting_key); ?>>
                                    <span class="elementor-hotspots-item-number"><?php echo $tab_count < 10 ? '0' . esc_html($tab_count) . '.' : esc_html($tab_count) . '.'; ?></span><?php echo esc_html($item['image_hotspots_tooltips_title']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php
                if (!empty($settings['link']['url'])) :
                    echo '<a class="elementor-hotspots-button button-primary" href="' . esc_url($settings['link']['url']) . '">' . $settings['button'] . ' </a>';
                endif;
                ?>
            </div>
        <?php endif; ?>
        <div id="opal-image-hotspots-<?php echo esc_attr($this->get_id()); ?>"
             class="opal-image-hotspots-container<?php echo $check_all_tooltip ? ' show-all-tooltip' : '' ?>"
             data-settings='<?php echo wp_json_encode($image_hotspots_settings); ?>'>
            <img class="opal-addons-image-hotspots-ib-img" alt="Background" src="<?php echo $image_src_size; ?>">
            <?php foreach ($settings['image_hotspots_icons'] as $index => $item) {
                $list_item_key = 'img_hotspot_' . $index;
                $this->add_render_attribute($list_item_key, 'class',
                    [
                        $animation_class,
                        'opal-image-hotspots-main-icons',
                        'elementor-repeater-item-' . $item['_id'],
                        'tooltip-wrapper',
                        'opal-image-hotspots-main-icons-' . $item['_id']
                    ]);
                $this->add_render_attribute($list_item_key, 'data-tab', '#elementor-hotspots-tab-title-' . $item['_id']);
                ?>
                <div <?php echo $this->get_render_attribute_string($list_item_key); ?>
                        data-tooltip-content="#tooltip_content-<?php echo esc_attr($this->get_id()); ?>">
                    <?php
                    $link_type = $item['image_hotspots_link_type'];
                    if ($link_type == 'url') {
                        $link_url = $item['image_hotspots_url']['url'];
                    } elseif ($link_type == 'link') {
                        $link_url = get_permalink($item['image_hotspots_existing_page']);
                    }
                    if ($item['image_hotspots_link_switcher'] == 'yes' && $settings['image_hotspots_trigger_type'] == 'hover') :
                        ?>
                        <a class="opal-image-hotspots-tooltips-link" href="<?php echo esc_url($link_url); ?>"
                           title="<?php echo $item['image_hotspots_link_text']; ?>"
                           <?php if (!empty($item['image_hotspots_url']['is_external'])) : ?>target="_blank"
                           <?php endif; ?><?php if (!empty($item['image_hotspots_url']['nofollow'])) : ?>rel="nofollow"<?php endif; ?>>
                            <i class="opal-image-hotspots-icon <?php echo $settings['image_hotspots_infomation_show'] == 'yes' ? ' style-2' : ''; ?>"><span><?php echo ($index + 1) < 10 ? '0' . ($index + 1) : ($index + 1); ?></span></i>
                        </a>
                    <?php else : ?>
                        <i class="opal-image-hotspots-icon <?php echo $settings['image_hotspots_infomation_show'] == 'yes' ? ' style-2' : ''; ?>"><span><?php echo ($index + 1) < 10 ? '0' . ($index + 1) : ($index + 1); ?></span></i>
                    <?php endif; ?>
                    <div class="opal-image-hotspots-tooltips-wrapper">
                        <div id="tooltip_content-<?php echo esc_attr($item['_id']); ?>"
                             class="opal-image-hotspots-tooltips-text opal-image-hotspots-tooltips-text-<?php echo esc_attr($this->get_id()); ?>"><?php
                            if ($item['image_hotspots_content'] == 'elementor_templates') {
                                $elementor_post_id = $item['image_hotspots_tooltips_temp'];
                                $elements_frontend = new Frontend;
                                echo $elements_frontend->get_builder_content($elementor_post_id, true);
                            } else {
                                echo $item['image_hotspots_tooltips_texts'];
                            } ?></div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <?php
    }
}

$widgets_manager->register_widget_type(new OSF_Elementor_Image_Hotspots_Widget());
