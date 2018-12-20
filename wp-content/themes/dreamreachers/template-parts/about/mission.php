<?php
// About - Mission

if( ! class_exists( 'About_Mission_Section' ) ) {
    class About_Mission_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                                    
            $fields = get_field( 'mission' );
            $this->set_fields( $fields );
                                    
            // Render the section
            if( empty( $this->render() ) ) {   
                return;
            }
            
            // print the section
            $this->print_element();        
        }
        
              
        // Add default attributes to section        
        protected function _add_render_attributes() {
            
            // use parent attributes
            parent::_add_render_attributes();
    
            $this->add_render_attribute(
                'wrapper', 'class', [
                     $this->get_name() . '-mission',
                     $this->get_name() . '-mission' . '-' . $this->get_id(),
                ]
            ); 
                        
        }  
        
        
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();  
                                                                
            $header = '';
            $heading = '';
            $description = '';
            if( ! empty( $fields['description'] ) ) {                
                $quote_mark = sprintf( '<span><img src="%sabout/quote-icon.svg" /></span>', 
                                       trailingslashit( THEME_IMG ) );
                 
                $description = wpautop( sprintf( '%s%s', $fields['description'], $quote_mark ) );
                
                $description = sprintf( '<div class="column column-block description"><div class="entry-content">%s</div></div>', 
                                        $description );
            }
                        
            $icon = sprintf( '<span class="icon"><img src="%sabout/mission-icon.svg" /></span>', trailingslashit( THEME_IMG ) );
            
            
            
            if( ! empty( $fields['heading'] ) ) {
                $heading = preg_replace( '/\s/', '<br />', $fields['heading'], 1 ); 
                $heading = sprintf( '<h2>%s</h2>', $heading );
            }
            
            if( ! empty( $heading ) ) {
                $header = sprintf( '<div class="column column-block"><header>%s%s</header></div>', $icon, $heading  );
                return  sprintf( '<div class="header"><div class="row medium-unstack align-middle">%s%s</div></div>',
                                  $header, $description );
            }
            
        }
        
    }
}
   
new About_Mission_Section;
