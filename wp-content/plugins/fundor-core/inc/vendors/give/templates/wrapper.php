<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
global $wp;
?>
<div class="profile-wrapper row">
	<?php
	if ( ! is_user_logged_in() ) { ?>
        <div class="profile-login col-12">
			<?php osf_give_get_template( 'login-register.php' ); ?>
        </div>
	<?php } else {
		$creator = new Opal_Give_Creator( get_current_user_id() );

		if ( true ) {
			?>
            <div class="profile-sidebar col">
				<?php osf_give_get_template( 'sidebar.php', [ 'creator' => $creator ] ); ?>
            </div>
            <div class="profile-content col">
				<?php
				if ( isset( $wp->query_vars['edit-campaign'] ) ) {
					$campaign = new Give_Donate_Form( $wp->query_vars['edit-campaign'] );

					if ( $campaign && get_post_status( $wp->query_vars['edit-campaign'] )
					     && ( get_post_field( 'post_author', $wp->query_vars['edit-campaign'] ) == get_current_user_id() )
					     && ( 'give_forms' == get_post_type( $wp->query_vars['edit-campaign'] ) ) ) {

						osf_give_get_template( 'edit-campaign.php', [ 'campaign' => $campaign ] );

					} else {
						echo 'sorry!';
					}
				} elseif ( isset( $wp->query_vars['campaigns'] ) ) {
					osf_give_get_template( 'campaigns.php', [ 'creator' => $creator ] );
				} elseif ( isset( $wp->query_vars['payment'] ) ) {
					osf_give_get_template( 'payment.php', [ 'creator' => $creator ] );
				} elseif ( isset( $wp->query_vars['add-campaign'] ) ) {
					osf_give_get_template( 'add-campaign.php', [ 'creator' => $creator ] );
				} else {
					osf_give_get_template( 'dashboard.php' );
				}
				?>
            </div>
			<?php
		}
	}
	?>
</div>