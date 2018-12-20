<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class Element_Link extends Element_Base {

	static public $count;
    
    /**
	 * Get widget name.
	 *
	 * Retrieve button widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'link';
	}
    
	
	/**
	 * Render button widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	public function render() {
                                
		if( empty( $this->get_fields( 'link' ) ) ) {
            return;
        }
        
        $link = $this->get_fields( 'link' );
                              
        if( ! is_array( $link ) ) {
            $link['url'] = $link;
            // $link['text'] = $this->get_settings( 'text' ) ? $this->get_settings( 'text' ) : __( 'Learn More' );
        }
        
        if( ! $this->get_render_attribute_string( 'anchor' ) ) {
            $this->add_render_attribute( 'anchor', 'href', $link['url'] );
        }
        
        if( empty( $link['text'] ) && ! $this->get_settings( 'text' ) ) {
            $this->set_settings( ['text' => __( 'Learn More' ) ] ) ;
        }
                                                                          
        $this->add_render_attribute( 'wrapper', 'class', 'element-link' );
                                    
        return sprintf( '<div %s><p><a %s><span>%s</span></a></p></div>', $this->get_render_attribute_string( 'wrapper' ), $this->get_render_attribute_string( 'anchor' ), $this->get_settings( 'text' ) );
	}
    	
}
