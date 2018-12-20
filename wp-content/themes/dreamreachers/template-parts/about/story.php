<?php

/*
About Story
		
*/    
    
if( ! class_exists( 'About_Story_Section' ) ) {
    class About_Story_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();
            
            $fields = get_field( 'our_story' );
            $this->set_fields( $fields );
            
            if( empty( $fields['events'] ) ) {
                return;
            }

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
                     $this->get_name() . '-our-story'
                ]
            );
            
            $this->add_render_attribute(
                'wrapper', 'id', $this->get_name() . '-our-story', true );
        }
        
        
        public function before_render() {      
            
            $fields = $this->get_fields();  
            
            $heading = empty( $fields['heading'] ) ? __( 'Our Story' ) : $fields['heading'];
            $heading = preg_replace( '/\s/', '<br />', $fields['heading'], 1 ); 
            $heading = _s_format_string( $heading, 'h2' );
            $description = ! empty( $fields['description'] ) 
                           ? sprintf( '<div class="column column-block description">%s</div>', $fields['description'] ) 
                           : '';
                        
            $icon = sprintf( '<span class="icon"><img src="%sabout/story-icon.svg" /></span>', trailingslashit( THEME_IMG ) );
            
            
            $header = sprintf( '<div class="column column-block"><header>%s%s</header></div>', $icon, $heading  );
            $header = sprintf( '<div class="container"><div class="wrap"><div class="header"><div class="row medium-unstack align-middle">%s%s</div></div></div></div>', 
            $header, $description );      
            
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
            
            $start = $this->get_year( 'start' );
            $end   = $this->get_year( 'end' );
                        
            $start_date = sprintf( '<span class="year start"><b></b>%s</span>', $start );
            $end_date   = sprintf( '<span class="year end"><b></b>%s</span>', $end );
            
            $years = '';
            $timeline = '';
            if( ! empty( $fields['years'] ) ) {
                $years = explode( ',', $fields['years'] );
                if( ! empty( $years ) ) {
                    foreach( $years as $year ) {
                        if( true == absint( $year ) ) {
                            $position = ( ( $year - $start ) / ( $end - $start ) ) * 100 . '%';
                            $timeline .= sprintf( '<span class="year point" style="left: %s;"><b></b>%s</span>', $position, $year );
                        }
                    }
                    
                    $timeline = sprintf( '<div class="years">%s</div>', $timeline );
                }
            }
                        
            $slides = '';
            
            $events = $fields['events'];
            
            foreach( $events as $event ) {
                
                $year = $photo = $description = '';
                
                $year = $event['year'];
                
                $position = ( ( $year - $start ) / ( $end - $start ) ) * 100 . '%';
                
                $photo = _s_get_acf_image( $event['photo'], 'large', true ); 
                
                $description = $event['description'];
                                                        
                $slides .= sprintf( '<div><div class="event" style="background-image:url(%s)" data-year="%s" data-position="%s">
                                    <div class="caption">
                                            <span class="caption-arrow">%s</span>
                                            <div class="caption-lower">
                                                <h5>%s</h5>%s
                                            </div>
									</div>
                                   </div></div>', 
                                       $photo,
                                       $year,
                                       $position, 
                                       get_svg( 'chevron' ),
                                       $year,
                                       $description
                                   );
                
            } 
            
            
               
            return sprintf( '<div class="row align-middle"><div class="column"><div class="timeline-cnt">%s%s%s</div>
                             <div class="timeline-slider"><div class="slick">%s</div><div class="slick-arrows"></div></div></div></div>', 
                                $start_date,
                                $timeline, 
                                $end_date,
                                $slides
                              );
        }
        
        
        private function get_year( $when = 'start' ) {
            return 'start' == $when ? $this->get_start_year() : $this->get_end_year();
        }
        
        
        private function get_start_year( ) {
            $events = $this->get_fields( 'events' );
            $start  = $this->get_fields( 'start' );
            if( empty( $start ) ) {
                $start = date( 'Y', strtotime('- 5 years') );
            }
            $event = array_shift( $events );
            $year = $event['year'];
            return $year < $start ? $year - 3 : $start - 3;
        }
        
        
        private function get_end_year( ) {
            $events = $this->get_fields( 'events' );
            $end  = $this->get_fields( 'end' );
            if( empty( $start ) ) {
                $start = date( 'Y', strtotime('+ 5 years') );
            }
            $event = array_pop( $events );
            $year = $event['year'];
            return $year > $end ? $year + 3 : $end + 3;
        }
    }
}
   
new About_Story_Section;

    