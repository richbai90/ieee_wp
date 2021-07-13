<?php

use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class OSF_Elementor_Video_Popup extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-video-popup';
    }

    public function get_title() {
        return __('Opal Video', 'fundor-core');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_icon() {
        return 'eicon-youtube';
    }

    public function get_script_depends() {
        return ['magnific-popup'];
    }

    public function get_style_depends() {
        return ['magnific-popup'];
    }


    protected function _register_controls() {
        $this->start_controls_section(
            'section_videos',
            [
                'label' => __('General', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'video_link',
            [
                'label' => __( 'Link to', 'fundor-core' ),
                'type' => Controls_Manager::TEXT,
                'description' => __('Support video from Youtube and Vimeo', 'fundor-core'),
                'placeholder' => __( 'https://your-link.com', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __( 'Title', 'fundor-core' ),
                'type' => Controls_Manager::TEXT,
                'placeholder' => __( 'Tile', 'fundor-core' ),
                'default'     => '',
            ]
        );

        $this->add_control(
            'position_title',
            [
                'label'   => __('Position Title', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'after',
                'options' => [
                    'before'        => __('Before', 'fundor-core'),
                    'after'         => __('After', 'fundor-core'),
                ],
                'prefix_class' => 'elementor-video-title-',
                'condition' => [
                    'title!'    => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'video_align',
            [
                'label'     => __('Alignment', 'fundor-core'),
                'type'      => Controls_Manager::CHOOSE,
                'default'     => 'center',
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_font',
            [
                'label' => __( 'Icon', 'fundor-core' ),
                'type' => Controls_Manager::ICON,
                'label_block' => true,
                'default' => 'opal-icon-play',
            ]
        );

        $this->end_controls_section();

        //Wrapper
        $this->start_controls_section(
            'section_wrapper_style',
            [
                'label' => __( 'Wrapper', 'fundor-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'bg_image',
            [
                'label' => __( 'Choose Image', 'fundor-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'show_label' => false,
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'bg_image', // Actually its `image_size`
                'label' => __( 'Image Resolution', 'fundor-core' ),
                'default' => 'large',
                'condition' => [
                    'bg_image[id]!' => '',
                ],
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label' => __( 'Overlay Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'condition' => [
                    'bg_image[id]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-overlay' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'overlay_blend_mode',
            [
                'label' => __( 'Blend Mode', 'fundor-core' ),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __( 'Normal', 'fundor-core' ),
                    'multiply' => 'Multiply',
                    'screen' => 'Screen',
                    'overlay' => 'Overlay',
                    'darken' => 'Darken',
                    'lighten' => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation' => 'Saturation',
                    'color' => 'Color',
                    'luminosity' => 'Luminosity',
                ],
                'condition' => [
                    'bg_image[id]!' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-overlay' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => __( 'Padding', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Icon
        $this->start_controls_section(
            'section_video_style',
            [
                'label' => __( 'Icon', 'fundor-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'video_width',
            [
                'label'     => __('Width', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icons' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'video_height',
            [
                'label'     => __('Height', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icons' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'video_size',
            [
                'label'     => __('Font Size', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icons' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'video_border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .opal-video-popup .elementor-video-icons',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'video_border_radius',
            [
                'label' => __( 'Border Radius', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icons' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => __( 'Margin', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icons' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_padding',
            [
                'label' => __( 'Padding', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-icons' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_video_style' );

        $this->start_controls_tab(
            'tab_video_normal',
            [
                'label' => __( 'Normal', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'video_color',
            [
                'label' => __( 'Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup:not(:hover) .elementor-video-icons' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'video_bgcolor',
            [
                'label' => __( 'Background Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup .elementor-video-icons' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_video_hover',
            [
                'label' => __( 'Hover', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'video_hover_color',
            [
                'label' => __( 'Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default'     => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup:hover .elementor-video-icons' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'video_hover_bgcolor',
            [
                'label' => __( 'Background Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default'     => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup:hover .elementor-video-icons' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'video_hover_bdcolor',
            [
                'label' => __( 'Border Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup:hover .elementor-video-icons' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->end_controls_section();

        //title
        $this->start_controls_section(
            'section_video_title',
            [
                'label' => __( 'Title', 'fundor-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'title!' => ''
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .opal-video-popup .elementor-video-title',
            ]
        );

        $this->add_control(
            'border_style_title',
            [
                'label'   => __('Border Style', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'        => __('None', 'fundor-core'),
                    'dotted'      => __('Dotted', 'fundor-core'),
                    'dashed'      => __('Dashed', 'fundor-core'),
                    'solid'       => __('Solid', 'fundor-core'),
                    'double'      => __('Double', 'fundor-core'),
                    'groove'      => __('Groove', 'fundor-core'),
                    'ridge'       => __('Ridge', 'fundor-core'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-title' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_size_title',
            [
                'label'     => __('Border Size', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-title' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'border_style_icon!'    => 'none'
                ]
            ]
        );

        $this->add_control(
            'title_border_radius',
            [
                'label' => __( 'Border Radius', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'border_style_title!'    => 'none'
                ]
            ]
        );

        $this->add_control(
            'show_title_block',
            [
                'label' => __( 'Style Block', 'fundor-core' ),
                'type' => Controls_Manager::SWITCHER,
                'label_off' => __( 'Off', 'fundor-core' ),
                'label_on' => __( 'On', 'fundor-core' ),
                'default' => 'label_on',
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup .elementor-video-popup' => 'flex-direction: column; align-items: center;',
                ],
            ]
        );

        $this->start_controls_tabs( 'tabs_title_style' );

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => __( 'Normal', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .opal-video-popup:not(:hover) .elementor-video-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_bdcolor',
            [
                'label' => __( 'Border Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup:not(:hover) .elementor-video-title' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'border_style_title!'    => 'none'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [
                'label' => __( 'Hover', 'fundor-core' ),
            ]
        );


        $this->add_control(
            'title_hover_color',
            [
                'label' => __( 'Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-popup:hover .elementor-video-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->end_controls_section();

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $bg_image = '';

        if(empty($settings['video_link'])){
            return;
        }

        if ( ! empty( $settings['bg_image']['id'] ) ) {
            $bg_image = Group_Control_Image_Size::get_attachment_image_src( $settings['bg_image']['id'], 'bg_image', $settings );
        } elseif ( ! empty( $settings['bg_image']['url'] ) ) {
            $bg_image = $settings['bg_image']['url'];
        }

        $this->add_render_attribute( 'wrapper', 'class', 'elementor-video-wrapper' );
        $this->add_render_attribute( 'wrapper', 'class', 'opal-video-popup' );

        if ( !empty( $bg_image ) ) {
            $this->add_render_attribute( 'wrapper', 'style', 'background-image: url(' . $bg_image . ');' );
        }

        $this->add_render_attribute( 'button', 'class', 'elementor-video-popup' );
        $this->add_render_attribute( 'button', 'role', 'button' );
        $this->add_render_attribute( 'button', 'href',  esc_url( $settings['video_link']));
        $this->add_render_attribute( 'button', 'data-effect', 'mfp-zoom-in' );



        $contentHtml = '<i class="'. esc_attr( $settings['icon_font'] ).'"></i>';

        $titleHtml = !empty($settings['title']) ? '<span class="elementor-video-title">'.$settings['title'].'</span>' : '';


        ?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
            <?php if ( !empty( $bg_image ) ) : ?>
                <span class="elementor-video-overlay"></span>
            <?php endif; ?>
            <a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
                <span class="elementor-video-icons"><?php echo $contentHtml; ?></span>
                <?php echo ($titleHtml);?>
            </a>

        </div>
        <?php
    }

}
$widgets_manager->register_widget_type(new OSF_Elementor_Video_Popup());