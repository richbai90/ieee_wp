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

class OSF_Elementor_Featured_Box extends OSF_Elementor_Carousel_Base
{

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
        return 'opal-featured-box';
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
        return __('Opal Featuerd Box', 'fundor-core');
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
        return 'eicon-image-box';
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
        $this->start_controls_section(
            'section_featured_box',
            [
                'label' => __('Featured Box', 'fundor-core'),
            ]
        );

        $repeater = new Elementor\Repeater();

        $repeater->add_control(
            'featured',
            [
                'label' => __('Featured Box Item', 'fundor-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => __('Image', 'fundor-core'),
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type' => Controls_Manager::MEDIA,
                'show_label' => false,
            ]
        );

        $repeater->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
                'default' => 'full',
                'separator' => 'none',
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => __('Name', 'fundor-core'),
                'default' => 'Talks and workshops',
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => __('Description', 'fundor-core'),
                'default' => 'Fundor hosts 4 stages of content, and running workshops and programming simultaneously covering everything startups, digital media, fintech, and future tech.',
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $repeater->add_control(
            'view',
            [
                'label' => __('View', 'fundor-core'),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __('Link to', 'fundor-core'),
                'placeholder' => __('https://your-link.com', 'fundor-core'),
                'default' => [
                    'url' => '#',
                ],
                'type' => Controls_Manager::URL,
            ]
        );

        $this->add_control(
            'featured_box_items',
            [
                'label' => __('Featured Box Items', 'fundor-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
            ]
        );


        $this->add_responsive_control(
            'columns',
            [
                'label' => __('Columns', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_responsive_control(
            'gutter',
            [
                'label' => __('Gutter', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .column-item' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2);',
                    '{{WRAPPER}} .elementor-featured-box-wrapper' => 'margin-left: calc({{SIZE}}{{UNIT}} / -2); margin-right: calc({{SIZE}}{{UNIT}} / -2);',
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
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
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} ' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Carousel Option
        $this->add_control_carousel();

        // Wrapper
        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => __('Wrapper', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'wrapper_color',
            [
                'label' => __('Background Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-content' => 'background-color: {{VALUE}};',
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
                    '{{WRAPPER}} .elementor-featured-box-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Image
        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __('Image', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_space',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}}  .elementor-item-box-image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Name
        $this->start_controls_section(
            'section_style_name',
            [
                'label' => __('Name', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_name',
                'selector' => '{{WRAPPER}} .elementor-featured-box-name',
            ]
        );

        $this->start_controls_tabs('tabs_name_style');

        $this->start_controls_tab(
            'tab_name_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-name:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_name_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'name_color_hover',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-name:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        // Description
        $this->start_controls_section(
            'section_style_description',
            [
                'label' => __('Description', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography_description',
                'selector' => '{{WRAPPER}} .elementor-featured-box-description',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-featured-box-description' => 'color: {{VALUE}};',
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

        $this->add_render_attribute('wrapper', 'class', 'elementor-featured-box-wrapper');


        // Item
        $this->add_render_attribute('item', 'class', 'elementor-featured-box-item');
        $this->add_render_attribute('item', 'class', 'column-item');

        $this->add_render_attribute('meta', 'class', 'elementor-featured-box-meta');

        $this->add_render_attribute('row', 'class', 'row');

//        class carousel
        if ($settings['enable_carousel'] === 'yes') {
            $this->add_render_attribute('row', 'class', 'owl-carousel owl-theme');
            $carousel_settings = array(
                'navigation' => $settings['navigation'],
                'autoplayHoverPause' => $settings['pause_on_hover'] === 'yes' ? 'true' : 'false',
                'autoplay' => $settings['autoplay'] === 'yes' ? 'true' : 'false',
                'autoplayTimeout' => $settings['autoplay_speed'],
                'items' => $settings['columns'],
                'items_tablet' => $settings['columns_tablet'],
                'items_mobile' => $settings['columns_mobile'],
                'loop' => $settings['infinite'] === 'yes' ? 'true' : 'false',

            );
            $this->add_render_attribute('row', 'data-settings', wp_json_encode($carousel_settings));
        } else {
            if (!empty($settings['columns'])) {
                $this->add_render_attribute('row', 'data-elementor-columns', $settings['columns']);
            }

            if (!empty($settings['columns_tablet'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-tablet', $settings['columns_tablet']);
            }
            if (!empty($settings['columns_mobile'])) {
                $this->add_render_attribute('row', 'data-elementor-columns-mobile', $settings['columns_mobile']);
            }
        }

        ?>
        <div <?php echo $this->get_render_attribute_string('wrapper'); ?>>
            <div <?php echo $this->get_render_attribute_string('row') ?>>
                <?php foreach ($settings['featured_box_items'] as $index => $item) : ?>
                    <div <?php echo $this->get_render_attribute_string('item'); ?>>
                        <?php $this->render_style($item,$settings) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    protected function render_style($settings)
    { ?>
        <div class="elementor-featured-box-meta-inner">
            <div class="elementor-featured-box-meta-item">
                <div class="elementor-item-box-image">
                    <?php
                    if (!empty($settings['image']['url'])) :
                        $image_html = Group_Control_Image_Size::get_attachment_image_html($settings, 'image', 'image');
                        echo $image_html;
                    endif;
                    ?>
                </div>
                <div class="elementor-featured-box-content">
                    <?php
                    $featured_box_name_html = $settings['name'];
                    if (!empty($settings['link']['url'])) :
                        $featured_box_name_html = '<a href="' . esc_url($settings['link']['url']) . '">' . $featured_box_name_html . '</a>';
                    endif;

                    $featured_box_description_html = $settings['description'];
                    ?>
                    <div class="elementor-featured-box-name"><?php echo $featured_box_name_html; ?></div>
                    <div class="elementor-featured-box-description"><?php echo $featured_box_description_html; ?></div>

                </div>
            </div>
        </div>

        <?php
    }

}

$widgets_manager->register_widget_type(new OSF_Elementor_Featured_Box());
