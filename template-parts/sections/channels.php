<?php
/**
 * Channel Overview section — GSAP fan/stack cards
 *
 * @package Growtele
 */

$channels = array(
	array(
		'slug'  => 'cltele',
		'class' => 'card-1',
		'label' => __( 'Cloud Telephony', 'growtele' ),
		'desc'  => __( 'Engage customers with voice alerts and reminders.', 'growtele' ),
		'image' => 'cltele.png',
	),
	array(
		'slug'  => 'rcs',
		'class' => 'card-2',
		'label' => __( 'RCS', 'growtele' ),
		'desc'  => __( 'Create smarter customer conversations.', 'growtele' ),
		'image' => 'rcs.png',
	),
	array(
		'slug'  => 'sms',
		'class' => 'active',
		'label' => __( 'SMS', 'growtele' ),
		'desc'  => __( 'Engage customers with real-time alerts.', 'growtele' ),
		'image' => 'sms.png',
	),
	array(
		'slug'  => 'whatsapp',
		'class' => 'card-4',
		'label' => __( 'WhatsApp', 'growtele' ),
		'desc'  => __( 'Build meaningful customer engagement.', 'growtele' ),
		'image' => 'whatsapp.png',
	),
	array(
		'slug'  => 'email',
		'class' => 'card-5',
		'label' => __( 'Email', 'growtele' ),
		'desc'  => __( 'Personalized email campaigns engage customers with reminders.', 'growtele' ),
		'image' => 'email.png',
	),
);
?>
<section class="gt-channels gt-section" id="channels">
	<div class="gt-container">
		<?php
		growtele_section_heading(
			__( 'One Platform for Every Customer Interaction', 'growtele' ),
			__( 'Deliver meaningful customer experiences through intelligent communication solutions built for performance and scale.', 'growtele' )
		);
		?>

		<div class="cards-wrapper">
			<?php foreach ( $channels as $channel ) : ?>
				<article class="card <?php echo esc_attr( $channel['class'] ); ?>">
					<div class="img img-<?php echo esc_attr( $channel['slug'] ); ?>">
						<img
							class="img-<?php echo esc_attr( $channel['slug'] ); ?>-pic"
							src="<?php echo esc_url( growtele_get_image( 'channels/' . $channel['image'] ) ); ?>"
							alt="<?php echo esc_attr( $channel['label'] ); ?>"
							loading="lazy"
						/>
					</div>
					<div class="content">
						<h3 class="bluebg"><?php echo esc_html( $channel['label'] ); ?></h3>
						<p class="blueft"><?php echo esc_html( $channel['desc'] ); ?></p>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
