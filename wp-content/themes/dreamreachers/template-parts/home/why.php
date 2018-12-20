<?php
// Home - Why

if( ! class_exists( 'Home_Why_Section' ) ) {
    class Home_Why_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                        
            $fields = get_field( 'why' );
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
                     $this->get_name() . '-why',
                     $this->get_name() . '-why' . '-' . $this->get_id(),
                ]
            ); 
            
            $this->add_render_attribute(
                'wrapper', 'id', $this->get_name() . '-why', true );
        }  
        
        
        public function before_render() {            
            
            $navigation = '<div class="column row show-for-large navigation"></div>';
            
            // Header
            $fields = $this->get_fields();  
            $header = new Element_Header( [ 'fields' => $fields ] );
            $header = sprintf( '<div class="container"><div class="wrap"><div class="column row">%s</div>%s</div></div>', $header->get_element(), $navigation );
            
            
            
            $this->add_render_attribute( 'inner', 'class', 'inner' );
            $this->add_render_attribute( 'primary', 'class', 'primary' );
            $this->add_render_attribute( 'container', 'class', 'container' );
            $this->add_render_attribute( 'wrap', 'class', 'wrap' );
            
            $this->add_render_attribute( 'background', 'class', 'background-slick slick' );
            
            
            $rows = $this->get_fields( 'tabs' );
            $slick = '';
            
            if( ! empty( $rows ) ) {
                $slides = '';
                
                foreach( $rows as $key => $row ) { 
                    $background = $row['background_image'];
                    $background = sprintf( ' style="background-image: url(%s)";', _s_get_acf_image( $background, 'hero', true ) );
                    $slides .= sprintf( '<div><div class="slick-background" %s></div></div>', $background );
                }
                
            }
            
            return sprintf( '<%s %s><div %s>%s<div %s><div %s>%s</div><div %s><div %s>', 
                            esc_html( $this->get_html_tag() ), 
                            $this->get_render_attribute_string( 'wrapper' ), 
                            $this->get_render_attribute_string( 'inner' ), 
                            $header,
                            $this->get_render_attribute_string( 'primary' ), 
                            $this->get_render_attribute_string( 'background' ),
                            $slides,
                            $this->get_render_attribute_string( 'container' ),                             
                            $this->get_render_attribute_string( 'wrap' )
                            );
        }

        
        public function after_render() {
            return sprintf( '</div></div></div></div></%s>', esc_html( $this->get_html_tag() ) );
        }
        
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();  
                                        
            $tabs = new Element_tabs( [ 'fields' => $fields ] );
            $tabs = $tabs->get_element();
            
            return sprintf( '%s',
                            $tabs
                             );
        }
        

        
    }
}
   
new Home_Why_Section;
