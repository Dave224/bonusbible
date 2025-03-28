<?php
global $post;
$game_allowed_html = array(
	'a' => array(
		'href' => true,
		'title' => true,
		'target' => true,
		'rel' => true
	),
	'br' => array(),
	'em' => array(),
	'strong' => array(),
	'span' => array(
		'class' => true
	),
	'div' => array(
		'class' => true
	),
	'p' => array()
);

$game_short_desc = wp_kses( get_post_meta( get_the_ID(), 'game_short_desc', true ), $game_allowed_html );
$game_external_link = esc_url( get_post_meta( get_the_ID(), 'game_external_link', true ) );

	if ( get_option( 'aces_game_link_mask_slug') && $game_external_link ) {
		
		$game_mask_link_slug = esc_attr( get_post_meta( get_the_ID(), 'game_mask_link', true ) );

		if ( $game_mask_link_slug ) {

			if ( $_GET['m'] == $game_mask_link_slug ){
				$redirect_link = esc_url( $game_external_link );
				header('Location: ' . $redirect_link );
				die();
			}

			$game_external_link = esc_url( get_the_permalink().'?m='.$game_mask_link_slug );
			
		}
	}

$game_button_title = esc_html( get_post_meta( get_the_ID(), 'game_button_title', true ) );
$game_button_notice = wp_kses( get_post_meta( get_the_ID(), 'game_button_notice', true ), $game_allowed_html );

$unit_popup_title = esc_html( get_post_meta( get_the_ID(), 'aces_unit_popup_title', true ) );
$unit_popup_hide = esc_attr( get_post_meta( get_the_ID(), 'aces_unit_popup_hide', true ) );
$unit_detailed_tc = wp_kses( get_post_meta( get_the_ID(), 'unit_detailed_tc', true ), $game_allowed_html );

if ($game_button_title) {
	$button_title = $game_button_title;
} else {
	if ( get_option( 'games_play_now_title') ) {
		$button_title = esc_html( get_option( 'games_play_now_title') );
	} else {
		$button_title = esc_html__( 'Play Now', 'mercury' );
	}
}

if ($game_external_link) {
	$external_link_url = $game_external_link;
} else {
	$external_link_url = get_the_permalink();
}

if ($unit_popup_title) {
	$custom_popup_title = $unit_popup_title;
} else {
	$custom_popup_title = esc_html__( 'T&Cs Apply', 'mercury' );
}

?>

<div class="space-organizations-3-archive-item units-provider box-100 relative">
	<div class="space-organizations-3-archive-item-ins relative">
		<div class="space-organizations-3-archive-item-logo box-25 relative">
			<div class="space-organizations-3-archive-item-logo-ins box-100 text-center relative" style="padding-bottom: 0;">
				<?php
				$post_title_attr = the_title_attribute( 'echo=0' );
				if ( wp_get_attachment_image(get_post_thumbnail_id()) ) { ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php echo wp_get_attachment_image( get_post_thumbnail_id(), 'mercury-213-120', "", array( "alt" => $post_title_attr ) ); ?>
					</a>
				<?php } ?>
				<div class="space-organizations-3-title-box relative" style="margin-top: 5px;">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</div>
			</div>
		</div>
		<div class="space-organizations-3-archive-item-provider box-25 relative">
			<div class="space-organizations-3-archive-item-provider-ins box-100 text-center relative">
				<?php
				$vendors = get_the_terms( $post->ID , 'vendor' );
				if ($vendors) { ?>
					<div style="font-size: 14px; margin-top: 5px;"><?php echo esc_html( 'Software Provider', 'mercury' ); ?></div>
					<?php foreach ( $vendors as $vendor ) { ?>
						<?php
						$vendor_logo = get_term_meta($vendor->term_id, 'taxonomy-image-id', true);
						if ($vendor_logo) { ?>
							<a href="<?php echo esc_url (get_term_link( (int)$vendor->term_id, $vendor->taxonomy )); ?>" title="<?php echo esc_attr($vendor->name); ?>" class="space-vendors-item">
								<?php echo wp_get_attachment_image( $vendor_logo, 'mercury-9999-70', "", array( "class" => "space-vendor-logo" ) );  ?>
							</a>
						<?php } else {  ?>
							<a href="<?php echo esc_url (get_term_link( (int)$vendor->term_id, $vendor->taxonomy )); ?>" title="<?php echo esc_attr($vendor->name); ?>" class="space-vendors-item name">
								<?php echo esc_html($vendor->name); ?>
							</a>
						<?php } ?>
					<?php } ?>
				<?php } ?>
			</div>
		</div>
		<div class="space-organizations-3-archive-item-terms box-25 relative" style="order: 3;">
			<div class="space-organizations-3-archive-item-terms-ins box-100 text-center relative">
			<?php if ($game_short_desc) {
				echo wp_kses( $game_short_desc, $game_allowed_html );
			} ?>
			</div>
		</div>
		<div class="space-organizations-3-archive-item-button box-25 relative">
			<div class="space-organizations-3-archive-item-button-ins box-100 text-center relative">
				<a href="<?php echo esc_url( $external_link_url ); ?>" title="<?php echo esc_attr( $button_title ); ?>" <?php if ($external_link) { ?>target="_blank" rel="nofollow"<?php } ?>><i class="fas fa-check-circle"></i> <?php echo esc_html( $button_title ); ?></a>

				<?php if ($unit_popup_hide == true ) { ?>
					<div class="space-organization-header-button-notice relative" style="margin-top: 5px;">
						<span class="tc-apply"><?php echo esc_html( $custom_popup_title ); ?></span>
						<div class="tc-desc">
							<?php
								if ($unit_detailed_tc) {
									echo wp_kses( $unit_detailed_tc, $game_allowed_html );
								}
							?>
						</div>
					</div>
				<?php } ?>

				<?php if ($game_button_notice) { ?>

				<div class="space-organizations-archive-item-button-notice relative" style="margin-top: 5px;">
					<?php echo wp_kses( $game_button_notice, $game_allowed_html ); ?>
				</div>

				<?php } ?>
				
			</div>
		</div>
		<?php
		if ($unit_popup_hide == true ) {

		} else {
			if ($unit_detailed_tc) { ?>
			<div class="space-organizations-archive-item-detailed-tc box-100 relative">
				<div class="space-organizations-archive-item-detailed-tc-ins relative">
					<?php echo wp_kses( $unit_detailed_tc, $game_allowed_html ); ?>
				</div>
			</div>
		<?php
			}
		}
		?>
	</div>
</div>