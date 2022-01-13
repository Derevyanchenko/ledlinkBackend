<?php

if ( ! defined("ABSPATH") ) {
    exit;
}




// old code
$flag = false;
if ( $flag === true ) {
    
// add base woo theme support
function ecommerce_add_woocommerce_base() {
    add_theme_support( 'woocommerce', array(
        // 'thumbnail_image_width' => 150,
        // 'single_image_width'    => 300,

        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 4,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ) );
    
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

add_action( 'after_setup_theme', 'ecommerce_add_woocommerce_base' );

// remove basic woo styles
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

// archive product page
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);

add_action( 'woocommerce_before_main_content',  'ecommerce_add_banner_wrapper_start',  40);
function ecommerce_add_banner_wrapper_start() {
    ?>
    <!-- Start Page Header Wrapper -->
        <div class="page-header-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <div class="page-header-content">
    <?php
}

remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);

add_filter( 'woocommerce_show_page_title', function() {
    if( is_shop() ) {
        return false;
    } 
});

add_action( 'woocommerce_before_main_content', 'ecommerce_add_custom_page_title', 45 );
function ecommerce_add_custom_page_title() {
    if( is_product() ) { ?>
        <h2><?php the_title() ?></h2>
    <?php 
    } else { ?>
        <h2><?php woocommerce_page_title() ?></h2>
    <?php
    }
}

add_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 50 );


/**
 * Change several of the breadcrumb defaults
 */
add_filter( 'woocommerce_breadcrumb_defaults', 'ecommerce_woocommerce_breadcrumbs' );
function ecommerce_woocommerce_breadcrumbs() {
    return array(
            'delimiter'   => '',
            'wrap_before' => '<nav class="woocommerce-breadcrumb page-breadcrumb" itemprop="breadcrumb"><ul class="d-flex justify-content-center">',
            'wrap_after'  => ' </ul></nav>',
            'before'      => '<li>',
            'after'       => '</li>',
            'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
        );
}

add_action( 'woocommerce_before_main_content',  'ecommerce_add_banner_wrapper_end',  55);
function ecommerce_add_banner_wrapper_end() {
    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Header Wrapper -->
<?php
}

// archive product loop grid

// remove divs for main content
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
add_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);

remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

add_action( 'woocommerce_before_shop_loop', 'ecommerce_archive_product_loop_start', 5 );
function ecommerce_archive_product_loop_start() {
    ?>
    <div id="shop-page-wrapper" class="pt-86 pt-md-56 pt-sm-46 pb-50 pb-md-20 pb-sm-10">
        <div class="container">
            <div class="row"> 
    <?php
}

add_action( 'woocommerce_after_shop_loop', 'ecommerce_archive_product_loop_end', 15 );
function ecommerce_archive_product_loop_end() {
    ?>
            </div>
        </div>
    </div>
    <?php
}



// remove sidebar
add_action('woocommerce_before_main_content', 'remove_sidebar' );
function remove_sidebar() {
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
}

add_action( 'woocommerce_before_shop_loop', 'ecommerce_sidebar_wrap_start', 10 );
function ecommerce_sidebar_wrap_start() {
    ?>
    <div class="col-lg-3 order-last order-lg-first mt-md-54 mt-sm-44">
        <div class="sidebar-area-wrapper">
    <?php
}

/**#####################################################################################
 * Shop Sidebar Filter
 #####################################################################################*/
