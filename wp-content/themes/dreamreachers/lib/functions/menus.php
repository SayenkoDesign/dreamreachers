<?php

function _s_primary_menu_menu_atts( $atts, $item, $args ) {
              
    if( 'primary' != $args->theme_location ) {
        return $atts;
    }
          
    $classes = $item->classes;
    
    foreach( $classes as $class ) {
                
        if( strpos( $class, 'service' ) !== false ) {
            $post_id = $item->object_id;
            $icon = get_field( 'icon', $post_id );
            if( ! empty( $icon ) ) {
                $icon = _s_get_acf_image( $icon, 'medium', false );
                $atts['data-icon'] = esc_html( $icon );
            }
        }
            
    }
      
    return $atts;
}

add_filter( 'nav_menu_link_attributes', '_s_primary_menu_menu_atts', 99, 3 );


// Contact Modal
function _s_contact_menu_atts( $atts, $item, $args ) {
      $classes = $item->classes;
      
 	  if ( in_array( 'lets-build', $classes ) ) {
		$atts['data-open'] = 'lets-build';
	  }
	  return $atts;
}

add_filter( 'nav_menu_link_attributes', '_s_contact_menu_atts', 10, 3 );


// remove parent class from homepage - used for single page scroll menus
function clear_nav_menu_item_class($classes, $item, $args) {
    
    
	if( is_front_page() && ( $args->theme_location == 'primary' ) ) {
		$classes = array_filter($classes, "remove_parent_classes");
	}
	
	return $classes;
}

add_filter('nav_menu_css_class', 'clear_nav_menu_item_class', 10, 3);


// Filter menu items as needed and set a custom class etc....
function set_current_menu_class($classes) {
	global $post;
	
	if( is_singular( 'team' ) ) {
		
		$classes = array_filter($classes, "remove_parent_classes");
		
		if ( in_array('menu-item-27', $classes ) )
			$classes[] = 'current-menu-item';
	}
			
	return $classes;
}

//add_filter('nav_menu_css_class', 'set_current_menu_class',1,2); 


// check for current page classes, return false if they exist.
function remove_parent_classes($class){
  return in_array( $class, array( 'current_page_item', 'current_page_parent', 'current_page_ancestor', 'current-menu-item' ) )  ? FALSE : TRUE;
}



function _s_is_page_template_name( $template_name ) {
	
	if( is_page() ) {
		$template_found = str_replace( '.php', '', basename( get_page_template_slug( get_queried_object_id() ) ) );
		return $template_name === $template_found ? true : false;
	}
	
}
