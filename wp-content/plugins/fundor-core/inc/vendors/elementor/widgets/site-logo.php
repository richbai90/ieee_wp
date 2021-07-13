<?php

use Elementor\Widget_Image;
use Elementor\Plugin;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Css_Filter;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

class OSF_Element_Site_Logo extends Widget_Image {

    public function get_name() {
        // `theme` prefix is to avoid conflicts with a dynamic-tag with same name.
        return 'opal-site-logo';
    }

    public function get_title() {
        return __( 'Opal Site Logo', 'fundor-core' );
    }

    public function get_icon() {
        return 'eicon-site-logo';
    }

    public function get_categories() {
        return [ 'opal-addons' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_extra',
            [
                'label' => __( 'Logo Site', 'fundor-core' ),
            ]
        );
        $this->add_control(
            'logo_select',
            [
                'label' => __( 'Image from', 'fundor-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'site_logo',
                'options' => [
                    'site_logo' => __( 'Use Site Logo', 'fundor-core' ),
                    'customize' => __( 'Custom Logo', 'fundor-core' ),
                ]
            ]
        );

        $this->add_control(
            'image_logo',
            [
                'label' => __( 'Choose Image', 'fundor-core' ),
                'type' => Controls_Manager::MEDIA,
                'dynamic' => [
                    'active' => true,
                ],
                'default' => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'logo_select' => 'customize'
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_image',
            [
                'label' => __( 'Image', 'fundor-core' ),
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
                'default' => 'full',
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label' => __( 'Alignment', 'fundor-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
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
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'caption_source',
            [
                'label' => __( 'Caption', 'fundor-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => __( 'None', 'fundor-core' ),
                    'attachment' => __( 'Attachment Caption', 'fundor-core' ),
                    'custom' => __( 'Custom Caption', 'fundor-core' ),
                ],
                'default' => 'none',
            ]
        );

        $this->add_control(
            'caption',
            [
                'label' => __( 'Custom Caption', 'fundor-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => __( 'Enter your image caption', 'fundor-core' ),
                'condition' => [
                    'caption_source' => 'custom',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->add_control(
            'link_to',
            [
                'label' => __( 'Link', 'fundor-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'custom',
                'options' => [
                    'none' => __( 'None', 'fundor-core' ),
                    'file' => __( 'Media File', 'fundor-core' ),
                    'custom' => __( 'Custom URL', 'fundor-core' ),
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __( 'Link', 'fundor-core' ),
                'type' => Controls_Manager::URL,
                'dynamic' => [
                    'active' => true,
                ],
                'placeholder' => site_url(),
                'condition' => [
                    'link_to' => 'custom',
                ],
                'show_label' => false,
            ]
        );

        $this->add_control(
            'open_lightbox',
            [
                'label' => __( 'Lightbox', 'fundor-core' ),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __( 'Default', 'fundor-core' ),
                    'yes' => __( 'Yes', 'fundor-core' ),
                    'no' => __( 'No', 'fundor-core' ),
                ],
                'condition' => [
                    'link_to' => 'file',
                ],
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => __( 'View', 'fundor-core' ),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_image',
            [
                'label' => __( 'Image', 'fundor-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => __( 'Width', 'fundor-core' ),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => [ '%', 'px', 'vw' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img,
                    {{WRAPPER}} .elementor-image>a img[src$=".svg"],
                    {{WRAPPER}} .elementor-image> img[src$=".svg"],
                    {{WRAPPER}} .elementor-image figure>a img[src$=".svg"]' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'separator_panel_style',
            [
                'type' => Controls_Manager::DIVIDER,
                'style' => 'thick',
            ]
        );

        $this->start_controls_tabs( 'image_effects' );

        $this->start_controls_tab( 'normal',
            [
                'label' => __( 'Normal', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'opacity',
            [
                'label' => __( 'Opacity', 'fundor-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters',
                'selector' => '{{WRAPPER}} .elementor-image img',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab( 'hover',
            [
                'label' => __( 'Hover', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'opacity_hover',
            [
                'label' => __( 'Opacity', 'fundor-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image:hover img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'css_filters_hover',
                'selector' => '{{WRAPPER}} .elementor-image:hover img',
            ]
        );

        $this->add_control(
            'background_hover_transition',
            [
                'label' => __( 'Transition Duration', 'fundor-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $this->add_control(
            'hover_animation',
            [
                'label' => __( 'Hover Animation', 'fundor-core' ),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .elementor-image img',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => __( 'Border Radius', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'exclude' => [
                    'box_shadow_position',
                ],
                'selector' => '{{WRAPPER}} .elementor-image img',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style_caption',
            [
                'label' => __( 'Caption', 'fundor-core' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'caption_source!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'caption_align',
            [
                'label' => __( 'Alignment', 'fundor-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
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
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .widget-image-caption' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Text Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .widget-image-caption' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
            ]
        );

        $this->add_control(
            'caption_background_color',
            [
                'label' => __( 'Background Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .widget-image-caption' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'caption_typography',
                'selector' => '{{WRAPPER}} .widget-image-caption',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => 'caption_text_shadow',
                'selector' => '{{WRAPPER}} .widget-image-caption',
            ]
        );

        $this->add_responsive_control(
            'caption_space',
            [
                'label' => __( 'Spacing', 'fundor-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .widget-image-caption' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

    }

    protected function get_html_wrapper_class() {
        return parent::get_html_wrapper_class() . ' elementor-widget-' . parent::get_name();
    }

    public function get_value( array $options = [] ) {
        $custom_logo_id = get_theme_mod( 'custom_logo' );

        if ( $custom_logo_id ) {
            $url = wp_get_attachment_image_src( $custom_logo_id , 'full' )[0];
        } else {
            $url = Elementor\Utils::get_placeholder_image_src();
        }

        return [
            'id' => $custom_logo_id,
            'url' => $url,
        ];
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if('site_logo' === $settings['logo_select']){
            $custom_logo = $this->get_value();
            $settings['image']['url'] = $custom_logo['url'];
            $settings['image']['id'] = $custom_logo['id'];
        }else{
            $settings['image']['url'] = $settings['image_logo']['url'];
            $settings['image']['id'] = $settings['image_logo']['id'];
        }

        if ( empty( $settings['image']['url'] ) ) {
            return;
        }


        $has_caption = ! empty( $settings['caption'] );

        $this->add_render_attribute( 'wrapper', 'class', 'elementor-image' );

        if ( ! empty( $settings['shape'] ) ) {
            $this->add_render_attribute( 'wrapper', 'class', 'elementor-image-shape-' . $settings['shape'] );
        }

        $link = $this->get_link_url( $settings );

        if ( $link ) {
            $this->add_render_attribute( 'link', [
                'href' => $link['url'],
            ] );

            if(!empty($settings['open_lightbox'])){
                $this->add_render_attribute('link', [
                    'data-elementor-open-lightbox'      => $settings['open_lightbox'],
                ]);
            }

            if ( Plugin::$instance->editor->is_edit_mode() ) {
                $this->add_render_attribute( 'link', [
                    'class' => 'elementor-clickable',
                ] );
            }

            if ( ! empty( $link['is_external'] ) ) {
                $this->add_render_attribute( 'link', 'target', '_blank' );
            }

            if ( ! empty( $link['nofollow'] ) ) {
                $this->add_render_attribute( 'link', 'rel', 'nofollow' );
            }
        } ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <?php if ( $has_caption ) : ?>
            <figure class="wp-caption">
                <?php endif; ?>
                <?php if ( $link ) : ?>
                <a <?php echo $this->get_render_attribute_string( 'link' ); ?>>
                    <?php endif; ?>
                    <?php echo  Elementor\Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
                    <?php if ( $link ) : ?>
                </a>
            <?php endif; ?>
                <?php if ( $has_caption ) : ?>
                    <figcaption class="widget-image-caption wp-caption-text"><?php echo $settings['caption']; ?></figcaption>
                <?php endif; ?>
                <?php if ( $has_caption ) : ?>
            </figure>
        <?php endif; ?>
        </div>
        <?php
    }

    private function get_link_url( $settings ) {
        if ( isset($settings['link_to']) && 'none' === $settings['link_to'] ) {
            return false;
        }

            if ( empty( $settings['link']['url'] ) ) {
                $settings['link']['url'] = site_url();
            }
            return $settings['link'];
//
    }

    protected function _content_template() {
        return;
    }
}
$widgets_manager->register_widget_type(new OSF_Element_Site_Logo());