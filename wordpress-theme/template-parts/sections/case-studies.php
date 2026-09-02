<?php
/**
 * Case Studies section
 *
 * @package Growtele
 */

$case_studies = array(
	array(
		'name'     => 'Tanishq',
		'category' => __( 'Jewellery & Retail', 'growtele' ),
		'icon'     => 'tanishq-logo.png',
		'modifier' => 'tanishq',
		'image'    => 'sections/case-study-tanishq.png',
		'desc'     => __( 'Growtele empowered Tanishq to deliver seamless customer experiences through high-performance SMS and WhatsApp communication. From promotional campaigns to transactional notifications, the platform enabled faster delivery, greater reliability, and consistent engagement across multiple locations.', 'growtele' ),
		'stats'    => array(
			array( 'value' => '99.9%', 'label' => __( 'Platform Reliability', 'growtele' ) ),
			array( 'value' => '3 Years', 'label' => __( 'Trusted Partnership', 'growtele' ) ),
		),
		'quote'    => __( 'Growtele has been a reliable communication partner for our business. Their robust infrastructure, excellent service quality, and responsive support have helped us engage customers more effectively across all our branches.', 'growtele' ),
		'author'   => 'Krishnanand Patwari',
		'role'     => __( 'Operations Manager, Tanishq', 'growtele' ),
	),
	array(
		'name'     => 'KlinicApp',
		'category' => __( 'Healthcare', 'growtele' ),
		'icon'     => 'klinicapp-logo.png',
		'modifier' => 'klinicapp',
		'image'    => 'sections/case-study-klinicapp.png',
		'desc'     => __( 'Streamline patient booking and communication with automated reminders, test report updates, teleconsultations, and feedback collection. KlinicApp is a smart healthcare solution designed to enhance patient engagement and care experience.', 'growtele' ),
		'stats'    => array(
			array( 'value' => '97.4%', 'label' => __( 'Platform Reliability', 'growtele' ) ),
			array( 'value' => '2 Years', 'label' => __( 'Trusted Partnership', 'growtele' ) ),
		),
		'quote'    => __( 'KlinicApp has been a game-changer for our clinic. Automated reminders and real-time updates have improved patient satisfaction and reduced no-shows. The platform is reliable, easy to use, and the support team is always responsive.', 'growtele' ),
		'author'   => 'Dr. Neha Sharma',
		'role'     => __( 'MD & Director, KlinicApp', 'growtele' ),
	),
	array(
		'name'       => 'Dabur',
		'category'   => __( 'Ayurvedic', 'growtele' ),
		'icon'       => 'dabur-logo.png',
		'icon_class' => 'dabur',
		'modifier'   => 'dabur',
		'image'      => 'sections/case-study-dabur.png',
		'desc'       => __( 'Dabur leveraged Growtele’s robust messaging solutions to strengthen customer engagement across India and global markets. With real-time SMS and WhatsApp updates for promotions, order confirmations, and delivery alerts, Dabur enhanced customer experience, increased campaign effectiveness, and built stronger brand trust.', 'growtele' ),
		'stats'      => array(
			array( 'value' => '98.8%', 'label' => __( 'Platform Reliability', 'growtele' ) ),
			array( 'value' => '5+ Years', 'label' => __( 'Trusted Partnership', 'growtele' ) ),
		),
		'quote'      => __( 'Growtele has been an incredible communication partner for Dabur. Their reliable platform, excellent service quality, and quick support have helped us campaigns and engage with millions of customers effectively. Their solutions are scalable, dependable.', 'growtele' ),
		'author'     => 'Rohit Malhotra',
		'role'       => __( 'Head of Digital Marketing, Dabur India', 'growtele' ),
	),
	array(
		'name'     => 'Jaro Education',
		'category' => __( 'Education', 'growtele' ),
		'icon'     => 'jaro-logo.png',
		'modifier' => 'jaro',
		'image'    => 'sections/case-study-jaro.png',
		'desc'     => __( 'Jaro Education partnered with Growtele to enhance learner engagement and streamline communication. With automated SMS and WhatsApp notifications for course updates, class reminders, and enrollment confirmations, Jaro improved learner experience, increased course completions, and strengthened trust across their learner community.', 'growtele' ),
		'stats'    => array(
			array( 'value' => '98.7%', 'label' => __( 'Platform Reliability', 'growtele' ) ),
			array( 'value' => '3+ Years', 'label' => __( 'Trusted Partnership', 'growtele' ) ),
		),
		'quote'    => __( 'Growtele has helped us transform how we communicate with learners. Their reliable platform, automation capabilities, and proactive support have played a key role in improving engagement and driving better outcomes for our programs.', 'growtele' ),
		'author'   => 'Dr. Rishi Bhatnagar',
		'role'     => __( 'CEO, Jaro Education', 'growtele' ),
	),
);
?>
<section class="gt-case-studies gt-section" id="case-studies" data-case-cycle="5000" style="--gt-case-cycle: 3s;">
	<div class="gt-container">
		<?php
		growtele_section_heading(
			__( 'Trusted by Businesses. Proven by Results.', 'growtele' ),
			__( 'Discover how businesses across industries leverage Growtele to improve customer engagement, streamline communication, and achieve measurable growth.', 'growtele' )
		);
		?>

		<div class="gt-case-studies__nav">
			<div class="gt-case-studies__tabs" data-case-tabs>
				<?php foreach ( $case_studies as $i => $study ) : ?>
					<button class="gt-case-studies__tab<?php echo 0 === $i ? ' is-active' : ''; ?>" data-case-tab="<?php echo esc_attr( $i ); ?>">
						<img src="<?php echo esc_url( growtele_get_image( 'brands/' . $study['icon'] ) ); ?>" alt="<?php echo esc_attr( $study['name'] ); ?>" class="gt-case-studies__tab-logo<?php echo ! empty( $study['icon_class'] ) ? ' gt-case-studies__tab-logo--' . esc_attr( $study['icon_class'] ) : ''; ?>" width="41" height="41" loading="lazy" />
						<div>
							<strong><?php echo esc_html( $study['name'] ); ?></strong>
							<span><?php echo esc_html( $study['category'] ); ?></span>
						</div>
					</button>
				<?php endforeach; ?>
			</div>

			<div class="gt-case-studies__progress">
				<div class="gt-case-studies__progress-bar" data-case-progress></div>
			</div>
		</div>

		<div class="gt-case-studies__stack" data-case-stack>
		<?php foreach ( $case_studies as $i => $study ) : ?>
			<div class="gt-case-studies__panel<?php echo 0 === $i ? ' is-active' : ''; ?>" data-case-panel="<?php echo esc_attr( $i ); ?>" aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>">
				<div class="gt-case-studies__card gt-case-studies__card--<?php echo esc_attr( $study['modifier'] ); ?>">
					<div class="gt-case-studies__card-main gt-case-studies__card-main--<?php echo esc_attr( $study['modifier'] ); ?>">
						<div class="gt-case-studies__card-header">
							<h3><?php echo esc_html( $study['name'] ); ?></h3>
							<span><?php echo esc_html( $study['category'] ); ?></span>
						</div>
						<p class="gt-case-studies__card-desc"><?php echo esc_html( $study['desc'] ); ?></p>
						<div class="gt-case-studies__card-stats">
							<?php foreach ( $study['stats'] as $stat ) : ?>
								<div class="gt-case-studies__stat">
									<span class="gt-case-studies__stat-value"><?php echo esc_html( $stat['value'] ); ?></span>
									<span class="gt-case-studies__stat-label"><?php echo esc_html( $stat['label'] ); ?></span>
								</div>
							<?php endforeach; ?>
						</div>
						<div class="gt-case-studies__card-visual-col">
							<div class="gt-case-studies__card-visual">
								<span class="gt-case-studies__card-visual-bg" aria-hidden="true"></span>
								<img src="<?php echo esc_url( growtele_get_image( ! empty( $study['image'] ) ? $study['image'] : 'sections/case-study-person.png' ) ); ?>" alt="<?php echo esc_attr( $study['name'] ); ?>" loading="lazy" />
							</div>
							<a href="#" class="gt-btn gt-btn--gradient gt-btn--sm">
								<span><?php esc_html_e( 'Read Full Case Study', 'growtele' ); ?></span>
								<img src="<?php echo esc_url( growtele_get_image( 'icons/arrow-up-right.png' ) ); ?>" alt="" width="19" height="19" loading="lazy" />
							</a>
						</div>
					</div>
					<div class="gt-case-studies__card-quote">
						<div class="gt-case-studies__quote-body">
							<span class="gt-case-studies__quote-mark gt-case-studies__quote-mark--open">&ldquo;</span>
							<blockquote><?php echo esc_html( $study['quote'] ); ?></blockquote>
							<span class="gt-case-studies__quote-mark gt-case-studies__quote-mark--close">&rdquo;</span>
						</div>
						<cite>
							<strong><?php echo esc_html( $study['author'] ); ?></strong>
							<span><?php echo esc_html( $study['role'] ); ?></span>
						</cite>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
		</div>
	</div>
</section>
