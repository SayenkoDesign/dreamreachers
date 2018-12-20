<?php
// Home - Locations

use \PSC\Map;

if( ! class_exists( 'Home_Locations_Section' ) ) {
    class Home_Locations_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                        
            $fields['locations'] = get_field( 'locations' );
            
            $markers = psc_map_get_markers();
                        
            $markers = wp_list_pluck( $markers, 'marker' );
            
            if( empty( $markers ) ) {
                return;
            }
                        
            $fields['markers'] = join( '', $markers );
            $fields['legend'] = psc_map_get_legend();
                        
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
                     $this->get_name() . '-locations'
                ]
            );  
            
            $this->add_render_attribute(
                'wrapper', 'id', $this->get_name() . '-locations', true );   
                        
        }  
        
        public function before_render() {
            
            
            $shape = '<div class="shape"><svg viewBox="0 0 100 5" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#ffffff" d="M0 0, 100 0, 50 5z"/>
                    </svg></div>';
                
            $this->add_render_attribute( 'wrap', 'class', 'wrap' );
            
            $fields = $this->get_fields();
 
            // Header
            $header = new Element_Header( [ 'fields' => $fields['locations'] ] );
            $header = sprintf( '<div class="column row">%s</div>', $header->get_element() );
        
            return sprintf( '<%s %s>%s<div %s>%s', 
                        esc_html( $this->get_html_tag() ), 
                        $this->get_render_attribute_string( 'wrapper' ), 
                        $header,
                        $this->get_render_attribute_string( 'wrap' ),
                        $shape
                        );
        }
        
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();

            $legend =  $fields['legend'];
            
            $markers = $fields['markers'];
                                                            
            return sprintf( '<div class="row small-collapse large-uncollapse"><div class="column">%s</div></div><div class="acf-map google-map">%s</div>', $legend, $markers );
                        
        }
        
    }
}
   
new Home_Locations_Section;
