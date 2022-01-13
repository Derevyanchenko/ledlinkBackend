<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ecommerce
 */

get_header();
?>

<section class="section aboutPage defaultPage-template dir-ltr" >
    <div class="container">
        <div class="aboutPage__content">
			<h2 class="aboutPage__title"><?php single_post_title(); ?></h2>
			<div class="aboutPage__text">
			<?php
				if ( have_posts() ) :

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

				endif;
				?>
			</div>
		</div>
    </div>
</section>

<?php
get_footer();
