<?php

namespace megamenu;

use Walker_Nav_Menu;


class MegaMenu_Walker_Nav_Menu extends Walker_Nav_Menu
{

    public $megaMenuID;
    
    public $hasMegaMenu;
    public $hasColumnDivider;
    public $hasDivider;
    public $hasFeaturedImage;
    public $hasIcon; 
    public $hasFeaturedContent;
    
    public $count;

    public function __construct()
    {
        $this->megaMenuID = 0;        
    }

    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $this->count = 0;
        
        $indent = str_repeat("\t", $depth);
        $submenu = ($depth > 0 && $this->megaMenuID != 0) ? 'sub-menu' : 'sub-menu';
        $output .= "\n$indent<ul class=\"$submenu\" >\n";
        
        if ($this->megaMenuID != 0 && $depth == 0) {
            $column_classes[] = '';
            if( $this->hasIcon ) {
                $column_classes[] = 'menu-item-column-icon';
                $output .= sprintf( '<li class="mega-menu-column %s"><ul><li class="menu-item"><span class="icon shadow">%s</span></li></ul>', 
                                    implode( ' ', $column_classes ), 
                                    wp_get_attachment_image( $this->hasIcon ) 
                                  );
                $output .= "\n";
            }
            
            $output .= '<li class="mega-menu-column"><ul>';
            $output .= "\n";
        }
               
    }

    public function end_lvl(&$output, $depth = 0, $args = array())
    {
        if ($this->megaMenuID != 0 && $depth == 0) {
            $output .= "</ul></li>";
        }

        $output .= "</ul>";
    }

    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {

        $this->hasMegaMenu = get_field( 'activate_mega_menu', $item );
        $this->hasColumnDivider = get_field( 'column_divider', $item );
        $this->hasDivider = get_field( 'item_divider', $item );
        $this->hasFeaturedImage = get_field( 'featured_image', $item );
        $this->hasIcon = get_field( 'icon', $item );
        $this->hasFeaturedContent = get_field( 'featured_content', $item );
        
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $li_attributes = '';
        $class_names = $value = '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;

        if ( $this->megaMenuID != 0 && $this->megaMenuID != intval( $item->menu_item_parent ) && $depth == 0 ) {
            $this->megaMenuID = 0;
        }
        
        // $column_divider = array_search('column-divider', $classes);
        if ( $this->hasColumnDivider && 0 !== $this->count ) {
            array_push($classes, 'column-divider');
            $output .= '</ul></li><li class="mega-menu-column"><ul>';
            $output .= "\n";
        }

        // managing divider: add divider class to an element to get a divider before it.
        // $divider_class_position = array_search('divider', $classes);
        if ( $this->hasDivider && 0 !== $this->count ) {
            $output .= "<li class=\"divider\"></li>\n";
            // unset($classes[$divider_class_position]);
        }

        if ( !$depth && $this->hasMegaMenu ) {
            array_push($classes, 'mega-menu-item');
            $this->megaMenuID = $item->ID;
        }
        
        $this->count++;
        
        $classes[] = ( isset( $args->has_children ) && $args->has_children ) ? 'dropdown' : '';
        $classes[] = ($item->current || $item->current_item_ancestor) ? 'active' : '';
        $classes[] = 'menu-item-'.$item->ID;
        if ( $depth && ( isset( $args->has_children ) && $args->has_children ) ) {
            // $classes[] = 'submenu'; // this could cause conflicts
        }

        if ($depth && $this->hasFeaturedImage) {
            array_push($classes, 'menu-item-image');
        }
        
        if ($depth && $this->hasIcon) {
            array_push($classes, 'menu-item-icon');
        }

        $class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = ' class="'.esc_attr($class_names).'"';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'.$item->ID, $item, $args);
        $id = strlen($id) ? ' id="'.esc_attr($id).'"' : '';

        $output .= $indent.'<li'.$id.$value.$class_names.$li_attributes.'>';
        
        /*
        $attributes = !empty($item->attr_title) ? ' title="'.esc_attr($item->attr_title).'"' : '';
        $attributes .= !empty($item->target) ? ' target="'.esc_attr($item->target).'"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="'.esc_attr($item->xfn).'"' : '';
        $attributes .= !empty($item->url) ? ' href="'.esc_attr($item->url).'"' : '';
        
        */
        
        $atts = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
		$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
		$atts['href']   = ! empty( $item->url )        ? $item->url        : '';

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array $atts {
		 *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        
        $attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}
        
        $attributes .= ( isset( $args->has_children ) && $args->has_children) ? ' class="dropdown-toggle" data-toggle="dropdown"' : '';
        
        /** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output = $args->before;
        
        // if( ! $depth || ( $depth && $this->megaMenuID != 0 && '#' != $item->url ) ) {
        // if( $depth && $this->megaMenuID != 0 && '#' == $item->url ) {
        if( $this->megaMenuID != 0 && ( ! $depth && '#' == $item->url ) || ( $depth && '#' != $item->url ) ) {
            $item_output .= '<a'.$attributes.'>';
        }
        else {
            $item_output .= '<a'.$attributes.'>';
        }
                
        $item_output .= $args->link_before . $title . $args->link_after;
          
        /*      
        // add support for menu item title
        if ( $item->attr_title ) {
            $item_output .= '<h3 class="tit">'.$item->attr_title.'</h3>';
        }
        // add support for menu item descriptions
        if (strlen($item->description) > 2) {
            $item_output .= '</a> <span class="sub">'.$item->description.'</span>';
        }
        */

        // if mega menu
        if ( $this->megaMenuID != 0 ) {
            
            // Images don't need content
            if( $this->hasFeaturedImage ) {
                $item_output .= wp_get_attachment_image( $this->hasFeaturedImage );
            }
        
        }

        // $item_output .= (($depth == 0 || 1) && $args->has_children) ? ' <b class="caret"></b></a>' : '</a>';
        if( $this->megaMenuID != 0 && ( ! $depth && '#' == $item->url ) || ( $depth && '#' != $item->url ) ) {
            $item_output .= '</a>'; 
        }
        else {
            $item_output .= '</a>'; 
        }
        
        $item_output .= $args->after;
        

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    
    public function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        if (!$element) {
            return;
        }

        $id_field = $this->db_fields['id'];

        //display this element
        if (is_array($args[0])) {
            $args[0]['has_children'] = !empty($children_elements[$element->$id_field]);
        } elseif (is_object($args[0])) {
            $args[0]->has_children = !empty($children_elements[$element->$id_field]);
        }

        $cb_args = array_merge(array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'start_el'), $cb_args);

        $id = $element->$id_field;

        // descend only when the depth is right and there are childrens for this element
        if (($max_depth == 0 || $max_depth > $depth + 1) && isset($children_elements[$id])) {
            foreach ($children_elements[ $id ] as $child) {
                if (!isset($newlevel)) {
                    $newlevel = true;
              //start the child delimiter
              $cb_args = array_merge(array(&$output, $depth), $args);
                    call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
                }
                $this->display_element($child, $children_elements, $max_depth, $depth + 1, $args, $output);
            }
            unset($children_elements[ $id ]);
        }

        if (isset($newlevel) && $newlevel) {
            //end the child delimiter
          $cb_args = array_merge(array(&$output, $depth), $args);
            call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
        }

        //end this element
        $cb_args = array_merge(array(&$output, $element, $depth), $args);
        call_user_func_array(array(&$this, 'end_el'), $cb_args);
    }
    
}
