<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var $creator Opal_Give_Creator
 */

global $wp;
?>

<div class="profile-sidebar-inner">
    <div class="profile-avatar">
		<div class="profile-avatar-img"><?php echo $creator->get_avatar(); ?></div>
        <div>
            <span class="author-name"><?php echo $creator->display_name; ?></span>
        </div>
        <a class="opal-give-button-edit-avatar">edit</a>
    </div><!-- .entry-meta -->
    <ul class="profile-sidebar-link">
        <li <?php echo isset( $wp->query_vars['page'] ) ? ' class="active"' : ''; ?>>
            <a href="<?php echo esc_url( osf_give_get_dashboard_link() ); ?>"><?php echo esc_html__( 'My Account', 'fundor-core' ) ?></a>
        </li>
        <li<?php echo isset( $wp->query_vars['campaigns'] ) ? ' class="active"' : ''; ?>>
            <a href="<?php echo esc_url( osf_give_get_dashboard_link( 'campaigns' ) ); ?>"><?php echo esc_html__( 'My Campaigns', 'fundor-core' ) ?></a>
        </li>
        <li<?php echo isset( $wp->query_vars['payment'] ) ? ' class="active"' : ''; ?>>
            <a href="<?php echo esc_url( osf_give_get_dashboard_link( 'payment' ) ); ?>"><?php echo esc_html__( 'Payment', 'fundor-core' ) ?></a>
        </li>
		<?php do_action( 'opal_give_profile_sidebar_link' ); ?>
        <li>
            <a title="logout" href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><?php echo esc_html__( 'Logout', 'fundor-core' ) ?></a>
        </li>
    </ul>
    <a class="button-primary add-new-campaign" title="add campaign" href="<?php echo esc_url( osf_give_get_dashboard_link( 'add-campaign' ) ); ?>"><?php echo esc_html__( 'Add New Campaign', 'fundor-core' ) ?></a>
</div>
