<?php

namespace Elementor;
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor image box widget.
 *
 * Elementor widget that displays an image, a headline and a text.
 *
 * @since 1.0.0
 */
class OSF_Widget_Image_Box extends Widget_Image_Box {

    /**
     * Get widget name.
     *
     * Retrieve image box widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'image-box';
    }

    /**
     * Get widget title.
     *
     * Retrieve image box widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Image Box', 'fundor-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve image box widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-image-box';
    }

    public function get_categories() {
        return ['opal-addons'];
    }

    /**
     * Register image box widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_image',
            [
                'label' => __('Image Box', 'fundor-core'),
            ]
        );

        $this->add_control(
            'image',
            [
                'label'   => __('Choose Image', 'fundor-core'),
                'type'    => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'view_style',
            [
                'label'        => __('View', 'fundor-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'default' => __('Default', 'fundor-core'),
                    'stacked' => __('Stacked', 'fundor-core'),
                    'framed'  => __('Framed', 'fundor-core'),
                ],
                'default'      => 'default',
                'prefix_class' => 'elementor-view-',
                'condition'    => [
                    'image!' => '',
                ],
            ]
        );

        $this->add_control(
            'shape',
            [
                'label'        => __('Shape', 'fundor-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'circle' => __('Circle', 'fundor-core'),
                    'square' => __('Square', 'fundor-core'),
                ],
                'default'      => 'circle',
                'condition'    => [
                    'view_style!' => 'default',
                    'image!'      => '',
                ],
                'prefix_class' => 'elementor-shape-',
            ]
        );

        $this->add_control(
            'title_text',
            [
                'label'       => __('Title & Description', 'fundor-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => __('This is the heading', 'fundor-core'),
                'placeholder' => __('Enter your title', 'fundor-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'sub_title_text',
            [
                'label'       => __('Sub Title', 'fundor-core'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('Enter your sub-title', 'fundor-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description_text',
            [
                'label'       => __('Description', 'fundor-core'),
                'type'        => Controls_Manager::TEXTAREA,
                'dynamic'     => [
                    'active' => true,
                ],
                'default'     => __('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'fundor-core'),
                'placeholder' => __('Enter your description', 'fundor-core'),
                'separator'   => 'none',
                'rows'        => 10,
            ]
        );
        $this->add_control(
            'hover_animation_wrapper',
            [
                'label'        => __('Hover Wrapper Animation', 'fundor-core'),
                'type'         => Controls_Manager::HOVER_ANIMATION,
                'prefix_class' => 'elementor-animation-',
            ]
        );

        $this->add_control(
            'link',
            [
                'label'       => __('Link to', 'fundor-core'),
                'type'        => Controls_Manager::URL,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => __('https://your-link.com', 'fundor-core'),
                'separator'   => 'before',
            ]
        );

//        $this->add_control(
//            'link_download',
//            [
//                'label' => __('Donload Link ?', 'fundor-core'),
//                'type'  => Controls_Manager::SWITCHER,
//            ]
//        );

        $this->add_control(
            'show_decor',
            [
                'label' => __('Show Decor', 'fundor-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'show_button',
            [
                'label' => __('Show Button', 'fundor-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'position',
            [
                'label'        => __('Image Position', 'fundor-core'),
                'type'         => Controls_Manager::CHOOSE,
                'default'      => 'top',
                'options'      => [
                    'left'  => [
                        'title' => __('Left', 'fundor-core'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'top'   => [
                        'title' => __('Top', 'fundor-core'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'fundor-core'),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-position-',
                'toggle'       => false,
            ]
        );

        $this->add_control(
            'title_size',
            [
                'label'   => __('Title HTML Tag', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'h3',
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => __('View', 'fundor-core'),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button',
            [
                'label' => __('Button', 'fundor-core'),
                'condition' => [
                    'show_button!'  => ''
                ]
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label' => __('Type', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
                'default'      => 'primary',
                'options' => [
                    '' => __('Default', 'fundor-core'),
                    'primary_gradient' => __('Primary Gradient', 'fundor-core'),
                    'primary' => __('Primary', 'fundor-core'),
                    'secondary' => __('Secondary', 'fundor-core'),
                    'outline_primary' => __('Outline Primary', 'fundor-core'),
                    'outline_secondary' => __('Outline Secondary', 'fundor-core'),
                    'dark' => __('Dark', 'fundor-core'),
                    'light' => __('Light', 'fundor-core'),
                    'link' => __('Link', 'fundor-core'),
                    'info' => __('Info', 'fundor-core'),
                    'success' => __('Success', 'fundor-core'),
                    'warning' => __('Warning', 'fundor-core'),
                    'danger' => __('Danger', 'fundor-core'),
                ],
                'prefix_class' => 'elementor-button-',
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label' => __('Size', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'md',
                'options' => [
                    'xs' => __('Extra Small', 'fundor-core'),
                    'sm' => __('Small', 'fundor-core'),
                    'md' => __('Medium', 'fundor-core'),
                    'lg' => __('Large', 'fundor-core'),
                    'xl' => __('Extra Large', 'fundor-core'),
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'fundor-core'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Click Here', 'fundor-core'),
            ]
        );

        $this->add_control(
            'link_button',
            [
                'label' => __('Link', 'fundor-core'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'fundor-core'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __('Image', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_space',
            [
                'label'     => __('Spacing', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 15,
                ],
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-position-right .elementor-image-box-img' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-left .elementor-image-box-img'  => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-top .elementor-image-box-img'   => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .elementor-image-box-img'                  => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_size',
            [
                'label'      => __('Width', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,

                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ]

                ],
                'size_units' => [
                    'px', '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'      => __('Height', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,

                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ]

                ],
                'size_units' => [
                    'px', '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_image_hover_style');

        $this->start_controls_tab(
            'tab_image_hover_style_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );

        $this->add_control(
            'image_opacity',
            [
                'label'     => __('Opacity', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 1,
                ],
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img img' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img svg' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_image_hover_style_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'image_opacity_hover',
            [
                'label'     => __('Opacity', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 1,
                ],
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-wrapper .elementor-image-box-img img' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}}:hover .elementor-image-box-wrapper .elementor-image-box-img svg' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __('Hover Animation', 'fundor-core'),
                'type'  => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => __('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-image-framed' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_style_svg',
            [
                'label' => __('SVG', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'svg_size',
            [
                'label'     => __('SVG Size', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 46,
                    'unit' => 'px',
                ],
                'range'     => [
                    'min' => 5,
                    'max' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-img svg' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_svg_style');

        $this->start_controls_tab(
            'svg_button_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );


        $this->add_control(
            'svg_color',
            [
                'label'     => __('SVG Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'show_svg_decor',
            [
                'label'     => __('Show Background Decor', 'fundor-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'fundor-core'),
                'label_off' => __('Hide', 'fundor-core'),
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'svg_button_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'svg_hover_color',
            [
                'label'     => __('SVG Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-wrapper .elementor-image-box-img svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'svg_transformation',
            [
                'label'        => __('Animation', 'fundor-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'none'            => 'None',
                    'move-horizontal' => 'Move Horizontal',
                    'move-vertical'   => 'Move Vertical',
                ],
                'default'      => 'none',
                'prefix_class' => 'imagebox-svg-transform-',
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'svg_hover_transition',
            [
                'label'     => __('Transition Duration', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-image-box-img svg' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->end_controls_section();


        $this->start_controls_section(
            'config_box_view_section',
            [
                'label'     => __('Box View', 'fundor-core'),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'view_style!' => 'default',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_width_box',
            [
                'label'      => __('Border Width', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition'  => [
                    'view_style' => 'framed',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_view_style');

        $this->start_controls_tab(
            'view_button_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );

        $this->add_control(
            'view_bg',
            [
                'label'     => __('Box View Background', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'framed_color',
            [
                'label'     => __('Border Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-icon' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'view_style' => 'framed',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'view_button_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'view_bg_hover',
            [
                'label'     => __('Box View Background', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-wrapper .elementor-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'framed_color_hover',
            [
                'label'     => __('Border Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-wrapper .elementor-icon' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'view_style' => 'framed',
                ],
            ]
        );

        $this->add_control(
            'framed_hover_transition',
            [
                'label'     => __('Transition Duration', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper .elementor-icon' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => __('Content', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label'     => __('Alignment', 'fundor-core'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'    => [
                        'title' => __('Left', 'fundor-core'),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'  => [
                        'title' => __('Center', 'fundor-core'),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'   => [
                        'title' => __('Right', 'fundor-core'),
                        'icon'  => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'fundor-core'),
                        'icon'  => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_vertical_alignment',
            [
                'label'        => __('Vertical Alignment', 'fundor-core'),
                'type'         => Controls_Manager::SELECT,
                'options'      => [
                    'top'    => __('Top', 'fundor-core'),
                    'middle' => __('Middle', 'fundor-core'),
                    'bottom' => __('Bottom', 'fundor-core'),
                ],
                'default'      => 'top',
                'prefix_class' => 'elementor-vertical-align-',
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding_content',
            [
                'label'      => __('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-image-box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label'     => __('Title', 'fundor-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_title_decor',
            [
                'label'     => __('Show Decor', 'fundor-core'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => __('Show', 'fundor-core'),
                'label_off' => __('Hide', 'fundor-core'),
            ]
        );
        $this->add_control(
            'title_decor_color',
            [
                'label'     => __('Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .image-box-decor' => 'background-color: {{VALUE}};',
                ],
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_responsive_control(
            'title_bottom_space',
            [
                'label'     => __('Spacing', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs('tabs_view_title_style');

        $this->start_controls_tab(
            'view_title_button_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => __('Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title' => 'color: {{VALUE}};',
                ],
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'view_title_button_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label'     => __('Color Hover (Wrapper)', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-content .elementor-image-box-title' => 'color: {{VALUE}};',
                ],
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
            ]
        );

        $this->add_control(
            'title_hover_transition',
            [
                'label'     => __('Transition Duration', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-title' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_control(
            'heading_sub_title',
            [
                'label'     => __('Sub-title', 'fundor-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'sub_title_typography',
                'selector' => '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-sub-title',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_responsive_control(
            'sub_title_bottom_space',
            [
                'label'     => __('Spacing', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-sub-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_view_subtitle_style');

        $this->start_controls_tab(
            'view_subtitle_button_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );

        $this->add_control(
            'sub_title_color',
            [
                'label'     => __('Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'view_subtitle_button_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'sub_title_color_hover',
            [
                'label'     => __('Color Hover (Wrapper)', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-content .elementor-image-box-sub-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'sub_title_hover_transition',
            [
                'label'     => __('Transition Duration', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-sub-title' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'heading_description',
            [
                'label'     => __('Description', 'fundor-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-description',
                'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->start_controls_tabs('tabs_view_description_style');

        $this->start_controls_tab(
            'view_description_button_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label'     => __('Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-description' => 'color: {{VALUE}};',
                ],
                'scheme'    => [
                    'type'  => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
            ]
        );

        $this->add_control(
            'description_opacity',
            [
                'label'     => __('Opacity', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 1,
                ],
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-description' => 'opacity: {{SIZE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'view_description_button_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'description_color_hover',
            [
                'label'     => __('Color Hover (Wrapper)', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-content .elementor-image-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'description_hover_opacity',
            [
                'label'     => __('Opacity', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'size' => 1,
                ],
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-image-box-content .elementor-image-box-description' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'description_hover_transition',
            [
                'label'     => __('Transition Duration', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-content .elementor-image-box-description' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'description_bottom_space',
            [
                'label'     => __('Spacing', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image-box-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_decor_style',
            [
                'label' => __('Decor', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_decor' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'decor_color',
            [
                'label'     => __('Decor Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-box-decor' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'decor_width',
            [
                'label'     => __('Width', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units'    => ['px','%'],
                'selectors' => [
                    '{{WRAPPER}} .image-box-decor' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'decor_margin',
            [
                'label'      => __('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .image-box-decor' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //BUTON

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => __('Button', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition' => [
                    'show_button!' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label'      => __('Width', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,

                'range'      => [
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ]

                ],
                'size_units' => [
                    'px', '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-box-button a',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '.elementor-icon-box-button.elementor-button'
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __('Border Radius', 'fundor-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => __('Padding', 'fundor-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label' => __( 'Margin', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-button a:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => __('Background Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-button a:not(:hover)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __('Text Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-button a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => __('Background Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-button a:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_hover_color',
            [
                'label' => __('Border Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-button a:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    protected function render() {

        $settings = $this->get_settings_for_display();

        $has_content = !empty($settings['title_text']) || !empty($settings['description_text']);
        $this->add_render_attribute('wrapper', 'class', 'elementor-image-box-wrapper');

        $this->add_render_attribute('button_text', 'class', [
            'elementor-button',
            'elementor-size-' . $settings['button_size'],
        ]);

        if (!empty($settings['link_button']['url'])) {
            $this->add_render_attribute('button_text', 'href', $settings['link_button']['url']);

            if (!empty($settings['link_button']['is_external'])) {
                $this->add_render_attribute('button_text', 'target', '_blank');
            }
        }

        $html = '<div ' . $this->get_render_attribute_string("wrapper") . '>';

        if (!empty($settings['link']['url'])) {
            $this->add_render_attribute('link', 'href', $settings['link']['url']);

            if ($settings['link']['is_external']) {
                $this->add_render_attribute('link', 'target', '_blank');
            }

            if (!empty($settings['link']['nofollow'])) {
                $this->add_render_attribute('link', 'rel', 'nofollow');
            }

//            if ($settings['link_download'] === 'yes') {
//                $this->add_render_attribute('link', 'download');
//            }
        }

        if (!empty($settings['image']['url'])) {
            $this->add_render_attribute('image', 'src', $settings['image']['url']);
            $this->add_render_attribute('image', 'alt', Control_Media::get_image_alt($settings['image']));
            $this->add_render_attribute('image', 'title', Control_Media::get_image_title($settings['image']));

            if ($settings['hover_animation']) {
                $this->add_render_attribute('image', 'class', 'elementor-animation-' . $settings['hover_animation']);
            }
            $this->add_render_attribute('image-wrapper', 'class', 'elementor-image-box-img');

            $this->add_render_attribute('image-framed', 'class', 'elementor-image-framed');
            if($settings['show_svg_decor'] == 'yes') {
                $this->add_render_attribute('image-framed', 'class', 'svg-box-decor');
            }
            if ($settings['view_style'] !== 'default' && $settings['view_style']) {
                $this->add_render_attribute('image-wrapper', 'class', 'elementor-icon');
            }

            $image_url = '';
            $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'image');
            if (!empty($settings['image']['url'])) {
                $image_url = $settings['image']['url'];
                $path_parts = pathinfo($image_url);
                if ($path_parts['extension'] === 'svg') {
                    $image = $this->get_settings_for_display('image');
                    if ($image['id']) {
                        $pathSvg = get_attached_file($image['id']);
                        $image_html = osf_get_icon_svg($pathSvg);
                    }
                }
            }

            if (!empty($settings['link']['url'])) {
                $image_html = '<a ' . $this->get_render_attribute_string('link') . '>' . $image_html . '</a>';
            }

            $html .= '<div ' . $this->get_render_attribute_string("image-framed") . '>';
            $html .= '<figure ' . $this->get_render_attribute_string("image-wrapper") . '>' . $image_html . '</figure>';
            $html .= '</div>';
        }

        if ($has_content) {
            $html .= '<div class="elementor-image-box-content">';

            if (!empty($settings['sub_title_text'])) {
                $this->add_render_attribute('sub_title_text', 'class', 'elementor-image-box-sub-title');
                $html .= '<div ' . $this->get_render_attribute_string("sub_title_text") . '>' . $settings["sub_title_text"] . '</div>';
            }

            if (!empty($settings['title_text'])) {
                $this->add_render_attribute('title_text', 'class', 'elementor-image-box-title');

                $this->add_inline_editing_attributes('title_text', 'none');

                $title_html = $settings['title_text'];

                if (!empty($settings['link']['url'])) {
                    $title_html = '<a ' . $this->get_render_attribute_string('link') . '>' . $title_html . '</a>';
                }

                $html .= sprintf('<%1$s %2$s>%3$s</%1$s>', $settings['title_size'], $this->get_render_attribute_string('title_text'), $title_html);
                if($settings['show_title_decor'] == 'yes') {
                    $html .= '<span class="image-box-decor"></span>';
                }
            }

            if ($settings['show_decor'] == 'yes') {
                $html .= '<span class="image-box-decor"></span>';
            }

            if (!empty($settings['description_text'])) {
                $this->add_render_attribute('description_text', 'class', 'elementor-image-box-description');

                $this->add_inline_editing_attributes('description_text');

                $html .= sprintf('<p %1$s>%2$s</p>', $this->get_render_attribute_string('description_text'), $settings['description_text']);
            }

            if (!empty($settings['show_button']) && !empty($settings['button_text'])){
                $html .= '<div class="elementor-image-box-button"><a '.$this->get_render_attribute_string('button_text').'><span class="elementor-price-table_button-text">'.$settings['button_text'].'</span></a></div>';
            }

            $html .= '</div>';
        }

        $html .= '</div>';





        echo $html;
    }

    protected function _content_template() {
        return;
        ?>
        <#
        view.addRenderAttribute( 'wrapper', 'class', 'elementor-image-box-wrapper' );
        var html = '
        <div '+ view.getRenderAttributeString("wrapper") +'>';

        if ( settings.image.url ) {
        var image = {
        id: settings.image.id,
        url: settings.image.url,
        size: settings.thumbnail_size,
        dimension: settings.thumbnail_custom_dimension,
        model: view.getEditModel()
        };

        var image_url = elementor.imagesManager.getImageUrl( image );
        if(image_url.substr((image_url.lastIndexOf('.') + 1)) === 'svg'){
        var imageHtml = '
        <object data="'+image_url+'" type="image/svg+xml"></object>';
        }else{
        var imageHtml = '<img src="' + image_url + '" class="elementor-animation-' + settings.hover_animation + '"/>';
        }

        if ( settings.link.url ) {
        imageHtml = '<a href="' + settings.link.url + '">' + imageHtml + '</a>';
        }

        view.addRenderAttribute( 'image-wrapper', 'class', 'elementor-image-box-img' );
        if(settings.view_style !== 'default'){
        view.addRenderAttribute( 'image-wrapper', 'class', 'elementor-icon' );
        }
        html += '
        <div class="elementor-image-framed">';
            html += '
            <figure
            ' + view.getRenderAttributeString( 'image-wrapper' ) + '>' + imageHtml + '</figure>';
            html += '
        </div>';
        }

        var hasContent = !! ( settings.title_text || settings.description_text );

        if ( hasContent ) {
        html += '
        <div class="elementor-image-box-content">';
            if ( settings.sub_title_text ) {
            html += '
            <div class="elementor-image-box-sub-title">' + settings.sub_title_text + '</div>
            ';
            }
            if ( settings.title_text ) {
            var title_html = settings.title_text;

            if ( settings.link.url ) {
            title_html = '<a href="' + settings.link.url + '">' + title_html + '</a>';
            }

            view.addRenderAttribute( 'title_text', 'class', 'elementor-image-box-title' );

            view.addInlineEditingAttributes( 'title_text', 'none' );

            html += '<' + settings.title_size + ' ' + view.getRenderAttributeString( 'title_text' ) + '>' + title_html +
            '
        </' + settings.title_size  + '>';
        }

        if(settings.show_decor !== '') {
        title_html += '<span class="image-box-decor"></span>'}

        if ( settings.description_text ) {
        view.addRenderAttribute( 'description_text', 'class', 'elementor-image-box-description' );

        view.addInlineEditingAttributes( 'description_text' );

        html += '<p ' + view.getRenderAttributeString( 'description_text' ) + '>' + settings.description_text + '</p>';
        }

        html += '</div>';
        }

        html += '</div>';

        print( html );
        #>
        <?php
    }
}

$widgets_manager->register_widget_type(new OSF_Widget_Image_Box());
