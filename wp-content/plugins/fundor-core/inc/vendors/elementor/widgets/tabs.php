<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Tabs extends Elementor\Widget_Base {

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-tabs';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Opal Tabs', 'fundor-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-tabs';
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls() {

        $templates = Elementor\Plugin::instance()->templates_manager->get_source('local')->get_items();

        $options = [
            '0' => '— ' . __('Select', 'fundor-core') . ' —',
        ];

        $types = [];

        foreach ($templates as $template) {
            $options[$template['template_id']] = $template['title'] . ' (' . $template['type'] . ')';
            $types[$template['template_id']]   = $template['type'];
        }

        $this->start_controls_section(
            'section_tabs',
            [
                'label' => __('Tabs', 'fundor-core'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_icon',
            [
                'name'        => 'tab_icon',
                'label'       => __('Icon', 'fundor-core'),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'default'     => 'fa fa-check',
            ]
        );

        $repeater->add_control(
            'tab_title',
            [
                'label'       => __('Title & Description', 'fundor-core'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Tab Title', 'fundor-core'),
                'placeholder' => __('Tab Title', 'fundor-core'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'source',
            [
                'label'   => __('Source', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'html',
                'options' => [
                    'html'     => __('HTML', 'fundor-core'),
                    'template' => __('Template', 'fundor-core'),
                ],
            ]
        );

        $repeater->add_control(
            'tab_html',
            [
                'label'       => __('Content', 'fundor-core'),
                'default'     => __('Tab Content', 'fundor-core'),
                'placeholder' => __('Tab Content', 'fundor-core'),
                'type'        => Controls_Manager::WYSIWYG,
                'show_label'  => false,
                'condition'   => [
                    'source' => 'html',
                ],
            ]
        );
        $repeater->add_control(
            'tab_template',
            [
                'label'       => __('Choose Template', 'fundor-core'),
                'default'     => 0,
                'type'        => Controls_Manager::SELECT,
                'options'     => $options,
                'types'       => $types,
                'label_block' => 'true',
                'condition'   => [
                    'source' => 'template',
                ],
            ]
        );
        $repeater->add_control(
            'bg_tab_a',
            [
                'label'     => __('Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label'       => __('Tabs Items', 'fundor-core'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'tab_icon'  => __('', 'fundor-core'),
                        'tab_title' => __('Tab #1', 'fundor-core'),
                        'source'    => 'html',
                        'tab_html'  => __('I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'fundor-core'),
                    ],
                    [
                        'tab_icon'  => __('', 'fundor-core'),
                        'tab_title' => __('Tab #2', 'fundor-core'),
                        'source'    => 'html',
                        'tab_html'  => __('I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'fundor-core'),
                    ],
                    [
                        'tab_icon'  => __('', 'fundor-core'),
                        'tab_title' => __('Tab #3', 'fundor-core'),
                        'source'    => 'html',
                        'tab_html'  => __('I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'fundor-core'),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
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

        $this->add_control(
            'type',
            [
                'label'        => __('Type', 'fundor-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'horizontal',
                'options'      => [
                    'horizontal' => __('Horizontal', 'fundor-core'),
                    'vertical'   => __('Vertical', 'fundor-core'),
                ],
                'prefix_class' => 'elementor-tabs-view-',
                'separator'    => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_tabs_style',
            [
                'label' => __('Tabs', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'navigation_width',
            [
                'label'      => __('Navigation Width', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'default'    => [
                    'unit' => '%',
                ],
                'range'      => [
                    '%'  => [
                        'min' => 10,
                        'max' => 50,
                    ],
                    'px' => [
                        'min' => 250,
                        'max' => 500,
                    ],
                ],
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition'  => [
                    'type' => 'vertical',
                ],
            ]
        );

        $this->add_control(
            'background_tabs',
            [
                'label'     => __('Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_tabs',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-tabs',
            ]
        );

        $this->add_control(
            'tabs_border_radius',
            [
                'label'      => __('Border Radius', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tabs' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'tabs_shadow',
                'selector' => '{{WRAPPER}} .elementor-tabs',
            ]
        );

        $this->add_responsive_control(
            'tabs_padding',
            [
                'label'      => __('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tabs_margin',
            [
                'label'      => __('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_tab_header_style',
            [
                'label' => __('Header', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_tab_header',
            [
                'label'     => __('Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_tab_header',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-tabs-wrapper',
            ]
        );

        $this->add_responsive_control(
            'tab_header_padding',
            [
                'label'      => __('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_header_margin',
            [
                'label'      => __('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'align_items',
            [
                'label'       => __('Align', 'fundor-core'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'flex-start' => [
                        'title' => __('Left', 'fundor-core'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'     => [
                        'title' => __('Center', 'fundor-core'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end'   => [
                        'title' => __('Right', 'fundor-core'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'condition'   => [
                    'type' => 'horizontal',
                ],
                'default'     => 'flex-start',
                'selectors'   => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __('Title', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_responsive_control(
            'tab_title_width',
            [
                'label'      => __('Width', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-desktop-title' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_title_height',
            [
                'label'      => __('Height', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-desktop-title' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tab_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-desktop-title',
            ]
        );

        $this->start_controls_tabs('tabs_title_style');

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title:not(.elementor-active):not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_background_color',
            [
                'label'     => __('Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title:not(.elementor-active):not(:hover)' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'     => __('Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title:hover' => 'color: {{VALUE}} !important;'
                ],
            ]
        );

        $this->add_control(
            'title_background_hover_color',
            [
                'label'     => __('Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title:hover' => 'background-color: {{VALUE}} !important;'
                ],
            ]
        );

        $this->add_control(
            'title_hover_border_color',
            [
                'label'     => __('Border Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title:hover' => 'border-color: {{VALUE}} !important;'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_active',
            [
                'label' => __('Active', 'fundor-core'),
            ]
        );

        $this->add_control(
            'title_active_color',
            [
                'label'     => __('Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title.elementor-active' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'title_background_active_color',
            [
                'label'     => __('Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title.elementor-active' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'title_active_border_color',
            [
                'label'     => __('Border Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title.elementor-active' => 'border-color: {{VALUE}} !important;'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_tabs_title',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-tab-desktop-title',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'tabs_title_border_radius',
            [
                'label'      => __('Border Radius', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-desktop-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_title_padding',
            [
                'label'      => __('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-desktop-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_title_margin',
            [
                'label'      => __('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-desktop-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'align_title',
            [
                'label'       => __('Align', 'fundor-core'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'flex-start' => [
                        'title' => __('Left', 'fundor-core'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'     => [
                        'title' => __('Center', 'fundor-core'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end'   => [
                        'title' => __('Right', 'fundor-core'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'     => 'center',
                'selectors'   => [
                    '{{WRAPPER}} .elementor-tab-desktop-title' => 'justify-content: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => __('Icon', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'      => __('Size', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label'      => __('Spacing', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->start_controls_tabs('tabs_icon_style');

        $this->start_controls_tab(
            'tab_icon_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => __('Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title .elementor-tab-icon' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label'     => __('Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title:hover .elementor-tab-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_icon_active',
            [
                'label' => __('Active', 'fundor-core'),
            ]
        );

        $this->add_control(
            'icon_active_color',
            [
                'label'     => __('Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title.elementor-active .elementor-tab-icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style',
            [
                'label' => __('Content', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-content',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     => __('Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_background',
            [
                'label'     => __('Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_content',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}}.elementor-tabs-view-horizontal .elementor-tabs-content-wrapper .elementor-tab-content,{{WRAPPER}}.elementor-tabs-view-vertical .elementor-tabs-content-wrapper .elementor-tab-content',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'content_border_radius',
            [
                'label'      => __('Border Radius', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label'      => __('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => __('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'align_content',
            [
                'label'       => __('Align', 'fundor-core'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'left'   => [
                        'title' => __('Left', 'fundor-core'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'fundor-core'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'fundor-core'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'     => 'left',
                'selectors'   => [
                    '{{WRAPPER}} .elementor-tab-content' => 'text-align: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $tabs = $this->get_settings_for_display('tabs');

        $id_int = substr($this->get_id_int(), 0, 3);
        ?>
        <div class="elementor-tabs" role="tablist">
            <div class="elementor-tabs-wrapper">
                <?php
                foreach ($tabs as $index => $item) :
                    $tab_count = $index + 1;
                    $class_item = 'elementor-repeater-item-' . $item['_id'];
                    $class = ($index == 0) ? 'elementor-active' : '';

                    $tab_title_setting_key = $this->get_repeater_setting_key('tab_title', 'tabs', $index);

                    $this->add_render_attribute($tab_title_setting_key, [
                        'id'            => 'elementor-tab-title-' . $id_int . $tab_count,
                        'class'         => ['elementor-tab-title', 'elementor-tab-desktop-title', $class, $class_item],
                        'data-tab'      => $tab_count,
                        'tabindex'      => $id_int . $tab_count,
                        'role'          => 'tab',
                        'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                    ]);
                    ?>
                    <div <?php echo $this->get_render_attribute_string($tab_title_setting_key); ?>>

                        <?php if (!empty($item['tab_icon'])) {
                            ?>
                            <span class="elementor-tab-icon">
                                <i class="<?php echo esc_attr($item['tab_icon']); ?>" aria-hidden="true"></i>
                            </span>
                        <?php } ?>

                        <span><?php echo $item['tab_title']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="elementor-tabs-content-wrapper">
                <?php
                foreach ($tabs as $index => $item) :
                    $tab_count = $index + 1;
                    $class_item = 'elementor-repeater-item-' . $item['_id'];
                    $class_content = ($index == 0) ? 'elementor-active' : '';

                    $tab_content_setting_key = $this->get_repeater_setting_key('tab_content', 'tabs', $index);

                    $this->add_render_attribute($tab_content_setting_key, [
                        'id'              => 'elementor-tab-content-' . $id_int . $tab_count,
                        'class'           => ['elementor-tab-content', 'elementor-clearfix', $class_content, $class_item],
                        'data-tab'        => $tab_count,
                        'role'            => 'tabpanel',
                        'aria-labelledby' => 'elementor-tab-title-' . $id_int . $tab_count,
                    ]);

                    $this->add_inline_editing_attributes($tab_content_setting_key, 'advanced');
                    ?>
                    <div <?php echo $this->get_render_attribute_string($tab_content_setting_key); ?>>
                        <?php if ('html' === $item['source']): ?>
                            <?php echo do_shortcode($item['tab_html']); ?>
                        <?php else: ?>
                            <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($item['tab_template']); ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}

$widgets_manager->register_widget_type(new OSF_Elementor_Tabs());
