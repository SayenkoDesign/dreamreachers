<?php
// Home - What We Do

if( ! class_exists( 'Home_What_Section' ) ) {
    class Home_What_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                        
            $fields = get_field( 'what' );
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
                     $this->get_name() . '-what'
                ]
            );            
            
        }  
                
       
           /*public function before_render() {
            
            $shape = '<div class="shape"><svg viewBox="0 0 100 5" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#2B70AA" d="M0 0, 100 5, 0 5z"/>
                        <path fill="#035481" d="M0 0, 100 4, 100 5, 0 .1z"/>
                        </svg></div>';
            
            $this->add_render_attribute( 'inner', 'class', 'inner' );
            
            $this->add_render_attribute( 'wrap', 'class', 'wrap' );
            
            return sprintf( '<%s %s><div %s>%s<div %s>', 
                            esc_html( $this->get_html_tag() ), 
                            $this->get_render_attribute_string( 'wrapper' ), 
                            $this->get_render_attribute_string( 'inner' ), 
                            $shape,
                            $this->get_render_attribute_string( 'wrap' )
                            );
        }*/
        
        
        public function after_render() {
            
            return sprintf( '</div></div></div></div></%s>', esc_html( $this->get_html_tag() ) );
        }
       
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
                                                 
            $row = new Element_Row(); 
            $column = new Element_Column();    
                            
            // Header
            $header = new Element_Header( [ 'fields' => $fields ] );
            $column->add_child( $header );
            
            // Editor
            $editor = new Element_Editor( [ 'fields' => $fields ] ); // set fields from Constructor
            $column->add_child( $editor );
            
            $row->add_child( $column );
            $this->add_child( $row );
            
            $row = new Element_Row(); 
            
            $html = $this->grid();
                        
            $html = new Element_Html( [ 'fields' => [ 'html' => $html ] ] ); // set fields from Constructor
            $column = new Element_Column(); 
            $column->add_child( $html );
                        
            $row->add_child( $column );
            
            $this->add_child( $row );
                                         
            
        }
        
        private function grid() {
            
            $rows = $this->get_fields( 'services' );
            
            if( empty( $rows ) ) {
                return;
            }
                        
            $grid_items = '';
            
            $tag = 'a';
            
            
            if( ! empty( $rows ) ) {
                                
                foreach( $rows as $row ) { 
                                                    
                    $title = _s_format_string( $row->post_title, 'h5' );    
                    $attachment_id = get_field( 'icon', $row->ID );     
                    $icon = sprintf( '<span class="icon">%s</span>', wp_get_attachment_image( $attachment_id ) ); 
                    $permalink = get_permalink( $row->ID );  
                   
                    $grid_items .= sprintf( '<div class="column column-block"><%1$s class="grid-item" href="%4$s">%2$s%3$s</%1$s></div>', 
                                     $tag, $icon, $title, $permalink );
                }
            }
            
            return sprintf( '<div class="grid"><div class="row small-up-2 medium-up-3 align-center">%s</div></div>', $grid_items );   
        }
        
    }
}
   
new Home_What_Section;
