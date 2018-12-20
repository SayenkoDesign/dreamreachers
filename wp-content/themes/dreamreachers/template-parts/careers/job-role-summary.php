<?php
// Careers - Job Summary

if( ! class_exists( 'Job_Summary_Section' ) ) {
    class Job_Summary_Section extends Element_Section {
        
        public function __construct() {
            parent::__construct();   
            
            $fields = get_field( 'summary' );
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
                     $this->get_name() . '-summary'
                ]
            ); 
                        
        }  
        
        
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();  
            
            $header = '';
            
            if( ! empty( $fields['heading'] ) ) {
                $header = sprintf( '<header><h2>%s</h2></header>', $fields['heading'] );
            }

            $editor = new Element_Editor( [ 'fields' => $fields ] );
            $editor = $editor->get_element();
            
            $related = $this->get_related();
            
            return sprintf( '<div class="row"><div class="column column-block small-12 large-6 xxlarge-7">%s%s</div><div class="column column-block small-12 large-6 xxlarge-5 shrink">%s</div></div>',
                             $header, $editor, $related );
            
        }
        
        
        private function get_related() {
            
            $post_ids = get_field( 'related_posts' );
            
            if( empty( $post_ids ) ) {
                return false;
            }
             
            $args = array(
                'post_type' => 'job',
                'order' => 'ASC',
                'orderby' => 'post__in',
                'post__in' => $post_ids,
                'posts_per_page' => 100,
            );
            
            // only show upcoming  
			$meta_query		= array(
				
				 array(
					'key' => 'closing_date',
					'value' => date_i18n('Ymd'),
					'compare' => '>='
				 )
			 );
		  
		    $args['meta_query'] = $meta_query;  
                           
            $loop = new WP_Query( $args );
            
            $out = '';
            
            if ( $loop->have_posts() ) : 
          
                while ( $loop->have_posts() ) :
    
                    $loop->the_post();   
                    
                    $term = '';
                    
                    $terms = wp_get_post_terms( get_the_ID(), 'region' );
                    if( !is_wp_error( $terms ) ) {
                        $term = array_pop($terms);
                        $term = $term->name;
                    }
                    
                    $location = get_field( 'location' );

                    $out .= sprintf( '<li><a href="%s"><span>%s</span><strong>%s</strong></a></li>', get_permalink(), get_the_title(), $location );
    
                endwhile;
                
            endif; 
            
            wp_reset_postdata();
            
            $icon = get_svg( 'arrow-right' );
            return sprintf( '<p class="text-right go-back"><a href="%s">Back to Careers%s</a></p><div class="related-jobs"><h2>Similar Opportunities</h2><ul class="no-bullet">%s</ul></div>', 
                            get_post_type_archive_link( 'job' ), $icon, $out );
        }
        
    }
}
   
new Job_Summary_Section();


