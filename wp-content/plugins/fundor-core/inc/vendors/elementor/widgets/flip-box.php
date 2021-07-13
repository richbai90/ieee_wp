<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Scheme_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class OSF_Elementor_Flip_Box extends Elementor\Widget_Base {

	public function get_name() {
		return 'opal-flip-box';
	}

	public function get_title() {
		return __( 'Opal Flip Box', 'fundor-core' );
	}

	public function get_icon() {
		return 'eicon-flip-box';
	}

    public function get_categories() {
        return [ 'opal-addons' ];
    }

	protected function _register_controls() {

		$this->start_controls_section(
			'section_side_a_content',
			[
				'label' => __( 'Front', 'fundor-core' ),
			]
		);

		$this->start_controls_tabs( 'side_a_content_tabs' );

		$this->start_controls_tab( 'side_a_content_tab', [ 'label' => __( 'Content', 'fundor-core' ) ] );

		$this->add_control(
			'graphic_element',
			[
				'label' => __( 'Graphic Element', 'fundor-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'none' => [
						'title' => __( 'None', 'fundor-core' ),
						'icon' => 'fa fa-ban',
					],
					'image' => [
						'title' => __( 'Image', 'fundor-core' ),
						'icon' => 'fa fa-picture-o',
					],
					'icon' => [
						'title' => __( 'Icon', 'fundor-core' ),
						'icon' => 'fa fa-star',
					],
				],
				'default' => 'none',
			]
		);

		$this->add_control(
			'image',
			[
				'label' => __( 'Choose Image', 'fundor-core' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'image', // Actually its `image_size`
				'default' => 'thumbnail',
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'fundor-core' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-star',
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_view',
			[
				'label' => __( 'View', 'fundor-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => __( 'Default', 'fundor-core' ),
					'stacked' => __( 'Stacked', 'fundor-core' ),
					'framed' => __( 'Framed', 'fundor-core' ),
				],
				'default' => 'default',
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_shape',
			[
				'label' => __( 'Shape', 'fundor-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'circle' => __( 'Circle', 'fundor-core' ),
					'square' => __( 'Square', 'fundor-core' ),
				],
				'default' => 'circle',
				'condition' => [
					'icon_view!' => 'default',
					'graphic_element' => 'icon',
				],
			]
		);

        $this->add_control(
            'sub_title_text_a',
            [
                'label' => __( 'Sub Title', 'fundor-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'This is the sub title', 'fundor-core' ),
                'placeholder' => __( 'Enter your sub title', 'fundor-core' ),
                'label_block' => true,
                'separator' => 'before',
            ]
        );

		$this->add_control(
			'title_text_a',
			[
				'label' => __( 'Title', 'fundor-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the heading', 'fundor-core' ),
				'placeholder' => __( 'Enter your title', 'fundor-core' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'description_text_a',
			[
				'label' => __( 'Description', 'fundor-core' ),
				'type' => Controls_Manager::TEXTAREA,
				'placeholder' => __( 'Enter your description', 'fundor-core' ),
				'separator' => 'none',
				'rows' => 10,
                'label_block' => true,
//				'show_label' => false,
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'side_a_background_tab', [ 'label' => __( 'Background', 'fundor-core' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_a',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .elementor-flip-box__front',
			]
		);

		$this->add_control(
			'background_overlay_a',
			[
				'label' => __( 'Background Overlay', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__overlay' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'background_a_image[id]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_side_b_content',
			[
				'label' => __( 'Back', 'fundor-core' ),
			]
		);

		$this->start_controls_tabs( 'side_b_content_tabs' );

		$this->start_controls_tab( 'side_b_content_tab', [ 'label' => __( 'Content', 'fundor-core' ) ] );

        $this->add_control(
            'graphic_element_back',
            [
                'label' => __( 'Graphic Element', 'fundor-core' ),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'none' => [
                        'title' => __( 'None', 'fundor-core' ),
                        'icon' => 'fa fa-ban',
                    ],
                    'image' => [
                        'title' => __( 'Image', 'fundor-core' ),
                        'icon' => 'fa fa-picture-o',
                    ],
                    'icon' => [
                        'title' => __( 'Icon', 'fundor-core' ),
                        'icon' => 'fa fa-star',
                    ],
                ],
                'default' => 'none',
            ]
        );

        $this->add_control(
            'image_back',
            [
                'label' => __( 'Choose Image', 'fundor-core' ),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'graphic_element_back' => 'image',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'image_back', // Actually its `image_size`
                'default' => 'thumbnail',
                'condition' => [
                    'graphic_element_back' => 'image',
                ],
            ]
        );

        $this->add_control(
            'icon_back',
            [
                'label' => __( 'Icon', 'fundor-core' ),
                'type' => Controls_Manager::ICON,
                'default' => 'fa fa-star',
                'condition' => [
                    'graphic_element_back' => 'icon',
                ],
            ]
        );

        $this->add_control(
            'sub_title_text_b',
            [
                'label' => __( 'Sub Title', 'fundor-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'This is the sub title', 'fundor-core' ),
                'placeholder' => __( 'Enter your sub title', 'fundor-core' ),
                'label_block' => true,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'title_text_b',
            [
                'label' => __( 'Title', 'fundor-core' ),
                'type' => Controls_Manager::TEXT,
                'default' => __( 'This is the heading', 'fundor-core' ),
                'placeholder' => __( 'Enter your title', 'fundor-core' ),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'description_text_b',
            [
                'label' => __( 'Description', 'fundor-core' ),
                'type' => Controls_Manager::TEXTAREA,
                'placeholder' => __( 'Enter your description', 'fundor-core' ),
                'separator' => 'none',
                'rows' => 10,
                'label_block' => true,
            ]
        );

		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button Text', 'fundor-core' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Click Here', 'fundor-core' ),
				'separator' => 'before',
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Link', 'fundor-core' ),
				'type' => Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'fundor-core' ),
			]
		);

		$this->add_control(
			'link_click',
			[
				'label' => __( 'Apply Link On', 'fundor-core' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'box' => __( 'Whole Box', 'fundor-core' ),
					'button' => __( 'Button Only', 'fundor-core' ),
				],
				'default' => 'button',
				'condition' => [
					'link[url]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab( 'side_b_background_tab', [ 'label' => __( 'Background', 'fundor-core' ) ] );

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'background_b',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .elementor-flip-box__back',
			]
		);

		$this->add_control(
			'background_overlay_b',
			[
				'label' => __( 'Background Overlay', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__overlay' => 'background-color: {{VALUE}};',
				],
				'separator' => 'before',
				'condition' => [
					'background_b_image[id]!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_box_settings',
			[
				'label' => __( 'Settings', 'fundor-core' ),
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label' => __( 'Height', 'fundor-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'size_units' => [ 'px', 'vh' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'border_radius',
			[
				'label' => __( 'Border Radius', 'fundor-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__layer, {{WRAPPER}} .elementor-flip-box__layer__overlay' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'flip_effect',
			[
				'label' => __( 'Flip Effect', 'fundor-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'flip',
				'options' => [
					'flip' => 'Flip',
					'slide' => 'Slide',
					'push' => 'Push',
					'zoom-in' => 'Zoom In',
					'zoom-out' => 'Zoom Out',
					'fade' => 'Fade',
				],
                'default' => 'slide',
				'prefix_class' => 'elementor-flip-box--effect-',
			]
		);

		$this->add_control(
			'flip_direction',
			[
				'label' => __( 'Flip Direction', 'fundor-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'up',
				'options' => [
					'left' => __( 'Left', 'fundor-core' ),
					'right' => __( 'Right', 'fundor-core' ),
					'up' => __( 'Up', 'fundor-core' ),
					'down' => __( 'Down', 'fundor-core' ),
				],
				'condition' => [
					'flip_effect!' => [
							'fade',
							'zoom-in',
							'zoom-out',
						],
				],
				'prefix_class' => 'elementor-flip-box--direction-',
			]
		);

		$this->add_control(
			'flip_3d',
			[
				'label' => __( '3D Depth', 'fundor-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'fundor-core' ),
				'label_off' => __( 'Off', 'fundor-core' ),
				'return_value' => 'elementor-flip-box--3d',
				'default' => '',
				'prefix_class' => '',
				'condition' => [
					'flip_effect' => 'flip',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_a',
			[
				'label' => __( 'Front', 'fundor-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'padding_a',
			[
				'label' => __( 'Padding', 'fundor-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'alignment_a',
			[
				'label' => __( 'Alignment', 'fundor-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
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
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__overlay' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'vertical_position_a',
			[
				'label' => __( 'Vertical Position', 'fundor-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'fundor-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'fundor-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'fundor-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
                'default' => 'bottom',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__overlay' => 'justify-content: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_a',
				'selector' => '{{WRAPPER}} .elementor-flip-box__front',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_image_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Image', 'fundor-core' ),
				'condition' => [
					'graphic_element' => 'image',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_spacing',
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
					'{{WRAPPER}} .elementor-flip-box__image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'image_width',
			[
				'label' => __( 'Size (%)', 'fundor-core' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'default' => [
					'unit' => '%',
				],
				'range' => [
					'%' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__image img' => 'width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'image_opacity',
			[
				'label' => __( 'Opacity', 'fundor-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 1,
				],
				'range' => [
					'px' => [
						'max' => 1,
						'min' => 0.10,
						'step' => 0.01,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__image' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'image_border',
				'selector' => '{{WRAPPER}} .elementor-flip-box__image img',
				'condition' => [
					'graphic_element' => 'image',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'fundor-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__image img' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'graphic_element' => 'image',
				],
			]
		);

		$this->add_control(
			'heading_icon_style',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Icon', 'fundor-core' ),
				'condition' => [
					'graphic_element' => 'icon',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_spacing',
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
					'{{WRAPPER}} .elementor-icon-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_primary_color',
			[
				'label' => __( 'Primary Color', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .elementor-view-stacked .elementor-icon' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .elementor-view-framed .elementor-icon, {{WRAPPER}} .elementor-view-default .elementor-icon' => 'color: {{VALUE}}; border-color: {{VALUE}}',
				],
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_secondary_color',
			[
				'label' => __( 'Secondary Color', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'condition' => [
					'graphic_element' => 'icon',
					'icon_view!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-view-framed .elementor-icon' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .elementor-view-stacked .elementor-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Icon Size', 'fundor-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_padding',
			[
				'label' => __( 'Icon Padding', 'fundor-core' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
				'range' => [
					'em' => [
						'min' => 0,
						'max' => 5,
					],
				],
				'condition' => [
					'graphic_element' => 'icon',
					'icon_view!' => 'default',
				],
			]
		);

		$this->add_control(
			'icon_rotate',
			[
				'label' => __( 'Icon Rotate', 'fundor-core' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
					'unit' => 'deg',
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon i' => 'transform: rotate({{SIZE}}{{UNIT}});',
				],
				'condition' => [
					'graphic_element' => 'icon',
				],
			]
		);

		$this->add_control(
			'icon_border_width',
			[
				'label' => __( 'Border Width', 'fundor-core' ),
				'type' => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-width: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'graphic_element' => 'icon',
					'icon_view' => 'framed',
				],
			]
		);

		$this->add_control(
			'icon_border_radius',
			[
				'label' => __( 'Border Radius', 'fundor-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'graphic_element' => 'icon',
					'icon_view!' => 'default',
				],
			]
		);


        $this->add_control(
            'heading_sub_title_style_a',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Sub Title', 'fundor-core' ),
                'separator' => 'before',
                'condition' => [
                    'sub_title_text_a!' => '',
                ],
            ]
        );

        $this->add_control(
            'sub_title_spacing_a',
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
                    '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__sub_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'sub_title_text_a!' => '',
                ],
            ]
        );

        $this->add_control(
            'sub_title_color_a',
            [
                'label' => __( 'Text Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__sub_title' => 'color: {{VALUE}}',

                ],
                'condition' => [
                    'sub_title_text_a!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography_a',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__sub_title',
                'condition' => [
                    'sub_title_text_a!' => '',
                ],
            ]
        );

		$this->add_control(
			'heading_title_style_a',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Title', 'fundor-core' ),
				'separator' => 'before',
				'condition' => [
					'title_text_a!' => '',
				],
			]
		);

		$this->add_control(
			'title_spacing_a',
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
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'title_text_a!' => '',
				],
			]
		);

		$this->add_control(
			'title_color_a',
			[
				'label' => __( 'Text Color', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__title' => 'color: {{VALUE}}',

				],
				'condition' => [
					'title_text_a!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography_a',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__title',
				'condition' => [
					'title_text_a!' => '',
				],
			]
		);

		$this->add_control(
			'heading_description_style_a',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Description', 'fundor-core' ),
				'separator' => 'before',
				'condition' => [
					'description_text_a!' => '',
				],
			]
		);

		$this->add_control(
			'description_color_a',
			[
				'label' => __( 'Text Color', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__description' => 'color: {{VALUE}}',

				],
				'condition' => [
					'description_text_a!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography_a',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__description',
				'condition' => [
					'description_text_a!' => '',
				],
			]
		);

        $this->add_control(
            'description_spacing_a',
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
                    '{{WRAPPER}} .elementor-flip-box__front .elementor-flip-box__layer__description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'description_text_a!' => '',
                ],
            ]
        );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_b',
			[
				'label' => __( 'Back', 'fundor-core' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'padding_b',
			[
				'label' => __( 'Padding', 'fundor-core' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'alignment_b',
			[
				'label' => __( 'Alignment', 'fundor-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
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
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__overlay' => 'text-align: {{VALUE}}',
					'{{WRAPPER}} .elementor-flip-box__button' => 'margin-{{VALUE}}: 0',
				],
			]
		);

		$this->add_control(
			'vertical_position_b',
			[
				'label' => __( 'Vertical Position', 'fundor-core' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'fundor-core' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'fundor-core' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'fundor-core' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
                'default' => 'bottom',
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__overlay' => 'justify-content: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border_b',
				'selector' => '{{WRAPPER}} .elementor-flip-box__back',
				'separator' => 'before',
			]
		);

        $this->add_control(
            'heading_sub_title_style_b',
            [
                'type' => Controls_Manager::HEADING,
                'label' => __( 'Sub Title', 'fundor-core' ),
                'separator' => 'before',
                'condition' => [
                    'sub_title_text_b!' => '',
                ],
            ]
        );

        $this->add_control(
            'sub_title_spacing_b',
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
                    '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__sub_title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'sub_title_text_b!' => '',
                ],
            ]
        );

        $this->add_control(
            'sub_title_color_b',
            [
                'label' => __( 'Text Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__sub_title' => 'color: {{VALUE}}',

                ],
                'condition' => [
                    'sub_title_text_b!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sub_title_typography_b',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
                'selector' => '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__sub_title',
                'condition' => [
                    'sub_title_text_b!' => '',
                ],
            ]
        );

		$this->add_control(
			'heading_title_style_b',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Title', 'fundor-core' ),
				'separator' => 'before',
				'condition' => [
					'title_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'title_spacing_b',
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
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'title_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'title_color_b',
			[
				'label' => __( 'Text Color', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__title' => 'color: {{VALUE}}',

				],
				'condition' => [
					'title_text_b!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography_b',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__title',
				'condition' => [
					'title_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'heading_description_style_b',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Description', 'fundor-core' ),
				'separator' => 'before',
				'condition' => [
					'description_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'description_spacing_b',
			[
				'label' => __( 'Spacing', 'fundor-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
                'default'    => [
                    'size' => 30,
                ],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
                'condition' => [
                    'description_text_b!' => '',
                ],
			]
		);

		$this->add_control(
			'description_color_b',
			[
				'label' => __( 'Text Color', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__description' => 'color: {{VALUE}}',

				],
				'condition' => [
					'description_text_b!' => '',
				],
			]
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography_b',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .elementor-flip-box__back .elementor-flip-box__layer__description',
				'condition' => [
					'description_text_b!' => '',
				],
			]
		);

		$this->add_control(
			'heading_button',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Button', 'fundor-core' ),
				'separator' => 'before',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_size',
			[
				'label' => __( 'Size', 'fundor-core' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'md',
				'options' => [
					'xs' => __( 'Extra Small', 'fundor-core' ),
					'sm' => __( 'Small', 'fundor-core' ),
					'md' => __( 'Medium', 'fundor-core' ),
					'lg' => __( 'Large', 'fundor-core' ),
					'xl' => __( 'Extra Large', 'fundor-core' ),
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

        $this->add_control(
            'button_type',
            [
                'label'        => __('Type', 'fundor-core'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'primary',
                'options' => [
                    '' => __('Default', 'fundor-core'),
                    'primary_gradient' => __('Primary Gradient', 'fundor-core'),
                    'primary' => __('Primary', 'fundor-core'),
                    'secondary' => __('Secondary', 'fundor-core'),
                    'outline_primary' => __('Outline Primary', 'fundor-core'),
                    'outline_secondary' => __('Outline Secondary', 'fundor-core'),
                    'dark' => __('Dark', 'fundor-core'),
                    'light' => __('Light', 'fundor-core'),
                    'link' => __('Link', 'fundor-core'),
                    'info' => __('Info', 'fundor-core'),
                    'success' => __('Success', 'fundor-core'),
                    'warning' => __('Warning', 'fundor-core'),
                    'danger' => __('Danger', 'fundor-core'),
                ],
                'prefix_class' => 'elementor-button-',
            ]
        );

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .elementor-flip-box__button',
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->start_controls_tabs( 'button_tabs' );

		$this->start_controls_tab( 'normal',
			[
				'label' => __( 'Normal', 'fundor-core' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label' => __( 'Text Color', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label' => __( 'Background Color', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_border_color',
			[
				'label' => __( 'Border Color', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'hover',
			[
				'label' => __( 'Hover', 'fundor-core' ),
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label' => __( 'Text Color', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button:hover' => 'color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label' => __( 'Background Color', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button:hover' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'fundor-core' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button:hover' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'button_border_width',
			[
				'label' => __( 'Border Width', 'fundor-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 20,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'before',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'fundor-core' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-flip-box__button' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
				'condition' => [
					'button_text!' => '',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings();
		$wrapper_tag = 'div';
		$button_tag = 'a';
		$link_url = empty( $settings['link']['url'] ) ? '#' : $settings['link']['url'];
		$this->add_render_attribute( 'button', 'class', [
				'elementor-flip-box__button',
				'elementor-button',
				'elementor-size-' . $settings['button_size'],
			]
		);

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-flip-box__layer elementor-flip-box__back' );
		if ( 'box' === $settings['link_click'] ) {
			$wrapper_tag = 'a';
			$button_tag = 'button';
			$this->add_render_attribute( 'wrapper', 'href', $link_url );
			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'wrapper', 'target', '_blank' );
			}
		} else {
			$this->add_render_attribute( 'button', 'href', $link_url );
			if ( $settings['link']['is_external'] ) {
				$this->add_render_attribute( 'button', 'target', '_blank' );
			}
		}

		if ( 'icon' === $settings['graphic_element'] ) {
			$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-icon-wrapper' );
			$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-view-' . $settings['icon_view'] );
			if ( 'default' != $settings['icon_view'] ) {
				$this->add_render_attribute( 'icon-wrapper', 'class', 'elementor-shape-' . $settings['icon_shape'] );
			}
			if ( ! empty( $settings['icon'] ) ) {
				$this->add_render_attribute( 'icon', 'class', $settings['icon'] );
			}
		}

		?>
		<div class="elementor-flip-box">
			<div class="elementor-flip-box__layer elementor-flip-box__front">
				<div class="elementor-flip-box__layer__overlay">
					<div class="elementor-flip-box__layer__inner">
						<?php if ( 'image' === $settings['graphic_element'] && ! empty( $settings['image']['url'] ) ) : ?>
							<div class="elementor-flip-box__image">
								<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
							</div>
						<?php elseif ( 'icon' === $settings['graphic_element'] && ! empty( $settings['icon'] ) ) : ?>
							<div <?php echo $this->get_render_attribute_string( 'icon-wrapper' ); ?>>
								<div class="elementor-icon">
									<i <?php echo $this->get_render_attribute_string( 'icon' ); ?>></i>
								</div>
							</div>
						<?php endif; ?>

                        <?php if ( ! empty( $settings['sub_title_text_a'] ) ) : ?>
                            <span class="elementor-flip-box__layer__sub_title">
                                <?php echo $settings['sub_title_text_a']; ?>
                            </span>
                        <?php endif; ?>

						<?php if ( ! empty( $settings['title_text_a'] ) ) : ?>
							<h3 class="elementor-flip-box__layer__title">
								<?php echo $settings['title_text_a']; ?>
							</h3>
                        <?php endif; ?>

						<?php if ( ! empty( $settings['description_text_a'] ) ) : ?>
							<div class="elementor-flip-box__layer__description">
								<?php echo $settings['description_text_a']; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<<?php echo $wrapper_tag; ?> <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
				<div class="elementor-flip-box__layer__overlay">
					<div class="elementor-flip-box__layer__inner">

                        <?php if ( 'image' === $settings['graphic_element_back'] && ! empty( $settings['image_back']['url'] ) ) : ?>
                            <div class="elementor-flip-box__image">
                                <?php echo Group_Control_Image_Size::get_attachment_image_html( $settings ); ?>
                            </div>
                        <?php elseif ( 'icon' === $settings['graphic_element_back'] && ! empty( $settings['icon_back'] ) ) : ?>
                            <div <?php echo $this->get_render_attribute_string( 'icon-wrapper' ); ?>>
                                <div class="elementor-icon">
                                    <i <?php echo $this->get_render_attribute_string( 'icon_back' ); ?>></i>
                                </div>
                            </div>

                        <?php endif; ?>
                        <?php if ( ! empty( $settings['sub_title_text_b'] ) ) : ?>
                            <span class="elementor-flip-box__layer__sub_title">
                                <?php echo $settings['sub_title_text_b']; ?>
                            </span>
                        <?php endif; ?>

						<?php if ( ! empty( $settings['title_text_b'] ) ) : ?>
							<h3 class="elementor-flip-box__layer__title">
								<?php echo $settings['title_text_b']; ?>
							</h3>
                        <?php endif; ?>

						<?php if ( ! empty( $settings['description_text_b'] ) ) : ?>
							<div class="elementor-flip-box__layer__description">
								<?php echo $settings['description_text_b']; ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $settings['button_text'] ) ) : ?>
							<<?php echo $button_tag; ?> <?php echo $this->get_render_attribute_string( 'button' ); ?>>
								<?php echo $settings['button_text']; ?>
							</<?php echo $button_tag; ?>>
						<?php endif; ?>
					</div>
				</div>
			</<?php echo $wrapper_tag; ?>>
		</div>
		<?php
	}

	protected function _content_template() {
		?>
		<#
			var btnClasses = 'elementor-flip-box__button elementor-button elementor-size-' + settings.button_size;

			if ( 'image' === settings.graphic_element && '' !== settings.image.url ) {
				var image = {
					id: settings.image.id,
					url: settings.image.url,
					size: settings.image_size,
					dimension: settings.image_custom_dimension,
					model: view.getEditModel()
				};

				var imageUrl = elementor.imagesManager.getImageUrl( image );
			}

			var wrapperTag = 'div',
				buttonTag = 'a';

			if ( 'box' === settings.link_click ) {
				wrapperTag = 'a';
				buttonTag = 'button';
			}

			if ( 'icon' === settings.graphic_element ) {
				var iconWrapperClasses = 'elementor-icon-wrapper';
					iconWrapperClasses += ' elementor-view-' + settings.icon_view;
				if ( 'default' !== settings.icon_view ) {
					iconWrapperClasses += ' elementor-shape-' + settings.icon_shape;
				}
			}
		#>

		<div class="elementor-flip-box">
			<div class="elementor-flip-box__layer elementor-flip-box__front">
				<div class="elementor-flip-box__layer__overlay">
					<div class="elementor-flip-box__layer__inner">
						<# if ( 'image' === settings.graphic_element && '' !== settings.image.url ) { #>
							<div class="elementor-flip-box__image">
								<img src="{{ imageUrl }}">
							</div>
						<#  } else if ( 'icon' === settings.graphic_element && settings.icon ) { #>
							<div class="{{ iconWrapperClasses }}" >
								<div class="elementor-icon">
									<i class="{{ settings.icon }}"></i>
								</div>
							</div>
						<# } #>

                        <# if ( settings.sub_title_text_a ) { #>
                        <span class="elementor-flip-box__layer__sub_title">{{{ settings.sub_title_text_a }}}</span>
                        <# } #>

						<# if ( settings.title_text_a ) { #>
							<h3 class="elementor-flip-box__layer__title">{{{ settings.title_text_a }}}</h3>
                        <# } #>

						<# if ( settings.description_text_a ) { #>
							<div class="elementor-flip-box__layer__description">{{{ settings.description_text_a }}}</div>
						<# } #>
					</div>
				</div>
			</div>
			<{{ wrapperTag }} class="elementor-flip-box__layer elementor-flip-box__back">
				<div class="elementor-flip-box__layer__overlay">
					<div class="elementor-flip-box__layer__inner">
                        <# if ( 'image' === settings.graphic_element_back && '' !== settings.image_back.url ) { #>
                        <div class="elementor-flip-box__image">
                            <img src="{{ imageUrl }}">
                        </div>
                        <#  } else if ( 'icon' === settings.graphic_element_back && settings.icon_back ) { #>
                        <div class="{{ iconWrapperClasses }}" >
                            <div class="elementor-icon">
                                <i class="{{ settings.icon_back }}"></i>
                            </div>
                        </div>
                        <# } #>

                        <# if ( settings.sub_title_text_b ) { #>
                        <span class="elementor-flip-box__layer__sub_title">{{{ settings.sub_title_text_b }}}</span>
                        <# } #>

						<# if ( settings.title_text_b ) { #>
							<h3 class="elementor-flip-box__layer__title">{{{ settings.title_text_b }}}</h3>
						<# } #>

						<# if ( settings.description_text_b ) { #>
							<div class="elementor-flip-box__layer__description">{{{ settings.description_text_b }}}</div>
                        <# } #>

						<# if ( settings.button_text ) { #>
							<{{ buttonTag }} href="#" class="{{ btnClasses }}">{{{ settings.button_text }}}</{{ buttonTag }}>
						<# } #>
					</div>
				</div>
			</{{ wrapperTag }}>
		</div>
		<?php
	}
}

$widgets_manager->register_widget_type(new OSF_Elementor_Flip_Box());