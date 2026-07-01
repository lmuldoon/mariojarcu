// Small mostly vanilla JS (some jQuery) library to init Google Maps

const GoogleMap = (function () {

	/**
	 * Get the value of the global CSS variable holding the page colour.
	 * @return {String}
	 */
	function getPageColor() {
		let color = getComputedStyle(document.documentElement).getPropertyValue('--page-color');

		// remove hash from hex color
		return color.toLowerCase().trim().substring(1);
	}

	function GoogleMap(element, markers) {
		this.element = element;
		this.markers = markers;
		this.themeUri = element.getAttribute('data-theme-uri') || '';

		this.zoom = 18;

		this.options = {
			zoom: this.zoom,
			center: new google.maps.LatLng(0, 0),
			scrollwheel: false,
			disableDefaultUI: true,
			streetViewControl: false,
			mapId: 'b757e55fce0499adc9fc4580'
		};

		if (element.hasAttribute('data-zoom-position')) {
			this.options.zoomControlOptions = {
				position: google.maps.ControlPosition[element.getAttribute('data-zoom-position')]
			};
		}

		init.call(this);
	}

	GoogleMap.prototype.add_marker = function (lat, lng) {

		const latlng = { lat: parseFloat(lat), lng: parseFloat(lng) };

		const pinImg = document.createElement('img');
		pinImg.src = this.themeUri + 'images/map-marker.svg';
		pinImg.width = 55;
		pinImg.height = 55;

		const marker = new google.maps.marker.AdvancedMarkerElement({
			position: latlng,
			map: this.map,
			content: pinImg,
		});

		return marker;
	};

	GoogleMap.prototype.add_info_window = function (marker, html) {
		const info_window = new google.maps.InfoWindow({
			content: html
		});

		google.maps.event.addListener(marker, 'click', function () {
			info_window.open(this.map, marker);
		});

		return info_window;
	};

	GoogleMap.prototype.center = function () {
		const bounds = get_bounds.call(this);

		if (1 === this.map.markers.length) {
			this.map.setCenter(bounds.getCenter());
			this.map.setZoom(this.zoom);
		} else {
			this.map.fitBounds(bounds);
		}
	};

	function get_bounds() {
		const bounds = new google.maps.LatLngBounds();

		for (let i = 0, len = this.map.markers.length; i < len; i++) {
			const marker = this.map.markers[i];
			bounds.extend(marker.position);
		}

		return bounds;
	}

	GoogleMap.prototype.set_zoom = function (zoom) {
		this.map.setZoom(zoom);
	};

	GoogleMap.prototype.zoom_in = function () {
		this.map.setZoom(this.map.getZoom() + 1);
	};

	GoogleMap.prototype.zoom_out = function () {
		this.map.setZoom(this.map.getZoom() - 1);
	};

	function init() {
		this.map = new google.maps.Map(this.element, this.options);
		this.map.markers = [];

		for (let i = 0, len = this.markers.length; i < len; i++) {
			const _marker = this.markers[i];
			const marker = this.add_marker(_marker.lat, _marker.lng);

			this.map.markers.push(marker);

			if (_marker.hasOwnProperty('html') && '' !== _marker.html) {
				this.add_info_window(marker, _marker.html);
			}
		}

		this.center();

		this.element.classList.add('map-initialised');
		trigger_custom_event(this.element, 'map-ready');

		/**
		 * Recenter the map each time the window is resized.
		 * Center will keep focus on the current position 
		 * of the map *not* the marker that was added.
		 * @see http://stackoverflow.com/questions/8792676/center-google-maps-v3-on-browser-resize-responsive
		 */
		const _ = this;
		window.addEventListener('resize', function () {
			const center = _.map.getCenter();
			google.maps.event.trigger(_.map, "resize");
			_.map.setCenter(center);
		});
	}

	/**
	 * Trigger a custom event on an element.
	 * @param  {Node}   element    A DOM Node to trigger the event on.
	 * @param  {String} event_name A unique identifier for the event.
	 */
	function trigger_custom_event(element, event_name) {
		const event = new Event(event_name);
		element.dispatchEvent(event);
	}

	return GoogleMap;
})();

export function create_map(element) {
	let markers = Array.prototype.slice.call(element.querySelectorAll('.js-google-map__marker'));

	markers = markers.map((marker) => {
		return {
			lat: marker.getAttribute('data-lat'),
			lng: marker.getAttribute('data-lng'),
			html: marker.innerHTML
		};
	});

	jQuery(element).on('map-ready', () => {
		jQuery(element).siblings('.js-google-map-preloader').fadeOut(250);
	});

	const map = new GoogleMap(element, markers);
}
