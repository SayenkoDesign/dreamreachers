<?php

// Redirect Region and Industries (we usually do this when using the single term radion button plugin)
function _redirect_single_terms()
{
    if ( is_tax( 'region' ) || is_tax( 'industry' ) ) {
        wp_safe_redirect( site_url(), 301 );
        exit();
    }
}
add_action( 'template_redirect', '_redirect_single_terms' );