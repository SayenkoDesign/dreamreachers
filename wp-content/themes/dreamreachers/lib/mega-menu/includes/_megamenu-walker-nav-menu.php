<?php

namespace megamenu;

use Walker_Nav_Menu;


/*

class Mega_Menu_Walker extends Walker_Nav_Menu
{
    
    var $columns;
    
    var $mega_menu_item = false;
    
    var $menu_item;
    
    var $current_classes;
    
    
    
    public function start_lvl( &$output, $depth = 0, $args = array() )
	{
        $indent = str_repeat("\t", $depth);
             
        $item = $this->menu_item;
        
        $classes = $item->classes;
        

        $tag = ( in_array("menu-item-has-children", $classes ) && in_array("mega-menu-item", $classes ) ) ? 'div' : 'ul';
        
        $output .= sprintf( "\n%s<%s class=\"sub-menu\">\n", $indent, $tag ); 
	}
    
	
 	
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
    {
        $indent  = ($depth) ? str_repeat("\t", $depth) : '';
                
        // Custom filter, we need to add mega menu classes earlier than nav_menu_css_class
        $item = apply_filters( 'be_mega_menu_item', $item, $args );
        
        // Grab the menu item so we can use it in start_lvl()
        $this->menu_item = $item; 
        
         
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[]      = 'menu-item-' . $item->ID;
        
        $class_names    = join(' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names    = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
       
        $id             = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth);
        $id             = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        
        // Set mega menu flag
        if( in_array("mega-menu-item", $classes ) ) {
             $this->mega_menu_item = true;
        }
        
        
        // Wrap columns
        if( in_array("mega-menu-column", $classes ) ) {
            
            // Close the open column
            if( $this->columns ) {
                $output .= "</ul>";
            }
            
            $output .= '<ul class="mega-sub-menu">';
            
            // Increment the Column count
            $this->columns++;
        }
        
        
        $output        .= $indent . '<li' . $id . $class_names . '>';
        $atts           = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        $atts           = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        $attributes     = '';
        
		foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
             }
         }
		
		// Change output tag for mega menu post
		$item_output_tag = 'a';
 		if( strpos( $class_names, 'mega-menu-post-' ) !== false ) {
			$attributes = 'class="hide"';
			$item_output_tag = 'div';
		}
        
        
        $item_output = $args->before;
        $item_output .= sprintf('<%s %s>', $item_output_tag, $attributes );
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID);
        $item_output .= $args->link_after;
        $item_output .= sprintf('</%s>', $item_output_tag );
        $item_output .= $args->after;
                   
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
 		
    }

    
    public function end_lvl( &$output, $depth = 0, $args = array() ) 
    {
        $indent = str_repeat( "\t", $depth );
        
        $item = $this->menu_item;
                
        if( true == $this->mega_menu_item ) {
            $output .= "$indent</ul><!-- close mega-sub-menu-->\n";
        }
		
        $tag =  true == $this->mega_menu_item ? 'div' : 'ul';
         
        $output .= "$indent</$tag><!-- close end_lvl -->\n";
        
        // Reset column count
        $this->columns = 0;
        $this->mega_menu_item = false;
    }
     
}
*/