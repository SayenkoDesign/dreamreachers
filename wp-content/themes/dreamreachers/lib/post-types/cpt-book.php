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
		        
     }
}

new CPT_Book();

$book_categories = array(
    __( 'Book Category', CPT_Book::TEXTDOMAIN ), // Singular
    __( 'Books Category', CPT_Book::TEXTDOMAIN ), // Plural
    'book_cat' // Registered name
);

register_via_taxonomy_core( $book_categories, 
	array(
		'public' => true,
        'rewrite' => 'books-category',
	), 
	array( CPT_Book::POST_TYPE ) 
);

