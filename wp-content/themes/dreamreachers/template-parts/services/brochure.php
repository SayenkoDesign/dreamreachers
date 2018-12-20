<?php
// Service - Brochure

if( ! class_exists( 'Service_Brochure_Section' ) ) {
    class Service_Brochure_Section extends Element_Section {
        
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
                     $this->get_name() . '-why-us'
                ]
            );            
            
        }  
       
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
                                                 
            $row = new Element_Row(); 
            
            $column = new Element_Column(); 
                            
            // Heading
            $header = new Element_Header( [ 'fields' => $fields ] ); // set fields from Constructor
            $column->add_child( $header );
            
            $grid_items = $this->get_fields( 'grid' );
            
            $grid = '';
            
            if( ! empty( $grid_items ) ) {
                                
                foreach( $grid_items as $item ) {
                    
                    $icon = $item['grid_image'];
                    
                    $thumbnail = sprintf( '<div class="icon">%s</div>', _s_get_acf_image( $icon, 'thumbnail' ) );
                                                                             
                    $grid .= sprintf( '<div class="column column-block"><div class="grid-item">%s<div class="panel" data-equalizer-watch>%s</div></div></div>', 
                                     $thumbnail, 
                                     $item['grid_description'] );
                }
            }
            
            $grid = sprintf( '<div class="grid" data-equalizer data-equalize-on="medium"><div class="row small-up-1 medium-up-2 large-up-3 xxlarge-up-4">%s</div></div>', $grid );
            
            $html = new Element_Html( [ 'fields' => [ 'html' => $grid ] ] ); // set fields from Constructor
            $column->add_child( $html );
                        
            $row->add_child( $column );
            
            $this->add_child( $row );
                                                
            
        }
        
    }
}
   
new Service_Brochure_Section;
