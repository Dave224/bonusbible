<?php get_header(); ?>

<!-- Title Box Start -->

<div class="space-archive-title-box box-100 relative">
	<div class="space-archive-title-box-ins space-page-wrapper relative">
		<div class="space-archive-title-box-h1 relative">
			<h1><?php echo esc_html(get_queried_object()->name); ?></h1>
			
			<!-- Breadcrumbs Start -->

			<?php get_template_part( '/theme-parts/breadcrumbs' ); ?>

			<!-- Breadcrumbs End -->
		</div>
	</div>
</div>

<!-- Title Box End -->

<!-- Archive Section Start -->

<div class="space-archive-section box-100 relative space-organization-archive">
	<div class="space-archive-section-ins space-page-wrapper relative">
		<div class="space-organization-archive-ins box-100 relative">

			<?php 
				if( get_theme_mod('mercury_category_navigation_games') ) {
				$args = array(
					'hide_empty'=> 1,
					'type' => 'game',
					'orderby' => 'name',
					'taxonomy' => 'game-category',
					'order' => 'ASC'
				);
				$categories = get_categories($args);

				if( $categories ){
			 ?>
			<div class="space-categories-list-box relative">
				<ul class="space-categories-title">
					<?php if (get_theme_mod( 'mercury_games_list_page_id')) { ?>
						<li>  
							<a href="<?php echo esc_url( get_permalink(get_theme_mod( 'mercury_games_list_page_id')) ); ?>"><?php esc_html_e( 'All', 'mercury' ); ?></a>
						</li>
					<?php } ?>
					<?php
						$current_tax = get_queried_object();

						foreach($categories as $category) {

							if( $current_tax->slug == $category->slug ) { ?>

							<li class="active">  
								<?php echo esc_html($category->name); ?>
							</li>

							<?php } else { ?>

							<li>  
								<a href="<?php echo esc_url( get_term_link($category->slug, 'game-category') ); ?>" title="<?php echo esc_attr($category->name); ?>"><?php echo esc_html($category->name); ?></a>
							</li>
							
							<?php
							}
						}
					?>
				</ul>
			</div>
			<?php }
			} ?>

			<div class="space-units-archive-items box-100 relative">

				<?php

				$games_archive_style = get_theme_mod('mercury_game_archive_style');

				if ( have_posts() ) : while ( have_posts() ) : the_post();

					if ($games_archive_style == 2) {
						get_template_part( '/aces/game-item-style-2' );
					} elseif ($games_archive_style == 3) {
						get_template_part( '/aces/game-item-style-3' );
					} else {
						get_template_part( '/aces/game-item-style-1' );
					}

				endwhile;

				?>

				<!-- Archive Navigation Start -->

				<?php
					the_posts_pagination( array(
						'end_size' => 2,
						'prev_text'    => esc_html__('&laquo;', 'mercury'),
						'next_text'    => esc_html__('&raquo;', 'mercury'),
					));
				?>

				<!-- Archive Navigation End -->

				<?php else : ?>

				<!-- Posts not found Start -->

				<div class="space-page-content-wrap relative">
					<div class="space-page-content page-template box-100 relative">
						<h2><?php esc_html_e( 'Posts not found', 'mercury' ); ?></h2>
						<p>
							<?php esc_html_e( 'No posts has been found. Please return to the homepage.', 'mercury' ); ?>
						</p>
					</div>
				</div>

				<!-- Posts not found End -->

				<?php endif; ?>

			</div>
			<div class="space-taxonomy-description box-100 relative">
				
				<?php if( !is_paged() ) { 
					if (term_description()) { ?>
					<div class="space-page-content case-15 relative">
						<?php echo term_description(); ?>
					</div>
				<?php }
				} ?>
				
			</div>
		</div>
	</div>
</div>

<!-- Archive Section End -->

<?php get_footer(); ?>