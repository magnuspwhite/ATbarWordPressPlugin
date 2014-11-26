<?

class ATbar_Widget extends WP_Widget{

	public function __construct(){
		parent::__construct(
	 		'atbar_widget',
			'ATbar',
			array('description' => __( 'ATbar launcher. Loads the selected version of ATbar (settings->ATbar)', 'atbar'),)
		);
	}

	public function widget( $args, $instance ) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;
		if(! empty($title)){
			echo $before_title.$title.$after_title;
		}
		$this->launcher();	
		echo $after_widget;
	}

	public function update($new_instance, $old_instance){
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}
	
	public function form($instance){
		if(isset($instance['title'])){
			$title = $instance['title'];
		}
		else{
			$title = __( 'New title', 'atbar');
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'atbar' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php 
	}
	
	private function launcher(){
		$version = get_option('atbar_version');
	
		switch ($version){

			default:
				$js = file_get_contents(dirname(__FILE__).'/atbar-launcher-en.js');
			break;

			case "en":
				$js = file_get_contents(dirname(__FILE__).'/atbar-launcher-en.js');
			break;

			case "ar":
				$js = file_get_contents(dirname(__FILE__).'/atbar-launcher-ar.js');
			break;
			
			case "marketplace":
				$js = get_option('atbar_marketplace_toolbar');
			break;
		}
		
		$launcher = '<a href="'.$js.'" id="toolbar-launch" title="'.__('Launch ATbar to adjust this webpage, have it read aloud and other functions.', 'atbar').'"><img src="https://core.atbar.org/resources/img/launcher.png" alt="ATbar"></a>';
		echo '<div id="toolbar-widget">'.$launcher.'</div>';
	}

}

?>