add_action( 'woocommerce_before_shop_loop', 'ecommerce_shopping_filter_custom', 15 );
function ecommerce_shopping_filter_custom() {
    ?>
    <!-- Start Single Sidebar -->
    <div class="single-sidebar-wrap">
        <h3 class="sidebar-title">Категории товаров</h3>
        <div class="sidebar-body">
            <ul class="sidebar-list">
                <?php 
                    $list_product_categories = get_categories(array(
                        'taxonomy'     => 'product_cat',
                        'orderby'      => 'name',
                        'show_count'   => 1,
                        'pad_counts'   => 0,
                        'hierarchical' => 0,
                        'title_li'     => '',
                        'hide_empty'   => 0
                    ));

                    foreach( $list_product_categories as $cat ) {
                        echo sprintf(
                            '<li><a href="%s">%s <span>(%d)</span></a></li>',
                            get_term_link( (int) $cat->term_id, 'product_cat' ),
                            $cat->cat_name,
                            (int) $cat->category_count
                        );
                    } 
                ?>
            </ul>
        </div>
    </div>
    <!-- End Single Sidebar -->

    <?php 
        $colors_attr = get_terms(array(
            'taxonomy' => 'pa_colors',
            'hide_empty' => false,
            'count' => true,
        ));
        if ( ! empty( $colors_attr ) ) :
        $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
        if( ! empty( $_GET['min_price'] ) ) {
            $shop_page_url = add_query_arg( 'min_price', $_GET['min_price'], $shop_page_url );
        }
        if( ! empty( $_GET['max_price'] ) ) {
            $shop_page_url = add_query_arg( 'max_price', $_GET['max_price'], $shop_page_url );
        }
        if( ! empty( $_GET['filter_sizes'] ) ) {
            $shop_page_url = add_query_arg( 'filter_sizes', $_GET['filter_sizes'], $shop_page_url );
        }
    ?>
        <!-- Start Single Sidebar -->
        <div class="single-sidebar-wrap">
            <h3 class="sidebar-title">Цвет</h3>
            <div class="sidebar-body">
                <ul class="sidebar-list">
                    <?php
                    foreach( $colors_attr as $color ) {
                        echo sprintf(
                            '<li><a href="%s" class="%s">%s <span>(%d)</span></a></li>',
                            add_query_arg('filter_colors', $color->slug, $shop_page_url),
                            // "?filter_colors={$color->slug}",
                            isset( $_GET['filter_colors'] ) && $_GET['filter_colors'] == $color->slug ? 'active' : '',
                            $color->name,
                            (int) $color->count
                        );    
                    } 
                    ?>
                </ul>
            </div>
        </div>
        <!-- End Single Sidebar -->
    <?php endif; ?>

    <!-- Start Single Sidebar -->
    <div class="single-sidebar-wrap">
        <h3 class="sidebar-title">Цены</h3>
        <div class="sidebar-body">
            <div class="price-range-wrap">
                <div class="price-range" data-min="10" data-max="1000"></div>
                <div class="range-slider">
                    <form  method="get" action="" id="price_filter">
                        <label for="amount">Цена: </label>
                        <input type="text" id="amount" />
                        <input type="hidden" id="min_price" name="min_price" value="<?php echo isset( $_GET['min_price'] ) ? intval( $_GET['min_price'] ) : 10; ?>" />
                        <input type="hidden" id="max_price" name="max_price" value="<?php echo isset( $_GET['max_price'] ) ? intval( $_GET['max_price'] ) : 1000; ?>" />

                        <?php echo wc_query_string_form_fields( null, array( 'min_price', 'max_price', 'paged' ), '', true ); ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Single Sidebar -->

    <?php 
        $sizes_attr = get_terms(array(
            'taxonomy' => 'pa_sizes',
            'hide_empty' => false,
            'count' => true,
        ));
        if ( ! empty( $sizes_attr ) ) :
        
        $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
        if( ! empty( $_GET['min_price'] ) ) {
            $shop_page_url = add_query_arg( 'min_price', $_GET['min_price'], $shop_page_url );
        }
        if( ! empty( $_GET['max_price'] ) ) {
            $shop_page_url = add_query_arg( 'max_price', $_GET['max_price'], $shop_page_url );
        }
        if( ! empty( $_GET['filter_colors'] ) ) {
            $shop_page_url = add_query_arg( 'filter_colors', $_GET['filter_colors'], $shop_page_url );
        }
    ?>
        <!-- Start Single Sidebar -->
        <div class="single-sidebar-wrap">
            <h3 class="sidebar-title">Размер</h3>
            <div class="sidebar-body">
                <ul class="size-list">
                <?php
                    foreach( $sizes_attr as $size ) {
                        echo sprintf(
                            '<li><a href="%s" class="%s">%s</a></li>',
                            add_query_arg('filter_sizes', $size->slug, $shop_page_url),
                            // "?filter_sizes={$size->slug}",
                            isset( $_GET['filter_sizes'] ) && $_GET['filter_sizes'] == $size->slug ? 'active' : '',
                            $size->name
                        );    
                    } 
                ?>
                </ul>
            </div>
        </div>
        <!-- End Single Sidebar -->
    <?php endif; ?>

    <?php
        $product_tags = get_terms( 'product_tag' );
        if ( ! empty($product_tags) ) :
    ?>
    <!-- Start Single Sidebar -->
    <div class="single-sidebar-wrap">
        <h3 class="sidebar-title">Теги</h3>
        <div class="sidebar-body">
            <ul class="tags-cloud">
                <?php 
                    foreach ($product_tags as $tag) {
                        echo sprintf(
                            '<li><a href="%s">%s</a></li>',
                            get_term_link( (int) $tag->term_id, 'product_tag' ),
                            $tag->name
                        );
                    }
                ?>
            </ul>
        </div>
    </div>
    <!-- End Single Sidebar -->
    <?php 
    endif;
}

