<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function osf_give_get_template( $template_name, $args = array() ) {
	extract( $args );
	include trailingslashit( FUNDOR_CORE_PLUGIN_DIR ) . 'inc/vendors/give/templates/' . $template_name;
}

function osf_give_get_dashboard_link( $sub = '' ) {
	$dashboard_page = give_get_option( 'osf_dashboard_page', false );
	if ( $dashboard_page ) {
		return get_permalink( $dashboard_page ) . $sub;
	}

	return home_url();
}

function osf_give_get_creator_link( $sub = '' ) {
	$creator_page = give_get_option( 'osf_creator_page', false );
	if ( $creator_page ) {
		return get_permalink( $creator_page ) . 'detail/'. $sub;
	}

	return home_url();
}

/**
 * @param $loop WP_Query
 */
function osf_give_the_paginate( $loop ) {
	$paginate_args = array(
		'format'    => '?paging=%#%',
		'current'   => isset( $_GET['paging'] ) ? absint( $_GET['paging'] ) : 1,
		'total'     => $loop->max_num_pages,
		'show_all'  => false,
		'prev_next' => true,
		'prev_text' => esc_html__( '« Previous', 'fundor-core' ),
		'next_text' => esc_html__( 'Next »', 'fundor-core' ),
		'type'      => 'plain',
	);

	printf(
		'<div class="give-page-numbers">%s</div>',
		paginate_links( apply_filters( 'osf_give_get_paginate_args', $paginate_args ) )
	);
}

/**
 * @param $price string
 */
function osf_give_format_price( $price ) {
	$currency = give_get_option( 'currency' );
	$amount   = give_format_amount( $price,
		array(
			'sanitize' => true,
			'currency' => $currency,
		)
	);
	$symbol   = give_currency_symbol( $currency );
	$position = give_get_option( 'currency_position' );
	if ( $position == 'before' ) {
		return $symbol . $amount;
	}

	return $amount . $symbol;

}