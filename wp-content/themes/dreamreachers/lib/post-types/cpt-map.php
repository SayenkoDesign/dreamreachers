<?php
 
/**
 * Create new CPT - Map
 */
 
class CPT_Map extends CPT_Core {

    const POST_TYPE = 'map';
	const TEXTDOMAIN = '_s';
	
	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

 		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'Marker', self::TEXTDOMAIN ), // Singular
				__( 'Map', self::TEXTDOMAIN ), // Plural
				self::POST_TYPE // Registered name/slug
			),
			array( 
				'public'              => true,
				'publicly_queryable'  => true,
				'show_ui'             => true,
				'query_var'           => true,
				'capability_type'     => 'post',
				'has_archive'         => true,
				'hierarchical'        => false,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => false,
				'exclude_from_search' => false,
				'rewrite'             => false,
				'supports' => array( 'title', 'revisions', 'page-attributes' ),
                'menu_icon' => 'dashicons-location'
			)

        );
		
        add_action( 'pre_get_posts', array( $this,'pre_get_posts' ) );
		
     }
	 
     function pre_get_posts($query) {
						
		if ( $query->is_main_query() && is_post_type_archive( self::POST_TYPE ) && !is_admin() ) {
			            											
			$query->set('posts_per_page', '-1' );
		
		}
			
		return $query;
	}    
     
}

new CPT_Map();
