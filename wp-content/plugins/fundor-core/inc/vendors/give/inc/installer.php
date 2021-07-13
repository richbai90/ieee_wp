<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class OSF_Give_Installer {
	public function do_install() {
		$this->user_roles();
	}

	public function user_roles() {
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) && ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}
		add_role( 'opal-creator', __( 'Opal Creator', 'fundor-core' ), array(
			'read'            => true,
			'unfiltered_html' => true,
			'upload_files'    => true,
			'opal_media'      => true,
		) );
	}

	public function setup_page() {
		$page_created = get_option( 'opal_give_pages_created', false );
		if ( $page_created ) {
			return;
		}

		$pages = array(
			array(
				'post_title' => __( 'Dashboard', 'fundor-core' ),
				'slug'       => 'dashboard',
				'content'    => '[opal_give_dashboard]',
			),
			array(
				'post_title' => __( 'Creator', 'fundor-core' ),
				'slug'       => 'creator',
				'content'    => '[opal_give_creator]',
			)
		);


		foreach ( $pages as $page ) {
			$page_id = $this->create_page( $page );
			give_update_option('osf_dashboard_page', $page_id);
		} // end foreach

		update_option( 'opal_give_pages_created', true );
	}

	private function create_page( $page ) {
		$meta_key = '_wp_page_template';
		$page_obj = get_page_by_path( $page['post_title'] );

		if ( ! $page_obj ) {
			$page_id = wp_insert_post( array(
				'post_title'     => $page['post_title'],
				'post_name'      => $page['slug'],
				'post_content'   => $page['content'],
				'post_status'    => 'publish',
				'post_type'      => 'page',
				'comment_status' => 'closed',
			) );

			if ( $page_id && ! is_wp_error( $page_id ) ) {

				if ( isset( $page['template'] ) ) {
					update_post_meta( $page_id, $meta_key, $page['template'] );
				}

				return $page_id;
			}
		}

		return false;
	}
}

return new OSF_Give_Installer();