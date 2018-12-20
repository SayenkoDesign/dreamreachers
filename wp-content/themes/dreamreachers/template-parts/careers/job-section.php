<?php
// Careers - Job Section

if( ! class_exists( 'Job_Section' ) ) {
    class Job_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();         
        }
              
        // Add default attributes to section        
        protected function _add_render_attributes() {
            
            // use parent attributes
            parent::_add_render_attributes();
                        
        }  
        
        
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();  
            
            $header = '';
            $heading = '';
                        
            $icon = sprintf( '<span class="icon"><img src="%sjob/%s-icon.svg" /></span>', trailingslashit( THEME_IMG ), $this->get_settings( 'icon' ) );

            
            if( ! empty( $fields['heading'] ) ) {
                $heading = preg_replace( '/\s/', '<br />', $fields['heading'], 1 ); 
                $heading = sprintf( '<h2>%s</h2>', $heading );
            }
            
            if( ! empty( $heading ) ) {
                $header = sprintf( '<div class="row column column-block"><header>%s%s</header></div>', $icon, $heading  );
            }
            
            $editor = new Element_Editor( [ 'fields' => $fields ] );
            $editor = sprintf( '<div class="row column">%s</div>', $editor->get_element() );
            
            return $header . $editor;
            
        }
        

        
    }
}
   
$groups = [ 'responsibilities', 'requirements', 'minimum_expertise', 'preferred_expertise', 'benefits', 'the_location' ];

foreach( $groups as $group ) {
    $field = get_field( $group );
    $section = new Job_Section();
    $section->set_fields( $field );
    $section->set_settings( ['icon' => $group] );
    $section->add_render_attribute( 'wrapper', 'class', $section->get_name() . '-' .$group ); 
    $section->render();
    $section->print_element();  
}


