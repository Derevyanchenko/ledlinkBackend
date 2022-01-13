<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ecommerce
 */

get_header();
the_post();
if ( is_cart() || is_checkout() ) : ?>


<!-- Start Page Header Wrapper -->
<div class="page-header-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="page-header-content">
                    <h2><?php woocommerce_page_title() ?></h2>
                    <?php woocommerce_breadcrumb(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Header Wrapper -->

<!--== Start Checkout Page Wrapper ==-->
<div id="checkout-page-wrapper" class="pt-90 pt-md-60 pt-sm-50 pb-50 pb-md-20 pb-sm-10">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
<?php endif; 

    the_content(); 

if ( is_cart() || is_checkout() ) : 
?>
            </div>
        </div>
    </div>
</div>

<?php endif; 
get_footer(); ?>
