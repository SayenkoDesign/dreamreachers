<?php
// Careers - Post Hero

if( ! class_exists( 'Post_Hero_Section' ) ) {
    class Post_Hero_Section extends Element_Section {
                
        public function __construct() {
            parent::__construct();
                                  
            $fields = get_field( 'hero' );
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
            
            $this->add_render_attribute( 'background', 'class', 'background-image' );
            
            if( ! empty( $background_image ) ) {
                $background_image = _s_get_acf_image( $background_image, 'hero', true );
                
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
            
            $shape = '<div class="shape"><svg viewBox="0 0 100 6" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#ffffff" d="M0 0, 70 6, 100 0, 100 6, 0 6z"/>
                    </svg></div>';
                
            return sprintf( '</div></div></div></div>%s</%s>', $shape , esc_html( $this->get_html_tag() ) );
        }
       
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
            
            $heading = the_title( '<h1>', '</h1>', false );
                        
            $description = '';
            $location = get_field( 'location' );
            $closing_date = get_field( 'closing_date' );
            $date = new DateTime( $closing_date );
            $closing_date = sprintf( '<span class="date">Closing %s</span>', $date->format('F d, Y' ) );

            $description = sprintf( '<div class="description">%s/%s</div>', $location, $closing_date );
            
            $social = _s_get_addtoany_share_icons();
            $apply  = '<div class="apply"><a href="#section-apply-now" class="button">Apply Now</a></div>';
            
            $actions = sprintf( '<div class="actions">%s%s</div>', $social, $apply );
                        
            $html = sprintf( '<div class="hero-caption"><header>%s</header>%s%s</div>', $heading, $description, $actions );
                                                                        
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
   
new Post_Hero_Section;
