<?php
/**
 * PSC_Locations_Widget
 */


class PSC_Locations_Widget extends WP_Widget {
	
	protected $defaults;
    
    /**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
				
		// widget basics
		$widget_ops = array(
			'classname'   => 'psc-locations-widget',
			'description' => 'Create list of Locations'
		);
		
		// widget controls
		$control_ops = array(
			'id_base' => 'psc-locations-widget',
			//'width'   => '400',
		);
        
        $this->defaults = [];
		
		// load widget
        parent::__construct( 'psc-locations-widget', __( 'PSC Locations Widget' ), $widget_ops, $control_ops );
	}

    
	/**
     * Outputs the HTML for this widget.
     *
     * @param array  An array of standard parameters for widgets in this theme 
     * @param array  An array of settings for this widget instance 
     * @return void Echoes it's output
     **/
	function widget( $args, $instance ) {
		
        extract( $args );
	
		echo $before_widget;
        
        echo '<div class="widget-wrap">';
		
		if ( !empty( $instance['title'] ) ) { 
			echo $before_title . $instance['title'] . $after_title;
		}
	    
		$locations = psc_get_locations();
            
        echo $locations;
        
        echo '</div>';
			
		echo $after_widget;
	}

    /**
     * Deals with the settings when they are saved by the admin. Here is
     * where any validation should be dealt with.
     *
     * @param array  An array of new settings as submitted by the admin
     * @param array  An array of the previous settings 
     * @return array The validated and (if necessary) amended settings
     **/
	function update( $new_instance, $old_instance ) {
		
		$new_instance['title'] = strip_tags( $new_instance['title'] );

		return $new_instance;
	}
	
    /**
     * Displays the form for this widget on the Widgets page of the WP Admin area.
     *
     * @param array  An array of the current settings for this widget
     * @return void Echoes it's output
     **/
	function form( $instance ) {		
    
        $instance = wp_parse_args( (array) $instance, $this->defaults );
		
		echo '<p>
			<label for="' . $this->get_field_id( 'title' ) . '">Title:</label>
			<input type="text" id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" value="' . esc_attr( $instance['title'] ) . '" class="widefat" />
			</p>';
			
    	
        $scheme = is_ssl() ? 'https' : 'http';
	    printf( '<p><a href="">Click Here</a> to manage Locations.</p>', admin_url( 'edit.php?post_type=location', $scheme ) );        
	} 
    
    
}


add_action( 'widgets_init', function() {
    register_widget('PSC_Locations_Widget');   
});