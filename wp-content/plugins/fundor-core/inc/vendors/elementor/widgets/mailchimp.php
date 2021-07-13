<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

if (!osf_is_mailchimp_activated()) {
    return;
}

use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Controls_Manager;


class OSF_Elementor_Mailchimp extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-mailchmip';
    }

    public function get_title() {
        return __( 'MailChimp Sign-Up Form', 'fundor-core' );
    }

    public function get_categories() {
        return array( 'opal-addons' );
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_script_depends() {
        return [ 'magnific-popup' ];
    }

    public function get_style_depends() {
        return [ 'magnific-popup' ];
    }


    protected function _register_controls() {
        $this->start_controls_section(
            'mailchmip',
            [
                'label' => __( 'General', 'fundor-core' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'hide_text',
            [
                'label'        => __( 'Hide Text', 'fundor-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_off'    => __( 'Off', 'fundor-core' ),
                'label_on'     => __( 'On', 'fundor-core' ),
                'default'      => '',
                'return_value' => 'none',
                'selectors'    => [
                    '{{WRAPPER}} .mc4wp-form-fields span' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'hide_icon',
            [
                'label'        => __( 'Hide Icon', 'fundor-core' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_off'    => __( 'Off', 'fundor-core' ),
                'label_on'     => __( 'On', 'fundor-core' ),
                'default'      => '',
                'return_value' => 'none',
                'selectors'    => [
                    '{{WRAPPER}} .mc4wp-form-fields i' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'spacing_icon',
            [
                'label'     => __( 'Icon Spacing', 'fundor-core' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields i' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'setting_mailchmip',
            [
                'label' => __( 'Setting', 'fundor-core' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_responsive_control(
            'setting_block',
            [
                'label'     => __( 'Layout', 'fundor-core' ),
                'type'      => Controls_Manager::SELECT,
                'default' => 'row',
                'options'      => [
                    'row'         => __('Horizontal', 'fundor-core'),
                    'column'           => __('Vertical', 'fundor-core'),
                ],
                'prefix_class' => 'mailchimp-layout-',
                'selectors'  => [
                    '{{WRAPPER}} .mc4wp-form-fields' => '    flex-direction: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'width_form',
            [
                'label'      => __( 'Form Width', 'fundor-core' ),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'size' => 100,
                    'unit' => '%'
                ],
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .mc4wp-form-fields' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'align_form',
            [
                'label'     => __( 'Alignment', 'fundor-core' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => __( 'Left', 'fundor-core' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'     => [
                        'title' => __( 'Center', 'fundor-core' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'flex-end'   => [
                        'title' => __( 'Right', 'fundor-core' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors'  => [
                    '{{WRAPPER}} .mc4wp-form' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        //wrapper style
        $this->start_controls_section(
            'mailchip_style_wrapper',
            [
                'label' => __( 'Wrapper', 'fundor-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'mailchimp_wrapper_bkg',
            [
                'label'     => __('Background color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_wrapper_style' );

        $this->start_controls_tab(
            'tab_wrapper_normal',
            [
                'label' => __( 'Normal', 'fundor-core' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_wrapper',
                'selector'    => '{{WRAPPER}} .mc4wp-form-fields:not(:focus-within)',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_wrapper_focus',
            [
                'label' => __( 'Focus', 'fundor-core' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_wrapper_focus',
                'selector'    => '{{WRAPPER}} .mc4wp-form-fields:focus-within',
            ]
        );

        $this->end_controls_tab();

        $this->add_responsive_control(
            'border-radius_wrapper',
            [
                'label'     => __( 'Border Radius', 'fundor-core' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'size_units'    => ['px','%'],
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before'
            ]
        );

        $this->end_controls_tabs();

        $this->end_controls_section();

        //INPUT
        $this->start_controls_section(
            'mailchip_style_input',
            [
                'label' => __( 'Input', 'fundor-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'tabs_input_style' );

        $this->start_controls_tab(
            'tab_input_normal',
            [
                'label' => __( 'Normal', 'fundor-core' ),
            ]
        );


        $this->add_control(
            'input_background',
            [
                'label'     => __( 'Background Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label'     => __( 'Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'placeholder_color',
            [
                'label'     => __( 'Placeholder Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields ::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form-fields ::-moz-placeholder'          => 'color: {{VALUE}};',
                    '{{WRAPPER}} .mc4wp-form-fields ::-ms-input-placeholder'     => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_input_focus',
            [
                'label' => __( 'Focus', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'input_background_focus',
            [
                'label'     => __( 'Background Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_border_color_focus',
            [
                'label'     => __( 'Border Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'align_input',
            [
                'label'     => __( 'Alignment', 'fundor-core' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __( 'Left', 'fundor-core' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'fundor-core' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'right'  => [
                        'title' => __( 'Right', 'fundor-core' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(

            Group_Control_Border::get_type(),
            [
                'name'        => 'border_input',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .mc4wp-form-fields input[type="email"]',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'input_border_radius',
            [
                'label'      => __( 'Border Radius', 'fundor-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label'      => __( 'Padding', 'fundor-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .mc4wp-form-fields input[type="email"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'spacing_input',
            [
                'label'     => __( 'Margin', 'fundor-core' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Button
        $this->start_controls_section(
            'mailchip_style_button',
            [
                'label' => __( 'Button', 'fundor-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'width_button',
            [
                'label'      => __( 'Width', 'fundor-core' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .mc4wp-form-fields button' => 'min-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label' => __( 'Type', 'fundor-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options'      => [
                    'default'           => __('Deafault', 'fundor-core'),
                    'primary'           => __('Primary', 'fundor-core'),
                    'secondary'         => __('Secondary', 'fundor-core'),
                    'outline_primary'   => __('Outline Primary', 'fundor-core'),
                    'outline_secondary' => __('Outline Secondary', 'fundor-core'),
                    'outline_dark'      => __('Outline Dark', 'fundor-core'),
                    'dark' => __('Dark', 'fundor-core'),
                    'light' => __('Light', 'fundor-core'),
                    'link' => __('Link', 'fundor-core'),
                ],
                'prefix_class' => 'mailchimp-button-',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'selector' => '{{WRAPPER}} .mc4wp-form-fields button[type="submit"]',
            ]
        );


        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __( 'Normal', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'button_bacground',
            [
                'label'     => __( 'Background Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields button[type="submit"]' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label'     => __( 'Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields button[type="submit"]:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __( 'Hover', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'button_bacground_hover',
            [
                'label'     => __( 'Background Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields button[type="submit"]:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label'     => __( 'Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields button[type="submit"]:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_hover',
            [
                'label'     => __( 'Border Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields button[type="submit"]:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_focus',
            [
                'label' => __( 'Focus', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'button_bacground_focus',
            [
                'label'     => __( 'Background Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields button[type="submit"]:forcus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color_focus',
            [
                'label'     => __( 'Button Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields button[type="submit"]:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_focus',
            [
                'label'     => __( 'Border Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .mc4wp-form-fields button[type="submit"]:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_button',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .mc4wp-form-fields button[type="submit"]',
                'separator'   => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label'      => __( 'Border Radius', 'fundor-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .mc4wp-form-fields button[type="submit"]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label'      => __( 'Padding', 'fundor-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .mc4wp-form-fields button[type="submit"]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_align_vertical',
            [
                'label'     => __( 'Alignment', 'fundor-core' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => __( 'Left', 'fundor-core' ),
                        'icon'  => 'fa fa-align-left',
                    ],
                    'center'     => [
                        'title' => __( 'Center', 'fundor-core' ),
                        'icon'  => 'fa fa-align-center',
                    ],
                    'flex-end'   => [
                        'title' => __( 'Right', 'fundor-core' ),
                        'icon'  => 'fa fa-align-right',
                    ],
                ],
                'default'   => 'stretch',
                'selectors'  => [
                    '{{WRAPPER}} .mc4wp-form-fields' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_style',
            [
                'label'     => __('Icon', 'fundor-core'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before'
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label'     => __( 'Size', 'fundor-core' ),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} button[type="submit"] i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => __( 'Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button[type="submit"] i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label'     => __( 'Color Hover', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button[type="submit"]:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label'     => __( 'Margin', 'fundor-core' ),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} button[type="submit"] i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        echo '<div class="form-style">';
        mc4wp_show_form();
        echo '</div>';
    }
}
$widgets_manager->register_widget_type(new OSF_Elementor_Mailchimp());