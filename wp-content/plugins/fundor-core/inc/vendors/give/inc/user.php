<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class OSF_Give_User {
	public function __construct() {
		add_action( 'admin_init', array( $this, 'block_admin_access' ) );

		add_action( 'show_user_profile', [ $this, 'add_custom_user_profile_fields' ] );
		add_action( 'edit_user_profile', [ $this, 'add_custom_user_profile_fields' ] );

		add_action( 'personal_options_update', [ $this, 'save_custom_user_profile_fields' ] );
		add_action( 'edit_user_profile_update', [ $this, 'save_custom_user_profile_fields' ] );

		add_filter('show_admin_bar', [$this, 'show_hide_admin_bar']);
	}

	/**
	 * @return bool
	 */
	public function show_hide_admin_bar($is_show){
	    $user_id = get_current_user_id();
	    if($user_id){
		    $creator = new Opal_Give_Creator($user_id);
		    if($creator->is_creator()){
		        return false;
            }
        }
	    return $is_show;
    }

	public function add_custom_user_profile_fields( $user ) {

		if ( 'opal-creator' == $user->roles[0] ) {
			?>

            <table class="form-table">
                <tr>
                    <th>
                        <label for="location"><?php _e( 'Location', 'fundor-core' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="user_location" id="user_location" value="<?php echo esc_attr( get_the_author_meta( 'user_location', $user->ID ) ); ?>" class="regular-text"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="company"><?php _e( 'Company', 'fundor-core' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="user_company" id="user_company" value="<?php echo esc_attr( get_the_author_meta( 'user_company', $user->ID ) ); ?>" class="regular-text"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="user_phone"><?php _e( 'Phone', 'fundor-core' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="user_phone" id="user_phone" value="<?php echo esc_attr( get_the_author_meta( 'user_phone', $user->ID ) ); ?>" class="regular-text"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="user_fax"><?php _e( 'Fax', 'fundor-core' ); ?></label>
                    </th>
                    <td>
                        <input type="text" name="user_fax" id="user_fax" value="<?php echo esc_attr( get_the_author_meta( 'user_fax', $user->ID ) ); ?>" class="regular-text"/>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="campaign-max"><?php _e( 'Create campaign max', 'fundor-core' ); ?></label>
                    </th>
                    <td>
                        <input type="number" name="campaign_max" id="campaign-max" value="<?php echo empty( get_the_author_meta( 'campaign_max', $user->ID ) ) ? 5 : esc_attr( get_the_author_meta( 'campaign_max', $user->ID ) ); ?>" class="regular-text"/>
                    </td>
                </tr>
            </table>
		<?php }
	}

	public function save_custom_user_profile_fields( $user_id ) {

		if ( ! current_user_can( 'edit_user', $user_id ) ) {
			return false;
		}

		update_user_meta( $user_id, 'campaign_max', $_POST['campaign_max'] );
        update_user_meta( $user_id, 'user_location', $_POST['user_location'] );
        update_user_meta( $user_id, 'user_company', $_POST['user_company'] );
        update_user_meta( $user_id, 'user_phone', $_POST['user_phone'] );
        update_user_meta( $user_id, 'user_fax', $_POST['user_fax'] );
	}

    public function block_admin_access() {
        global $pagenow, $current_user;

        // bail out if we are from WP Cli
        if ( defined( 'WP_CLI' ) ) {
            return;
        }

        $valid_pages = array( 'admin-ajax.php', 'admin-post.php', 'async-upload.php', 'media-upload.php' );
        $user_role   = reset( $current_user->roles );

        if ( ( !in_array( $pagenow, $valid_pages ) ) && in_array( $user_role, array( 'opal-creator', ) ) ) {
            wp_redirect( home_url() );
            exit;
        }
    }

}

return new OSF_Give_User();