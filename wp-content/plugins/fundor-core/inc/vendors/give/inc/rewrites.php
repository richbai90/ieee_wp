<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class OSF_Give_Rewrites {
	private $query_vars = [];
	public function __construct() {
		$this->query_vars = [
			"campaigns",
			"edit-campaign",
			"add-campaign",
			"payment",
			'detail'
		];

		add_action('init', [$this, 'register_rule']);
		add_filter( 'query_vars', [$this, 'register_query_var'] );
	}

	public function register_rule(){
		foreach ( $this->query_vars as $var ) {
			add_rewrite_endpoint( $var, EP_PAGES );
		}
	}

	/**
	 * @param $vars array
	 *
	 * @return array
	 */
	public function register_query_var($vars){
		foreach ($this->query_vars as $query_var){
			$vars[] = $query_var;
		}
		return $vars;
	}
}

return new OSF_Give_Rewrites();