<?php
// Careers - Job Apply

if( ! class_exists( 'Job_Apply' ) ) {
    class Job_Apply extends Element_Section {
        
        public function __construct() {
            parent::__construct();    
            
            $fields = get_field( 'job_settings_apply', 'option' );
            $this->set_fields( $fields );
            
            $this->render();
            
            $this->print_element(); 
        }
              
        // Add default attributes to section        
        protected function _add_render_attributes() {
            
            // use parent attributes
            parent::_add_render_attributes();
            
            $this->add_render_attribute(
                'wrapper', 'class', [
                     $this->get_name() . '-apply'
                ]
            ); 
            
            $this->add_render_attribute(
                'wrapper', 'id', [
                     $this->get_name() . '-apply-now'
                ], true
            ); 
                                   
        }  
        
        
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();  
            
            $content = '';
            
            $heading = 'Apply Now';
            $form_id = $fields['form_id'];
                        
            $icon = sprintf( '<span class="icon"><img src="%sjob/%s-icon.svg" /></span>', trailingslashit( THEME_IMG ), 'apply' );
            
            $heading = preg_replace( '/\s/', '<br />', $heading, 1 ); 
            $heading = sprintf( '<h2>%s</h2>', $heading );
            
            $closing_date = get_field( 'closing_date' );
            $date = new DateTime( $closing_date );
            
            $closing = sprintf( '<p>%s %s</p>', $fields['closing_date'], $date->format('F d, Y' ) );
            
            $message = _s_format_string( $fields['message'], 'p' );
            
            $social = sprintf( '<h5>Share This</h5>%s', _s_get_addtoany_share_icons() );
            
            $content .= sprintf( '<div class="column column-block small-12 large-6 xxlarge-5"><header>%s%s</header><div class="entry-content">%s%s%s</div></div>', 
                                 $icon, $heading, $closing, $message, $social );
            
            $form_id = $fields['form_id'];
            $form = GFAPI::get_form( $form_id );
            
            if( false !== $form ) {
               $content .= sprintf( '<div class="column column-block small-12 large-6 xxlarge-7"><div class="form-wrapper">%s</div></div>', 
                        do_shortcode( sprintf( '[gravityform id="%s" title="false" description="false" ajax="true"]', $form_id ) ) );
            }
            
            
            
            return sprintf( '<div class="row">%s</div>', $content );
            
        }
        

        
    }
}

new Job_Apply();