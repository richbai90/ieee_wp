<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!osf_is_contactform7_activated()) {
    return;
}
use Elementor\Controls_Manager;
//use ElementorExtra\Module;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;

class OSF_Elementor_ContactForm7 extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-contactform7';
    }

    public function get_title() {
        return __('Opal Contact Form', 'fundor-core');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_icon() {
        return 'eicon-form-horizontal';
    }

    public function get_script_depends() {
        return ['magnific-popup'];
    }

    public function get_style_depends() {
        return ['magnific-popup'];
    }


    protected function _register_controls() {
        $this->start_controls_section(
            'contactform7',
            [
                'label' => __('General', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $cf7 = get_posts('post_type="wpcf7_contact_form"&numberposts=-1');
        $contact_forms[''] = __('Please select form', 'fundor-core');
        if ($cf7) {
            foreach ($cf7 as $cform) {
                $contact_forms[$cform->ID] = $cform->post_title;
            }
        } else {
            $contact_forms[0] = __('No contact forms found', 'fundor-core');
        }

        $this->add_control(
            'cf_id',
            [
                'label'   => __('Select contact form', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => $contact_forms,
                'default' => ''
            ]
        );

        $this->add_control(
            'form_name',
            [
                'label'   => __('Form name', 'fundor-core'),
                'type'    => Controls_Manager::TEXT,
                'default' => __('Contact form', 'fundor-core'),
            ]
        );
        $this->end_controls_section();


        //WRAPPER
        $this->start_controls_section(
            'section_wrapper_style',
            [
                'label' => __( 'Wrapper', 'fundor-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'show_animation_wrapper',
            [
                'label'        => __('Show Before', 'fundor-core'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'prefix_class' => 'elementor-show-before-',
            ]
        );

        $this->add_control(
            'wrapper_bgcolor',
            [
                'label' => __( 'Background Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_wrapper',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .wpcf7',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'wrapper_border_radius',
            [
                'label'      => __( 'Border Radius', 'fundor-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label'      => __( 'Padding', 'fundor-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //LABEL
        $this->start_controls_section(
            'section_label_style',
            [
                'label' => __( 'Label', 'fundor-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'label_typography',
                'selector' => '{{WRAPPER}} .wpcf7 .wpcf7-form label,{{WRAPPER}} .wpcf7 .wpcf7-form .wpcf7-list-item-label',
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => __( 'Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form label ,{{WRAPPER}} .wpcf7 .wpcf7-form .wpcf7-list-item-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'label_align',
            [
                'label' => __( 'Alignment', 'fundor-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __( 'Left', 'fundor-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'fundor-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'fundor-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form label ,{{WRAPPER}} .wpcf7 .wpcf7-form .wpcf7-list-item-label' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'label_margin',
            [
                'label' => __( 'Margin', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form label ,{{WRAPPER}} .wpcf7 .wpcf7-form .wpcf7-list-item-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        //INPUT
        $this->start_controls_section(
            'section_input_style',
            [
                'label' => __( 'Input', 'fundor-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'input_size',
            [
                'label' => __( 'Input Height', 'fundor-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input:not([type="submit"])' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'area_size',
            [
                'label' => __( 'Textarea Height', 'fundor-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form textarea' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'input_typography',
                'selector' => '{{WRAPPER}} .wpcf7 .wpcf7-form input:not([type="submit"]), {{WRAPPER}} .wpcf7-form textarea',
            ]
        );

        $this->add_control(
            'input_color_placeholder',
            [
                'label' => __( 'Placeholder Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input::placeholder, {{WRAPPER}} .wpcf7-form textarea::placeholder' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label' => __( 'Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input:not([type="submit"]), {{WRAPPER}} .wpcf7-form textarea' => 'color: {{VALUE}};',
                ],
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
            'input_background_color',
            [
                'label' => __( 'Background Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input:not([type="submit"]), {{WRAPPER}} .wpcf7-form textarea' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_input_hover',
            [
                'label' => __( 'Hover', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'input_background_color_hover',
            [
                'label' => __( 'Background Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input:not([type="submit"]):hover, {{WRAPPER}} .wpcf7-form textarea:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_border_bottom_color_hover',
            [
                'label' => __( 'Border Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input:not([type="submit"]):hover, {{WRAPPER}} .wpcf7-form textarea:hover' => 'border-color: {{VALUE}};',
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
            'input_background_color_focus',
            [
                'label' => __( 'Background Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input:not([type="submit"]):focus, {{WRAPPER}} .wpcf7-form textarea:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_border_bottom_color_focus',
            [
                'label' => __( 'Border Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input:not([type="submit"]):focus, {{WRAPPER}} .wpcf7-form textarea:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_input',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .wpcf7 .wpcf7-form input:not([type="submit"]), {{WRAPPER}} .wpcf7-form textarea',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label'      => __( 'Border Radius', 'fundor-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input:not([type="submit"]), {{WRAPPER}} .wpcf7-form textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input:not([type="submit"]), {{WRAPPER}} .wpcf7-form textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'input_margin',
            [
                'label'      => __( 'Margin', 'fundor-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input:not([type="submit"]), {{WRAPPER}} .wpcf7-form textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //VALID

        $this->start_controls_section(
            'section_valid_style',
            [
                'label' => __( 'Valid', 'fundor-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'valid_color',
            [
                'label' => __( 'Text Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form .wpcf7-not-valid-tip ' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'valid_typography',
                'selector' => '{{WRAPPER}} .wpcf7 .wpcf7-form .wpcf7-not-valid-tip ',
            ]
        );

        $this->add_responsive_control(
            'valid_margin',
            [
                'label' => __( 'Margin', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form .wpcf7-not-valid-tip' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //SELECT

        $this->start_controls_section(
            'section_seclect_style',
            [
                'label' => __( 'Select', 'fundor-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'select_size',
            [
                'label' => __( 'Height', 'fundor-core' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 select' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'select_typography',
                'selector' => '{{WRAPPER}} .wpcf7 select',
            ]
        );

        $this->start_controls_tabs( 'tabs_select_style' );

        $this->start_controls_tab(
            'tab_select_normal',
            [
                'label' => __( 'Normal', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'select_text_color',
            [
                'label' => __( 'Text Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 select' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'select_bg_color',
            [
                'label' => __( 'Background Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 select' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_select_hover',
            [
                'label' => __( 'Hover', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'select_text_hover_color',
            [
                'label' => __( 'Text Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 select:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'select_bg_color_hover',
            [
                'label' => __( 'Background Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 select:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'select_bd_color_hover',
            [
                'label' => __( 'Border Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 select:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_select_focus',
            [
                'label' => __( 'Focus', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'select_text_focus_color',
            [
                'label' => __( 'Text Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 select:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'select_bg_color_focus',
            [
                'label' => __( 'Background Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 select:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'select_bd_color_focus',
            [
                'label' => __( 'Border Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 select:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border_select',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .wpcf7 select',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'select_border_radius',
            [
                'label'      => __('Border Radius', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .wpcf7 select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'select_padding',
            [
                'label' => __( 'Padding', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'select_margin',
            [
                'label' => __( 'Margin', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 select' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //BUTTON

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => __( 'Button', 'fundor-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label'        => __('Type', 'fundor-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'primary',
                'options'      => [
                    'primary_gradient' => __('Primary Gradient', 'fundor-core'),
                    'primary'           => __('Primary', 'fundor-core'),
                    'secondary'         => __('Secondary', 'fundor-core'),
                    'outline_primary'   => __('Outline Primary', 'fundor-core'),
                    'outline_secondary' => __('Outline Secondary', 'fundor-core'),
                ],
                'prefix_class' => 'elementor-wpcf7-button-',
            ]
        );

        $this->add_control(
            'button_size',
            [
                'label'        => __('Size', 'fundor-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'md',
                'options'      => [
                    'xs'                  => __('Extra Small', 'fundor-core'),
                    'sm'           => __('Small', 'fundor-core'),
                    'md'         => __('Medium', 'fundor-core'),
                    'lg'   => __('Large', 'fundor-core'),
                    'xl' => __('Extra Large', 'fundor-core'),
                ],
                'prefix_class' => 'elementor-wpcf7-button-',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .wpcf7 .wpcf7-form input[type="submit"], {{WRAPPER}} button',
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
            'button_text_color',
            [
                'label' => __( 'Text Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input[type="submit"]:not(:hover), {{WRAPPER}} button:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'background_color',
            [
                'label' => __( 'Background Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input[type="submit"]:not(:hover), {{WRAPPER}} button:not(:hover)' => 'background-color: {{VALUE}};',
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
            'hover_color',
            [
                'label' => __( 'Text Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input[type="submit"]:hover, {{WRAPPER}} button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => __( 'Background Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input[type="submit"]:hover, {{WRAPPER}} button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_border_color',
            [
                'label' => __( 'Border Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'border_border!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input[type="submit"]:hover, {{WRAPPER}} button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .wpcf7 .wpcf7-form input[type="submit"], {{WRAPPER}} button',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __( 'Border Radius', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7 .wpcf7-form input[type="submit"], {{WRAPPER}} button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .wpcf7 .wpcf7-form input[type="submit"], {{WRAPPER}} button',
            ]
        );
        $this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', 'fundor-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left'    => [
                        'title' => __( 'Left', 'fundor-core' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'fundor-core' ),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'fundor-core' ),
                        'icon' => 'fa fa-align-right',
                    ],
                    'justify' => [
                        'title' => __( 'Justified', 'fundor-core' ),
                        'icon' => 'fa fa-align-justify',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
                'default' => '',
            ]
        );
        $this->add_responsive_control(
            'text_padding',
            [
                'label' => __( 'Padding', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} input[type="submit"],{{WRAPPER}} button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_margin',
            [
                'label' => __( 'Margin', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} input[type="submit"],{{WRAPPER}} button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        if(!$settings['cf_id']){
            return;
        }
        $args['id']    = $settings['cf_id'];
        $args['title'] = $settings['form_name'];

        echo osf_do_shortcode('contact-form-7', $args);
    }
}
$widgets_manager->register_widget_type(new OSF_Elementor_ContactForm7());