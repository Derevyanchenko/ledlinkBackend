<?php 
/**
 * Template Name: Contacts page
 **/ 

get_header();

$left_column = get_field( "left_column" );

$left_column_title = $left_column['title'];
$contacts_info     = $left_column['contacts_information_items'];
$map               = $left_column['map'];

$right_column = get_field( "right_column" );
$right_column_title = $right_column['title'];
$shortcode = $right_column['shortcode'];

?>

<section class="section contactsPage">
    <div class="contactsPage-container">
        <div class="contactsPage__wrapper">
            <div class="contactsPage__info-col">
                <?php if ( ! empty( $left_column_title ) ): ?>
                    <h2 class="contactsPage__title">
                        <?php echo $left_column_title; ?>
                    </h2>
                <?php endif; ?>
                <div class="contactsPage__info">
                <?php if ( ! empty( $contacts_info ) ): ?>
                    <?php foreach ( $contacts_info as $item ) : ?>
                        <div class="contactsPage__item">
                            <?php 
                                if ( $item['item_type'] == 'default' ) {
                                    echo sprintf(
                                        '<p class="contactsPage__item-text left">%s</p>',
                                        $item['item_value']
                                    );
                                } 
                                if ( $item['item_type'] == 'tel' ) {
                                    echo sprintf(
                                        '<a href="tel:%s" class="contactsPage__item-text left">%s</a>',
                                        $item['item_value'],
                                        $item['item_value']
                                    );
                                }
                                if ( $item['item_type'] == 'email' ) {
                                    echo sprintf(
                                        '<a href="mail:%s" class="contactsPage__item-text left">%s</a>',
                                        $item['item_value'],
                                        $item['item_value']
                                    );
                                }
                            ?>
                            <p class="contactsPage__item-text right"><?php echo $item['item_title']; ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                    <div class="map__wrapper">
                        <div class="map acf-map" data-zoom="8">
                            <div class="marker" data-lat="<?php echo esc_attr($map['lat']); ?>" data-lng="<?php echo esc_attr($map['lng']); ?>"></div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- contactsPage__info-col -->

            <div class="contactsPage__form-col">
                <?php if ( ! empty( $right_column_title ) ): ?>
                    <h2 class="contactsPage__title">
                        <?php echo $right_column_title; ?>
                    </h2>
                <?php endif; ?>

                <?php if ( ! empty( $shortcode ) ): ?>
                    <div class="contactsPage__form-wrapper">
                        <div class="contacts__form">
                            <?php echo do_shortcode( $shortcode ); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <!-- contactsPage__form-wrapper -->
        </div>
    </div>
</section>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOQlByLnQ-dSIiIN3gjMZ2E7QSsauhHx4"></script>
<script type="text/javascript">
(function( $ ) {

/**
 * initMap
 *
 * Renders a Google Map onto the selected jQuery element
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   jQuery $el The jQuery element.
 * @return  object The map instance.
 */
function initMap( $el ) {

    // Find marker elements within map.
    var $markers = $el.find('.marker');

    // Create gerenic map.
    var mapArgs = {
        zoom        : $el.data('zoom') || 16,
        mapTypeId   : google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map( $el[0], mapArgs );

    // Add markers.
    map.markers = [];
    $markers.each(function(){
        initMarker( $(this), map );
    });

    // Center map based on markers.
    centerMap( map );

    // Return map instance.
    return map;
}

/**
 * initMarker
 *
 * Creates a marker for the given jQuery element and map.
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   jQuery $el The jQuery element.
 * @param   object The map instance.
 * @return  object The marker instance.
 */
function initMarker( $marker, map ) {

    // Get position from marker.
    var lat = $marker.data('lat');
    var lng = $marker.data('lng');
    var latLng = {
        lat: parseFloat( lat ),
        lng: parseFloat( lng )
    };

    // Create marker instance.
    var marker = new google.maps.Marker({
        position : latLng,
        map: map
    });

    // Append to reference for later use.
    map.markers.push( marker );

    // If marker contains HTML, add it to an infoWindow.
    if( $marker.html() ){

        // Create info window.
        var infowindow = new google.maps.InfoWindow({
            content: $marker.html()
        });

        // Show info window when marker is clicked.
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open( map, marker );
        });
    }
}

/**
 * centerMap
 *
 * Centers the map showing all markers in view.
 *
 * @date    22/10/19
 * @since   5.8.6
 *
 * @param   object The map instance.
 * @return  void
 */
function centerMap( map ) {

    // Create map boundaries from all map markers.
    var bounds = new google.maps.LatLngBounds();
    map.markers.forEach(function( marker ){
        bounds.extend({
            lat: marker.position.lat(),
            lng: marker.position.lng()
        });
    });

    // Case: Single marker.
    if( map.markers.length == 1 ){
        map.setCenter( bounds.getCenter() );

    // Case: Multiple markers.
    } else{
        map.fitBounds( bounds );
    }
}

// Render maps on page load.
$(document).ready(function(){
    $('.acf-map').each(function(){
        console.log('acf map loop');
        var map = initMap( $(this) );
    });
});

})(jQuery);
</script>

<?php get_footer(); ?>