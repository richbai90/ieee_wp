<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class OSF_Give_Campaigns {

	public function __construct() {
		add_action( 'save_post', [ $this, 'save_campaign' ] );
		add_action( 'delete_post', [ $this, 'delete_campaign' ] );

		add_action( 'post_updated', [ $this, 'campaign_updated' ], 10, 3 );
	}

	/**
	 * @param $post_id int
	 * @param $post_after WP_Post
	 * @param $post_before WP_Post
	 */
	public function campaign_updated( $post_id, $post_after, $post_before ) {
		if ( 'give_forms' == get_post_type( $post_id ) ) {
			$creator_after  = new Opal_Give_Creator( $post_after->post_author );
			$creator_before = new Opal_Give_Creator( $post_before->post_author );
			if ( $post_after->post_status == 'trash' ) {
				$creator_after->remove_campaign_id( $post_id );
				$creator_before->remove_campaign_id( $post_id );
			} elseif ( $post_before->post_author != $post_after->post_author ) {
				$creator_after->add_campaign_id( $post_id );
				$creator_before->remove_campaign_id( $post_id );
			}
		}
	}

	public function save_campaign( $post_id ) {
		if ( 'give_forms' == get_post_type( $post_id ) ) {
			$post_author_id = get_post_field( 'post_author', $post_id );
			$creator        = new Opal_Give_Creator( $post_author_id );
			$creator->add_campaign_id( $post_id );
		}
	}

	public function delete_campaign( $post_id ) {
		if ( 'give_forms' == get_post_type( $post_id ) ) {
			$post_author_id = get_post_field( 'post_author', $post_id );
			$creator        = new Opal_Give_Creator( $post_author_id );
			$creator->remove_campaign_id( $post_id );
		}

	}

}

return new OSF_Give_Campaigns();