/**
 * Lazy-loads Mapbox GL JS + CSS only when the #mapbox-map element is
 * close to entering the viewport. This removes ~229KB of JS (plus a
 * CSS file) from the critical path, which is the single largest
 * performance win available on mobile (~900ms CPU on a throttled device).
 *
 * rootMargin: '300px' starts loading 300px before the element is visible
 * so the map is ready by the time the user scrolls to it.
 */

export default function initLazyMap() {
    const mapEl = document.getElementById( 'mapbox-map' );
    if ( ! mapEl ) return;

    if ( ! ( 'IntersectionObserver' in window ) ) {
        // Fallback for very old browsers — load immediately
        loadMapbox();
        return;
    }

    const observer = new IntersectionObserver( ( entries ) => {
        if ( entries[ 0 ].isIntersecting ) {
            observer.disconnect();
            loadMapbox();
        }
    }, { rootMargin: '300px' } );

    observer.observe( mapEl );
}

function loadMapbox() {
    // CSS
    const link = document.createElement( 'link' );
    link.rel  = 'stylesheet';
    link.href = 'https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css';
    document.head.appendChild( link );

    // JS
    const script  = document.createElement( 'script' );
    script.src    = 'https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js';
    script.onload = initMap;
    document.head.appendChild( script );
}

function initMap() {
    const el = document.getElementById( 'mapbox-map' );
    if ( ! el ) return;

    /* global mapboxgl */
    mapboxgl.accessToken = 'pk.eyJ1IjoibHVrZW11bGRvb24iLCJhIjoiY21wdWJhM2Y5MDJmdDJ2cXNhcWluZWNsayJ9.FoG_R-Gdvy0_sGc5D_4oag';

    const map = new mapboxgl.Map( {
        container: 'mapbox-map',
        style:     'mapbox://styles/lukemuldoon/cmpube4t6002401s84n1xa1zy',
        center:    [ -1.2517371, 52.376622 ],
        zoom:      16,
    } );

    map.addControl( new mapboxgl.NavigationControl(), 'top-right' );

    new mapboxgl.Marker( { color: '#C39A43', scale: 1.5 } )
        .setLngLat( [ -1.2517371, 52.376622 ] )
        .addTo( map );
}
