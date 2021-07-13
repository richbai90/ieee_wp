<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor icon box widget.
 *
 * Elementor widget that displays an icon, a headline and a text.
 *
 * @since 1.0.0
 */
class OSF_Widget_Icon_Box extends Widget_Icon_Box
{

    /**
     * Get widget name.
     *
     * Retrieve icon box widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name()
    {
        return 'icon-box';
    }

    /**
     * Get widget title.
     *
     * Retrieve icon box widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title()
    {
        return __('Icon Box', 'fundor-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve icon box widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon()
    {
        return 'eicon-icon-box';
    }

    public function get_categories()
    {
        return ['opal-addons'];
    }

    /**
     * Register icon box widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_icon',
            [
                'label' => __('Icon Box', 'fundor-core'),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Choose Icon', 'fundor-core'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => __('View', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => __('Default', 'fundor-core'),
                    'stacked' => __('Stacked', 'fundor-core'),
                    'framed' => __('Framed', 'fundor-core'),
                ],
                'default' => 'default',
                'prefix_class' => 'elementor-view-',
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'shape',
            [
                'label' => __('Shape', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'circle' => __('Circle', 'fundor-core'),
                    'square' => __('Square', 'fundor-core'),
                    'polygon' => __('Polygon', 'fundor-core'),
                ],
                'default' => 'circle',
                'condition' => [
                    'view!' => 'default',
                    'icon!' => '',
                ],
                'prefix_class' => 'elementor-shape-',
            ]
        );

        $this->add_control(
            'title_text',
            [
                'label' => __('Title & Description', 'fundor-core'),
                'type' => Controls_Manager::TEXT,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __('This is the heading', 'fundor-core'),
                'placeholder' => __('Enter your title', 'fundor-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description_text',
            [
                'label' => '',
                'type' => Controls_Manager::TEXTAREA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => __('Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'fundor-core'),
                'placeholder' => __('Enter your description', 'fundor-core'),
                'rows' => 10,
                'separator' => 'none',
                'show_label' => false,
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __('Link to', 'fundor-core'),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => __('https://your-link.com', 'fundor-core'),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'link_download',
            [
                'label' => __('Donload Link ?', 'fundor-core'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );
        $this->add_control(
            'show_decor',
            [
                'label' => __('Show Decor', 'fundor-core'),
                'type' => Controls_Manager::SWITCHER,
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
                'label' => __('Icon Position', 'fundor-core'),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'top',
                'options' => [
                    'left' => [
                        'title' => __('Left', 'fundor-core'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'top' => [
                        'title' => __('Top', 'fundor-core'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'fundor-core'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-position-',
                'toggle' => false,
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'title_size',
            [
                'label' => __('Title HTML Tag', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'default' => 'h3',
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

        //WRAPPER

        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => __('Wrapper', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'wrapper_height',
            [
                'label' => __('Min Height', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-wrapper' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_animation',
            [
                'label' => __('Show Animation', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __('Default', 'fundor-core'),
                    'style-1' => __('Show', 'fundor-core'),
                    'style-2' => __('Show When Hover', 'fundor-core'),
                ],
                'prefix_class' => 'icon-box-',
            ]
        );

        $this->start_controls_tabs('tabs_wrapper_style');

        $this->start_controls_tab(
            'tab_wrapper_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );


        $this->add_control(
            'background_wrapper',
            [
                'label' => __('Background Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_shadow',
                'selector' => '{{WRAPPER}} .elementor-icon-box-wrapper',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_wrapper_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'background_wrapper_hover',
            [
                'label' => __('Background Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-wrapper:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_shadow_hover',
                'selector' => '{{WRAPPER}} .elementor-icon-box-wrapper:hover',
            ]
        );

        $this->add_responsive_control(
            'wrapper_translate',
            [
                'label' => __('Translate Rotate', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => -20,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container:hover .elementor-icon-box-wrapper' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_wrapper',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-icon-box-wrapper',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'wrapper_radius',
            [
                'label' => __('Border Radius', 'fundor-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => __('Padding', 'fundor-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_margin',
            [
                'label' => __('Margin', 'fundor-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //ICON
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => __('Icon', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'primary_color',
            [
                'label' => __('Primary Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked:not(:hover) .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed:not(:hover) .elementor-icon, {{WRAPPER}}.elementor-view-default:not(:hover) .elementor-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'secondary_color',
            [
                'label' => __('Secondary Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'view!' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed:not(:hover) .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked:not(:hover) .elementor-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_space',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-position-right .elementor-icon-box-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-left .elementor-icon-box-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-top .elementor-icon-box-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .elementor-icon-box-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => __('Size', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_padding',
            [
                'label' => __('Padding', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'condition' => [
                    'view!' => 'default',
                ],
            ]
        );

        $this->add_control(
            'rotate',
            [
                'label' => __('Rotate', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0,
                    'unit' => 'deg',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
                ],
            ]
        );

        $this->add_control(
            'icon_border_width',
            [
                'label' => __('Border Width', 'fundor-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'view' => 'framed',
                ],
            ]
        );

        $this->add_control(
            'icon_border_color',
            [
                'label' => __('Border Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:not(:hover) .elementor-icon' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'view' => 'framed',
                ],
            ]
        );

        $this->add_control(
            'icon_border_radius',
            [
                'label' => __('Border Radius', 'fundor-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'view!' => 'default',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_svg',
            [
                'label' => __('SVG', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'svg_size',
            [
                'label' => __('Size', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'default'   => [
                        'size'    => 80
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-svg img' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'svg_space',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'size' => 15,
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-position-right .elementor-icon-box-svg' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-left .elementor-icon-box-svg' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.elementor-position-top .elementor-icon-box-svg' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '(mobile){{WRAPPER}} .elementor-icon-box-svg' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_hover',
            [
                'label' => __('Icon Hover', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon!' => '',
                ],
            ]
        );

        $this->add_control(
            'hover_primary_color',
            [
                'label' => __('Primary Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-framed:hover .elementor-icon, {{WRAPPER}}.elementor-view-default:hover .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_secondary_color',
            [
                'label' => __('Secondary Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'condition' => [
                    'view!' => 'default',
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-view-framed:hover .elementor-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}}.elementor-view-stacked:hover .elementor-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __('Hover Animation', 'fundor-core'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_content',
            [
                'label' => __('Content', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'text_align',
            [
                'label' => __('Alignment', 'fundor-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'fundor-core'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'fundor-core'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'fundor-core'),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __('Justified', 'fundor-core'),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_vertical_alignment',
            [
                'label' => __('Vertical Alignment', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'top' => __('Top', 'fundor-core'),
                    'middle' => __('Middle', 'fundor-core'),
                    'bottom' => __('Bottom', 'fundor-core'),
                ],
                'default' => 'top',
                'prefix_class' => 'elementor-vertical-align-',
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label' => __('Title', 'fundor-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'title_bottom_space',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:not(:hover) .elementor-icon-box-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_color_hover',
            [
                'label' => __('Hover Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-icon-box-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-title',
            ]
        );

        $this->add_control(
            'heading_description',
            [
                'label' => __('Description', 'fundor-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'description_color_hover',
            [
                'label' => __('Hover Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}:hover .elementor-icon-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-box-content .elementor-icon-box-description',
            ]
        );

        $this->add_responsive_control(
            'description_bottom_space',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_decor_style',
            [
                'label' => __('Decor', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_decor' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'decor_color',
            [
                'label' => __('Decor Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-box-decor' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'decor_width',
            [
                'label' => __('Width', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .image-box-decor' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'decor_margin',
            [
                'label' => __('Margin', 'fundor-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
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

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('icon', 'class', ['elementor-icon', 'elementor-animation-' . $settings['hover_animation']]);

        $icon_tag = 'span';
        $has_icon = !empty($settings['icon']);

        if (!empty($settings['link']['url'])) {
            $this->add_render_attribute('link', 'href', $settings['link']['url']);
            $icon_tag = 'a';

            if ($settings['link']['is_external']) {
                $this->add_render_attribute('link', 'target', '_blank');
            }

            if ($settings['link']['nofollow']) {
                $this->add_render_attribute('link', 'rel', 'nofollow');
            }

            if ($settings['link_download'] === 'yes') {
                $this->add_render_attribute('link', 'download');
            }

        }

        if ($has_icon) {
            $this->add_render_attribute('i', 'class', $settings['icon']);
            $this->add_render_attribute('i', 'aria-hidden', 'true');
        }

        $icon_attributes = $this->get_render_attribute_string('icon');
        $link_attributes = $this->get_render_attribute_string('link');

        $this->add_render_attribute('description_text', 'class', 'elementor-icon-box-description');

        $this->add_inline_editing_attributes('title_text', 'none');
        $this->add_inline_editing_attributes('description_text');

        $migrated = isset($settings['__fa4_migrated']['selected_icon']);
        $is_new = empty($settings['icon']) && Icons_Manager::is_migration_allowed();

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

        ?>
        <div class="elementor-icon-box-wrapper">
        <?php if ($settings['icon']['value'] && is_string($settings['icon']['value'])) : ?>
        <div class="elementor-icon-box-icon">
        <<?php echo implode(' ', [$icon_tag, $icon_attributes, $link_attributes]); ?>>
        <?php if ($is_new || $migrated) :
            Icons_Manager::render_icon($settings['icon']);
        else : ?>
            <i <?php echo $this->get_render_attribute_string('i'); ?>></i>
        <?php endif; ?>
        </<?php echo $icon_tag; ?>>
        </div>
    <?php elseif ($settings['icon']['value']): ?>
        <div class="elementor-icon-box-svg">
            <img src="<?php echo esc_attr($settings['icon']['value']['url']);?>" alt="">
        </div>
    <?php endif;?>
        <div class="elementor-icon-box-content">
        <<?php echo $settings['title_size']; ?> class="elementor-icon-box-title">
        <<?php echo implode(' ', [$icon_tag, $link_attributes]); ?><?php echo $this->get_render_attribute_string('title_text'); ?>><?php echo $settings['title_text']; ?></<?php echo $icon_tag; ?>>
        </<?php echo $settings['title_size']; ?>>

        <?php
        if ($settings['show_decor'] == 'yes') {
            ?>
            <span class="image-box-decor"></span>
            <?php
        }
        ?>

        <p <?php echo $this->get_render_attribute_string('description_text'); ?>><?php echo $settings['description_text']; ?></p>

        <?php if (!empty($settings['show_button'])) : ?>
        <div class="elementor-icon-box-button">
            <?php if (!empty($settings['button_text'])) : ?>
                <a <?php echo $this->get_render_attribute_string('button_text'); ?>>
                    <span class="elementor-price-table_button-text"><?php echo $settings['button_text']; ?></span>
                </a>
            <?php endif; ?>

        </div>
    <?php endif; ?>

        </div>
        </div>
        <?php
    }
    protected function _content_template() {}
}

$widgets_manager->register_widget_type(new OSF_Widget_Icon_Box());