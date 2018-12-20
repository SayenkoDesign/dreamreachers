<?php

// Turn on label visibility
add_filter( 'gform_enable_field_label_visibility_settings', '__return_true' );

// On submit scroll back down to form
//add_filter( 'gform_confirmation_anchor', '__return_true' );

// Remove scroll to a specific form #5
//add_filter( 'gform_confirmation_anchor_5', '__return_false' );

// Populate Locations
add_filter( 'gform_pre_render', 'populate_locations' );
add_filter( 'gform_pre_validation', 'populate_locations' );
add_filter( 'gform_pre_submission_filter', 'populate_locations' );
add_filter( 'gform_admin_pre_render', 'populate_locations' );

function populate_locations( $form ) {
 
    foreach ( $form['fields'] as &$field ) {
 
        if ( $field->type != 'select' || strpos( $field->cssClass, 'populate-locations' ) === false ) {
            continue;
        }
 
        // you can add additional parameters here to alter the posts that are retrieved
        // more info: http://codex.wordpress.org/Template_Tags/get_posts
        $locations = new \PSC\Locations;
        
        $rows = $locations->get_gf_field_locations();
         
        $choices = array();
 
        foreach ( $rows as $row ) {
            $choices[] = array( 'text' => $row, 'value' => $row );
        }
 
        // update 'Select a Post' to whatever you'd like the instructive option to be
        // $field->placeholder = 'Select a Location';
        $field->choices = $choices;
 
    }
 
    return $form;
}


// Populate Locations
add_filter( 'gform_pre_render', 'populate_services' );
add_filter( 'gform_pre_validation', 'populate_services' );
add_filter( 'gform_pre_submission_filter', 'populate_services' );
add_filter( 'gform_admin_pre_render', 'populate_services' );


function _s_get_services() {
    // arguments, adjust as needed
	$args = array(
		'post_type'      => 'service',
		'posts_per_page' => 100,
		'post_status'    => 'publish',
        'order'          => 'ASC',
        'orderby'        => 'menu_order'
	);

	// Use $loop, a custom variable we made up, so it doesn't overwrite anything
	$loop = new WP_Query( $args );
    
    $list = [];

	// have_posts() is a wrapper function for $wp_query->have_posts(). Since we
	// don't want to use $wp_query, use our custom variable instead.
	if ( $loop->have_posts() ) : 
		while ( $loop->have_posts() ) : $loop->the_post(); 

			$list[] = get_the_title();

		endwhile;
	endif;

	// We only need to reset the $post variable. If we overwrote $wp_query,
	// we'd need to use wp_reset_query() which does both.
	wp_reset_postdata();
    
    return $list;   
}

function populate_services( $form ) {
 
    foreach ( $form['fields'] as &$field ) {
 
        if ( $field->type != 'select' || strpos( $field->cssClass, 'populate-services' ) === false ) {
            continue;
        }
 
        // you can add additional parameters here to alter the posts that are retrieved
        // more info: http://codex.wordpress.org/Template_Tags/get_posts
        $rows = _s_get_services();
         
        $choices = array();
 
        foreach ( $rows as $row ) {
            $choices[] = array( 'text' => $row, 'value' => $row );
        }
 
        // update 'Select a Post' to whatever you'd like the instructive option to be
        // $field->placeholder = 'Select a Location';
        $field->choices = $choices;
 
    }
 
    return $form;
}