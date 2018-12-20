(function (document, window, $) {

	var map_zoom_level = 6;
    
    /*
    *  render_map
    *   Do we want to center map on a specific marker?
    *
    */
    function render_map( $el ) {
        
        var center_lat = $el.find( '.marker[data-active="true"]' ).data('lat');
        var center_lng = $el.find( '.marker[data-active="true"]' ).data('lng');
            
        // variables
        var $markers = $el.find('.marker');
        var args = {
            zoom	: map_zoom_level,
            center	: new google.maps.LatLng(center_lat, center_lng),
            mapTypeId	: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false,
            //disableDefaultUI: false,
            zoomControl: true,
            scaleControl: false,
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false,
            styles: [{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"labels.text","stylers":[{"visibility":"on"},{"color":"#8e8e8e"}]},{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#7f7f7f"}]},{"featureType":"administrative","elementType":"labels.text.stroke","stylers":[{"visibility":"off"}]},{"featureType":"administrative.country","elementType":"geometry.stroke","stylers":[{"color":"#bebebe"}]},{"featureType":"administrative.province","elementType":"geometry.stroke","stylers":[{"visibility":"on"},{"color":"#cbcbcb"},{"weight":"0.69"}]},{"featureType":"administrative.locality","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#e4e4e4"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45},{"visibility":"simplified"}]},{"featureType":"road","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"},{"color":"#dadada"}]},{"featureType":"road.highway","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"all","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#eeeeee"}]},{"featureType":"road.local","elementType":"labels.text","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#cbcbcb"},{"visibility":"on"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#d9d9d9"}]},{"featureType":"water","elementType":"geometry.stroke","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels.text","stylers":[{"visibility":"simplified"}]}]
        };
    
        // create map
        var map = new google.maps.Map( $el[0], args);
    
        // add a markers reference
        map.markers = [];
        map.infoBoxes = [];
    
        // add markers
        $markers.each(function(){
            add_marker( $(this), map );
        });
    
        // let's open the first map marker
        google.maps.event.trigger(map.markers[0], 'click');
    
        // return
        return map;
    }
    
    /*
    *  add_marker
    *
    *  This function will add a marker to the selected Google Map
    *
    *  @type	function
    *  @date	8/11/2013
    *  @since	4.3.0
    *
    *  @param	$marker (jQuery element)
    *  @param	map (Google Map object)
    *  @return	n/a
    */
    function add_marker( $marker, map ) {
    
        // var
        var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
                        
        var image = {
          url: map_params.icon,
          scaledSize: new google.maps.Size(33, 48), // IE hack
        };
    
        // create marker
        // https://developers.google.com/maps/documentation/javascript/reference/marker#MarkerOptions.optimized
        var marker = new google.maps.Marker({
            position	: latlng,
            map			: map,
            icon        : image,
            optimized   : false, // IE hack
            // Custom values
            _region   : $marker.attr('data-region'),
            _id         : $marker.attr('data-id')
        });
        
     
        // add to array
        map.markers.push( marker );
    
        // if marker contains HTML, add it to an infoWindow
        if( $marker.html() )
        {

            var infobox = new InfoBox({
                content: $marker.html(),
                disableAutoPan: false,
                zIndex: null,
                pixelOffset: new google.maps.Size(-140, -70),
                alignBottom: true,
                boxStyle: {
                    //background: "none",
                    width: '276px'
                },
                closeBoxMargin: 0
                ,closeBoxURL: map_params.cross
                ,infoBoxClearance: new google.maps.Size(1, 1)
                ,isHidden: false
                ,pane: "floatPane"
                ,enableEventPropagation: false
                ,id:$marker.attr('data-id')
            });
            
            map.infoBoxes.push(infobox);
    
            // show info window when marker is clicked
            google.maps.event.addListener(marker, 'click', function() {
                // close not working
                for(i = 0; i < map.infoBoxes.length; i++){
                    map.infoBoxes[i].close();
                }
                
                // center marker on click
                var latLng = marker.getPosition();
                map.setCenter( latLng );
                map.panBy(0, -150);
                
                // open infowindow
                infobox.open( map, marker );
                
                // marker._id
                var $current = $("#map-legend").find('span.active');
                var current_id = $current.data('marker-id');
                var current_parent_id = $current.parents('.is-accordion-submenu-parent').attr('id');
                var $clicked;
                
                if( current_id != marker._id ) {
                    $("#map-legend").find('span').removeClass('active');
                    $clicked = $( '[data-marker-id="' + marker._id + '"]', "#map-legend" );
                    $clicked.addClass('active');
                    if( $clicked.parents('.is-accordion-submenu-parent').attr('id') != current_parent_id ) {
                        $clicked.parents('.is-accordion-submenu-parent').find('a').trigger('click');
                    }
                }
                
                
            });
            
            
            // close info window when map is clicked
            google.maps.event.addListener(map, 'click', function(event) {
                if (infobox) {
                    infobox.close(); 
                }
            }); 
            
            // let's open the first map marker, moved this to "render_map" function
            //google.maps.event.trigger(map.markers[0], 'click');
           
    
        }
    }
    
    /*
    *  center_map
    *
    *  This function will center the map, showing all markers attached to this map
    *
    *  @type	function
    *  @date	8/11/2013
    *  @since	4.3.0
    *
    *  @param	map (Google Map object)
    *  @return	n/a
    */
    function center_map( map ) {
        
        //var bounds = new google.maps.LatLngBounds();
        //map.setCenter( bounds.getCenter() );
		//map.setZoom( 3 );
        
        
        // vars
        /*
		var bounds = new google.maps.LatLngBounds();
	 
		// loop through all markers and create bounds
		$.each( map.markers, function( i, marker ){
			var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
			bounds.extend( latlng );
		});
	 
		// only 1 marker?
		if( map.markers.length == 1 ){
			// set center of map
		    map.setCenter( bounds.getCenter() );
		    map.setZoom( 11 );
		}
		else{
			// fit to bounds
			//map.fitBounds( bounds );
            map.setCenter( bounds.getCenter() );
		}
        */
        
    }
    
    /*
    *  document ready
    *
    *  This function will render each map when the document is ready (page has loaded)
    *
    *  @type	function
    *  @date	8/11/2013
    *  @since	5.0.0
    *
    *  @param	n/a
    *  @return	n/a
    */
    // global var
    var map = null;
 	
	// Loop all instances, though we're only going to use one this time.
 	$('.acf-map').each(function(){
		// create map
		map = render_map( $(this) );
        
        google.maps.event.addDomListener(window, "resize", function() {
            var center = map.getCenter();
            google.maps.event.trigger(map, "resize");
            map.setCenter(center);
        });	
        
        $("#map-legend").addClass('show');	
	
	});
    
    
	
		
	$("#map-legend").on( 'click', '.marker-anchor', function(){
        
        // Do nothing if active marker
        if( $(this).hasClass('active') ) {
            return;
        }
        var id = $(this).data('marker-id');
                
        for (var i= 0; i < map.markers.length; i++) {            
            if (map.markers[i]._id == id) {  
                $("#map-legend").find('span').removeClass('active');
                $(this).addClass('active');
                google.maps.event.trigger(map.markers[i], 'click');
                break;
            }
        }
        
        
    });
		
    
}(document, window, jQuery));
