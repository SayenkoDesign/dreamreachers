<?php
// Clients - Industries

if( ! class_exists( 'Client_Industries_Section' ) ) {
    class Client_Industries_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
            
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
                     $this->get_name() . '-industries'
                ]
            );            
            
        }  
                
        
        // Add content
        public function render() {
            
            $heading = '<h2>Industries We Serve</h2>';
            
            $header = sprintf( '<div class="row column column-block"><header>%s</header></div>', $heading  );
            
            return $header . $this->grid();
        }
        
        private function grid() {
            
            $terms = get_terms( array(
                'taxonomy' => 'industry',
                'hide_empty' => false,    
            ) );
            
            if( is_wp_error( $terms ) || empty( $terms ) ) {
                return false;
            } 
            
            $tag = 'div';
            $grid_items = '';
                                            
            foreach( $terms as $term ) { 
                                                
                $title = _s_format_string( $term->name, 'h4' );    
                $attachment_id = get_field( 'image', $term );     
                $icon = sprintf( '<span class="icon %s">%s</span>', $term->slug, wp_get_attachment_image( $attachment_id ) ); 
               
                $grid_items .= sprintf( '<div class="column column-block"><%1$s class="grid-item"><div class="panel">%2$s%3$s</div></%1$s></div>', 
                                 $tag, $icon, $title );
            }
            
            return sprintf( '<div class="grid"><div class="row small-up-1 medium-up-2 large-up-3 align-center">%s</div></div>', $grid_items );   
        }
        
    }
}
   
new Client_Industries_Section;
