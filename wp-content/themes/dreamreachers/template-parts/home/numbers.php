<?php
// Home - Numbers

if( ! class_exists( 'Home_Numbers_Section' ) ) {
    class Home_Numbers_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                        
            $fields = get_field( 'numbers' );
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
                     $this->get_name() . '-numbers'
                ]
            );            
            
        }
        
        
        public function after_render() {
            
            $shape = '<div class="shape"><svg viewBox="0 0 100 5" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#035481" d="M0 0, 0 5, 100 5, 100 3, 0 .25z"/>
                        <path fill="#2B70AA" d="M0 0, 0 5, 100 5, 100 4, 0 0z"/>
                        </svg></div>';
            
            return sprintf( '</div></div></div></div>%s</%s>', $shape, esc_html( $this->get_html_tag() ) );
        }  
       
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
                                                 
            $row = new Element_Row(); 
                                        
            // Header
            $header = new Element_Header( [ 'fields' => $fields ] );
            $column = new Element_Column(); 
            $column->add_render_attribute( 'wrapper', 'class', 'text-center' );
            $column->add_child( $header );
            
            $row->add_child( $column );
            $this->add_child( $row );
            
            $row = new Element_Row(); 
            $row->add_render_attribute( 'wrapper', 'class', 'large-collapse' );
            
            $html = $this->grid();
                        
            $html = new Element_Html( [ 'fields' => [ 'html' => $html ] ] ); // set fields from Constructor
            $column = new Element_Column(); 
            $column->add_child( $html );
                        
            $row->add_child( $column );
            
            $this->add_child( $row );
                                         
            
        }
        
        private function grid() {
            
            $rows = $this->get_fields( 'numbers' );
            
            $grid_items = '';
            
            $tag = 'div';
            
            
            if( ! empty( $rows ) ) {
                                
                foreach( $rows as $row ) {     
                                    
                    $number = _s_format_string( $row['number'], 'span' ); 
                    $symbol =   $row['symbol'];     
                    $description = _s_format_string( $row['description'], 'p' );    
                   
                    $grid_items .= sprintf( '<div class="column column-block"><%1$s class="grid-item"><h3>%2$s%3$s</h3>%4$s</%1$s></div>', 
                                     $tag, $number, $symbol, $description );
                }
            }
            
            return sprintf( '<div class="grid"><div class="row small-up-2 medium-up-2 large-up-4 align-center">%s</div></div>', $grid_items );   
        }
        
    }
}
   
new Home_Numbers_Section;
