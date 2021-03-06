<?php

namespace Elementor;

use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor counter widget.
 *
 * Elementor widget that displays stats and numbers in an escalating manner.
 *
 * @since 1.0.0
 */
class OSF_Elementor_Counter extends Widget_Counter
{

    /**
     * Get widget name.
     *
     * Retrieve counter widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'counter';
    }

    /**
     * Get widget title.
     *
     * Retrieve counter widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return __('Counter', 'fundor-core');
    }

    /**
     * Get widget icon.
     *
     * Retrieve counter widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon()
    {
        return 'eicon-counter';
    }

    /**
     * Retrieve the list of scripts the counter widget depended on.
     *
     * Used to set scripts dependencies required to run the widget.
     *
     * @return array Widget scripts dependencies.
     * @since  1.3.0
     * @access public
     *
     */
    public function get_script_depends()
    {
        return ['jquery-numerator'];
    }

    /**
     * Register counter widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'section_counter',
            [
                'label' => __('Counter', 'fundor-core'),
            ]
        );

        $this->add_control(
            'starting_number',
            [
                'label' => __('Starting Number', 'fundor-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
            ]
        );

        $this->add_control(
            'ending_number',
            [
                'label' => __('Ending Number', 'fundor-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 100,
            ]
        );

        $this->add_control(
            'prefix',
            [
                'label' => __('Number Prefix', 'fundor-core'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => 1,
            ]
        );

        $this->add_control(
            'suffix',
            [
                'label' => __('Number Suffix', 'fundor-core'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __('Plus', 'fundor-core'),
            ]
        );

        $this->add_control(
            'show_icon',
            [
                'label' => __('Show Icon', 'fundor-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Show', 'fundor-core'),
                'label_off' => __('Hide', 'fundor-core'),
            ]
        );

        $this->add_control(
            'icon_select',
            [
                'label' => __('Icon select', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'use_icon',
                'options' => [
                    'use_icon' => __('Use Icon', 'fundor-core'),
                    'use_image' => __('Use Image', 'fundor-core'),
                ],
                'condition' => [
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => __('Choose Image', 'fundor-core'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'icon_select' => 'use_image',
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'image_size',
            [
                'label' => __(' Size', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter .elementor-icon-counter img, {{WRAPPER}} .elementor-counter .elementor-icon-counter svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_select' => 'use_image',
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => __('Choose Icon', 'fundor-core'),
                'type' => Controls_Manager::ICON,
                'default' => 'fa fa-star',
                'condition' => [
                    'icon_select' => 'use_icon',
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_title_block',
            [
                'label' => __( 'Style Inline', 'fundor-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'Off', 'fundor-core' ),
                'label_on' => __( 'On', 'fundor-core' ),
                'default' => '',
                'condition' => [
                    'show_icon' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter-wrapper' => 'display: inline-flex;align-items: center;',
                ],
            ]
        );

        $this->add_control(
            'duration',
            [
                'label' => __('Animation Duration', 'fundor-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 2000,
                'min' => 100,
                'step' => 100,
            ]
        );

        $this->add_control(
            'thousand_separator',
            [
                'label' => __('Thousand Separator', 'fundor-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'label_on' => __('Show', 'fundor-core'),
                'label_off' => __('Hide', 'fundor-core'),
            ]
        );

        $this->add_control(
            'thousand_separator_char',
            [
                'label' => __('Separator', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
                'condition' => [
                    'thousand_separator' => 'yes',
                ],
                'options' => [
                    '' => 'Default',
                    '.' => 'Dot',
                    ' ' => 'Space',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', 'fundor-core'),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'default' => __('Cool Number', 'fundor-core'),
                'placeholder' => __('Cool Number', 'fundor-core'),
            ]
        );

        $this->add_control(
            'show_decor',
            [
                'label' => __('Show Decor', 'fundor-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => __('Description', 'fundor-core'),
                'type' => Controls_Manager::TEXTAREA,
                'label_block' => true,
                'placeholder' => __('Description...', 'fundor-core'),
            ]
        );

        $this->add_responsive_control(
            'position',
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
                    ]
                ],
                'toggle' => false,
                'prefix_class' => 'elementor-position-',
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter' => 'text-align: {{VALUE}}',
                ],
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

        //number
        $this->start_controls_section(

            'section_number',
            [
                'label' => __('Number', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => __('Text Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter-number' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .heading-decor' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_number',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-counter-number',
            ]
        );

        $this->add_responsive_control(
            'spacing_number_wrapper',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter-number-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //number prefix
        $this->start_controls_section(

            'section_number_prefix',
            [
                'label' => __('Number Prefix', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'number_prefix_color',
            [
                'label' => __('Text Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter-number-prefix' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_number_prefix',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-counter-number-prefix',
            ]
        );

        $this->add_responsive_control(
            'spacing_number_prefix',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter-number-prefix' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //number suffix
        $this->start_controls_section(

            'section_number_suffix',
            [
                'label' => __('Number Suffix', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'number_suffix_color',
            [
                'label' => __('Text Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter-number-suffix' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_number_suffix',
                'scheme' => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-counter-number-suffix',
            ]
        );

        $this->add_responsive_control(
            'spacing_number_suffix',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter-number-suffix' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //title
        $this->start_controls_section(
            'section_title',
            [
                'label' => __('Title', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'title!' => '',
                ]
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __('Text Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_title',
                'selector' => '{{WRAPPER}} .elementor-counter-title',
            ]
        );

        $this->add_responsive_control(
            'spacing_title',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
                    '{{WRAPPER}} .heading-decor' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'decor_bg_color',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .heading-decor' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'decor_spacing',
            [
                'label'     => __('Margin', 'fundor-core'),
                'type'      => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .heading-decor' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        //description
        $this->start_controls_section(
            'section_description',
            [
                'label' => __('Description', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'description!' => '',
                ]
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Text Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-counter-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_description',
                'selector' => '{{WRAPPER}} .elementor-counter-description',
            ]
        );

        $this->end_controls_section();

        //icon
        $this->start_controls_section(
            'section_icon',
            [
                'label' => __('Icon', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon_select' => 'use_icon',
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-counter' => 'color: {{VALUE}};',
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
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-counter' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_counter_margin',
            [
                'label' => __( 'Margin', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-counter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //image
        $this->start_controls_section(
            'section_image',
            [
                'label' => __('Image & SVG', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'icon_select' => 'use_image',
                    'show_icon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'svg_color',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-counter svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_counter_margin',
            [
                'label' => __( 'Margin', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-counter' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render counter widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _content_template()
    {
        return;
    }

    /**
     * Render counter widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $has_icon = !empty($settings['icon']);

        if ($has_icon) {
            $this->add_render_attribute('icon', 'class', $settings['icon']);
            $this->add_render_attribute('icon', 'aria-hidden', 'true');
        }

        $this->add_render_attribute('counter', [
            'class' => 'elementor-counter-number',
            'data-duration' => $settings['duration'],
            'data-to-value' => $settings['ending_number'],
        ]);

        if (!empty($settings['thousand_separator'])) {
            $delimiter = empty($settings['thousand_separator_char']) ? ',' : $settings['thousand_separator_char'];
            $this->add_render_attribute('counter', 'data-delimiter', $delimiter);
        }
        ?>
        <div class="elementor-counter">
            <div class="elementor-counter-wrapper">
                <?php $this->get_image_icon(); ?>
                <div class="elementor-counter-number-wrapper">
                    <span class="elementor-counter-number-prefix"><?php echo $settings['prefix']; ?></span>
                    <span <?php echo $this->get_render_attribute_string('counter'); ?>><?php echo $settings['starting_number']; ?></span>
                    <span class="elementor-counter-number-suffix"><?php echo $settings['suffix']; ?></span>
                </div>
            </div>
            <div class="elementor-counter-title-wrap">
                <?php if ($settings['title']) : ?>
                    <div class="elementor-counter-title"><?php echo $settings['title']; ?></div>
                <?php endif; ?>
                <?php
                if ($settings['show_decor'] == 'yes') { ?>
                    <span class="heading-decor"></span>
                    <?php
                }
                ?>
                <?php if ($settings['description']) : ?>
                    <div class="elementor-counter-description"><?php echo $settings['description']; ?></div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    private function get_image_icon()
    {
        $settings = $this->get_settings_for_display();
        if ('yes' === $settings['show_icon']):
            ?>
            <div class="elementor-icon-counter">
                <?php if ('use_image' === $settings['icon_select'] && !empty($settings['image']['url'])) :
                    $image_url = '';
                    $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, '', 'image');
                    $image_url = $settings['image']['url'];
                    $path_parts = pathinfo($image_url);
                    if ($path_parts['extension'] === 'svg') {
                        $image = $this->get_settings_for_display('image');
                        $pathSvg = get_attached_file($image['id']);
                        $image_html = osf_get_icon_svg($pathSvg);
                    }
                    echo $image_html;
                    ?>
                <?php elseif ('use_icon' === $settings['icon_select'] && !empty($settings['icon'])) : ?>
                    <i <?php echo $this->get_render_attribute_string('icon'); ?>></i>
                <?php endif; ?>
            </div>
        <?php
        endif;
    }
}

$widgets_manager->register_widget_type(new OSF_Elementor_Counter());
