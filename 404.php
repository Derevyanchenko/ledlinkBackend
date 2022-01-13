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
			<h1 class="text-center" style="margin-bottom: 25px;">שגיאה 404</h1>
			<h2 class="aboutPage__title text-center"><?php esc_html_e( 'אופס! לא ניתן למצוא את הדף הזה.', 'ecommerce' ); ?></h2>
		</div>
    </div>
</section>

<?php
get_footer();