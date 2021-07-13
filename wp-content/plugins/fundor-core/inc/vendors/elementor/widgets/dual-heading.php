<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Scheme_Typography;

class OSF_Elementor_Dual_Heading extends Elementor\Widget_Base {

    public function get_name() {
        return 'opal-dual-heading';
    }

    public function get_title() {
        return __('Opal Dual Heading', 'fundor-core');
    }

    public function get_icon() {
        return 'eicon-type-tool';
    }

    public function get_categories() {
        return array('opal-addons');
    }

    protected function _register_controls() {

        $this->start_controls_section('dual_heading_general_settings',
            [
                'label' => __('Dual Heading', 'fundor-core')
            ]
        );

        /*First Header*/
        $this->add_control('dual_heading_first_header_text',
            [
                'label'       => __('First Heading', 'fundor-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'default'     => __('Dual', 'fundor-core'),
                'label_block' => true,
            ]
        );

        /*Second Header*/
        $this->add_control('dual_heading_second_header_text',
            [
                'label'       => __('Second Heading', 'fundor-core'),
                'type'        => Controls_Manager::TEXT,
                'dynamic'     => ['active' => true],
                'default'     => __('Heading', 'fundor-core'),
                'label_block' => true,
            ]
        );

        /*Title Tag*/
        $this->add_control('dual_heading_first_header_tag',
            [
                'label'       => __('HTML Tag', 'fundor-core'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'h2',
                'options'     => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'p'    => 'p',
                    'span' => 'span',
                ],
                'label_block' => true,
            ]
        );

        /*Text Align*/
        $this->add_control('dual_heading_position',
            [
                'label'       => __('Display', 'fundor-core'),
                'type'        => Controls_Manager::SELECT,
                'options'     => [
                    'inline' => __('Inline', 'fundor-core'),
                    'block'  => __('Block', 'fundor-core'),
                ],
                'default'     => 'inline',
                'selectors'   => [
                    '{{WRAPPER}} .dual-heading-first-container span, {{WRAPPER}} .dual-heading-second-container' => 'display: {{VALUE}};',
                ],
                'label_block' => true
            ]
        );

        $this->add_control('dual_heading_link_switcher',
            [
                'label'       => __('Link', 'fundor-core'),
                'type'        => Controls_Manager::SWITCHER,
                'description' => __('Enable or disable link', 'fundor-core'),
            ]
        );

        $this->add_control('dual_heading_link',
            [
                'label'       => __('Link', 'fundor-core'),
                'type'        => Controls_Manager::URL,
                'default'     => [
                    'url' => '#',
                ],
                'placeholder' => 'https://yoursite.com/',
                'label_block' => true,
                'separator'   => 'after',
                'condition'   => [
                    'dual_heading_link_switcher'  => 'yes',
                ]
            ]
        );

        /*Text Align*/
        $this->add_responsive_control('dual_heading_text_align',
            [
                'label'     => __('Alignment', 'fundor-core'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
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
                        'icon'  => 'fa fa-align-right'
                    ]
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .dual-heading-container' => 'text-align: {{VALUE}};'
                ],
            ]
        );

        /*End General Settings Section*/
        $this->end_controls_section();

        /*Start First Header Styling Section*/
        $this->start_controls_section('dual_heading_first_style',
            [
                'label' => __('First Heading', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        /*First Typography*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'first_header_typography',
                'selector' => '{{WRAPPER}} .dual-heading-first-span'
            ]
        );

        $this->add_control('dual_heading_first_animated',
            [
                'label' => __('Animated Background', 'fundor-core'),
                'type'  => Controls_Manager::SWITCHER
            ]
        );

        /*First Coloring Style*/
        $this->add_control('dual_heading_first_back_clip',
            [
                'label'       => __('Background Style', 'fundor-core'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'color',
                'description' => __('Choose ‘Normal’ style to put a background behind the text. Choose ‘Clipped’ style so the background will be clipped on the text.', 'fundor-core'),
                'options'     => [
                    'color'   => __('Normal Background', 'fundor-core'),
                    'clipped' => __('Clipped Background', 'fundor-core'),
                ],
                'label_block' => true
            ]
        );

        /*First Color*/
        $this->add_control('dual_heading_first_color',
            [
                'label'     => __('Text Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'dual_heading_first_back_clip' => 'color'
                ],
                'selectors' => [
                    '{{WRAPPER}} .dual-heading-first-span' => 'color: {{VALUE}};'
                ]
            ]
        );

        /*First Background Color*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'dual_heading_first_background',
                'types'     => ['classic', 'gradient'],
                'condition' => [
                    'dual_heading_first_back_clip' => 'color'
                ],
                'selector'  => '{{WRAPPER}} .dual-heading-first-span'
            ]
        );

        /*First Clip*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'dual_heading_first_clipped_background',
                'types'     => ['classic', 'gradient'],
                'condition' => [
                    'dual_heading_first_back_clip' => 'clipped'
                ],
                'selector'  => '{{WRAPPER}} .dual-heading-first-span'
            ]
        );

        /*First Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'first_header_border',
                'selector' => '{{WRAPPER}} .dual-heading-first-span'
            ]
        );

        /*First Border Radius*/
        $this->add_control('dual_heading_first_border_radius',
            [
                'label'      => __('Border Radius', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .dual-heading-first-span' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        /*First Text Shadow*/
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'    => __('Shadow', 'fundor-core'),
                'name'     => 'dual_heading_first_text_shadow',
                'selector' => '{{WRAPPER}} .dual-heading-first-span'
            ]
        );

        /*First Margin*/
        $this->add_responsive_control('dual_heading_first_margin',
            [
                'label'      => __('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .dual-heading-first-span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        /*First Padding*/
        $this->add_responsive_control('dual_heading_first_padding',
            [
                'label'      => __('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .dual-heading-first-span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        /*End First Header Styling Section*/
        $this->end_controls_section();

        /*Start First Header Styling Section*/
        $this->start_controls_section('dual_heading_second_style',
            [
                'label' => __('Second Heading', 'fundor-core'),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        /*Second Typography*/
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'second_header_typography',
                'selector' => '{{WRAPPER}} .dual-heading-second-header'
            ]
        );

        $this->add_control('dual_heading_second_animated',
            [
                'label' => __('Animated Background', 'fundor-core'),
                'type'  => Controls_Manager::SWITCHER
            ]
        );

        /*Second Coloring Style*/
        $this->add_control('dual_heading_second_back_clip',
            [
                'label'       => __('Background Style', 'fundor-core'),
                'type'        => Controls_Manager::SELECT,
                'default'     => 'color',
                'description' => __('Choose ‘Normal’ style to put a background behind the text. Choose ‘Clipped’ style so the background will be clipped on the text.', 'fundor-core'),
                'options'     => [
                    'color'   => __('Normal Background', 'fundor-core'),
                    'clipped' => __('Clipped Background', 'fundor-core')
                ],
                'label_block' => true
            ]
        );

        /*Second Color*/
        $this->add_control('dual_heading_second_color',
            [
                'label'     => __('Text Color', 'fundor-core'),
                'type'      => Controls_Manager::COLOR,
                'condition' => [
                    'dual_heading_second_back_clip' => 'color'
                ],
                'selectors' => [
                    '{{WRAPPER}} .dual-heading-second-header' => 'color: {{VALUE}};'
                ]
            ]
        );

        /*Second Background Color*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'dual_heading_second_background',
                'types'     => ['classic', 'gradient'],
                'condition' => [
                    'dual_heading_second_back_clip' => 'color'
                ],
                'selector'  => '{{WRAPPER}} .dual-heading-second-header'
            ]
        );

        /*Second Clip*/
        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'      => 'dual_heading_second_clipped_background',
                'types'     => ['classic', 'gradient'],
                'condition' => [
                    'dual_heading_second_back_clip' => 'clipped'
                ],
                'selector'  => '{{WRAPPER}} .dual-heading-second-header'
            ]
        );

        /*Second Border*/
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'second_header_border',
                'selector' => '{{WRAPPER}} .dual-heading-second-header'
            ]
        );

        /*Second Border Radius*/
        $this->add_control('dual_heading_second_border_radius',
            [
                'label'      => __('Border Radius', 'fundor-core'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .dual-heading-second-header' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        /*Second Text Shadow*/
        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'label'    => __('Shadow', 'fundor-core'),
                'name'     => 'dual_heading_second_text_shadow',
                'selector' => '{{WRAPPER}} .dual-heading-second-header'
            ]
        );

        /*Second Margin*/
        $this->add_responsive_control('dual_heading_second_margin',
            [
                'label'      => __('Margin', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .dual-heading-second-header' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}'
                ]
            ]
        );

        /*Second Padding*/
        $this->add_responsive_control('dual_heading_second_padding',
            [
                'label'      => __('Padding', 'fundor-core'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .dual-heading-second-header' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ]
            ]
        );

        /*End Second Header Styling Section*/
        $this->end_controls_section();

    }

    protected function render() {
        // get our input from the widget settings.
        $settings = $this->get_settings_for_display();

        $this->add_inline_editing_attributes('dual_heading_first_header_text');

        $this->add_inline_editing_attributes('dual_heading_second_header_text');

        $first_title_tag = $settings['dual_heading_first_header_tag'];

        $first_title_text = $settings['dual_heading_first_header_text'] . ' ';

        $second_title_text = $settings['dual_heading_second_header_text'];

        $first_clip = '';

        $second_clip = '';

        if ($settings['dual_heading_first_back_clip'] === 'clipped') : $first_clip = "dual-heading-first-clip"; endif;

        if ($settings['dual_heading_second_back_clip'] === 'clipped') : $second_clip = "dual-heading-second-clip"; endif;

        $first_grad = $settings['dual_heading_first_animated'] === 'yes' ? ' gradient' : '';

        $second_grad = $settings['dual_heading_second_animated'] === 'yes' ? ' gradient' : '';

        $full_first_title_tag = '<' . $first_title_tag . ' class="dual-heading-first-header ' . $first_clip . $first_grad . '"><span class="dual-heading-first-span">' . $first_title_text . '</span><span class="dual-heading-second-header ' . $second_clip . $second_grad . '">' . $second_title_text . '</span></' . $settings['dual_heading_first_header_tag'] . '> ';

        $link = '';
        if ($settings['dual_heading_link_switcher'] == 'yes') {
            $link = $settings['dual_heading_link']['url'];
        }

        ?>

        <div class="dual-heading-container">
            <?php if (!empty ($link)) : ?>
            <a href="<?php echo esc_attr($link); ?>" <?php if (!empty($settings['dual_heading_link']['is_external'])) : ?> target="_blank" <?php endif; ?><?php if (!empty($settings['dual_heading_link']['nofollow'])) : ?> rel="nofollow" <?php endif; ?>>
                <?php endif; ?>
                <div class="dual-heading-first-container">
                    <?php echo $full_first_title_tag; ?>
                </div>
                <?php if (!empty ($link)) : ?>
            </a>
        <?php endif; ?>
        </div>

        <?php
    }

    protected function _content_template() {
        ?>
        <#

        view.addInlineEditingAttributes('dual_heading_first_header_text');

        view.addInlineEditingAttributes('dual_heading_second_header_text');

        var firstTag = settings.dual_heading_first_header_tag,

        firstText = settings.dual_heading_first_header_text + ' ',

        secondText = settings.dual_heading_second_header_text,

        firstClip = '',

        secondClip = '';

        if( 'clipped' === settings.dual_heading_first_back_clip )
        firstClip = "dual-heading-first-clip";

        if( 'clipped' === settings.dual_heading_second_back_clip )
        secondClip = "dual-heading-second-clip";

        var firstGrad = 'yes' === settings.dual_heading_first_animated  ? ' gradient' : '',

        secondGrad = 'yes' === settings.dual_heading_second_animated ? ' gradient' : '';

        view.addRenderAttribute('first_title', 'class', ['dual-heading-first-header', firstClip, firstGrad ] );
        view.addRenderAttribute('second_title', 'class', ['dual-heading-second-header', secondClip, secondGrad ] );

        if( 'yes' == settings.dual_heading_link_switcher ){
            var link = settings.dual_heading_link.url;
        }

        #>

        <div class="dual-heading-container">
            <# if( 'yes' == settings.dual_heading_link_switcher ) { #>
            <a href="{{ link }}">
                <# } #>
                <div class="dual-heading-first-container">
                    <{{{firstTag}}} {{{ view.getRenderAttributeString('first_title') }}}>
                    <span class="dual-heading-first-span">{{{ firstText }}}</span><span {{{ view.getRenderAttributeString('second_title') }}}>{{{ secondText }}}</span>
                </
                {{{firstTag}}}>

        </div>
        <# if( 'yes' == settings.dual_heading_link_switcher ) { #>
        </a>
        <# } #>
        </div>

        <?php
    }
}

$widgets_manager->register_widget_type(new OSF_Elementor_Dual_Heading());