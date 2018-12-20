<?php
// About - Values

if( ! class_exists( 'About_Values_Section' ) ) {
    class About_Values_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
                                    
            $fields = get_field( 'values' );
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
                     $this->get_name() . '-values',
                     $this->get_name() . '-values' . '-' . $this->get_id(),
                ]
            ); 
                        
        }  
        
        
        
        public function before_render() {      
            
            $fields = $this->get_fields();  
            
            $header = '';
            $heading = '';
            $description = '';
            if( ! empty( $fields['description'] ) ) {
                $description = sprintf( '<div class="column column-block description">%s</div>', $fields['description'] );
            }
                        
            $icon = sprintf( '<span class="icon"><img src="%sabout/values-icon.svg" /></span>', trailingslashit( THEME_IMG ) );
            
            if( ! empty( $fields['heading'] ) ) {
                $heading = preg_replace( '/\s/', '<br />', $fields['heading'], 1 ); 
                $heading = sprintf( '<h2>%s</h2>', $heading );
            }
            
            if( ! empty( $heading ) ) {
                $header = sprintf( '<div class="column column-block shrink"><header>%s%s</header></div>', $icon, $heading  );
                $header =  sprintf( '<div class="container header"><div class="wrap"><div class="row medium-unstack align-middle">%s%s</div></div></div>',
                                  $header, $description );
            }      
            
            $this->add_render_attribute( 'inner', 'class', 'inner' );
            $this->add_render_attribute( 'container', 'class', 'container primary' );
            $this->add_render_attribute( 'wrap', 'class', 'wrap' );
            
            return sprintf( '<%s %s><div %s><div %s>%s<div %s><div %s>', 
                            esc_html( $this->get_html_tag() ), 
                            $this->get_render_attribute_string( 'wrapper' ), 
                            $this->get_render_attribute_string( 'inner' ), 
                            $this->get_render_attribute_string( 'background' ),
                            $header,
                            $this->get_render_attribute_string( 'container' ), 
                            $this->get_render_attribute_string( 'wrap' )
                            );
        }
        
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();  
                                                   
            $bullets = $this->get_fields( 'bullets' );
            $bullets = wp_list_pluck( $bullets, 'point' );
            $bullets = sprintf( '<div class="entry-content">%s</div>', ul( $bullets ) );
            
            
            $photo = $this->get_fields( 'photo' );
            $photo = _s_get_acf_image( $photo, 'medium' );
            
            return sprintf( '<div class="row content"><div class="column small-12 large-7">%s<hr /></div><div class="column small-12 large-4 align-self-middle show-for-large">%s</div></div>', $bullets, $photo );
            
        }
        
    }
}
   
new About_Values_Section;
