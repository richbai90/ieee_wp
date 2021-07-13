<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Give' ) ) {
	return;
}

use Elementor\Control_Media;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;
use Elementor\Scheme_Typography;
use Elementor\Scheme_Color;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

/**
 * Class OSF_Elementor_Blog
 */
class OSF_Elementor_Give_Categories extends OSF_Elementor_Carousel_Base {

	public function get_name() {
		return 'opal-give-categories';
	}

	public function get_title() {
		return __( 'Opal Give Categories', 'fundor-core' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve testimonial widget icon.
	 *
	 * @return string Widget icon.
	 * @since  1.0.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return array( 'opal-addons' );
	}

	protected function _register_controls() {
		$this->start_controls_section(
			'section_c',
			[
				'label' => __( 'Content', 'fundor-core' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'selected_icon',
			[
				'label'   => __( 'Icon', 'fundor-core' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-star',
					'library' => 'fa-solid',
				],
			]
		);

		$this->add_control(
			'categories',
			[
				'label'    => __( 'Categories', 'fundor-core' ),
				'type'     => Controls_Manager::SELECT,
				'options'  => $this->get_post_categories(),
				'multiple' => true,
			]
		);

		$this->add_responsive_control(
			'text_align',
			[
				'label'     => __( 'Alignment', 'fundor-core' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => __( 'Left', 'fundor-core' ),
						'icon'  => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'fundor-core' ),
						'icon'  => 'fa fa-align-center',
					],
					'right'  => [
						'title' => __( 'Right', 'fundor-core' ),
						'icon'  => 'fa fa-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .elementor-give-categories-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_icon',
			[
				'label' => __( 'Icon', 'fundor-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => __( 'Color', 'fundor-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-give-category-icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_bkg',
			[
				'label'     => __( 'Background', 'fundor-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .categories_bkg, {{WRAPPER}} .categories_bkg:before, {{WRAPPER}} .categories_bkg:after' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => __( 'Size', 'fundor-core' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 6,
						'max' => 300,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-give-category-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_space',
			[
				'label'     => __( 'Spacing', 'fundor-core' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-give-category-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'     => __( 'Padding', 'fundor-core' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => [
					'{{WRAPPER}} .elementor-give-category-icon' => 'padding: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_effect',
			[
				'label'        => __( 'Effect', 'fundor-core' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'on',
				'separator'    => 'before',
				'prefix_class' => 'give-category-effect-'
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_title',
			[
				'label' => __( 'Title', 'fundor-core' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .elementor-give-category-title',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => __( 'Color', 'fundor-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-give-category-title a:not(:hover)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'title_color_hover',
			[
				'label'     => __( 'Color Hover', 'fundor-core' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-give-category-title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function get_post_categories() {
		$categories = get_terms( array(
				'taxonomy'   => 'give_forms_category',
				'hide_empty' => false,
			)
		);
		$results    = array();
		if ( ! is_wp_error( $categories ) ) {
			foreach ( $categories as $category ) {
				$results[ $category->slug ] = $category->name;
			}
		}

		return $results;
	}


	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'elementor-give-categories-wrapper' );

		$has_icon = ! empty( $settings['selected_icon'] );

		if ( $has_icon ) {
			$this->add_render_attribute( 'i', 'class', $settings['selected_icon'] );
			$this->add_render_attribute( 'i', 'aria-hidden', 'true' );
		}

		$migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
		$is_new   = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
		?>
        <div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( ! empty( $settings['categories'] ) ): ?>
				<?php
				$term = get_term_by( 'slug', $settings['categories'], 'give_forms_category' );
				?>
				<?php if ( $settings['selected_icon']['value'] ) : ?>
                    <div class="elementor-give-category-icon">
                        <span class="categories-icon">
                            <?php if ( $is_new || $migrated ) :
                                Icons_Manager::render_icon( $settings['selected_icon'] );
                            else: ?>
                                <i <?php echo $this->get_render_attribute_string( 'i' ); ?>></i>
                            <?php endif; ?>
                        </span>
                        <span class="categories_bkg"></span>
                        <a href="<?php echo get_term_link( $settings['categories'], 'give_forms_category' ); ?>"></a>
                    </div>
				<?php endif; ?>
                <div class="elementor-give-category-title">
                    <a href="<?php echo get_term_link( $settings['categories'], 'give_forms_category' ); ?>"><?php echo esc_html( $term->name ); ?></a>
                </div>
			<?php endif; ?>
        </div>
		<?php
	}


}

$widgets_manager->register_widget_type( new OSF_Elementor_Give_Categories() );