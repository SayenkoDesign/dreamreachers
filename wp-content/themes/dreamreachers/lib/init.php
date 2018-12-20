<?php

/****************************************
	WordPress Cleanup functions - work in progress
*****************************************/
	include_once( 'wp-cleanup.php' );


/****************************************
	Theme Settings - load main stylesheet, add body classes
*****************************************/
	include_once( 'theme-settings.php' );



/****************************************
	include_onces (libraries, Classes etc)
*****************************************/
	include_once( 'includes/cpt-core/CPT_Core.php' );

	include_once( 'includes/taxonomy-core/Taxonomy_Core.php' );
    
    include_once( 'includes/table-class.php' );
    
    // Terms - has filter for post_type
    include_once( 'includes/theme-functions/terms.php' );

    include_once( 'includes/theme-functions/shortcodes.php' );
    include_once( 'includes/theme-functions/html.php' );
    include_once( 'includes/theme-functions/array.php' );

/****************************************
	Functions
*****************************************/

    include_once( 'functions/svg.php' );

	include_once( 'functions/theme.php' );

	include_once( 'functions/template-tags.php' );

	include_once( 'functions/acf.php' );

	include_once( 'functions/fonts.php' );

	include_once( 'functions/scripts.php' );

	include_once( 'functions/social.php' );

	include_once( 'functions/menus.php' );
    
	include_once( 'functions/gravity-forms.php' );

	include_once( 'functions/projects.php' );
    
    include_once( 'functions/blog.php' );
    
    include_once( 'functions/addtoany.php' );
    
    include_once( 'functions/facetwp.php' );
    
    include_once( 'functions/redirects.php' );
    
/****************************************
	include_onces (Foundation)
*****************************************/

include_once( 'foundation/class-foundation.php' );
include_once( 'foundation/class-foundation-accordion.php' );

/****************************************
	Page Builder
*****************************************/

    include_once( 'page-builder/init.php' );

/****************************************
	Post Types
*****************************************/
    
    include_once( 'post-types/cpt-client.php' );
    include_once( 'post-types/cpt-job.php' );
    include_once( 'post-types/cpt-location.php' );
    include_once( 'post-types/cpt-people.php' );
    include_once( 'post-types/cpt-project.php' );
    include_once( 'post-types/cpt-service.php' );
    include_once( 'post-types/taxonomies.php' );


/****************************************
	Moduels
*****************************************/

    include_once( 'modules/map/index.php' );
        
    
/****************************************
	Widgets
*****************************************/

    include_once( 'widgets/widget-locations.php' );
    include_once( 'widgets/widget-social.php' );
    
/****************************************
	Mega Menu
*****************************************/

    // include_once( 'mega-menu/mega-menu.php' );
        