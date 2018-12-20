<?php
// About - Vision

if( ! class_exists( 'About_Vision_Section' ) ) {
    class About_Vision_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                                    
            $fields = get_field( 'vision' );
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
                     $this->get_name() . '-vision',
                     $this->get_name() . '-vision' . '-' . $this->get_id(),
                ]
            ); 
                        
        }  
        
        
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();  
                                        
            
            if( ! empty( $fields['heading'] ) ) {
                $heading = $fields['heading'];
                $heading = sprintf( '<h2>%s</h2>', $heading );
            }
            
            $link = $this->get_fields( 'link' );
            if( ! empty( $link['url'] ) && ! empty( $link['title'] ) ) {
                $link = sprintf( '<p><a href="%s" class="link white">%s</a></p>', $link['url'], $link['title'] );
            }
            
            $panel = sprintf( '<div class="panel">%s%s%s</div>', 
                              _s_format_string( $this->get_fields( 'heading' ), 'h2' ),
                              $this->get_fields( 'description' ), 
                              $link
                            );
            
            $bullets = $this->get_fields( 'bullets' );
            $bullets = wp_list_pluck( $bullets, 'point' );
            $bullets = sprintf( '<div class="entry-content">%s</div>', ul( $bullets ) );
            
            return sprintf( '<div class="row"><div class="column column-block small-12 large-5">%s</div><div class="column column-block small-12 large-7">%s</div></div>',
                            $panel,
                            $bullets
                         
                          );

            
        }
        
    }
}
   
new About_Vision_Section;
