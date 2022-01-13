<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ecommerce
 */

get_header();
?>

	<main id="primary" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->
			<div class="col-lg-9">
				<div class="shop-page-products-wrapper mt-44 mt-sm-30">
					<div class="products-wrapper products-on-column">
						<div class="row">
							<?php
							/* Start the Loop */
							while ( have_posts() ) :
								the_post();

								/*
								* Include the Post-Type-specific template for the content.
								* If you want to override this in a child theme, then include a file
								* called content-___.php (where ___ is the Post Type name) and that will be used instead.
								*/
								the_content();

							endwhile;

							the_posts_navigation();
						endif;
						?>
						</div>
					</div>
				</div>
			</div>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
