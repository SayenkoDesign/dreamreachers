<?php

/*
Hero Post
		
*/


if( ! class_exists( 'Hero_Post' ) ) {
    class Hero_Post extends Element_Section {
        
        public function __construct() {
            parent::__construct();
            
            $fields = get_field( 'hero' );
            $this->set_fields( $fields );
                                    
            // Render the section
            $this->render();
            
            // print the section
            $this->print_element();        
        }
              
        // Add default attributes to section        
        protected function _add_render_attributes() {
            
            // use parent attributes
            parent::_add_render_attributes();
    
            $this->add_render_attribute(
                'wrapper', 'class', [
                     $this->get_name() . '-hero'
                ]
            );
            
            $background_image       = $this->get_fields( 'background_image' );
            $background_position_x  = strtolower( $this->get_fields( 'background_position_x' ) );
            $background_position_y  = strtolower( $this->get_fields( 'background_position_y' ) );
            $background_overlay     = $this->get_fields( 'background_overlay' );
            
            if( ! empty( $background_image ) ) {
                $background_image = _s_get_acf_image( $background_image, 'hero', true );
                
                $this->add_render_attribute( 'background', 'class', 'background-image' );
                $this->add_render_attribute( 'background', 'style', sprintf( 'background-image: url(%s);', $background_image ) );
                $this->add_render_attribute( 'background', 'style', sprintf( 'background-position: %s %s;', 
                                                                          $background_position_x, $background_position_y ) );
                
                if( true == $background_overlay ) {
                     $this->add_render_attribute( 'background', 'class', 'background-overlay' ); 
                }
                                                                          
            }             
        }
        
        
        
        /**
         * After section rendering.
         *
         * Used to add stuff after the section element.
         *
         * @since 1.0.0
         * @access public
         */
        public function after_render() {
                    
            $shape = sprintf( '<div class="shape"><img src="%sabout/hero-bottom.png" /></div>', trailingslashit( THEME_IMG ) );
                
            return sprintf( '</div></div></div></div>%s</%s>', $shape , esc_html( $this->get_html_tag() ) );
        }
        
        
        // Add content
        public function render() {
                                
            $heading        = $this->get_fields( 'heading' ) ? $this->get_fields( 'heading' ) : get_the_title();
            $heading        = _s_format_string( $heading, 'h1' );
            
            $post_date = _s_get_posted_on( 'M d, Y' );
                                    
            $post_author = _s_get_post_author();
            
            if( ! empty( $post_author ) ) {
                $this->add_render_attribute( 'wrapper', 'class', 'has-post-author' );   
            }
            
            return sprintf( '<div class="row align-middle"><div class="column"><div class="caption">%s%s%s</div></div></div>', 
                           get_the_category_list( '' ), 
                           $heading, 
                           $post_date );
        }
    }
}
   
new Hero_Post; 