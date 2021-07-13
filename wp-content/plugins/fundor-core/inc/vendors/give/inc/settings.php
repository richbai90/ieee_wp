<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( class_exists( 'Give_Settings_Page' ) ) :
	class OSF_Give_Settings extends Give_Settings_Page {
		public function __construct() {
			$this->id    = 'opal-give-dashboard';
			$this->label = __( 'Dashboard', 'fundor-core' );
			parent::__construct();
		}

		public function get_settings() {

			$settings = [
				[
					'name' => __( 'Dashboard Settings', 'fundor-core' ),
					'id'   => 'osf_give_title_dashboard',
					'type' => 'title',
				],
				[
					'name'       => __( 'Dashboard Page', 'fundor-core' ),
					'desc'       => sprintf( __( 'The page Dashboard are sent to after completing their donations. The %s shortcode should be on this page.', 'fundor-core' ), '<code>[opal_give_dashboard]</code>' ),
					'id'         => 'osf_dashboard_page',
					'class'      => 'give-select give-select-chosen',
					'type'       => 'select',
					'options'    => give_cmb2_get_post_options( array(
						'post_type'   => 'page',
						'numberposts' => 30,
					) ),
					'attributes' => array(
						'data-search-type' => 'pages',
						'data-placeholder' => esc_html__( 'Choose a page', 'fundor-core' ),
					)
				],
				[
					'name'       => __( 'Creator Detail Page', 'fundor-core' ),
					'desc'       => sprintf( __( 'The %s shortcode should be on this page.', 'fundor-core' ), '<code>[opal_give_creator_detail]</code>' ),
					'id'         => 'osf_creator_page',
					'class'      => 'give-select give-select-chosen',
					'type'       => 'select',
					'options'    => give_cmb2_get_post_options( array(
						'post_type'   => 'page',
						'numberposts' => 30,
					) ),
					'attributes' => array(
						'data-search-type' => 'pages',
						'data-placeholder' => esc_html__( 'Choose a page', 'fundor-core' ),
					)
				],
				[
					'type' => 'sectionend',
					'id'   => 'osf_give_title_dashboard',
				]
			];

			return $settings;
		}
	}

	return new OSF_Give_Settings();

endif;