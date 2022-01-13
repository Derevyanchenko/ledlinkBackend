<?php 
/**
 * Template Name: About page
 **/ 

get_header();

$about = get_field( "about_page" );

$about_title      = $about['title'];
$about_subtitle   = $about['subtitle'];
$about_content    = $about['content'];
$about_background = $about['background'];

?>

<section class="section aboutPage dir-ltr" style="background-image: url(<?php echo $about_background; ?>);">
    <div class="container">
        <div class="aboutPage__content">
            <h2 class="aboutPage__title"><?php echo $about_title; ?></h2>
            <p class="aboutPage__subtitle"><?php echo $about_subtitle; ?></p>
            <div class="aboutPage__text">
                <p>
                    <?php echo $about_content; ?>
                </p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>