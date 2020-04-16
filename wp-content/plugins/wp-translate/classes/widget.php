<?php
class WP_Translate_Widget extends WP_Widget {
	//register widget
	function __construct() {
		parent::__construct(
			'wp_translation_widget',
			__('WP Translate Widget', 'wp-translate'),
			array('description' => __('Creates a simple drop down list of languages to translate content to and hides tool bar', 'wp-translate'), )
		);
	}
	
	//front-end
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( !empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
	
		echo '<div id="wp_translate"></div>';		
		
		echo $args['after_widget'];
	}
	
	//back-end
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		else {
			$title = __( 'Translate', 'wp-translate' );
		}
		ob_start();
		?>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">		
		<?php
		ob_end_flush();
	}
	
	//sanitize form values when updated
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		
		$instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
		return $instance;
	}
}
?>