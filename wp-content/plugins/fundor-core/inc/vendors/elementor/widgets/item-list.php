<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor icon list widget.
 *
 * Elementor widget that displays a bullet list with any chosen icons and texts.
 *
 * @since 1.0.0
 */
class OSF_Widget_Item_List extends Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve icon list widget name.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'item-list';
    }

    /**
     * Get widget title.
     *
     * Retrieve icon list widget title.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget title.
     */
    public function get_title() {
        return __( 'Item List', 'fundor-core' );
    }

    /**
     * Get widget icon.
     *
     * Retrieve icon list widget icon.
     *
     * @since 1.0.0
     * @access public
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-bullet-list';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @since 2.1.0
     * @access public
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return [ 'item list', 'icon', 'list' ];
    }

    /**
     * Register icon list widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {
        $this->start_controls_section(
            'section_icon',
            [
                'label' => __( 'Item List', 'fundor-core' ),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'text',
            [
                'label' => __( 'Title', 'fundor-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __( 'Enter Title...', 'fundor-core' ),
                'default' => __( 'Title Item', 'fundor-core' ),
            ]
        );

        $repeater->add_control(
            'description',
            [
                'label' => __( 'Description', 'fundor-core' ),
                'type' => Controls_Manager::TEXT,
                'label_block' => true,
                'placeholder' => __( 'Enter Description...', 'fundor-core' ),
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label' => __( 'Link', 'fundor-core' ),
                'type' => Controls_Manager::URL,
                'label_block' => true,
                'placeholder' => __( 'https://your-link.com', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'icon_list',
            [
                'label' => '',
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'text' => __( 'Title Item #1', 'fundor-core' ),
                    ],
                    [
                        'text' => __( 'Title Item #2', 'fundor-core' ),
                    ],
                    [
                        'text' => __( 'Title Item #3', 'fundor-core' ),
                    ],
                ],
                'title_field' => '{{{ text }}}',
            ]
        );


        $this->add_responsive_control(
            'list_item_column',
            [
                'label'      => __('Column Item', 'fundor-core'),
                'type'       => Controls_Manager::SELECT,
                'options'   => [
                    '1' => __('1','fundor-core'),
                    '2' => __('2','fundor-core'),
                    '3' => __('3','fundor-core'),
                ],
                'default'   => '1',
                'selectors'    => [
                    '{{WRAPPER}} .elementor-icon-list-items' => 'column-count: {{VALUE}};-moz-column-count: {{VALUE}};-webkit-column-count: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'section_icon_list',
            [
                'label' => __( 'List', 'fundor-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_list_item',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-icon-list-item',
            ]
        );

        $this->add_control(
            'list_item_border_radius',
            [
                'label'      => __( 'Border Radius', 'fundor-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-icon-list-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'list_item_padding',
            [
                'label'      => __( 'Padding', 'fundor-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-icon-list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'list_item_margin',
            [
                'label'      => __( 'Margin', 'fundor-core' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-icon-list-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_align',
            [
                'label' => __( 'Alignment', 'fundor-core' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'fundor-core' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __( 'Center', 'fundor-core' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'fundor-core' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'elementor%s-align-',
                'separator'   => 'before',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_text_style',
            [
                'label' => __( 'Text', 'fundor-core' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_indent',
            [
                'label' => __( 'Text Indent', 'fundor-core' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-text' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'icon_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-list-item',
                'scheme' => Scheme_Typography::TYPOGRAPHY_3,
            ]
        );

        $this->start_controls_tabs( 'tabs_text_style' );

        $this->start_controls_tab(
            'tab_text_normal',
            [
                'label' => __( 'Normal', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Title Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-text' => 'color: {{VALUE}};',
                ],
                'scheme' => [
                    'type' => Scheme_Color::get_type(),
                    'value' => Scheme_Color::COLOR_3,
                ],
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => __( 'Description Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_text_hover',
            [
                'label' => __( 'Hover', 'fundor-core' ),
            ]
        );

        $this->add_control(
            'text_color_hover',
            [
                'label' => __( 'Title Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-text' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'description_color_hover',
            [
                'label' => __( 'Description Color', 'fundor-core' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-list-item:hover .elementor-icon-list-description' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * Render icon list widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        $this->add_render_attribute( 'icon_list', 'class', 'elementor-icon-list-items' );
        $this->add_render_attribute( 'list_item', 'class', 'elementor-icon-list-item' );

        ?>
        <ul <?php echo $this->get_render_attribute_string( 'icon_list' ); ?>>
            <?php
            foreach ( $settings['icon_list'] as $index => $item ) :
                $repeater_setting_key = $this->get_repeater_setting_key( 'text', 'icon_list', $index );
                $repeater_setting_key_sub = $this->get_repeater_setting_key( 'description', 'icon_list', $index );

                $this->add_render_attribute( $repeater_setting_key, 'class', 'elementor-icon-list-text' );
                $this->add_inline_editing_attributes( $repeater_setting_key );
                $this->add_render_attribute( $repeater_setting_key_sub, 'class', 'elementor-icon-list-description' );
                $this->add_inline_editing_attributes( $repeater_setting_key_sub );
                ?>
                <li class="elementor-icon-list-item" >
                    <?php
                    if ( ! empty( $item['link']['url'] ) ) {
                        $link_key = 'link_' . $index;

                        $this->add_render_attribute( $link_key, 'href', $item['link']['url'] );

                        if ( $item['link']['is_external'] ) {
                            $this->add_render_attribute( $link_key, 'target', '_blank' );
                        }

                        if ( $item['link']['nofollow'] ) {
                            $this->add_render_attribute( $link_key, 'rel', 'nofollow' );
                        }

                        echo '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
                    }

                        ?>
                    <span class="elementor-item-list-number">
                        <?php
                            $item_number = $index + 1;
                            if ($item_number<10){
                                echo '0'."$item_number".'.';
                            }
                            else{
                                echo "$item_number".'.';
                            }
                        ?>
                    </span>
                    <span <?php echo $this->get_render_attribute_string( $repeater_setting_key ); ?>><?php echo $item['text']; ?><?php if ($item['description']) echo ':';?></span>
                    <span <?php echo $this->get_render_attribute_string( $repeater_setting_key_sub ); ?>><?php echo $item['description']; ?></span>
                    <?php if ( ! empty( $item['link']['url'] ) ) : ?>
                        </a>
                    <?php endif; ?>
                </li>
            <?php
            endforeach;
            ?>
        </ul>
        <?php
    }
}
$widgets_manager->register_widget_type(new OSF_Widget_Item_List());