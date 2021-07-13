<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class OSF_Give_Admin {
	public function __construct() {
		add_filter( 'display_post_states', [ $this, 'post_states' ], 10, 2 );
	}

	/**
	 * @param $post_states
	 * @param $post WP_Post
	 */
	public function post_states( $post_states, $post ) {
		switch ($post->ID){
			case give_get_option( 'osf_dashboard_page' ):
				$post_states['opal_give_dashboard'] = __( 'Dashboard Creator', 'fundor-core' );
				break;
			case give_get_option( 'osf_creator_page' ):
				$post_states['opal_give_creator'] = __( 'Creator Detail', 'fundor-core' );
				break;
		}

		return $post_states;
	}

}

return new OSF_Give_Admin();