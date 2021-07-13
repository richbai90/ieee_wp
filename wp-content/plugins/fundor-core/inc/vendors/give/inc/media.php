<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class OSF_Give_Media_Frame {

	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'add_scripts' ), 100 );
		add_filter( 'posts_where', array( $this, 'hide_others_uploads' ), 1 );
		add_action( 'wp_enqueue_scripts', [ $this, 'check_media' ] );
        add_filter( 'ajax_query_attachments_args', [$this, 'media_uploader_restrict']);

	}

	public function check_media() {
		global $post;

		if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'opal_give_dashboard' ) ) {
			wp_enqueue_media();
		}
	}

	public function add_scripts() {
		$opal_l10n['choose_featured_img'] = esc_html__( 'Upload featured image', 'fundor-core' );
		$opal_l10n['choose_file']         = esc_html__( 'Choose a file', 'fundor-core' );
		$opal_l10n['ajaxurl']             = admin_url( 'admin-ajax.php' );

		wp_enqueue_script( 'osf-media-script', trailingslashit( FUNDOR_CORE_PLUGIN_URL ) . 'assets/js/media/main.js', array( 'jquery' ), false, true );
		wp_localize_script( 'osf-media-script', 'osf_media', $opal_l10n );
	}

	public function hide_others_uploads( $where ) {
		global $pagenow, $wpdb;
		if ( ( $pagenow == 'upload.php' || $pagenow == 'media-upload.php' ) && current_user_can( 'opal_media' ) ) {
			$user_id = get_current_user_id();
			$where .= " AND $wpdb->posts.post_author = $user_id";
		}

		return $where;
	}

    public function media_uploader_restrict( $args ) {
        // bail out for admin and editor
        if ( current_user_can( 'delete_pages' ) ) {
            return $args;
        }

        if ( current_user_can( 'opal_media' ) ) {
            $args['author'] = get_current_user_id();

            return $args;
        }

        return $args;
    }

}

return new OSF_Give_Media_Frame();