add_action( 'woocommerce_before_shop_loop', 'ecommerce_sidebar_wrap_end', 20 );
function ecommerce_sidebar_wrap_end() {
    ?>
        </div>
    </div>
    <?php
}

/***
 *  Content product (shop page card)
 ***/ 

add_action( 'woocommerce_before_shop_loop_item', 'ecommerce_image_wrapper_start', 5 );
function ecommerce_image_wrapper_start() {
    echo '<figure class="product-thumbnail">';
}

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
add_action( 'woocommerce_before_shop_loop_item', 'ecommerce_woocommerce_template_loop_product_link_open', 9 );
function ecommerce_woocommerce_template_loop_product_link_open() {
    ?>
        <a href="<?php the_permalink(); ?>" class="d-block">
    <?php
}

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_thumbnail', 10 );

add_action( 'woocommerce_before_shop_loop_item', 'ecommerce_woocommerce_template_loop_product_link_close', 11 );
function ecommerce_woocommerce_template_loop_product_link_close() {
   echo '<a/>';
}

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

add_action( 'woocommerce_before_shop_loop_item', 'ecommerce_wrapper_for_add_to_cart_and_sale_start', 15 );
function ecommerce_wrapper_for_add_to_cart_and_sale_start() {
    echo '<figcaption class="product-hvr-content">';
}

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_before_shop_loop_item', 'ecommerce_add_to_cart', 20 );
function ecommerce_add_to_cart() {
    global $product;
    echo apply_filters(
        'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
        sprintf(
            '<a href="%s" data-product_id="%s" data-quantity="%s" class="%s" %s>%s</a>',
            esc_url( $product->add_to_cart_url() ),
            $product->get_id(),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            'btn btn-black btn-addToCart product_type_' . $product->get_type() . ' ' . ( $product->is_purchasable() && $product->supports('ajax_add_to_cart') ? 'add_to_cart_button ajax_add_to_cart' : '' ),
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            esc_html( $product->add_to_cart_text() )
        ),
        $product,
        $args
    );
}

add_action( 'woocommerce_before_shop_loop_item', 'ecommerce_custom_sale_flash', 25 );
function ecommerce_custom_sale_flash() {
    global $post, $product;
    if ( $product->is_on_sale() ) : 
        echo apply_filters( 'woocommerce_sale_flash', '<span class="product-badge sale">' . esc_html__( 'Sale!', 'woocommerce' ) . '</span>', $post, $product ); 
    endif;
}

add_action( 'woocommerce_before_shop_loop_item', 'ecommerce_wrapper_for_add_to_cart_and_sale_end', 30 );
function ecommerce_wrapper_for_add_to_cart_and_sale_end() {
    echo '</figcaption>';
}

add_action( 'woocommerce_before_shop_loop_item_title', 'ecommerce_image_wrapper_end', 40 );
function ecommerce_image_wrapper_end() {
    echo '</figure>';
}

add_action( 'woocommerce_shop_loop_item_title', 'ecommerce_content_wrapper_start', 5 );
function ecommerce_content_wrapper_start() {
    echo '<div class="product-details">';
}

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'ecommerce_custom_woocommerce_template_loop_product_title', 10 );
function ecommerce_custom_woocommerce_template_loop_product_title() {
    ?>
        <h2 class="product-name"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    <?php
}

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'ecommerce_custom_price_wrapper_start', 15 );
function ecommerce_custom_price_wrapper_start() {
    echo '<div class="product-prices">';
}

add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_price', 20 );

add_action( 'woocommerce_shop_loop_item_title', 'ecommerce_custom_price_wrapper_end', 25 );
function ecommerce_custom_price_wrapper_end() {
    echo '</div>';
}

add_action( 'woocommerce_shop_loop_item_title', 'ecommerce_text_info_wrapper_start', 30 );
function ecommerce_text_info_wrapper_start() {
    echo '<div class="list-view-content">';
}

