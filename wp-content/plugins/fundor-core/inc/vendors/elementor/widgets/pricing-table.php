<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}



class OSF_Elementor_Price_Table extends Widget_Base {

    public function get_name() {
        return 'opal-price-table';
    }

    public function get_title() {
        return __('Opal Price Table', 'fundor-core');
    }

    public function get_categories() {
        return array('opal-addons');
    }

    public function get_icon() {
        return 'eicon-price-table';
    }

    protected function _register_controls() {
        $this->start_controls_section(
            'section_header',
            [
                'label' => __('Header', 'fundor-core'),
            ]
        );

        $this->add_control(
            'heading',
            [
                'label' => __('Title', 'fundor-core'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Pricing Table', 'fundor-core'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pricing',
            [
                'label' => __('Pricing', 'fundor-core'),
            ]
        );

        $this->add_control(
            'price',
            [
                'label' => __('Price', 'fundor-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => '39.99',
            ]
        );

        $this->add_control(
            'period',
            [
                'label' => __('Period', 'fundor-core'),
                'type' => Controls_Manager::TEXT,
                'default' => __('', 'fundor-core'),
                'placeholder'   => __('Period ...','fundor-core'),
            ]
        );

        $this->add_control(
            'currency_symbol',
            [
                'label' => __('Currency Symbol', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => __('None', 'fundor-core'),
                    'dollar' => '&#36; ' . _x('Dollar', 'Currency Symbol', 'fundor-core'),
                    'euro' => '&#128; ' . _x('Euro', 'Currency Symbol', 'fundor-core'),
                    'baht' => '&#3647; ' . _x('Baht', 'Currency Symbol', 'fundor-core'),
                    'franc' => '&#8355; ' . _x('Franc', 'Currency Symbol', 'fundor-core'),
                    'guilder' => '&fnof; ' . _x('Guilder', 'Currency Symbol', 'fundor-core'),
                    'krona' => 'kr ' . _x('Krona', 'Currency Symbol', 'fundor-core'),
                    'lira' => '&#8356; ' . _x('Lira', 'Currency Symbol', 'fundor-core'),
                    'peseta' => '&#8359 ' . _x('Peseta', 'Currency Symbol', 'fundor-core'),
                    'peso' => '&#8369; ' . _x('Peso', 'Currency Symbol', 'fundor-core'),
                    'pound' => '&#163; ' . _x('Pound Sterling', 'Currency Symbol', 'fundor-core'),
                    'real' => 'R$ ' . _x('Real', 'Currency Symbol', 'fundor-core'),
                    'ruble' => '&#8381; ' . _x('Ruble', 'Currency Symbol', 'fundor-core'),
                    'rupee' => '&#8360; ' . _x('Rupee', 'Currency Symbol', 'fundor-core'),
                    'indian_rupee' => '&#8377; ' . _x('Rupee (Indian)', 'Currency Symbol', 'fundor-core'),
                    'shekel' => '&#8362; ' . _x('Shekel', 'Currency Symbol', 'fundor-core'),
                    'yen' => '&#165; ' . _x('Yen/Yuan', 'Currency Symbol', 'fundor-core'),
                    'won' => '&#8361; ' . _x('Won', 'Currency Symbol', 'fundor-core'),
                    'custom' => __('Custom', 'fundor-core'),
                ],
                'default' => 'dollar',
            ]
        );

        $this->add_control(
            'currency_symbol_custom',
            [
                'label' => __('Custom Symbol', 'fundor-core'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'currency_symbol' => 'custom',
                ],
            ]
        );

        $this->add_control(
            'currency_format',
            [
                'label' => __('Currency Format', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '' => '1,234.56 (Default)',
                    ',' => '1.234,56',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_features',
            [
                'label' => __('Features', 'fundor-core'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_text',
            [
                'label' => __('Text', 'fundor-core'),
                'type' => Controls_Manager::TEXT,
                'default' => __('List Item', 'fundor-core'),
            ]
        );

        $this->add_control(
            'features_list',
            [
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_text' => __('List Item #1', 'fundor-core'),
                    ],
                    [
                        'item_text' => __('List Item #2', 'fundor-core'),
                    ],
                    [
                        'item_text' => __('List Item #3', 'fundor-core'),
                    ],
                ],
                'title_field' => '{{{ item_text }}}',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button',
            [
                'label' => __('Button', 'fundor-core'),
            ]
        );

        $this->add_control(
            'button_type',
            [
                'label' => __('Type', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
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

        $this->add_control(
            'button_size',
            [
                'label' => __('Size', 'fundor-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'md',
                'options' => [
                    'xs' => __('Extra Small', 'fundor-core'),
                    'sm' => __('Small', 'fundor-core'),
                    'md' => __('Medium', 'fundor-core'),
                    'lg' => __('Large', 'fundor-core'),
                    'xl' => __('Extra Large', 'fundor-core'),
                ],
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => __('Button Text', 'fundor-core'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Click Here', 'fundor-core'),
            ]
        );

        $this->add_control(
            'link',
            [
                'label' => __('Link', 'fundor-core'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'fundor-core'),
                'default' => [
                    'url' => '#',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_ribbon',
            [
                'label' => __( 'Ribbon', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'show_ribbon',
            [
                'label'     => __( 'Show', 'fundor-core' ),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => '',
            ]
        );

        $this->end_controls_section();


        //WRAPPER
        $this->start_controls_section(
            'section_wrapper_style',
            [
                'label' => __('Wrapper', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'wrapper_background',
            [
                'label' => __('Background', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table' => 'background: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => __('Padding', 'fundor-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        //HEADING
        $this->start_controls_section(
            'price_table_heading_style',
            [
                'label' => __('Heading', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__heading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .elementor-price-table__heading',
            ]
        );

        $this->add_control(
            'heading_spacing',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__heading' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        //PRICNG

        $this->start_controls_section(
            'section_pricing_element_style',
            [
                'label' => __('Pricing', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );


        $this->add_control(
            'price_heading',
            [
                'label' => __('Price', 'fundor-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'price_typography',
                'selector' => '{{WRAPPER}} .elementor-price-table__integer-part',
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__integer-part' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'sprice_spacing',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__price' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'symbol_heading',
            [
                'label' => __('Symbol', 'fundor-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'symbol_typography',
                'selector' => '{{WRAPPER}} .elementor-price-table__currency',
            ]
        );

        $this->add_control(
            'symbol_color',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__currency' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'period_heading',
            [
                'label' => __('Period', 'fundor-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'period_typography',
                'selector' => '{{WRAPPER}} .elementor-price-table__period',
            ]
        );

        $this->add_control(
            'period_color',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__period' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'period_spacing',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__period' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();


        // FEATURED
        $this->start_controls_section(
            'section_features_list_style',
            [
                'label' => __('Features', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'features_typography',
                'selector' => '{{WRAPPER}} .elementor-price-table__features-list',
            ]
        );

        $this->add_control(
            'features_color',
            [
                'label' => __('Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__features-list' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'features_spacing',
            [
                'label' => __('Spacing', 'fundor-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__feature-inner ' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();


        //BUTON

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => __('Button', 'fundor-core'),
                'tab' => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition' => [
                    'button_text!' => '',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .elementor-price-table__button',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-button',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'button_box_shadow',
                'selector' => '.elementor-price-table__button.elementor-button'
            ]
        );

        $this->add_control(
            'border_radius',
            [
                'label' => __('Border Radius', 'fundor-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'text_padding',
            [
                'label' => __('Padding', 'fundor-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} a.elementor-button, {{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => __('Normal', 'fundor-core'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__button:not(:hover)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => __('Background Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__button:not(:hover)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => __('Hover', 'fundor-core'),
            ]
        );

        $this->add_control(
            'button_hover_color',
            [
                'label' => __('Text Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_hover_color',
            [
                'label' => __('Background Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_hover_color',
            [
                'label' => __('Border Color', 'fundor-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_hover_animation',
            [
                'label' => __('Animation', 'fundor-core'),
                'type' => Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_ribbon_style',
            [
                'label'      => __( 'Ribbon', 'fundor-core' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition'  => [
                    'show_ribbon' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'ribbon_bg_color',
            [
                'label'     => __( 'Background', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__ribbon' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'ribbon_icon_color',
            [
                'label'     => __( 'Icon Color', 'fundor-core' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-price-table__ribbon' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function get_currency_symbol($symbol_name) {
        $symbols = [
            'dollar' => '&#36;',
            'euro' => '&#128;',
            'franc' => '&#8355;',
            'pound' => '&#163;',
            'ruble' => '&#8381;',
            'shekel' => '&#8362;',
            'baht' => '&#3647;',
            'yen' => '&#165;',
            'won' => '&#8361;',
            'guilder' => '&fnof;',
            'peso' => '&#8369;',
            'peseta' => '&#8359',
            'lira' => '&#8356;',
            'rupee' => '&#8360;',
            'indian_rupee' => '&#8377;',
            'real' => 'R$',
            'krona' => 'kr',
        ];
        return isset($symbols[$symbol_name]) ? $symbols[$symbol_name] : '';
    }

    protected function render() {
        $settings = $this->get_settings();
        $symbol = '';

        if (!empty($settings['currency_symbol'])) {
            if ('custom' !== $settings['currency_symbol']) {
                $symbol = $this->get_currency_symbol($settings['currency_symbol']);
            } else {
                $symbol = $settings['currency_symbol_custom'];
            }
        }
        $currency_format = empty($settings['currency_format']) ? '.' : $settings['currency_format'];

        $this->add_render_attribute('button_text', 'class', [
            'elementor-price-table__button',
            'elementor-button',
            'elementor-size-' . $settings['button_size'],
        ]);

        if (!empty($settings['link']['url'])) {
            $this->add_render_attribute('button_text', 'href', $settings['link']['url']);

            if (!empty($settings['link']['is_external'])) {
                $this->add_render_attribute('button_text', 'target', '_blank');
            }
        }

        if (!empty($settings['button_hover_animation'])) {
            $this->add_render_attribute('button_text', 'class', 'elementor-animation-' . $settings['button_hover_animation']);
        }

        if ( !empty($settings['icon']) ) {
            $this->add_render_attribute( 'i', 'class', $settings['icon'] );
            $this->add_render_attribute( 'i', 'aria-hidden', 'true' );
        }

        $this->add_render_attribute('heading', 'class', 'elementor-price-table__heading');
        $this->add_render_attribute('description', 'class', 'elementor-price-table__heading-description');
        $this->add_render_attribute('period', 'class', 'elementor-price-table__period');
        $this->add_render_attribute('item_repeater', 'class', 'item-active');

        $this->add_inline_editing_attributes('heading', 'none');
        $this->add_inline_editing_attributes('description');
        $this->add_inline_editing_attributes('button_text');
        $this->add_inline_editing_attributes('item_repeater');

        $period_element = '<div ' . $this->get_render_attribute_string('period') . '>/' . $settings['period'] . '</div>';


        ?>

        <div class="elementor-price-table">
            <div class="elementor-price-table__wrapper-header">

                <?php
                $pricing_number = '';
                if(!empty($settings['price'])) {
                    $pricing_string = (string)$settings['price'];
                    $pricing_array = explode('.', $pricing_string);
                    if (isset($pricing_array[1]) && strlen($pricing_array[1]) < 2) {
                        $decimals = 1;
                    } else {
                        $decimals = 2;
                    }

                    if (count($pricing_array) < 2) {
                        $decimals = 0;
                    }

                    if (empty($settings['currency_format'])) {
                        $dec_point = '.';
                        $thousands_sep = ',';
                    } else {
                        $dec_point = ',';
                        $thousands_sep = '.';
                    }
                    $pricing_number = number_format($settings['price'], $decimals, $dec_point, $thousands_sep);
                }
                ?>

                <?php if ($settings['heading']) : ?>
                    <div class="elementor-price-table__header">
                        <?php if (!empty($settings['heading'])) : ?>
                            <h3 <?php echo $this->get_render_attribute_string('heading'); ?>><?php echo $settings['heading']; ?></h3>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="elementor-price-table__price">
                    <?php if (!empty($settings['price'])) : ?>
                        <?php if (!empty($symbol)) : ?>
                            <span class="elementor-price-table__currency"><?php echo $symbol; ?></span>
                        <?php endif; ?>
                        <span class="elementor-price-table__integer-part"><?php echo $pricing_number; ?></span>
                    <?php endif; ?>
                </div>

                <!--            html period-->
                <?php if (!empty($settings['period'])) : ?>
                    <?php echo $period_element; ?>
                <?php endif; ?>
            </div>

            <!--            end header-->

            <?php if (!empty($settings['features_list'])) : ?>
                <ul class="elementor-price-table__features-list">
                    <?php foreach ($settings['features_list'] as $index => $item) :
                        $repeater_setting_key = $this->get_repeater_setting_key('item_text', 'features_list', $index);
                        $this->add_inline_editing_attributes($repeater_setting_key);
                        ?>
                        <li class="elementor-repeater-item-<?php echo $item['_id']; ?>">
                            <div class="elementor-price-table__feature-inner <?php echo esc_attr__($class_active,'fundor-core');?>">
                                <?php if (!empty($item['item_text'])) : ?>
                                    <span <?php echo $this->get_render_attribute_string($repeater_setting_key); ?>>
										<?php echo $item['item_text']; ?>
									</span>
                                <?php else :
                                    echo '&nbsp;';
                                endif;
                                ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <?php if (!empty($settings['button_text'])) : ?>
                <div class="elementor-price-table__footer">
                    <?php if (!empty($settings['button_text'])) : ?>
                        <a <?php echo $this->get_render_attribute_string('button_text'); ?>>
                            <span class="elementor-price-table_button-text"><?php echo $settings['button_text']; ?></span>
                        </a>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

            <?php if ( 'yes' === $settings['show_ribbon'] ) :
			$this->add_render_attribute( 'ribbon-wrapper', 'class', 'elementor-price-table__ribbon' );
			?>
            <div <?php echo $this->get_render_attribute_string( 'ribbon-wrapper' ); ?>>
                <i class="fa fa-star" aria-hidden="true"></i>
            </div>
		<?php endif; ?>

        </div>
        <?php
    }
}

$widgets_manager->register_widget_type(new OSF_Elementor_Price_Table());