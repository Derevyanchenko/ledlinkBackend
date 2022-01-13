<?php 
/**
 * Template Name: Gallery page
 **/ 

get_header();

$gallery_title         = get_field( 'title' );
$gallery_content       = get_field( 'content' );
$gallery_images_group  = get_field( 'images' );

$left_images_repeater  = $gallery_images_group['left_column'];
$right_images_repeater = $gallery_images_group['right_column'];

?>

<section class="section galleryPage">
    <div class="contactsPage-container galleryPage-container">
        <div class="galleryPage__wrapper">

        <?php if ( ! empty( $gallery_images_group ) ): ?>
            <div class="galleryPage__gallery-col galleryPage-col">
                <div class="scrollbar-container" data-scrollbar>
                    <div class="galleryPage__gallery-col__scrollbar bg--dark">
                        <div class="galleryPage__grid-wrapper">
                            <div class="galleryPage__grid">

                                <div class="galleryPage__grid-inner__col">
                                    <?php foreach ( $left_images_repeater as $left_images ) : ?>
                                        <div class="galleryPage__gallery-item galleryPage__item">
                                            <img src="<?php echo $left_images['image']; ?>" alt="">
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <div class="galleryPage__grid-inner__col">
                                    <?php foreach ( $right_images_repeater as $right_images ) : ?>
                                        <div class="galleryPage__gallery-item galleryPage__item">
                                            <img src="<?php echo $right_images['image']; ?>" alt="">
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="scrollbar-track scrollbar-track-y">
                    <div class="scrollbar-thumb scrollbar-thumb-y"></div>
                </div>

                <div class="gallery__bottom">
                    <p class="gallery__bottom-text">גללו לעוד</p>
                    <div class="stage">
                        <div class="box bounce">
                            <div class="arrows">
                                <div class="arrow-top">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery/arrow-bottom.svg" alt="">
                                </div>
                                <div class="arrow-bottom">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/gallery/arrow-bottom.svg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- galleryPage__info-col -->
        <?php endif; ?>


            <div class="galleryPage__info-col galleryPage-col bg--light dir-ltr">
                <h2 class="contactsPage__title galleryPage__title">
                    <?php echo $gallery_title; ?>
                </h2>

                <div class="galleryPage__info">
                    <p>
                    <?php echo $gallery_content; ?>
                </div>
            </div>
            <!-- galleryPage__form-wrapper -->
        </div>
    </div>
</section>


<?php get_footer(); ?>