add_action( 'woocommerce_shop_loop_item_title', 'ecommerce_text_info', 35 );
function ecommerce_text_info() {
    if ( get_the_content() ) { ?>
    <p class="product-desc"><?php the_content(); ?></p>
  <?php }
}

add_action( 'woocommerce_shop_loop_item_title', 'ecommerce_text_info_btn', 40 );
function ecommerce_text_info_btn() {
    global $product;
    echo '<div class="list-btn-group mt-30 mt-sm-14">';
    echo apply_filters(
        'woocommerce_loop_add_to_cart_link', // WPCS: XSS ok.
        sprintf(
            '<a href="%s" data-quantity="%s" class="%s" %s>%s</a>',
            esc_url( $product->add_to_cart_url() ),
            esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
            esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ) . ' btn btn-black',
            isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '',
            esc_html( $product->add_to_cart_text() )
        ),
        $product,
        $args
    );
    echo '</div>';
}

add_action( 'woocommerce_shop_loop_item_title', 'ecommerce_text_info_wrapper_end', 40 );
function ecommerce_text_info_wrapper_end() {
    echo '</div>';
}


add_action( 'woocommerce_after_shop_loop_item', 'ecommerce_content_wrapper_end', 15 );
function ecommerce_content_wrapper_end() {
    echo '</div>';
}

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );


/***
 *  Single product
 ***/ 


remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
add_action( 'woocommerce_before_single_product_summary', 'ecommerce_custom_show_product_images', 20 );
function ecommerce_custom_show_product_images() {
    global $product;
    $product_gallery_images_url = [];
    $attachment_ids = $product->get_gallery_image_ids();
    foreach( $attachment_ids as $attachment_id ) {
        $product_gallery_images_url[] = wp_get_attachment_url( $attachment_id );
    }

    $single_img_url = wp_get_attachment_url($product->get_image_id());
  
    if( ! empty($product_gallery_images_url) ) :
    ?>
        <div class="single-product-thumb-wrap tab-style-left p-0 pb-sm-30 pb-md-30">
            <!-- Product Thumbnail Large View -->
            <div class="product-thumb-large-view">
                <div class="product-thumb-carousel vertical-tab">

                    <?php foreach($product_gallery_images_url as $image_url): ?>
                        <figure class="product-thumb-item">
                            <img src="<?php echo $image_url; ?>" alt="Single Product"/>
                        </figure>
                    <?php endforeach; ?>

                </div>


            </div>

            <!-- Product Thumbnail Nav -->
            <div class="vertical-tab-nav">
                <?php foreach($product_gallery_images_url as $key => $image_url): ?>
                    <figure class="product-thumb-item <?php count($product_gallery_images_url) == $key+1 ? 'mb-0' : '' ?>">
                        <img src="<?php echo $image_url; ?>" alt="Single Product"/>
                    </figure>
                <?php endforeach; ?>
            </div>
        </div>

    <?php else : ?>
        <div class="single-product-thumb-wrap tab-style-left p-0 pb-sm-30 pb-md-30">
            <!-- Product Thumbnail Large View -->
            <div class="product-thumb-large-view">
                <img src="<?php echo $single_img_url; ?>" alt="">
            </div>
    </div>

    <?php endif; 
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'ecommerce_custom_template_single_title', 5 );
function ecommerce_custom_template_single_title() {
    ?>
        <h2 class="product-name"><?php the_title(); ?></h2>
    <?php
}

