<?php
// Page Builder - Block

if( ! class_exists( 'Services_Block_Section' ) ) {
    class Services_Block_Section extends Element_Section {
        
        static public $section_count;
                
        public function __construct() {
            parent::__construct();
                                    
            $fields = get_sub_field( 'block' );
            $fields['photo_alignment'] = strtolower( $fields['photo_alignment'] ); 
            $fields['photo_width'] = strtolower( $fields['photo_width'] );
            $this->set_fields( $fields );
            
            $settings = get_sub_field( 'settings' );
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
            
            self::$section_count ++;
    
            $this->add_render_attribute(
                'wrapper', 'class', [
                     $this->get_name() . '-block',
                     $this->get_name() . '-block' . '-' . self::$section_count,
                ]
            ); 
            
            if( ! empty( $this->get_settings( 'id' ) ) ) {
                $this->add_render_attribute(
                'wrapper', 'id', $this->get_name() . '-' . $this->get_settings( 'id' ), true );            
            }
            
            $this->add_render_attribute( 'wrap', 'class', 'wrap' );
            
            $fields          = $this->get_fields();
            $photo           = $this->get_fields( 'photo' );
            $photo_alignment = $this->get_fields( 'photo_alignment' );
            $photo_width     = $this->get_fields( 'photo_width' );
                        
            if( ! empty( $photo ) ) {
                
                $photo = _s_get_acf_image( $photo, 'large', true );
                                                  
                $this->add_render_attribute( 'wrapper', 'class', sprintf( 'photo-%s', $photo_alignment ) );
                
                if( 'wide' == $photo_width ) {
                    $this->add_render_attribute( 'wrapper', 'class', 'wide-image' );
                    $this->add_render_attribute( 'background', 'class', 'background-image' );
                    $this->add_render_attribute( 'background', 'style', sprintf( 'background-image: url(%s);', $photo ) );
                }
                
            }
            
        } 
        
        
        public function before_render() {
            return sprintf( '<%s %s><div %s></div><div %s>', 
                        esc_html( $this->get_html_tag() ), 
                        $this->get_render_attribute_string( 'wrapper' ), 
                        $this->get_render_attribute_string( 'background' ),
                        $this->get_render_attribute_string( 'wrap' )
                        );
        }


        public function after_render() {
            return sprintf( '</div></%s>', esc_html( $this->get_html_tag() ) );
        }
        
        // Add content
        public function render() {
            
            $fields = $this->get_fields();
                                    
            // Set column order            
            if( 'left' == $this->get_fields( 'photo_alignment' ) ) {
                $column_classes = [ 'small-order-1 large-order-1', 'small-order-2 large-order-2' ];
            }
            else {
                $column_classes = [ 'small-order-1 large-order-2', 'small-order-2 large-order-1' ];
            }
                        
            
                                                                        
            $row = new Element_Row(); 
            $row->add_render_attribute( 'wrapper', 'class', 'align-center large-unstack' );
                                 
            // Make sure we have a photo?         
            if( $this->get_fields( 'photo' ) ) {
                
                $photo = new Element_Photo( [ 'fields' => $fields ]  );
                $column = new Element_Column(); 
                $column->add_render_attribute( 'wrapper', 'class', [$column_classes[0], 'column-block' ] );
                $column->add_child( $photo );
                $row->add_child( $column );
                            
            }
            
            $column = new Element_Column(); 
            
            if( $this->get_fields( 'photo' ) ) {
                $column->add_render_attribute( 'wrapper', 'class', [$column_classes[1], 'column-block' ] );
            } else {
                $column->add_render_attribute( 'wrapper', 'class', [ 'large-9', 'large-center', 'column-block' ] );
            }
                            
            // Editor
            $editor = new Element_Editor( [ 'fields' => $fields ] ); // set fields from Constructor
            $column->add_child( $editor );            
            $row->add_child( $column );
            
            // Button
            $button_args = $this->get_fields( 'button' );
            $button_style = ! empty( $button_args['style'] )  ? strtolower( $button_args['style'] ) : '';
            if( 'link' == $button_style ) {
                $button_style .= ' orange';
            }
            $button = new Element_Button( [ 'fields' => $fields ]  ); // set fields from Constructor
            $button->add_render_attribute( 'anchor', 'class', $button_style ); 
            $column->add_child( $button );
            
            $this->add_child( $row ); 
        }
        
    }
}
   
new Services_Block_Section;
