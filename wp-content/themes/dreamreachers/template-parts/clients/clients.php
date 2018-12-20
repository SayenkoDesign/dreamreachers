<?php
// Home - Clients

if( ! class_exists( 'Home_Clients_Section' ) ) {
    class Home_Clients_Section extends Element_Section {
        
        var $post_type = 'client';
        
        public function __construct() {
            parent::__construct();
            
            $fields = get_field( 'clients' );
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
                     $this->get_name() . '-clients'
                ]
            );   
            
            $this->add_render_attribute(
                'wrapper', 'id', $this->get_name() . '-clients', true );          
            
        }  
                
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
                                                                        
            

            return sprintf( '%s', $this->clients() );
                        
        }
        
        
        private function clients() {
                    
            $heading = '<h2>Clients</h2>';
            
            $filters = _s_get_template_part( 'template-parts/clients', 'filters', [], true );
            
            $out = '';
            $columns = '';
            
            $args = array(
                'post_type'      => $this->post_type,
                'post_status'    => 'publish',
                'posts_per_page' => 150,
            ); 
                    
            // Use $loop, a custom variable we made up, so it doesn't overwrite anything
            $loop = new WP_Query( $args );
                    
            // have_posts() is a wrapper function for $wp_query->have_posts(). Since we
            // don't want to use $wp_query, use our custom variable instead.
            if ( $loop->have_posts() ) : 
            
                $out = sprintf( '<div class="row large-unstack"><div class="column shrink"><header>%s</header></div><div class="column">%s</div></div>', 
                                $heading, 
                                $filters
                                 );
                
                while ( $loop->have_posts() ) : $loop->the_post(); 
                                    
                    $url = get_field( 'url' );
                    $image = get_the_post_thumbnail( get_the_ID(), 'medium' );
                    $tag = 'span';
                    if( !empty( $url ) ) {
                        $tag = 'a';
                        $this->add_render_attribute( 'anchor', 'href', $url, true );
                    }
                    
                    $term_classes = [];
                    $terms = get_the_terms( get_the_ID(), 'region' );
                    if( !is_wp_error( $terms ) && !empty( $terms ) ) {
                        foreach($terms as $term){
                            $term_classes[] = sanitize_title( 'region-' . $term->name );
                        }
                    }
                    
                    
                    $columns .= sprintf( '<article class="column column-block %4$s"><div class="logo"><%1$s %2$s>%3$s</%1$s></div></article>', 
                                        $tag, 
                                        $this->get_render_attribute_string( 'anchor' ), 
                                        $image,
                                        join( ' ', get_post_class( $term_classes ) ) ); 
                endwhile;
                
                $out .= sprintf( '<div class="row small-up-1 medium-up-2 large-up-3 xlarge-up-4 isotopes grid">%s</div>', $columns );
                
            endif;
        
            wp_reset_postdata();
  
            return $out;
        }
        
        
        private function filters() {
                    
            $args = array(
                'taxonomy' => 'region',
                'hide_empty' => true,
                'post_type' => [ 'client' ],
            ); 
        
            $terms = get_terms( $args );
            
            if( is_wp_error( $terms ) || empty( $terms ) ) {
                return false;
            }
            
            $out = sprintf( '<li><button data-filter="*" class="active">%s</button></li>', __('All', '_s') ); 
            
            foreach ( $terms as $term ) : 
                $out .= sprintf( '<li><button data-filter=".%s">%s</button></li>', sanitize_title( 'region-' . $term->name ), $term->name );
            endforeach;
            
            return sprintf( '<div class="filter-button-group"><ul>%s</ul></div>', $out );            
        }
    }
}
   
new Home_Clients_Section;