add_filter( 'woocommerce_show_variation_price', '__return_true', 25 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'ecommerce_custom_single_price', 10 );
function ecommerce_custom_single_price() {
    global $product;
    ?>
        <div class="prices-stock-status d-flex align-items-center justify-content-between">
            <div class="prices-group">
                <?php if ( $product->get_regular_price() && empty( $product->get_sale_price() )  ) : ?>
                    <span class="price"><?php echo $product->get_regular_price() . ' ' . get_woocommerce_currency_symbol(); ?></span>
                <?php endif; ?>
                <?php if ( $product->get_sale_price() ) : ?>
                    <del class="old-price"><?php echo $product->get_regular_price() . ' ' . get_woocommerce_currency_symbol(); ?></del>
                    <span class="price"><?php echo $product->get_sale_price() . ' ' . get_woocommerce_currency_symbol(); ?></span>
                <?php endif; ?>

                <?php if( $product->is_type( 'variable' ) ) : ?>
                    <span class="price variable-product__price"><?php echo array_shift( array_shift($product->get_variation_prices()) ); ?> </span>
                    <span class="price"><?php echo get_woocommerce_currency_symbol(); ?></span>
                <?php endif; ?>
            </div>
            <?php if( ! empty( $product->get_availability()['class'] ) ): ?>
                <span class="stock-status"><i class="dl-icon-check-circle1"></i> В наличии</span>
            <?php endif; ?>
        </div>
    <?php
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'ecommerce_custom_single_excerpt', 20 );
function ecommerce_custom_single_excerpt() {
    echo sprintf(
        '<p class="product-desc">%s</p>',
        get_the_excerpt()
    );
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_action( 'woocommerce_single_product_summary', 'ecommerce_single_product_details_end', 40 );
function ecommerce_single_product_details_end() {
    echo '</div>';
}


add_action( 'woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 80 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );


/** 
 * remove on single product panel 'Additional Information' since it already says it on tab.
 */
add_filter('woocommerce_product_additional_information_heading', 'ecommerce_product_additional_information_heading');
 
function ecommerce_product_additional_information_heading() {
    echo '';
}

add_action('woocommerce_before_single_product_summary', 'quadlayers_product_default_attributes');
function quadlayers_product_default_attributes() {
    global $product;
    if (!count($default_attributes = get_post_meta($product->get_id(), '_default_attributes'))) {
    $new_defaults = array();
    $product_attributes = $product->get_attributes();
    if (count($product_attributes)) {
        foreach ($product_attributes as $key => $attributes) {
        $values = explode(',', $product->get_attribute($key));
        if (isset($values[0]) && !isset($default_attributes[$key])) {
            $new_defaults[$key] = sanitize_key($values[0]);
        }
        }
        update_post_meta($product->get_id(), '_default_attributes', $new_defaults);
    }
    }
}  

// #################################################################################################
/***
 *  Cart Page
 ***/ 

remove_action('woocommerce_before_cart', 'woocommerce_output_all_notices',  10);
//  remove_action("woocommerce_before_mini_cart", 20);

//  ajax upd cart count on the shop page
add_filter( 'woocommerce_add_to_cart_fragments', 'ecommerce_add_to_cart_fragment' );
function ecommerce_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	
    $fragments['.cart-count'] = '<span class="cart-count">' . $woocommerce->cart->cart_contents_count . '</span>';
 	return $fragments;
}

remove_action("woocommerce_widget_shopping_cart_total", "ecommerce_custom_widget_shopping_cart_subtotal", 10);
function ecommerce_custom_widget_shopping_cart_subtotal() {
    echo '<span class="cal-title">' . esc_html__( 'Subtotal:', 'woocommerce' ) . '</span> ' . '<span class="cal-amount">' . WC()->cart->get_cart_subtotal() . '</span>'; 
}

add_action( 'woocommerce_widget_shopping_cart_buttons', function(){
    // Removing Buttons
    remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
    remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

    // Adding customized Buttons
    add_action( 'woocommerce_widget_shopping_cart_buttons', 'custom_widget_shopping_cart_button_view_cart', 10 );
    add_action( 'woocommerce_widget_shopping_cart_buttons', 'custom_widget_shopping_cart_proceed_to_checkout', 20 );
}, 1 );

// Custom cart button
function custom_widget_shopping_cart_button_view_cart() {
    $original_link = wc_get_cart_url();
    $custom_link = home_url( '/cart/' ); // HERE replacing cart link
    echo '<a href="' . esc_url( $custom_link ) . '" class="button wc-forward btn btn-black">' . esc_html__( 'View cart', 'woocommerce' ) . '</a>';
}

// Custom Checkout button
function custom_widget_shopping_cart_proceed_to_checkout() {
    $original_link = wc_get_checkout_url();
    $custom_link = home_url( '/checkout/' ); // HERE replacing checkout link
    echo '<a href="' . esc_url( $custom_link ) . '" class="button checkout wc-forward btn btn-black mt-10">' . esc_html__( 'Checkout', 'woocommerce' ) . '</a>';
}

// #################################################################################################
/***
 *  Checkout
 ***/ 

remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20 );
add_action( 'woocommerce_checkout_terms_and_conditions', 'ecommerce_custom_wc_checkout_privacy_policy_text', 20 );
function ecommerce_custom_wc_checkout_privacy_policy_text() {
    wc_privacy_policy_text( 'checkout' );
}


}