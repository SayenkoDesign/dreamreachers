<?php
// Careers - Search

if( ! class_exists( 'Careers_Search_Section' ) ) {
    class Careers_Search_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
            
            $post_id = _s_get_page_id_from_template_name( 'page-templates/careers.php' );
            
            if( ! $post_id ) {
                return;
            }
                        
            $fields = get_field( 'quotes', $post_id );
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
                     $this->get_name() . '-search',
                     $this->get_name() . '-search' . '-' . $this->get_id(),
                ]
            );
            
            $this->add_render_attribute(
                'wrapper', 'id', $this->get_name() . '-search', true ); 
                        
        }  
        
        
        
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();  
                                        
            $header = '';
            $heading = _s_format_string( 'Search<br />Opportunities', 'h2' );
            
            $quote_mark = sprintf( '<div class="quote-mark"><span><img src="%scareers/quote-icon.svg" /></span></div>', trailingslashit( THEME_IMG ) );
            
            $slides = '';
            $nav = '';
            if( ! empty( $fields ) ) {
                foreach( $fields as $fields ) {
                    $photo = $fields['photo'];
                    $photo = _s_get_acf_image( $photo, 'thumbnail' );
                    $name = _s_format_string( $fields['name'], 'h5' );
                    $message = $fields['message'];
                    
                    if( empty( $photo ) || empty( $message ) ) {
                        continue;
                    }
                    
                    $slides .= sprintf( '<div class="quote">%s%s</div>', $message, $name );
                    $nav .= sprintf( '<div>%s</div>', $photo );
                }
                
                $quotes = sprintf( '<div class="column column-block">%s<div class="quotes slick">%s</div><div class="slick-nav">%s</div></div>', $quote_mark, $slides, $nav );
            }
            
            
                   
            $icon = sprintf( '<span class="icon"><img src="%scareers/search-icon.svg" /></span>', trailingslashit( THEME_IMG ) );
            
            if( ! empty( $heading ) ) {
                $header = sprintf( '<div class="column column-block"><header>%s%s</header></div>', $icon, $heading  );
                $header = sprintf( '<div class="header"><div class="row large-unstack align-middle">%s%s</div></div>', $header, $quotes );
            }
            
            return $header;
        }
        

        
    }
}
   
new Careers_Search_Section;
