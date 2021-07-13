<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Css_Filter;
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;

class OSF_Elementor_Testimonials extends OSF_Elementor_Carousel_Base {

    /**
     * Get widget name.
     *
     * Retrieve testimonial widget name.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'opal-testimonials';
    }

    /**
     * Get widget title.
     *
     * Retrieve testimonial widget title.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __('Opal Testimonials', 'fundor-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @since  1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-testimonial';
    }

    public function get_categories() {
        return array('opal-addons');
    }

    /**
     * Register testimonial widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_testimonial',
            [
                'label' => __('Testimonials', 'fundor-core'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'testimonial_title',
            [
                'label' => __('Title', 'fundor-core'),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'testimonial_content',
            [
                'label'       => __('Content', 'fundor-core'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                'label_block' => true,
                'rows'        => '10',
            ]
        );

        $repeater->add_control(
            'testimonial_image',
            [
                'label'      => __('Choose Image', 'fundor-core'),
                'default'    => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,
            ]
        );

        $repeater->add_control(
            'testimonial_name',
            [
                'label'   => __('Name', 'fundor-core'),
                'default' => 'John Doe',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'testimonial_job',
            [
                'label'   => __('Job', 'fundor-core'),
                'default' => 'Design',
                'type'    => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'testimonial_link',
            [
                'label'       => __('Link to', 'fundor-core'),
                'placeholder' => __('https://your-link.com', 'fundor-core'),
                'type'        => Controls_Manager::URL,
            ]
        );

        $repeater->add_control(
            'show_button',
            [
                'label' => __('Show Button', 'fundor-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $repeater->add_control(
            'testimonial_button_text',
            [
                'label'     => __('Button Text', 'fundor-core'),
                'type'      => Controls_Manager::TEXT,
                'default'   => __('Click Here', 'fundor-core'),
                'condition' => [
                    'show_button' => 'yes'
                ]
            ]
        );

        $repeater->add_control(
            'testimonial_button_link',
            [
                'name'        => 'testimonial_button_link',
                'label'       => __('Link', 'fundor-core'),
                'type'        => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'fundor-core'),
                'default'     => [
                    'url' => '#',
                ],
                'condition'   => [
                    'show_button' => 'yes'
                ]
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label'       => __('Testimonials Item', 'fundor-core'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ testimonial_name }}}',
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'testimonial_image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `testimonial_image_size` and `testimonial_image_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'testimonial_alignment',
            [
                'label'       => __('Alignment', 'fundor-core'),
                'type'        => Controls_Manager::CHOOSE,
                'default'     => 'center',
                'options'     => [
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
                'label_block' => false,
            ]
        );


        $this->add_responsive_control(
            'column',
            [
                'label'   => __('Columns', 'fundor-core'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 1,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 6 => 6],
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


        // Wrapper style

        $this->start_controls_section(
            'wrapper_style',
            [
                'label' => __('Wrapper', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('tabs_wrapper_style');

        $this->start_controls_tab(
            'tab_wrapper_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'background_wrapper',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .elementor-testimonial-content-wrapper',
            ]
        );


        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'wrapper_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-testimonial-content-wrapper',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_wrapper_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'background_wrapper_hover',
                'types'    => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .elementor-testimonial-content-wrapper:hover',
            ]
        );


        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'wrapper_box_shadow_hover',
                'selector' => '{{WRAPPER}} .elementor-testimonial-content-wrapper:hover',
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
                    '{{WRAPPER}} .elementor-testimonial-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator'  => 'before',
            ]
        );

        $this->add_control(
            'testimonial_effect',
            [
                'label'        => __('Hover Effect', 'fundor-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_off'    => __('Off', 'fundor-core'),
                'label_on'     => __('On', 'fundor-core'),
                'condition'    => [
                    'enable_carousel' => '',
                ],
                'return_value' => 'on',
                'prefix_class' => 'elementor-testimonial-effect-'
            ]
        );

        $this->add_control(
            'testimonial_line',
            [
                'label'        => __('Line Center', 'fundor-core'),
                'type'         => Controls_Manager::SWITCHER,
                'label_off'    => __('Off', 'fundor-core'),
                'label_on'     => __('On', 'fundor-core'),
                'condition'    => [
                    'enable_carousel' => '',
                ],
                'return_value' => 'on',
                'prefix_class' => 'elementor-testimonial-line-'
            ]
        );

        $this->end_controls_section();


        // Image style.
        $this->start_controls_section(
            'section_style_testimonial_image',
            [
                'label' => __('Image', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('image_effects');

        $this->start_controls_tab('normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );

        $this->add_control(
            'opacity',
            [
                'label'     => __('Opacity', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'css_filters',
                'selector' => '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'opacity_hover',
            [
                'label'     => __('Opacity', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper:hover .elementor-testimonial-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name'     => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .elementor-testimonial-wrapper:hover .elementor-testimonial-image img',
            ]
        );

        $this->add_control(
            'background_hover_transition',
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
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'transition-duration: {{SIZE}}s',
                ],
                'separator' => 'before'
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


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'selector'  => '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label'      => __('Border Radius', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label'      => __('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label'      => __('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-wrapper .elementor-testimonial-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Title
        $this->start_controls_section(
            'section_style_testimonial_title',
            [
                'label' => __('Title', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __('Text Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-testimonial-title',
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label'      => __('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => __('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Content
        $this->start_controls_section(
            'section_style_testimonial_style',
            [
                'label' => __('Content', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_content_color',
            [
                'label'     => __('Text Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .elementor-testimonial-content',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'content_border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-testimonial-content',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'content_radius',
            [
                'label'      => __('Border Radius', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-testimonial-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label'      => __('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Name.
        $this->start_controls_section(
            'section_style_testimonial_name',
            [
                'label' => __('Name', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_text_color',
            [
                'label'     => __('Text Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-name, {{WRAPPER}} .elementor-testimonial-name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'name_typography',
                'selector' => '{{WRAPPER}} .elementor-testimonial-name',
            ]
        );

        $this->add_responsive_control(
            'name_padding',
            [
                'label'      => __('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-name' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'name_margin',
            [
                'label'      => __('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Job.
        $this->start_controls_section(
            'section_style_testimonial_job',
            [
                'label' => __('Job', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'job_text_color',
            [
                'label'     => __('Text Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'job_typography',
                'selector' => '{{WRAPPER}} .elementor-testimonial-job',
            ]
        );

        $this->add_responsive_control(
            'job_padding',
            [
                'label'      => __('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-job' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'job_margin',
            [
                'label'      => __('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-job' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //BUTON

        $this->start_controls_section(
            'section_button_style',
            [
                'label'      => __('Button', 'fundor-core'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_responsive_control(
            'button_width',
            [
                'label' => __('Width', 'fundor-core'),
                'type'  => Controls_Manager::SLIDER,

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
                    '{{WRAPPER}} .elementor-testimonial-button a.elementor-button, {{WRAPPER}} .elementor-testimonial-button .elementor-button ' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}} .elementor-testimonial-button a.elementor-button,{{WRAPPER}} .elementor-testimonial-button .elementor-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-testimonial-button .elementor-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-testimonial-button .elementor-button'
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label'      => __('Border Radius', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-button .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label'      => __('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-button .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_margin',
            [
                'label'      => __('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-testimonial-button .elementor-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'label'     => __('Text Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-button .elementor-button:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label'     => __('Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-button .elementor-button:not(:hover)' => 'background-color: {{VALUE}};',
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
                'label'     => __('Text Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-button .elementor-button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label'     => __('Background Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-button .elementor-button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_hover_color',
            [
                'label'     => __('Border Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-button .elementor-button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // Add Carousel Control
        $this->add_control_carousel();

    }

    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['testimonials']) && is_array($settings['testimonials'])) {

            $this->add_render_attribute('wrapper', 'class', 'elementor-testimonial-wrapper');
            if ($settings['testimonial_alignment']) {
                $this->add_render_attribute('wrapper', 'class', 'elementor-testimonial-text-align-' . $settings['testimonial_alignment']);
            }
            // Row
            $this->add_render_attribute('row', 'class', 'row');
            if ($settings['enable_carousel'] === 'yes') {
                $this->add_render_attribute('row', 'class', 'owl-carousel owl-theme');
                $carousel_settings = $this->get_carousel_settings();
                $this->add_render_attribute('row', 'data-settings', wp_json_encode($carousel_settings));
            } else {
                $this->add_render_attribute('row', 'data-elementor-columns', $settings['column']);
                if (!empty($settings['column_tablet'])) {
                    $this->add_render_attribute('row', 'data-elementor-columns-tablet', $settings['column_tablet']);
                }
                if (!empty($settings['column_mobile'])) {
                    $this->add_render_attribute('row', 'data-elementor-columns-mobile', $settings['column_mobile']);
                }
            }

            // Item
            $this->add_render_attribute('item', 'class', 'elementor-testimonial-item');
            $this->add_render_attribute('item', 'class', 'column-item');


            ?>
            <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
                <div <?php echo $this->get_render_attribute_string('row') ?>>
                    <?php foreach ($settings['testimonials'] as $testimonial):

                        ?>
                        <div <?php echo $this->get_render_attribute_string('item'); ?>>

                            <div class="elementor-testimonial-content-wrapper">

                                <?php if ($testimonial['testimonial_title']): ?>
                                    <h2 class="elementor-testimonial-title"><?php echo $testimonial['testimonial_title']; ?></h2>
                                <?php endif; ?>

                                <?php
                                if (!empty($testimonial['testimonial_content'])) {
                                    echo '<div class="elementor-testimonial-content">' . $testimonial['testimonial_content'] . '</div>';
                                }
                                ?>
                                <div class="elementor-testimonial-meta-inner">

                                    <?php $this->render_image($settings, $testimonial); ?>

                                    <div class="elementor-testimonial-details">
                                        <?php
                                        $testimonial_name_html = $testimonial['testimonial_name'];
                                        if (!empty($testimonial['testimonial_link']['url'])) :
                                            $testimonial_name_html = '<a href="' . esc_url($testimonial['testimonial_link']['url']) . '">' . $testimonial_name_html . '</a>';
                                        endif;

                                        if (!empty($testimonial_name_html)) {
                                            echo '<div class="elementor-testimonial-name">' . $testimonial_name_html . '</div>';
                                        }
                                        if (!empty($testimonial['testimonial_job'])) {
                                            echo '<div class="elementor-testimonial-job">' . $testimonial['testimonial_job'] . '</div>';
                                        }
                                        ?>
                                        <?php if (!empty($testimonial['testimonial_button_text']) && $testimonial['show_button']) : ?>
                                            <div class="elementor-testimonial-button elementor-button-outline_primary">
                                                <a class="elementor-button elementor-size-md" href="<?php echo esc_url($testimonial['testimonial_button_link']['url']); ?>" <?php if (!empty($testimonial['testimonial_button_link']['is_external'])) {
                                                    echo 'target="_blank"';
                                                } ?>>
                                                    <span class="elementor-testimonial_button-text"><?php echo $testimonial['testimonial_button_text']; ?></span>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>

                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php
        }
    }

    private function render_image($settings, $testimonial) { ?>
        <div class="elementor-testimonial-image">
            <?php
            $testimonial['testimonial_image_size']             = $settings['testimonial_image_size'];
            $testimonial['testimonial_image_custom_dimension'] = $settings['testimonial_image_custom_dimension'];
            if (!empty($testimonial['testimonial_image']['url'])) :
                $image_html = Group_Control_Image_Size::get_attachment_image_html($testimonial, 'testimonial_image');
                echo $image_html;
            endif;
            ?>
        </div>
        <?php
    }

}

$widgets_manager->register_widget_type(new OSF_Elementor_Testimonials());
