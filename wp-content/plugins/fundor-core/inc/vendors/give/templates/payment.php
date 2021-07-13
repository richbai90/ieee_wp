<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * @var $creator Opal_Give_Creator
 */
$loop = new WP_Query( $creator->get_donations_query() );

?>
<div class="payment">
    <div class="payment-progress">
        <div class="raised">
            <span class="value">$<?php echo $creator->get_earnings(); ?></span>
            <span class="label"><?php echo esc_html__( 'Raised', 'fundor-core' ) ?></span>
        </div>
        <div class="donors">
            <span class="value"><?php echo $creator->get_donner_count(); ?></span>
            <span class="label"><?php esc_html__( 'Donors', 'fundor-core' ) ?></span>
        </div>
    </div>
    <div class="payment-table">
        <table class="table-reponsive">
            <thead class="thead-dark">
            <tr>
                <th><?php echo esc_html__( 'ID', 'fundor-core' ) ?></th>
                <th><?php echo esc_html__( 'Date', 'fundor-core' ) ?></th>
                <th><?php echo esc_html__( 'Campaign', 'fundor-core' ) ?></th>
                <th><?php echo esc_html__( 'Amount', 'fundor-core' ) ?></th>
                <th><?php echo esc_html__( 'Donor', 'fundor-core' ) ?></th>
            </tr>
            </thead>
			<?php
			while ( $loop->have_posts() ) : $loop->the_post();
				$payment  = new Give_Payment( get_the_ID() );
				$campaign = new Give_Donate_Form( $payment->form_id );
				$donner = new Give_Donor($payment->donor_id);
				?>
                <tr>
                    <td>#<?php echo Give()->seq_donation_number->get_serial_code( $payment ) ?></td>
                    <td><?php echo $payment->completed_date; ?></td>
                    <td>
                        <a href="<?php echo esc_url( get_permalink( $campaign->ID ) ) ?>">
							<?php echo $campaign->post_title; ?>
                        </a>
                    </td>
                    <td class="amount">
						<?php echo give_donation_amount( $payment, true ); ?>
                    </td>
                    <td><?php echo $donner->name; ?></td>
                </tr>
			<?php endwhile; ?>
        </table>
    </div>

	<?php
	osf_give_the_paginate($loop);
	wp_reset_postdata();
	?>
</div>

