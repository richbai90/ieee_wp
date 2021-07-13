<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class OSF_Give_Campaign_Shortcodes {
	public function __construct() {
		add_shortcode( 'opal_give_dashboard', array( $this, 'dashboard_content' ) );
		add_shortcode( 'opal_give_creator_detail', array( $this, 'creator_detail' ) );
	}

	public function creator_detail() {
		global $wp;
		$user_slug = false;
		if ( isset( $wp->query_vars['detail'] ) && $wp->query_vars['detail'] ) {
			$user_slug = $wp->query_vars['detail'];
		}

		ob_start();
		osf_give_get_template( 'creator.php', [ 'user_slug' => $user_slug ] );
		return ob_get_clean();
	}

	public function dashboard_content() {

		ob_start();

		osf_give_get_template( 'wrapper.php' );

		return ob_get_clean();
	}

}

return new OSF_Give_Campaign_Shortcodes();