<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$show_default_related_or_no_checkbox = get_field( 'show_default_related_or_no', 'theme-general-settings' );
$custom_related_products = get_field( 'related_products', get_the_ID() );

if ( ! empty( $custom_related_products ) || true == $show_default_related_or_no_checkbox ) : ?>

	<section class="related products">

		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'מוצרים נלווים', 'woocommerce' ) );

		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( ! empty( $custom_related_products )) : ?>
			<div class="products-row with-background">
			<?php woocommerce_product_loop_start(); ?>
				<div class="products-row with-background">
					<?php foreach ( $custom_related_products as $related_product ) : ?>
						<?php
							setup_postdata( $GLOBALS['post'] =& $related_product ); 
							wc_get_template_part( 'content', 'product' );
						?>
					<?php endforeach; ?>
				</div>

				<?php woocommerce_product_loop_end(); ?>
			</div>
			
		<?php wp_reset_postdata(); endif; ?>
		
		<?php if ( empty( $custom_related_products ) && ( true == $show_default_related_or_no_checkbox && $related_products ) ) : ?>
			<?php woocommerce_product_loop_start(); ?>
			<div class="products-row with-background">
				<?php foreach ( $related_products as $related_product ) : ?>

					<?php
						$post_object = get_post( $related_product->get_id() );
						setup_postdata( $GLOBALS['post'] =& $post_object ); 
						wc_get_template_part( 'content', 'product' );
					?>

				<?php endforeach; ?>
			</div>

			<?php woocommerce_product_loop_end(); ?>
		<?php wp_reset_postdata(); endif; ?>
	</section>

<?php 
	endif;


wp_reset_postdata();
