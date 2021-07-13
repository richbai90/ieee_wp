<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor heading widget.
 *
 * Elementor widget that displays an eye-catching headlines.
 *
 * @since 1.0.0
 */
class  OSF_Elementor_Heading extends Widget_Heading {

    public function get_title() {
        return __('Opal Heading', 'fundor-core');
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => __('Title', 'fundor-core'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => __('Title', 'fundor-core'),
                'type'        => Controls_Manager::TEXTAREA,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => __('Enter your title', 'fundor-core'),
                'default'     => __('Add Your Heading Text Here', 'fundor-core'),
            ]
        );

        $this->add_control(
            'sub_title',
            [
                'label'       => __('Sub Title', 'fundor-core'),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __('Enter your subtitle', 'fundor-core'),
                'default'     => __('', 'fundor-core'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'link',
            [
                'label'     => __('Link', 'fundor-core'),
                'type'      => Controls_Manager::URL,
                'dynamic'   => [
                    'active' => true,
                ],
                'default'   => [
                    'url' => '',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'size',
            [
                'label'   => __('Size', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => __('Default', 'fundor-core'),
                    'small'   => __('Small', 'fundor-core'),
                    'medium'  => __('Medium', 'fundor-core'),
                    'large'   => __('Large', 'fundor-core'),
                    'xl'      => __('XL', 'fundor-core'),
                    'xxl'     => __('XXL', 'fundor-core'),
                ],
            ]
        );

        $this->add_control(
            'header_size',
            [
                'label'   => __('HTML Tag', 'fundor-core'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'h2',
            ]
        );

        $this->add_control(
            'show_decor',
            [
                'label' => __('Show Decor', 'fundor-core'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'     => __('Alignment', 'fundor-core'),
                'type'      => Controls_Manager::CHOOSE,
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
                    'justify' => [
                        'title' => __('Justified', 'fundor-core'),
                        'icon'  => 'fa fa-align-justify',
                    ],
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
                'prefix_class' => 'elementor%s-align-',
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

        $this->start_controls_section(
            'section_title_style',
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
                'selectors' => [
                    // Stronger selector to avoid section style from overwriting
                    '{{WRAPPER}}.elementor-widget-heading .elementor-heading-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                //'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'text_shadow',
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->add_control(
            'blend_mode',
            [
                'label'     => __('Blend Mode', 'fundor-core'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    ''            => __('Normal', 'fundor-core'),
                    'multiply'    => 'Multiply',
                    'screen'      => 'Screen',
                    'overlay'     => 'Overlay',
                    'darken'      => 'Darken',
                    'lighten'     => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation'  => 'Saturation',
                    'color'       => 'Color',
                    'difference'  => 'Difference',
                    'exclusion'   => 'Exclusion',
                    'hue'         => 'Hue',
                    'luminosity'  => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label' => __( 'Padding', 'fundor-core' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_sub_title_style',
            [
                'label' => __('Sub Title', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'sub_title!' => ''
                ],
            ]
        );

        $this->add_control(
            'sub_title_color',
            [
                'label'     => __('Text Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-heading .sub-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'sub_title!' => ''
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'subtitle_typography',
                'selector' => '{{WRAPPER}}.elementor-widget-heading .sub-title',
                'condition' => [
                    'sub_title!' => ''
                ],
            ]
        );

        $this->add_responsive_control(
            'sub_title_spacing',
            [
                'label'     => __('Spacing', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-heading .sub-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'sub_title!' => ''
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

        $this->add_control(
            'decor_color',
            [
                'label'     => __('Decor Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .heading-decor' => 'background: {{VALUE}};',
                ],
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

        $this->add_responsive_control(
            'decor_spacing',
            [
                'label'     => __('Spacing', 'fundor-core'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-decor' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render heading widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

//        if (empty($settings['title'])) {
//            return;
//        }

        $this->add_render_attribute('title', 'class', 'elementor-heading-title');

        if (!empty($settings['size'])) {
            $this->add_render_attribute('title', 'class', 'elementor-size-' . $settings['size']);
        }

        $this->add_inline_editing_attributes('title');

        $title = $settings['title'];

        $title_html = '';

        if ($settings['sub_title']) {

            $title_html .= '<span class="sub-title">'.$settings['sub_title'].'</span>';
        }

        if (!empty($settings['link']['url'])) {
            $this->add_render_attribute('url', 'href', $settings['link']['url']);

            if ($settings['link']['is_external']) {
                $this->add_render_attribute('url', 'target', '_blank');
            }

            if (!empty($settings['link']['nofollow'])) {
                $this->add_render_attribute('url', 'rel', 'nofollow');
            }

            $title = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $title);
        }

        $title_html .= sprintf('<%1$s %2$s>%3$s</%1$s>', $settings['header_size'], $this->get_render_attribute_string('title'), $title);

        if ($settings['show_decor'] == 'yes') {
            $title_html .= '<span class="heading-decor"></span>';
        }

        echo $title_html;
    }

    /**
     * Render heading widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function _content_template() {
        ?>
        <#
        var title = settings.title;
        var title_html = '';

        if ( settings.sub_title ) {
        title_html += '<span class="sub-title">' + settings.sub_title + '</span>';
        }

        if ( '' !== settings.link.url ) {
        title = '<a href="' + settings.link.url + '">' + title + '</a>';
        }

        view.addRenderAttribute( 'title', 'class', [ 'elementor-heading-title', 'elementor-size-' + settings.size ] );

        view.addInlineEditingAttributes( 'title' );

        title_html += '<' + settings.header_size  + ' ' + view.getRenderAttributeString( 'title' ) + '>' + title + '</' + settings.header_size + '>';

        if(settings.show_decor !== '') {
        title_html += '<span class="heading-decor"></span>'}

        print( title_html );
        #>
        <?php
    }
}

$widgets_manager->register_widget_type(new OSF_Elementor_Heading());