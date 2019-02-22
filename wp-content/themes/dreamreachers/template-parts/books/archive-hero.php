<?php

/*
Books - Archive Hero
		
*/


if( ! class_exists( 'Hero_Section' ) ) {
    class Hero_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                        
            $fields = get_field( 'book_settings', 'option' );            
            $this->set_fields( $fields );
            
            $settings = [];
            $this->set_settings( $settings );
            
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
        }        
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields(); 
            
            $hero = $this->get_fields( 'hero' );
            
            $defaults = [
                'background_image' => false,
                'background_position_x' => 'center',
                'background_position_x' => 'center',
                'heading' => 'Books',
                'description' => '',
            ];
            
            $hero = wp_parse_args( $hero, $defaults );
            
            $background_image       = $hero['background_image'];
            $background_position_x  = $hero['background_position_x'];
            $background_position_y  = $hero['background_position_y'];
            
            if( ! empty( $background_image ) ) {
                $background_image = _s_get_acf_image( $background_image, 'hero', true );
                
                $this->add_render_attribute( 'background', 'class', 'background-image' );
                $this->add_render_attribute( 'background', 'style', sprintf( 'background-image: url(%s);', $background_image ) );
                $this->add_render_attribute( 'background', 'style', sprintf( 'background-position: %s %s;', 
                                                                          $background_position_x, $background_position_y ) );
            }             
            
            $heading = $hero['heading'];
            $heading = _s_format_string( $heading, 'h1' );
            
            $description = _s_format_string( $hero['description'], 'h3' );

            return sprintf( '<div class="row align-middle"><div class="column text-center">%s%s</div>', 
                             $heading,
                             $description
                          );
        }
    }
}
   
new Hero_Section; 