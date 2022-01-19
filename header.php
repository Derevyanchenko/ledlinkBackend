<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo wp_get_document_title(); ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="Sublime project">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--== Google Fonts ==-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@300;400;800&family=Spartan&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<body <?php is_front_page() ? body_class( "bg-black" ) : body_class() ; ?>>
<?php 
wp_body_open(); 

$header_logo = get_field( "header_logo", 'theme-general-settings' ); 

?>

<!-- 
шапка - перевод меню пунктов:
- Связаться с нами
- About us
- Projects
- brands
- светильники (category woo)
- Компонент (category woo)

======================
фктер:

- Компонент (category woo)
- светильники (category woo)
Бренды
Проекты
о
Связаться с нами
 -->

<div class="mobileMenu-overlay">
    <div class="mobileMenu">
        <button class="mobileMenu__close">&times;</button>
        <div class="mobileMenu__container">
            <?php  wp_nav_menu(array(
                'theme_location'  => 'header_menu',
                'menu'            => 'top_menu',
                'container'       => false,
                'menu_class'      => 'nav header__menu',
            ));  ?>
        </div>
    </div>
</div>
<header class="header">
    <div class="header__wrapper">

        <?php  wp_nav_menu(array(
            'theme_location'  => 'header_menu',
            'menu'            => 'top_menu',
            'container'       => false,
            'menu_class'      => 'nav header__menu',
        ));  ?>
        <?php if ( ! empty( $header_logo ) ): ?>
            <a href="<?php echo site_url(); ?>" class="logo">
                <img src="<?php echo $header_logo; ?>" alt="LEDLINK">
            </a>
        <?php endif; ?>
        <div class="burger open-menu-js">
            <div class="open-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</header>
