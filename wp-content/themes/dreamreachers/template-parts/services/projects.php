<?php
// Home - Projects

if( ! class_exists( 'Home_Projects_Section' ) ) {
    class Home_Projects_Section extends Element_Section {
        
        var $post_type = 'project';
        
        public function __construct() {
            parent::__construct();
            
            $fields = get_field( 'projects' );
            $this->set_fields( $fields );
                        
            $settings = get_field( 'settings' );
            $this->set_settings( $settings );
                        
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
                     $this->get_name() . '-projects'
                ]
            );   
            
            $this->add_render_attribute(
                'wrapper', 'id', $this->get_name() . '-projects', true );            
            
        }          
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
                                                                        
            $row = new Element_Row(); 
            $column = new Element_Column(); 
            
            // Header
            $header = new Element_Header( [ 'fields' => $fields ] ); // set fields from Constructor
            $column->add_child( $header );
            
            $html = new Element_Html( [ 'fields' => [ 'html' => $this->projects() ] ] );
            $html->add_render_attribute( 'wrapper', 'class', 'projects' );
            $column->add_child( $html );
            $row->add_child( $column );
            
            $this->add_child( $row ); 
                        
        }
        
        
        private function projects() {
        
            $post_ids = $this->get_fields( 'projects' );
                    
            $loop = new WP_Query( array(
                'post_type' => $this->post_type,
                'order' => 'ASC',
                'post__in' => $post_ids,
                'posts_per_page' => 6,
            ) );
            
            if( ! empty( $post_ids ) ) {
                $args['orderby'] = 'post__in';
                $args['post__in'] = $post_ids;
                $args['posts_per_page'] = 100;
            }
            
            $out = '';
            
            if ( $loop->have_posts() ) : 
                                                              
                while ( $loop->have_posts() ) :
    
                    $loop->the_post(); 
                        
                    $out .= sprintf( '<div class="column column-block">%s</div>', _s_get_template_part( 'template-parts/projects', 'project-column', [], true ) );
    
                endwhile;
                
                $out = sprintf( '<div class="row small-up-1 medium-up-2 large-up-3 grid" data-equalizer data-equalize-on="medium">%s</div>', $out );
                
            endif; 
            
            wp_reset_postdata();
            
            return $out;
        }
                
    }
}
   
new Home_Projects_Section;