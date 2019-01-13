<?php
 
/**
 * Create new CPT - Book
 */
 
class CPT_Book extends CPT_Core {

    const POST_TYPE = 'book';
	const TEXTDOMAIN = '_s';
	
	/**
     * Register Custom Post Types. See documentation in CPT_Core, and in wp-includes/post.php
     */
    public function __construct() {

 		
		// Register this cpt
        // First parameter should be an array with Singular, Plural, and Registered name
        parent::__construct(
        
        	array(
				__( 'Book', self::TEXTDOMAIN ), // Singular
				__( 'Books', self::TEXTDOMAIN ), // Plural
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
				'show_in_nav_menus'   => true,
				'exclude_from_search' => false,
				'rewrite'             => array( 'slug' => 'books' ),
				'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
                'menu_icon' => 'dashicons-book'
			)

        );
        
        // add_filter('pre_get_posts', array( $this, 'query_filter' ) );
        
        // add_filter( 'manage_edit-job_sortable_columns', array( $this, 'sortable_columns' ) );
		        
     }
    
    
     /**
	 * Registers admin columns to display. Hooked in via CPT_Core.
	 * @since  0.1.0
	 * @param  array  $columns Array of registered column names/labels
	 * @return array           Modified array
	 */
	public function columns( $columns ) {
        
        $columns['date'] = 'Posted Date';
        
        unset( $columns['post_type'] );
        
		$new_column = array(
			'closing_date' => 'Closing Date',
		);
		return array_slice( $columns, 0, 3, true ) + $new_column + array_slice( $columns, 1, null, true );
	}

	/**
	 * Handles admin column display. Hooked in via CPT_Core.
	 * @since  0.1.0
	 * @param  array  $column Array of registered column names
	 */
	public function columns_display( $column, $post_id ) {
		switch ( $column ) {
			case 'closing_date':
                $closing_date = get_field( 'closing_date' );
                $date = new DateTime( $closing_date );
                echo $date->format('F d, Y');
				break;
		}
	}
    
    
    public function sortable_columns( $columns ) {
        
        $columns['closing_date'] = 'closing_date';
     
        //To make a column 'un-sortable' remove it from the array
        //unset($columns['date']);
     
        return $columns;
    }
    
    
    public function query_filter( $query ) {
	    
        if( is_admin() ) {
            $this->sort_admin( $query );
        }
        else {
            if ( $query->is_main_query() && is_post_type_archive( 'job' ) ) {
                $query->set('posts_per_page', 999 );
                $query->set( 'meta_key', 'closing_date' );	
                $query->set( 'orderby', 'meta_value_num' );
                $query->set( 'order', 'ASC' ); 			
                
                $date_now = date_i18n('Ymd');
                
                $meta_query = array(
        
                    array(
                        'key'			=> 'closing_date',
                        'compare'		=> '>=',
                        'value'			=> $date_now,
                        'type'			=> 'DATE'
                    )
        
                );
                
                $query->set( 'meta_query', $meta_query );
            }
        }
        			
	}
    
    
    private function sort_admin( $query ) {
        
        $orderby = $query->get( 'orderby');
        //$order   = $query->get( 'order');
                
        if( 'closing_date' == $orderby ) {
            $query->set( 'meta_key', 'closing_date' );	
			$query->set( 'orderby', 'meta_value_num' );
			//$query->set( 'order', 'ASC' ); 			
            
			/*
            $date_now = date_i18n('Ymd');
            
			$meta_query = array(
	
				array(
					'key'			=> 'closing_date',
					'compare'		=> '>=',
					'value'			=> $date_now,
					'type'			=> 'DATE'
				)
    
			);
			
			$query->set( 'meta_query', $meta_query );
            */
        }   
    }
}

new CPT_Book();


$book_categories = array(
    __( 'Book Category', CPT_Book::TEXTDOMAIN ), // Singular
    __( 'Books Category', CPT_Book::TEXTDOMAIN ), // Plural
    'location_cat' // Registered name
);

register_via_taxonomy_core( $book_categories, 
	array(
		'public' => true,
        'rewrite' => 'books-category',
	), 
	array( CPT_Book::POST_TYPE ) 
);
