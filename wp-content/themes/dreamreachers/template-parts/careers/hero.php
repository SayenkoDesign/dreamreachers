<?php
// Careers - Hero

if( ! class_exists( 'Hero_Section' ) ) {
    class Hero_Section extends Element_Section {
        
        var $post_id;
        
        public function __construct() {
            parent::__construct();
            
            $post_id = _s_get_page_id_from_template_name( 'page-templates/careers.php' );
            
            if( ! $post_id ) {
                return;
            }
            
            $this->post_id = $post_id;
                      
            $fields = get_field( 'hero', $post_id );
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
                     $this->get_name() . '-hero',
                     $this->get_name() . '-hero' . '-' . $this->get_id(),
                ]
            ); 
            
            $background_image       = $this->get_fields( 'background_image' );
            $background_position_x  = $this->get_fields( 'background_position_x' );
            $background_position_y  = strtolower( $this->get_fields( 'background_position_y' ) );
            $background_overlay     = strtolower( $this->get_fields( 'background_overlay' ) );
            
            if( ! empty( $background_image ) ) {
                $background_image = _s_get_acf_image( $background_image, 'hero', true );
                
                $this->add_render_attribute( 'background', 'class', 'background-image' );
                $this->add_render_attribute( 'background', 'style', sprintf( 'background-image: url(%s);', $background_image ) );
                $this->add_render_attribute( 'background', 'style', sprintf( 'background-position: %s %s;', 
                                                                          $background_position_x, $background_position_y ) );
                
                if( true == $background_overlay ) {
                     $this->add_render_attribute( 'background', 'class', 'background-overlay' ); 
                }
                                                                          
            }             
            
        }  
                
            
        /**
         * After section rendering.
         *
         * Used to add stuff after the section element.
         *
         * @since 1.0.0
         * @access public
         */
        public function after_render() {
            
            $shape = '<div class="shape"><svg viewBox="0 0 100 5" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#ffffff" d="M0 5, 70 5, 100 5, 100 0, 70,4, 0 0z"/>
                    </svg></div>';
                
            return sprintf( '</div></div></div></div>%s</%s>', $shape , esc_html( $this->get_html_tag() ) );
        }
       
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
            
            $heading = empty( $fields['heading'] ) ? 'Careers' : $fields['heading'];
            $heading = _s_format_string( $heading, 'h1' );
            
            $description = '';
            if( ! empty( $fields['description'] ) ) {
                $description = _s_format_string( $fields['description'], 'p' );
                $description = sprintf( '<div class="description"><div>%s</div></div>', $description );
            }
                        
            $html = sprintf( '<div class="hero-caption"><header>%s</header>%s</div>', $heading, $description );
                                                                        
            $row = new Element_Row(); 
            $row->add_render_attribute( 'wrapper', 'class', 'align-middle' );
            
            $column = new Element_Column(); 

            $html = new Element_Html( [ 'fields' => array( 'html' => $html ) ]  ); // set fields from Constructor
            $column->add_child( $html );
                        
            $row->add_child( $column );
                        
            $this->add_child( $row );
        }
        
    }
}
   
new Hero_Section;
