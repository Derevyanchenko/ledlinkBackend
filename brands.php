<?php 
/**
 * Template Name: Brands
 **/ 

get_header();

$brands = get_field( "brands" );
?>

<section class="section brands">
    <div class="container shopPage-container brands-container">
        <div class="brands-title">
            <h2><?php the_title(); ?></h2>
        </div>

        <?php if ( ! empty( $brands ) ): ?>
        <div class="brands__wrapper">

            <?php foreach ( $brands as $brand ) :
                $brand_title = $brand['title'];
                $brand_link  = $brand['link'];
                $brand_logo  = $brand['logo'];
            ?>
                <div class="brands__col">
                    <a <?php echo ! empty($brand_link) ? 'href="'. $brand_link .'"' : ''; ?> class="brands__item">
                        <p class="brands__item-title"><?php echo $brand_title; ?></p>
                        <div class="brands__item-img">
                            <img src="<?php echo $brand_logo; ?>" alt="img">
                        </div>
                    </a>
                </div>
                <!-- brands__col -->
            <?php endforeach; ?>

        </div>
		<?php endif; ?>

    </div>
</section>

<?php get_footer(); ?>