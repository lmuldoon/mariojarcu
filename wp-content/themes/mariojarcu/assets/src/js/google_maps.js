import {
    create_map
} from './maps-scripts/load-maps';

// Load visible maps on page load
const $maps = $('.js-google-map');
$maps.each( (index, map) => {
    const $map = $(map);

    if ( $map.is(':visible') ) {
        create_map( $map.get(0) );
    }
} );