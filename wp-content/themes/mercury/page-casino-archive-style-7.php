<?php
/*
Template Name: Casinos Archive Style #7
*/
?>
<?php get_header(); ?>

<!-- Title Box Start -->

<div class="space-archive-title-box box-100 relative">
	<div class="space-archive-title-box-ins space-page-wrapper relative">
		<div class="space-archive-title-box-h1 relative">
			<h1><?php the_title(); ?></h1>
			
			<!-- Breadcrumbs Start -->

			<?php get_template_part( '/theme-parts/breadcrumbs' ); ?>

			<!-- Breadcrumbs End -->
		</div>
	</div>
</div>

<!-- Title Box End -->

<!-- Archive Section Start -->

<div class="space-archive-section box-100 relative space-organization-archive tax-organization-category">
	<div class="space-archive-section-ins space-page-wrapper relative">
		<div class="space-organization-archive-ins box-100 relative">

			<?php
				$current_page_id = get_the_ID();
				$page_data = get_page(get_the_ID());

				if( get_theme_mod('mercury_category_navigation_casinos') ) {
				$args = array(
					'hide_empty'=> 1,
					'type' => 'casino',
					'orderby' => 'name',
					'taxonomy' => 'casino-category',
					'order' => 'ASC'
				);
				$categories = get_categories($args);

				if( $categories ){
			 ?>
			<div class="space-categories-list-box relative">
				<ul class="space-categories-title">
					<?php if (get_theme_mod( 'mercury_casinos_list_page_id')) { ?>
						<li class="active">  
							<?php esc_html_e( 'All', 'mercury' ); ?>
						</li>
					<?php } ?>
					<?php
						$current_tax = get_queried_object();

						foreach($categories as $category) { ?>

							<li>  
								<a href="<?php echo esc_url( get_term_link($category->slug, 'casino-category') ); ?>" title="<?php echo esc_attr($category->name); ?>"><?php echo esc_html($category->name); ?></a>
							</li>
							
							<?php
						}
					?>
				</ul>
			</div>
			<?php }
			} ?>

			<div class="space-companies-archive-items box-100 relative">

				<?php
				$paged = $wp_query->get( 'paged' );
				$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
				$wp_query = new WP_Query(array(
					'post_type' => 'casino',
					'paged' => $paged,
					'meta_key' => 'casino_overall_rating',
					'orderby'  => 'meta_value_num',
					'order'    => 'DESC'
				));
				if ( have_posts() ) : while ( have_posts() ) : the_post();

					get_template_part( '/aces/casino-item-style-7' );

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

				<?php
					wp_reset_postdata();
					endif;
				?>

			</div>
			<?php
			$page_content = $page_data->post_content;

				if ( ! $paged || $paged < 2 ) {
			
					$page_loop = new WP_Query(array(
						'page_id' => $current_page_id
					));

					if( $page_loop->have_posts() ) :
						while( $page_loop->have_posts() ) : $page_loop->the_post(); ?>

						<div class="space-taxonomy-description box-100 relative" style="margin-top: 45px;">
							<div class="space-page-content case-15 relative">
								
								<?php
									the_content();
									wp_link_pages( array(
										'before'      => '<div class="clear"></div><div class="page-links">' . esc_html__( 'Pages:', 'mercury' ),
										'after'       => '</div>',
										'link_before' => '<span class="page-number">',
										'link_after'  => '</span>',
									));
								?>

							</div>
						</div>

						<?php
						endwhile;
						wp_reset_postdata();
					endif;

				}
			?>
		</div>
	</div>
</div>

<!-- Archive Section End -->

<?php get_footer(); ?>