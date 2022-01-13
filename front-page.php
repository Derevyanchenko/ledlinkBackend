<?php 
/**
 * Template Name: Homepage
 **/ 

get_header(); ?>

<?php
	// banner
	$banner = get_field( "banner" );

	// buttons_section
	$buttons_section		 = get_field( "buttons_section" );
	$left_button_text 		 = $buttons_section['left_button_text'];
	$left_button_link 		 = $buttons_section['left_button_link'];
	$buttons_section_content = $buttons_section['content'];
	$right_button_text 		 = $buttons_section['right_button_text'];
	$right_button_link 		 = $buttons_section['right_button_link'];

	// image_gallery
	$image_gallery = get_field( "image_gallery" );
	
?>

<section class="banner dir-ltr" style="background-image: url(<?php echo $banner['background']['url']; ?>);">
        <div class="banner__container">
            <div class="banner__content">
                <h1 class="banner__title">
                    <?php echo $banner['title']; ?>
                </h1>
                <p class="banner__text">
					<?php echo $banner['description']; ?>
                </p>
            </div>
        </div>
        <div class="banner__image--sm">
			<img src="<?php echo $banner['background']['url']; ?>" alt="">
        </div>
    </section>
    <!-- banner -->

    <section class="gradient-bg">

        <section class="parallax">
            <div class="container">
                <div class="parallax__wrapper">
                    <div class="parallax-lamp-small">
                        <div class="parallax-lamp-small__top">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/homepage-small-lamp.png" alt="">
                        </div>
                    </div>
                    <!-- big -->
                    <div class="parallax-lamp-big">
                        <div class="parallax-lamp-big__top">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/homepage-big-lamp-top.png" alt="">
                        </div>
                        <div class="parallax-lamp-big__bottom">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/homepage-big-lamp-bottom.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- parallax section -->

        <section class="homepageButtons ">
            <div class="container">
                <div class="homepageButtons__wrapper">

					<?php if ( ! empty( $left_button_text ) && ! empty( $left_button_link )  ) : ?>
						<a href="<?= $left_button_link; ?>" class="homepageButtons__btn left-btn"><?= $left_button_text; ?></a>
					<?php endif; ?>

                    <div class="homepageButtons__text text-center dir-ltr">
                        <p>
							<?php echo $buttons_section_content; ?>
						</p>
                    </div>
					
					<?php if ( ! empty( $right_button_text ) && ! empty( $right_button_link )  ) : ?>
						<a href="<?= $right_button_link; ?>" class="homepageButtons__btn right-btn"><?= $right_button_text; ?></a>
					<?php endif; ?>
                    
                    <div class="homepageButtons__btns">
						<?php if ( ! empty( $left_button_text ) && ! empty( $left_button_link )  ) : ?>
							<a href="<?= $left_button_link; ?>" class="homepageButtons__btn left-btn"><?= $left_button_text; ?></a>
						<?php endif; ?>
						<?php if ( ! empty( $right_button_text ) && ! empty( $right_button_link )  ) : ?>
							<a href="<?= $right_button_link; ?>" class="homepageButtons__btn right-btn"><?= $right_button_text; ?></a>
						<?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- homepageButtons section -->

		<?php if ( ! empty( $image_gallery ) ): ?>
			<section class="homepageGallery">
				<div class="container">
				
					<!-- Slider main container -->
					<div class="swiper-container">
						<!-- Additional required wrapper -->
						<div class="swiper-wrapper">
							<!-- Slides -->
							<?php foreach ( $image_gallery as $img ): ?>
								<div class="swiper-slide">
									<img src="<?php echo $img; ?>">
								</div>
							<?php endforeach; ?>
						</div>
						<!-- If we need navigation buttons -->
						<div class="homepageGallery__arrows">
							<div class="swiper-button-prev arrow-left"></div>
							<div class="swiper-button-next arrow-right"></div>
						</div>
					</div>

				</div>
			</section>
		<?php endif; ?>
        <!-- gallery section -->
    
    </section>
    <!-- gradient-bg -->

<?php get_footer(); ?>