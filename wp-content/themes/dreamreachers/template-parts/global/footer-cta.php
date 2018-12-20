<?php
// Footer - CTA

if( ! class_exists( 'Footer_CTA_Section' ) ) {
    class Footer_CTA_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
            
            $show_footer_cta = false;
            
            // default to TRUE for the blog
            if( is_page() && ! is_front_page() ) {
                $show_footer_cta = get_field( 'page_settings_call_to_action' );                
            }
            else {
                $show_footer_cta = true;
            }
            
            if( ! $show_footer_cta ) {
                return false;
            }
                        
            $fields = get_field( 'footer_cta', 'option' );
                                                
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
                     $this->get_name() . '-footer-cta'
                ]
            );   
            
        }  
        
        
        
        public function before_render() {            

            $shape = '<div class="shape"><svg viewBox="0 0 100 2" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#fff" d="M0 0, 100 0, 50 2, 0 0z"></path>
                    </svg></div>';
            
            $this->add_render_attribute( 'inner', 'class', 'inner' );
            $this->add_render_attribute( 'container', 'class', 'container' );
            $this->add_render_attribute( 'wrap', 'class', 'wrap' );
            
            return sprintf( '<%s %s><div %s>%s<div %s><div %s><div %s>', 
                            esc_html( $this->get_html_tag() ), 
                            $this->get_render_attribute_string( 'wrapper' ), 
                            $this->get_render_attribute_string( 'inner' ), 
                            $shape,
                            $this->get_render_attribute_string( 'background' ),
                            $this->get_render_attribute_string( 'container' ), 
                            $this->get_render_attribute_string( 'wrap' )
                            );

        }
        
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
                                                   
            $row = new Element_Row(); 
            $column = new Element_Column(); 
            $column->add_render_attribute( 'wrapper', 'class', 'column-block' );  
            
                         
            // Heading
            $header = new Element_Header( [ 'fields' => $fields ] ); // set fields from Constructor
            $column->add_child( $header );
            
            // Button
            $button_args = $fields['button'];
            $button = new Element_Button( [ 'fields' => $fields ]  ); // set fields from Constructor
            $button->add_render_attribute( 'anchor', 'class', [ 'button', 'orange' ] ); 
            if( ! empty( $button_args['type'] ) && 'modal' == strtolower( $button_args['type'] ) ) {
                $button->add_render_attribute( 'anchor', 'data-open', 'lets-build' ); 
            }
            
            $column->add_child( $button );
            $row->add_child( $column );
            
            $this->add_child( $row );         
        }
        
    }
}
   
new Footer_CTA_Section;
