<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class OSF_Give_Payment {
	public function __construct() {
		add_action( 'give_update_payment_status', [ $this, 'complete_purchase' ], 100, 3 );
		add_action( 'delete_post', [ $this, 'delete_payment' ] );

		add_action( 'post_updated', [ $this, 'updated_payment' ] );
	}

	public function updated_payment( $payment_id ) {
		global $post_type;
		if ( $post_type != 'give_payment' ) {
			return;
		}

		$payment = new Give_Payment( $payment_id );

		$creator  = new Opal_Give_Creator( get_post_field( 'post_author', $payment->form_id ) );
		$params   = array(
			'posts_per_page' => - 1,
			'post_type'      => [
				'give_forms',
			],
			'author'         => $creator->ID
		);
		$query    = new WP_Query( $params );
		$earnings = 0;
		while ( $query->have_posts() ): $query->the_post();
			$form     = new Give_Donate_Form( get_the_ID() );
			$earnings += $form->get_earnings();
		endwhile;

		$creator->set_earnings( floatval($earnings) );
	}

	public function delete_payment( $payment_id ) {
		global $post_type;
		if ( $post_type != 'give_payment' ) {
			return;
		}

		$payment = new Give_Payment( $payment_id );
		$total   = - 1 * floatval( $payment->total );
		$creator = new Opal_Give_Creator( get_post_field( 'post_author', $payment->form_id ) );
		$creator->set_earnings( $total );
	}

	public function complete_purchase( $payment_id, $new_status, $old_status ) {
		$payment = new Give_Payment( $payment_id );
		$total   = floatval( $payment->total );
		if ( $new_status != 'publish' ) {
			$total = - 1 * $total;
		}

		$creator = new Opal_Give_Creator( get_post_field( 'post_author', $payment->form_id ) );
		$creator->set_earnings( $total );
	}

}

return new OSF_Give_Payment();