<?php
// Careers - Hero

if( ! class_exists( 'Careers_Scholarship_Section' ) ) {
    class Careers_Scholarship_Section extends Element_Section {
        
        var $post_id;
        
        public function __construct() {
            parent::__construct();
            
            $post_id = _s_get_page_id_from_template_name( 'page-templates/careers.php' );
            
            if( ! $post_id ) {
                return;
            }
            
            $this->post_id = $post_id;
                      
            $fields = get_field( 'scholarship', $post_id );
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
                     $this->get_name() . '-scholarship',
                     $this->get_name() . '-scholarship' . '-' . $this->get_id(),
                ]
            ); 
            
            $background_image       = $this->get_fields( 'background_image' );
            $background_position_x  = $this->get_fields( 'background_position_x' );
            $background_position_y  = strtolower( $this->get_fields( 'background_position_y' ) );
            $background_overlay     = strtolower( $this->get_fields( 'background_overlay' ) );
            
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

       
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
            
            $heading = _s_format_string( $fields['heading'], 'h3' );
            $editor = $fields['editor']; // set fields from Constructor   
                                    
            $button = new Element_Button( [ 'fields' => $fields ]  );
            $button->add_render_attribute( 'anchor', 'class', [ 'link' ] ); 
            $button = $button->get_element();
               
            return sprintf( '<div class="row column"><div class="panel">%s%s%s</div></div>', 
                                $heading,
                                $editor,
                                $button
                              );
        }
        
    }
}
   
new Careers_Scholarship_Section;
