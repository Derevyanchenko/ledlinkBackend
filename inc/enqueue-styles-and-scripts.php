<?php 

/**
 * Enqueue scripts and styles.
 */

// styles

function ecommerce_styles()
{
    wp_enqueue_style('ecommerce-style', get_stylesheet_uri());
    wp_enqueue_style('ecommerce-main', get_template_directory_uri() . "./assets/css/main.css");
}

function ecommerce_scripts()
{
    wp_deregister_script('jquery');
    wp_enqueue_script('jquery', get_template_directory_uri() . './assets/js/jquery-3.0.0.min.js', array(), null, true);

    // wp_enqueue_script("ecommerce-masonry", get_template_directory_uri() . "./assets/js/masonry.pkgd.min.js", array("jquery"), "", true);
    wp_enqueue_script("ecommerce-lax", "https://cdn.jsdelivr.net/npm/lax.js", array("jquery"), "", true);
    wp_enqueue_script("ecommerce-smooth", get_template_directory_uri() . "./assets/js/smooth-scrollbar.js", array("jquery"), "", true);
    wp_enqueue_script("ecommerce-select", get_template_directory_uri() . "./assets/js/jquery.nice-select.min.js", array("jquery"), "", true);
    wp_enqueue_script("ecommerce-swiper", get_template_directory_uri() . "./assets/js/swiper-bundle.min.js", array("jquery"), "", true);

    wp_enqueue_script("ecommerce-main", get_template_directory_uri() . "./assets/js/main.js", array("jquery"), "", true);

    wp_localize_script('ecommerce-main', 'ajax_object',
        array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'templ_dir_uri' => get_template_directory_uri(),
            'home_url' => home_url()
        )
    );

    wp_deregister_style( 'woocommerce-general' );
    wp_deregister_style( 'woocommerce-layout' );
}

add_action('wp_enqueue_scripts', 'ecommerce_styles');
add_action('wp_enqueue_scripts', 'ecommerce_scripts');