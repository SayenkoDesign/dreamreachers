<?php
// Project - Testimonial

if( ! class_exists( 'Project_Testimonial_Section' ) ) {
    class Project_Testimonial_Section extends Element_Section {
                        
        public function __construct() {
            parent::__construct();
                        
            $fields = get_field( 'testimonial' );
            $this->set_fields( $fields );
            
            if( empty( $this->render() ) ) {
                return;
            }
                      
            // print the section
            $this->print_element();        
        }
              
        // Add default attributes to section        
        protected function _add_render_attributes() {
            
            // use parent attributes
            parent::_add_render_attributes();
    
            $this->add_render_attribute(
                'wrapper', 'class', [
                     $this->get_name() . '-testimonial',
                     $this->get_name() . '-testimonial' . '-' . $this->get_id(),
                ]
            ); 
                        
        }  
                
        
        // Add content
        public function render() {
                        
            $fields = $this->get_fields();  
                                        
            $photo = $this->get_fields( 'photo' );
            $photo = _s_get_acf_image( $photo, 'medium' );
            $message = $this->get_fields( 'message' );
            $name = _s_format_string( $this->get_fields( 'name' ), 'h4' );
            
            if( empty( $photo ) || empty( $message ) || empty( $name ) ) {
                return false;
            }
            
            $quote_mark = sprintf( '<div class="quote-mark"><span><img src="%sprojects/quote-icon.svg" /></span></div>', trailingslashit( THEME_IMG ) );
            
            $quote = sprintf( '<div class="quote">%s%s%s</div>', $quote_mark, $message, $name );
                
            return sprintf( '<div class="row large-unstack"><div class="column column-block">%s</div><div class="column column-block">%s</div></div>', $photo, $quote );
           
        }
        

        
    }
}
   
new Project_Testimonial_Section;
