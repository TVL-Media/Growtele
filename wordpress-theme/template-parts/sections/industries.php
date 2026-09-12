<?php
/**
 * Industry Solutions section with tabs
 *
 * @package Growtele
 */

$industries = array(
	'banking'    => array(
		'label'        => __( 'Banking', 'growtele' ),
		'icon'         => 'bankic.png',
		'panel_icon'   => 'panel-icon-banking.png',
		'panel_visual' => 'panel-visual-banking.png',
		'panel_style'  => '1',
		'desc'         => __( 'Deliver secure and real-time banking communication with OTP verification, transaction alerts and personalized customer engagement experiences.', 'growtele' ),
	),
	'shopping'   => array(
		'label'        => __( 'E-Commerce', 'growtele' ),
		'icon'         => 'commic.png',
		'panel_icon'   => 'panel-icon-shopping.png',
		'panel_visual' => 'panel-visual-shopping.png',
		'panel_style'  => '2',
		'desc'         => __( 'Drive conversions with automated order updates, cart recovery messages, and personalized promotional campaigns across multiple channels.', 'growtele' ),
	),
	'retail'     => array(
		'label'        => __( 'Retail', 'growtele' ),
		'icon'         => 'retailic.png',
		'panel_icon'   => 'panel-icon-retail.png',
		'panel_visual' => 'panel-visual-retail.png',
		'panel_style'  => '1',
		'desc'         => __( 'Enhance in-store and online retail experiences with timely notifications, loyalty program updates, and customer feedback collection.', 'growtele' ),
	),
	'healthcare' => array(
		'label'        => __( 'Healthcare', 'growtele' ),
		'icon'         => 'healthcareic.png',
		'panel_icon'   => 'panel-icon-healthcare.png',
		'panel_visual' => 'panel-visual-healthcare.png',
		'panel_style'  => '2',
		'desc'         => __( 'Send appointment reminders, health alerts, and secure patient communications while maintaining compliance with healthcare regulations.', 'growtele' ),
	),
	'education'  => array(
		'label'        => __( 'Education', 'growtele' ),
		'icon'         => 'educationic.png',
		'panel_icon'   => 'panel-icon-education.png',
		'panel_visual' => 'panel-visual-education.png',
		'panel_style'  => '1',
		'desc'         => __( 'Improve student engagement through automated course updates, enrollment confirmations, and personalized learning notifications via WhatsApp and SMS.', 'growtele' ),
	),
	'travelling' => array(
		'label'        => __( 'Travelling', 'growtele' ),
		'icon'         => 'travelic.png',
		'panel_icon'   => 'panel-icon-travelling.png',
		'panel_visual' => 'panel-visual-travelling.png',
		'panel_style'  => '2',
		'desc'         => __( 'Keep travelers informed with booking confirmations, itinerary updates, and real-time alerts across SMS, WhatsApp, and email.', 'growtele' ),
	),
	'logistic'   => array(
		'label'        => __( 'Logistic', 'growtele' ),
		'icon'         => 'logisticic.png',
		'panel_icon'   => 'panel-icon-logistic.png',
		'panel_visual' => 'panel-visual-logistic.png',
		'panel_style'  => '1',
		'desc'         => __( 'Streamline delivery operations with shipment tracking updates, dispatch alerts, and driver coordination through reliable omnichannel messaging.', 'growtele' ),
	),
);
?>
<section class="gt-industries gt-section" id="industries">
	<div class="gt-container">
		<div class="gt-industries__stage" data-industry-stage>
			<div class="gt-section-heading">
				<h2 class="gt-section-heading__title"><?php esc_html_e( 'Built for the Unique Needs of Every Industry', 'growtele' ); ?></h2>
				<p class="gt-section-heading__desc"><?php esc_html_e( 'Helping businesses connect, engage, and grow through reliable communication solutions tailored to their needs.', 'growtele' ); ?></p>
			</div>

			<div class="gt-industries__tabs" role="tablist" aria-label="<?php esc_attr_e( 'Industry Solutions', 'growtele' ); ?>" data-tabs>
				<?php $first = true; foreach ( $industries as $key => $industry ) : ?>
					<button
						class="gt-industries__tab<?php echo $first ? ' is-active' : ''; ?>"
						role="tab"
						id="tab-<?php echo esc_attr( $key ); ?>"
						aria-selected="<?php echo $first ? 'true' : 'false'; ?>"
						aria-controls="panel-<?php echo esc_attr( $key ); ?>"
						data-tab="<?php echo esc_attr( $key ); ?>"
					>
						<span class="gt-industries__tab-icon" aria-hidden="true">
							<img
								src="<?php echo esc_url( growtele_get_asset( $industry['icon'] ) ); ?>"
								alt=""
								width="36"
								height="36"
								loading="lazy"
							/>
						</span>
						<span class="gt-industries__tab-label"><?php echo esc_html( $industry['label'] ); ?></span>
					</button>
				<?php $first = false; endforeach; ?>
			</div>

			<div class="gt-industries__stack" data-industry-stack>
				<?php $first = true; foreach ( $industries as $key => $industry ) : ?>
					<div
						class="gt-industries__panel<?php echo $first ? ' is-active' : ''; ?>"
						role="tabpanel"
						id="panel-<?php echo esc_attr( $key ); ?>"
						aria-labelledby="tab-<?php echo esc_attr( $key ); ?>"
						data-tab-panel="<?php echo esc_attr( $key ); ?>"
						aria-hidden="<?php echo $first ? 'false' : 'true'; ?>"
					>
						<div class="gt-industries__panel-inner gt-industries__panel-inner<?php echo esc_attr( $industry['panel_style'] ); ?>">
							<div class="gt-industries__panel-left">
								<div class="gt-industries__panel-icon">
									<img
										src="<?php echo esc_url( growtele_get_image( 'industries/' . $industry['panel_icon'] ) ); ?>"
										alt=""
										width="34"
										height="34"
										loading="lazy"
									/>
								</div>
								<div class="gt-industries__panel-content">
									<h3 class="gt-industries__panel-title"><?php echo esc_html( $industry['label'] ); ?></h3>
									<p class="gt-industries__panel-desc"><?php echo esc_html( $industry['desc'] ); ?></p>
								</div>
							</div>
							<div class="gt-industries__panel-visual">
								<img
									class="gt-industries__visual-img gt-industries__visual-img--<?php echo esc_attr( $key ); ?>"
									src="<?php echo esc_url( growtele_get_image( 'industries/' . $industry['panel_visual'] ) ); ?>"
									alt="<?php echo esc_attr( $industry['label'] ); ?>"
									loading="lazy"
								/>
							</div>
						</div>
					</div>
				<?php $first = false; endforeach; ?>
			</div>
		</div>
	</div>
</section>
