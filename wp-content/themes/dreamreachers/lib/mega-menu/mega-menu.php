<?php

/**
 * Mega Menu
 * Version: 1.0
 * Requires ACF fields 
 * To Do - no ACF fallback
 */
 

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;



final class Mega_Menu_Walker_Edits {  

    
	/**
	 * Menu Location
	 *
	 * @since 1.0
	 */
	public $menu_location = 'primary';
    
    
    
    /**
	 * Plugin Constructor.
	 *
	 * @since 1.0
	 * @return BE_Mega_Menu
	 */
	function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}
    
    private function includes() {
        // require_once dirname( __FILE__ ) . '/includes/megamenu-custom-fields.php';   
    }
	
    
    /**
	 * Initialize
	 *
	 * @since 1.0
	 */
	function init() {
        
		// Set new location
		$this->menu_location = apply_filters( 'kr_mega_menu_location', $this->menu_location );
		// add_action( 'init', array( $this, 'register_cpt' ), 20 );
		add_filter( 'wp_nav_menu_args', array( $this, 'mega_menu_custom_args' ) );
        //add_filter( 'kr_mega_menu_item', array( $this, 'menu_item' ), 10, 2 );
		// add_filter( 'walker_nav_menu_start_el', array( $this, 'display_mega_menu_post' ), 10, 4 );
        //add_filter('wp_nav_menu_objects', array( $this, 'add_mega_menu_post' ), 10, 2);

	}
    
    
	/**
	 * Register Mega Menu post type
	 *
	 * @since 1.0.0
	 */
	function register_cpt() {
		$labels = array(
			'name'               => 'Mega Menus',
			'singular_name'      => 'Mega Menu',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Mega Menu',
			'edit_item'          => 'Edit Mega Menu',
			'new_item'           => 'New Mega Menu',
			'view_item'          => 'View Mega Menu',
			'search_items'       => 'Search Mega Menus',
			'not_found'          => 'No Mega Menus found',
			'not_found_in_trash' => 'No Mega Menus found in Trash',
			'parent_item_colon'  => 'Parent Mega Menu:',
			'menu_name'          => 'Mega Menus',
		);
		$args = array(
			'labels'              => $labels,
			'hierarchical'        => false,
			'supports'            => array( 'title', 'thumbnail', 'editor', 'revisions' ),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => 'themes.php',
			'show_in_nav_menus'   => false,
			'publicly_queryable'  => true,
			'exclude_from_search' => true,
			'has_archive'         => false,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => array( 'slug' => 'megamenu', 'with_front' => false ),
			'menu_icon'           => 'dashicons-editor-table', // https://developer.wordpress.org/resource/dashicons/
		);
        
		register_post_type( 'megamenu', apply_filters( 'kr_mega_menu_post_type_args', $args ) );
	}
    
    
	/**
	 * Limit Menu Depth
	 *
	 * @since 1.0.0
	 * @param array $args
	 * @return array
	 */
	function mega_menu_custom_args( $args ) {
		if( $this->menu_location == $args['theme_location'] ) {
			
            $walker = 'MegaMenu_Walker_Nav_Menu';
            if ( ! class_exists( $walker ) ) {
                // error_log( dirname( __FILE__ ) . '/includes/megamenu-walker-nav-menu.php' );
                require_once dirname( __FILE__ ) . '/includes/megamenu-walker-nav-menu.php';
            }
            
            //$args['depth'] = 0;
            $args['menu_class'] .= ' mega-menu';
            $args['link_before'] = '<span>';
            $args['link_after'] = '</span>';
            $args['walker'] = new megamenu\MegaMenu_Walker_Nav_Menu();
            return $args;
        }
	}
    
    
    
    /**
	 * Menu Item
	 *
	 * @since 1.0
	 * @param array $classes
	 * @param object $item
	 * @param object $args
	 * @param int $depth
	 * @return array
	 */
	/*function menu_item( $item, $args ) {
		if( $this->menu_location != $args->theme_location )
			return $item;
        
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
  		
        $menu_item = get_field( 'mega_menu', $item );
        
        if( empty( $menu_item ) ) {
            return $item;
        }
        
        // Add mega menu parent class
        if( 'Parent' == $menu_item['mega_menu_item'] ) {
             $classes[] = 'mega-menu-item';
        }
                
        // Wrap columns
        if( 'Column' == $menu_item['mega_menu_item'] ) {
            $classes[] = 'mega-menu-column';
        }
        
        $item->classes = $classes;
        
		return $item;
	}
    */
    
    
    
    /**
	 * Add Mega Menu Post to mega menu item
	 *
	 * @since 1.0.0
	 * @param array $args
	 * @return array
	 */
    function add_mega_menu_post( $items, $args ) {
        
        // loop
        foreach( $items as &$item ) {
            
                    
            // Parent needs to be a mega menu parent
            if( ! $item->menu_item_parent ) {
                continue;
            }
            
            $menu_item = get_field( 'mega_menu', $item );
            
            if( empty( $menu_item ) ) {
                continue;
            }
                    
            $menu_item_content = $menu_item['menu_item_content'];
                                    
            if( is_wp_error( $menu_item_content ) || ! is_object( $menu_item_content ) ) {
                continue;
            }
                
            $opening_markup = apply_filters( 'kr_mega_menu_opening_markup', '<div class="mega-menu-post-content">' );
            $closing_markup = apply_filters( 'kr_mega_menu_closing_markup', '</div>' );
            
            $content = '';
                        
            // Featured Image?
            if( has_post_thumbnail( $menu_item_content ) ) {
                $thumbnail = get_the_post_thumbnail( $menu_item_content, 'medium' );
                $content .= sprintf( '<div class="mega-menu-thumbnail" data-photo="%s">%s</div>', esc_html( $thumbnail ), $thumbnail );
            }
            
            $content .= apply_filters( 'the_content', $menu_item_content->post_content );
            $content = $opening_markup . $content . $closing_markup;
            
            $item->description = $content;
            
        }
        
        
        // return
        return $items;
        
    }
        
    
    // Output mega menu description to menu item
    function display_mega_menu_post( $item_output, $item, $depth, $args ) {
        
        if( $this->menu_location == $args->theme_location && $item->description )
            $item_output = $item->description;
            
        return $item_output;
    }
        
}

new Mega_Menu_Walker_Edits();