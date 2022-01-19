<?php  
	$footer_logo = get_field( "footer_logo", 'theme-general-settings' ); 
	$contact_form_section = get_field( "contact_form_section", 'theme-general-settings' ); 	
	$contact_form_shortcode = $contact_form_section['shortcode'];
?>	
	
	<a href="#contacts" class="floating-btn">
        צור קשר
    </a>
	<!-- // floating-btn -->

	<?php if ( ! is_page_template( 'contacts.php' ) ) : ?>
		<section class="contacts" id="contacts">
			<div class="contacts__wrapper">
				<div class="contacts__form-wrapper">
					<h3 class="contacts__form-title section__title text-right dir-ltr"><?php echo $contact_form_section['title']; ?></h3>
					<?php if ( ! empty( $contact_form_section['description'] ) ) : ?>
						<p class="contacts__text text-right dir-ltr">
							<?php echo $contact_form_section['description']; ?>
						</p>
					<?php endif; ?>
					<?php echo do_shortcode( $contact_form_shortcode ); ?>
				</div>
				<!-- form weapper -->

				<div class="contacts__img">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/img/contacts-section-img-right.png" alt="">
				</div>                    

			</div>
		</section>
		<!-- contacts section -->
	<?php endif; ?>

	<footer class="footer">
		<div class="footer__container">
			<div class="footer__wrapper">

			<?php  wp_nav_menu(array(
				'theme_location'  => 'footer_menu',
				'menu'            => 'bottom_menu',
				'container'       => false,
				'menu_class'      => 'nav header__menu footer__menu',
			));  ?>
			<?php if ( ! empty( $footer_logo ) ): ?>
				<a href="<?php echo site_url(); ?>" class="footer__logo">
					<img src="<?php echo $footer_logo; ?>" alt="LEDLINK">
				</a>
			<?php endif; ?>
			</div>
		</div>
	</footer>

	<?php wp_footer();  ?>
</body>
</html>

