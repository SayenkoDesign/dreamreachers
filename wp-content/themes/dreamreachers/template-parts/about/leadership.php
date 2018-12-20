<?php
// About - Leadership

if( ! class_exists( 'About_Leadership_Section' ) ) {
    class About_Leadership_Section extends Element_Section {
        
        var $post_type = 'people';
        
        public function __construct() {
            parent::__construct();
            
            $fields = get_field( 'leadership' );
            $this->set_fields( $fields );
                        
            $settings = get_field( 'settings' );
            $this->set_settings( $settings );
                        
            // Render the section
            if( empty( $this->render() ) ) {
                //return;   
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
                     $this->get_name() . '-leadership'
                ]
            );   
            
            $this->add_render_attribute(
                'wrapper', 'id', $this->get_name() . '-leadership', true ); 
            
            $this->add_render_attribute(
                'wrapper', 'id', [
                     $this->get_name() . '-leadership'
                ], true
            );            
            
        }          
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
            
            // Header
            $header = new Element_Header( [ 'fields' => $fields ] ); // set fields from Constructor
            if( ! empty( $header->get_element() ) ) {
                $row = new Element_Row(); 
                $column = new Element_Column(); 
                $column->add_child( $header );
                $row->add_child( $column );
                $this->add_child( $row ); 
            }
            
            $filters = _s_get_template_part( 'template-parts/about', 'filters', [], true );

            
            $people = $this->people();
            if( ! empty( $people ) ) {
                $html = new Element_Html( [ 'fields' => [ 'html' => $filters . $people ] ] );
                $html->add_render_attribute( 'wrapper', 'class', 'column row' ); 
                $this->add_child( $html ); 
            } 
                        
        }
        
        
        private function people() {
            
            $post_ids = $this->get_fields( 'people' );
        
            $args = array(
                'post_type' => $this->post_type,
                'order' => 'ASC',
                'posts_per_page' => 100,
            );
                        
            if( ! empty( $post_ids ) ) {
                $args['orderby'] = 'post__in';
                $args['post__in'] = $post_ids;
            }
            
            $loop = new WP_Query( $args );
            
            $out = '';
            
            if ( $loop->have_posts() ) :                 
                
                $out .= '<div class="row small-up-1 medium-up-2 large-up-3 xxlarge-up-4 isotopes grid">';
          
                while ( $loop->have_posts() ) :
    
                    $loop->the_post(); 
                    
                    $term_classes = [];
                    $terms = get_the_terms( get_the_ID(), 'region' );
                    if( !is_wp_error( $terms ) && !empty( $terms ) ) {
                        foreach($terms as $term){
                            $term_classes[] = sanitize_title( 'region-' . $term->name );
                        }
                    }
                    
                    $out .= sprintf( '<article id="post-%s" class="%s %s">', 
                                     get_the_ID(), 
                                     join( ' ', $term_classes ),
                                     join( ' ', get_post_class( 'column [ is-collapsed ]' ) )
                                  );
    
                    $background = sprintf( ' style="background-image: url(%s)"', get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ) );
                    
                    $position  = get_field( 'position' );
                    $position = _s_format_string( $position, 'p', [ 'class' => 'position' ] );
                    
                    $linkedin = get_field( 'linkedin' );
                    if( ! empty( $linkedin ) ) {
                        $linkedin = sprintf( '<a href="%s" class="linkedin">%s</a>', $linkedin, get_svg( 'linkedin' ) );
                    }
                    
                    $title  = sprintf( '<a class="header open">%s%s%s</a>', the_title( '<h4>', '</h4>', false ), $position, $linkedin );
                    
                    $photo = get_field( 'photo' );
                    if( ! empty( $photo ) ) {
                        $photo = _s_get_acf_image( $photo, 'medium' );
                        /*$photo = sprintf( '<div class="photo" style="background-image: url(%s);"></div>', 
                                           _s_get_acf_image( $photo, 'medium', true ) );*/
                    }
                                       
                    $expander = sprintf( '<div class="row">
                                            <div class="column small-12 large-8"><div class="entry-content">%s%s%s%s</div></div>
                                            <div class="column small-12 large-4 show-for-large shrink align-self-middle">%s</div>', 
                                            the_title( '<h2>', '</h2>', false ),
                                            $position,
                                            $this->accordion(), 
                                            '<i class="close [ js-collapser ]">&times;</i>',
                                            $photo 
                                       );
                    
                    $out .= sprintf( '<div class="column__inner [ js-expander ]">
                                        <div class="panel">
                                            <div class="thumbnail"%s></div>
                                            <div class="details" data-equalizer-watch>%s</div>
                                        </div>
                                      </div>
                                      <div class="column__expander">%s</div>', 
                            $background, 
                            $title, 
                            $expander
                            
                          );
                    
                    $out .= '</article>';
    
                endwhile;
                
                $out .= '</div>';
                
            endif; 
            
            wp_reset_postdata();
            
            return $out;
        }
        
        
        private function accordion() {
            
            $fields = [ 'skills', 'projects', 'articles', 'background', 'bio' ];
            
            $fa = new Foundation_Accordion( array('data' => array( 'data-accordion' => 'true',  'data-multi-expand' => 'false', 'data-allow-all-closed' => 'true' ) ) );
                
            foreach( $fields as $field ) {
                $heading = call_user_func_array( array( $this, $field ), array( 'heading' ) );
                $content = call_user_func_array( array( $this, $field ), array( 'content' ) );
                if( ! empty( $heading ) && ! empty( $content ) ) {
                    $fa->add_item( $heading, $content );
                }
                
            }
            
            return $fa->get_accordion();
        }
        
        
        
        private function skills( $return  = 'content' ) {
            $heading = $this->get_heading( 'skills' );
            $group = get_field( 'skills' );
            $content = $group['editor'];
            
            return ( 'heading' == $return ) ? $heading : $content;
        }
        
        
        
        private function projects( $return  = 'content' ) {
            $heading = $this->get_heading( 'projects' );
            $group = get_field( 'projects' );
            $list = [];
            $content = '';
            if( ! empty( $group['projects'] ) ) {
                $rows = $group['projects'];
                if( ! empty( $rows ) ) {
                    foreach( $rows as $row ) {
                        $list[] = sprintf( '<a href="%s">%s</a>', get_permalink( $row ), get_the_title( $row ) );
                    }
                }
                
                $content = ul( $list, ['class' => 'links' ] );
            }
                        
            
            return ( 'heading' == $return ) ? $heading : $content;
        }
        
        
        private function articles( $return  = 'content' ) {
            $heading = $this->get_heading( 'articles' );
            $group = get_field( 'articles' );
            $list = [];
            $content = '';
            if( ! empty( $group['articles'] ) ) {
                $rows = $group['articles'];
                if( ! empty( $rows ) ) {
                    foreach( $rows as $row ) {
                        $list[] = sprintf( '<a href="%s">%s</a>', get_permalink( $row ), get_the_title( $row ) );
                    }
                }
                
                $content = ul( $list, ['class' => 'links' ] );
            }
            
            
            return ( 'heading' == $return ) ? $heading : $content;
        }
        
        
        private function background( $return  = 'content' ) {
            $heading = $this->get_heading( 'background' );
            $group = get_field( 'background' );
            $content = $group['editor'];
            return ( 'heading' == $return ) ? $heading : $content;
        }
        
        
        
        private function bio( $return  = 'content' ) {
            $heading = $this->get_heading( 'bio' );
            $group = get_field( 'bio' );
            $content = $group['editor'];
            return ( 'heading' == $return ) ? $heading : $content;
        }
        
        
        private function get_heading( $field ) {
            $group = get_field( $field );
            if( ! empty( $group['heading'] ) ) {
                return $group['heading'];
            }
            return false;
        }
    }
}
   
new About_Leadership_Section;