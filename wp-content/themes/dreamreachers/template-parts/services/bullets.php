<?php
// Service - Bullets

if( ! class_exists( 'Services_Bullets_Section' ) ) {
    class Services_Bullets_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                        
            $fields = get_field( 'why_us' );
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
                     $this->get_name() . '-bullets'
                ]
            );            
            
        }  
       
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
                                                             
            $content = '';
            
            $bullets = get_field( 'bullets' );
            if( ! empty( $bullets ) ) {
                $list = '';
                foreach( $bullets as $bullet ) {
                    $list .= sprintf( '<li>%s</li>', $bullet['point'] );
                }
                
                $content = sprintf( '<div class="column row"><ul class="no-bullet checkmark">%s</ul></div>',$list );
                
            }
            
            if( ! empty( $content ) ) {
                $html = new Element_Html( [ 'fields' => [ 'html' => $content ] ] ); // set fields from Constructor
                $html->add_render_attribute( 'wrapper', 'class', 'bullets' );
                $row = new Element_Row(); 
                $column = new Element_Column(); 
            
                $column->add_child( $html );
                $row->add_child( $column );
                $this->add_child( $row );
            }
            
        }
        
    }
}
   
new Services_Bullets_Section;
