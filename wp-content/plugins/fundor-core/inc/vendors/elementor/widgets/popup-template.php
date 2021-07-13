<?php

use Elementor\Group_Control_Css_Filter;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

class OSF_Elementor_Popup_Template extends Elementor\Widget_Base{

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
    public function get_name()
    {
        return 'opal-popup-template';
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
    public function get_title()
    {
        return __('Opal Popup Template', 'fundor-core');
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
    public function get_icon()
    {
        return 'eicon-document-file';
    }

    public function get_categories()
    {
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
    protected function _register_controls()
    {

        $templates = Elementor\Plugin::instance()->templates_manager->get_source('local')->get_items();

        $options = [
            '0' => '— ' . __('Select', 'fundor-core') . ' —',
        ];

        $types = [];

        foreach ($templates as $template) {
            $options[$template['template_id']] = $template['title'] . ' (' . $template['type'] . ')';
            $types[$template['template_id']] = $template['type'];
        }


        $this->start_controls_section(
            'section_popup_template',
            [
                'label' => __('Popup Template', 'fundor-core'),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __( 'Icon', 'fundor-core' ),
                'type' => Controls_Manager::ICON,
                'label_block' => true,
                'default' => 'opal-icon-bars',
            ]
        );

        $this->add_control(
            'tab_template',
            [
                'label' => __('Choose Template', 'fundor-core'),
                'default' => 0,
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'types' => $types,
                'label_block' => 'true',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', 'fundor-core' ),
                'type' => Controls_Manager::CHOOSE,
                'default' => 'right',
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
                    '{{WRAPPER}} .elementor-toggle' => 'text-align: {{VALUE}};',
                ],
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => __('View', 'fundor-core'),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );


        $this->end_controls_section();

        // Wrapper
        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => __('Wrapper', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wrapper_bgcolor',
            [
                'label' => __( 'Background Wrapper', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-popup-template-meta' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'overlay_bgcolor',
            [
                'label' => __( 'Background Overlay', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-popup-overlay' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_size',
            [
                'label' => __( 'Width', 'fundor-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-popup-template-meta' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-popup-template-meta',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'wrapper_border_radius',
            [
                'label' => __( 'Border Radius', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-popup-template-meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-popup-template-meta',
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => __( 'Padding', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-popup-template-meta-inner >*:not(.button-close)' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Icon
        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => __('Icon', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_size',
            [
                'label' => __( 'Size', 'fundor-core' ),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-toggle i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __( 'Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-toggle i:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_color_hover',
            [
                'label' => __( 'Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-toggle i:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute('wrapper', 'class', 'elementor-popup-template-wrapper');

        // Item
        $this->add_render_attribute('item', 'class', 'elementor-popup-template-item');

        $this->add_render_attribute('meta', 'class', 'elementor-popup-template-meta');

        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <div <?php echo $this->get_render_attribute_string('item'); ?>>
                <div class="elementor-toggle">
                    <i class="<?php echo esc_attr( $settings['icon'] ); ?>" aria-hidden="true"></i>
                </div>
                <div <?php echo $this->get_render_attribute_string('meta'); ?>>
                    <div class="elementor-popup-template-meta-inner">
                        <i class="opal-icon-close button-close" aria-hidden="true"></i>
                        <?php echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display($settings['tab_template']); ?>
                    </div>
                </div>
                <div class="elementor-popup-overlay"></div>
            </div>
        </div>
        <?php
    }

}

$widgets_manager->register_widget_type(new OSF_Elementor_Popup_Template());
