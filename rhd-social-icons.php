<?php
/**
 * Plugin Name: RHD Social Icons
 * Description: Simple links to social networks with custom graphical buttons.
 * Author: Roundhouse Designs
 * Author URI: http://roundhouse-designs.com
 * Version: 1.0
**/

define( 'RHD_SI_DIR', plugin_dir_url(__FILE__) );

class RHD_Social_Icons extends WP_Widget {
	function __construct() {
		parent::__construct(
	 		'rhd_social_icons', // Base ID
			__( 'RHD Social Icons', 'rhd' ), // Name
			array( 'description' => __( 'Displays social networking link icons.', 'rhd' ), ) // Args
		);

		add_action( 'wp_enqueue_scripts', array( $this, 'display_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'display_scripts' ) );
	}

	public function display_styles() {
		wp_register_style( 'rhd-social-icons', RHD_SI_DIR . 'rhd-social-icons.css' );

		wp_enqueue_style( 'rhd-social-icons' );
	}

	public function display_scripts() {
		wp_register_script( 'jquery-visible', RHD_SI_DIR . '/js/jquery.visible.js', array( 'jquery' ), null, false );
		wp_register_script( 'rhd-social-icons', RHD_SI_DIR . '/js/rhd-social-icons.js', array( 'jquery', 'jquery-visible' ), null, false );

		wp_enqueue_script( 'jquery-visible' );
		wp_enqueue_script( 'rhd-social-icons' );
	}

	public function update( $new_instance, $old_instance ) {
		// processes widget options to be saved
		return $new_instance;
	}

	public function widget( $args, $instance ) {
		// outputs the content of the widget

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title']);

		if ( $instance['rss'] == '' )
			$rss_link = get_bloginfo('rss2_url' );
		else
			$rss_link = $instance['rss'];

		$widget_styles = array( 'horizontal', 'vertical' );
		$colors = array( 'black', 'white' );

		$widget_ids = array( $this->id . '-horizontal', $this->id . '-vertical' );

		//Twitter Handle Formatting
		if ( stripos( $instance['twitter'], '@' ) === 0 )
			$twitter_link = 'http://twitter.com/' . substr( $instance['twitter'], 1 );
		elseif ( !stripos( $instance['twitter'], '@' && $instance['twitter'] != '' ) )
			$twitter_link = 'http://twitter.com/' . $instance['twitter'];

		if ( $title )
			echo $before_title . $title . $after_title;

		echo $before_widget; ?>

		<?php for ( $i = 0; $i < 2; ++$i ) : ?>
			<ul id="<?php echo $widget_ids[$i]; ?>" class="<?php echo $this->id; ?> rhd_social_widget rhd_social-<?php echo $widget_styles[$i]; ?>">
				<li class="instagram-icon"><a href="//instagram.com/<?php echo $instance['instagram']; ?>/" target="_blank"><img src="<?php echo RHD_SI_DIR; ?>img/instagram-<?php echo $colors[$i]; ?>.png" alt="Instagram" class="instagram social-button"></a></li>
				<li class="pinterest-icon"><a href="//pinterest.com/<?php echo $instance['pinterest']; ?>" target="_blank"><img src="<?php echo RHD_SI_DIR; ?>img/pinterest-<?php echo $colors[$i]; ?>.png" alt="Pinterest" class="pinterest social-button"></a></li>
				<li class="twitter-icon"><a href="<?php echo $twitter_link; ?>" target="_blank"><img src="<?php echo RHD_SI_DIR; ?>img/twitter-<?php echo $colors[$i]; ?>.png" alt="Twitter" class="twitter social-button"></a></li>
				<li class="facebook-icon"><a href="<?php echo $instance['facebook']; ?>" target="_blank"><img src="<?php echo RHD_SI_DIR; ?>img/facebook-<?php echo $colors[$i]; ?>.png" alt="Facebook" class="facebook social-button"></a></li>
				<li class="bloglovin-icon"><a href="<?php echo $instance['bloglovin']; ?>/" target="_blank"><img src="<?php echo RHD_SI_DIR; ?>img/bloglovin-<?php echo $colors[$i]; ?>.png" alt="Bloglovin" class="bloglovin social-button"></a></li>
				<li class="rss-icon"><a href="<?php echo $rss_link; ?>" target="_blank"><img src="<?php echo RHD_SI_DIR; ?>img/rss-<?php echo $colors[$i]; ?>.png" alt="rss" class="rss social-button"></a></li>
				<li class="email-icon"><a href="<?php echo $instance['email']; ?>/" target="_blank"><img src="<?php echo RHD_SI_DIR; ?>img/email-<?php echo $colors[$i]; ?>.png" alt="email" class="email social-button"></a></li>
			</ul>
		<?php endfor; ?>

		<script type="text/javascript">
			var elemH = $("#<?php echo $widget_ids[0]; ?>");
			var elemV = $("#<?php echo $widget_ids[1]; ?>");

			rhdSocialStyle(elemH, elemV);
		</script>

<?php	echo $after_widget;
	}

	public function form( $instance ) {
		// outputs the options form on admin
		$args['title'] = esc_attr( $instance['title'] );

		$args['facebook'] = esc_attr( $instance['facebook'] );
		$args['twitter'] = esc_attr( $instance['twitter'] );
		$args['pinterest'] = esc_attr( $instance['pinterest'] );
		$args['instagram'] = esc_attr( $instance['instagram'] );
		$args['rss'] = esc_attr( $instance['rss'] );
		$args['bloglovin'] = esc_attr( $instance['bloglovin'] );
		$args['email'] = esc_attr( $instance['email'] );

		$args['widget_style'] = esc_attr( $instance['widget_style'] );
?>

		<?php wp_enqueue_style( 'rhd-social-icons', RHD_SI_DIR . '/rhd-social-icons.css' ); ?>

		<h3><?php _e( 'Widget Options:' ); ?></h3>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Widget Title (optional): </label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $args['title']; ?>" >
		</p>
		<p>

			<input id="<?php echo $this->get_field_id( 'style_horizontal' ); ?>" name="<?php echo $this->get_field_name( 'widget_style' ); ?>" type="radio" value="style_horizontal" <?php if( $args['widget_style'] === 'style_horizontal' ){ echo 'checked="checked"'; } ?> />
			<label for="<?php echo $this->get_field_id( 'style_horizontal' ); ?>"><?php _e( 'Horizontal (Default, black icons on white)' ); ?></label>

			<br />

			<input id="<?php echo $this->get_field_id( 'style_vertical' ); ?>" name="<?php echo $this->get_field_name( 'widget_style' ); ?>" type="radio" value="style_vertical" <?php if( $args['widget_style'] === 'style_vertical' ){ echo 'checked="checked"'; } ?> />
			<label for="<?php echo $this->get_field_id( 'style_vertical' ); ?>"><?php _e( 'Sticky Vertical (white icons on black)'); ?></label>
		</p>

		<div class="rhd-social-icons-entries">
			<h3><?php _e( 'Sidebar link Handles:' ); ?></h3>

			<p>
				<label for="<?php echo $this->get_field_id( 'facebook' ); ?>">Facebook URL: </label>
				<input id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" placeholder="http://facebook.com/your-page" value="<?php echo $args['facebook']; ?>" >
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'twitter' ); ?>">Twitter handle: </label>
				<input id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" placeholder="@my-twitter-handle" value="<?php echo $args['twitter']; ?>" >
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'pinterest' ); ?>">Pinterest username: </label>
				<input id="<?php echo $this->get_field_id( 'pinterest' ); ?>" name="<?php echo $this->get_field_name( 'pinterest' ); ?>" type="text" placeholder="my-pinterest-username" value="<?php echo $args['pinterest']; ?>" >
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'instagram' ); ?>">Instagram handle: </label>
				<input id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" placeholder="my-instagram-handle" value="<?php echo $args['instagram']; ?>" >
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'rss' ); ?>">RSS link <em>(Optional)</em>:</label>
				<input id="<?php echo $this->get_field_id( 'rss' ); ?>" name="<?php echo $this->get_field_name( 'rss' ); ?>" type="text" placeholder="Leave blank for default RSS" value="<?php echo $args['rss']; ?>" >
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'bloglovin' ); ?>">Bloglovin URL: </label>
				<input id="<?php echo $this->get_field_id( 'bloglovin' ); ?>" name="<?php echo $this->get_field_name( 'bloglovin' ); ?>" type="text" placeholder="http://bloglovin.com/blog/1234567" value="<?php echo $args['bloglovin']; ?>" >
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'email' ); ?>">Email Address: </label>
				<input id="<?php echo $this->get_field_id( 'email' ); ?>" name="<?php echo $this->get_field_name( 'email' ); ?>" type="text" placeholder="bob@bobs-burgers.com" value="<?php echo $args['email']; ?>" >
			</p>
		</div><!-- .rhd-social-icons-entries -->

<?php
	}
}
// register Foo_Widget widget
function register_rhd_social_icons_widget() {
    register_widget( 'RHD_Social_Icons' );
}
add_action( 'widgets_init', 'register_rhd_social_icons_widget' );