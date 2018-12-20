<?php
// About - Company

if( ! class_exists( 'About_Company_Section' ) ) {
    class About_Company_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                                    
            $fields = get_field( 'company' );
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
                     $this->get_name() . '-company',
                     $this->get_name() . '-company' . '-' . $this->get_id(),
                ]
            ); 
                        
        }  
        
        
        
        // Add content
        public function render() {
            
            $blocks = [];
            
            $blocks[] = sprintf( '<div class="column column-block small-12 large-4 tall">%s</div>', $this->get_block( 'block_one' ) );
            
            $blocks[] = sprintf( '<div class="column column-block small-12 large-8 tall"><div class="background-image" style="background-image: url(%s);"></div></div>', 
                                        _s_get_acf_image( $this->get_fields( 'block_two' ), 'large', true )
                                     );
            $blocks[] = sprintf( '<div class="column column-block small-12 large-4"><div class="background-image" style="background-image: url(%s);"></div></div>', 
                                        _s_get_acf_image( $this->get_fields( 'block_three' ), 'large', true )
                                     );
            $blocks[] = sprintf( '<div class="column column-block small-12 large-4"><div class="background-image" style="background-image: url(%s);"></div></div>', 
                                        _s_get_acf_image( $this->get_fields( 'block_four' ), 'large', true )
                                     );
            $blocks[] = sprintf( '<div class="column column-block small-12 large-4">%s</div>', $this->get_block( 'block_five' ) );
               
                                                    
            return sprintf( '<div class="row">%s</div>', join( '', $blocks ) );

            
        }
        
        private function get_block( $group ) {
            
            $block = $this->get_fields( $group );            
            
            $description = $block['description'];
            
            $link = $block['link'];
            if( ! empty( $link['url'] ) && ! empty( $link['title'] ) ) {
                $link = sprintf( '<p><a href="%s" class="link white center">%s</a></p>', $link['url'], $link['title'] );
            }
            
            return sprintf( '<div class="panel">%s%s</div>', 
                              _s_format_string( $description, 'h3' ),
                              $link
                            );
        
        }
        
    }
}
   
new About_Company_Section;
