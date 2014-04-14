<?php
/**
 * Plugin Name: RHD Social Icons
 * Description: Simple links to social networks with custom graphical "buttons."
 * Author: Roundhouse Designs
 * Author URI: http://roundhouse-designs.com
 * Version: 0.1
**/

/* ==========================================================================
   RHD SOCIAL ICONS
   ========================================================================== */

class RHD_Social_Icons extends WP_Widget {
	function __construct() {
		parent::__construct(
	 		'rhd_social_icons', // Base ID
			__('RHD Social Icons', 'rhd'), // Name
			array( 'description' => __( 'Displays social networking link icons.', 'rhd' ), ) // Args
		);
	}
	
	public function update($new_instance, $old_instance) {
		// processes widget options to be saved
		return $new_instance;
	}

	public function widget($args, $instance) {
		// outputs the content of the widget 
		
		extract( $args );
		
		echo $before_widget;
		
		$title = apply_filters('widget_title', $instance['title']);
		
		if ( $instance['rss'] == '' )
			$rss_link = get_bloginfo('rss2_url');
		else
			$rss_link = $instance['rss'];

		//Twitter Handle Formatting
		if ( stripos($instance['twitter'], '@') === 0 )
			$twitter_link = 'http://twitter.com/' . substr($instance['twitter'], 1);
		elseif ( !stripos($instance['twitter'], '@' && $instance['twitter'] != '') )
			$twitter_link = 'http://twitter.com/' . $instance['twitter'];
		
		if ( $title )
			echo $before_title . $title . $after_title; ?>
		
		<?php wp_enqueue_style('rhd-social-icons', plugin_dir_url(__FILE__) . '/rhd-social-icons.css'); ?>
		
		<ul class="social-widget">
			<li class="facebook-icon"><a href="<?php echo $instance['facebook']; ?>" target="_blank"><img src="<?php echo THEME_DIR; ?>/img/facebook-icon.png" alt="Facebook button"></a></li>
			<li class="twitter-icon"><a href="//twitter.com/<?php echo $twitter_link; ?>" target="_blank"><img src="<?php echo THEME_DIR; ?>/img/twitter-icon.png" alt="Twitter button"></a></li>
			<li class="pinterest-icon"><a href="//pinterest.com/<?php echo $instance['pinterest']; ?>" target="_blank"><img src="<?php echo THEME_DIR; ?>/img/pinterest-icon.png" alt="Pinterest button"></a></li>
			<li class="instagram-icon"><a href="//instagram.com/<?php echo $instance['instagram']; ?>/" target="_blank"><img src="<?php echo THEME_DIR; ?>/img/instagram-icon.png" alt="Instagram button"></a></li>
			<li class="rss-icon"><a href="<?php echo $rss_link; ?>" target="_blank"><img src="<?php echo THEME_DIR; ?>/img/rss-icon.png" alt="rss button"></a></li>	
			<li class="bloglovin-icon"><a href="<?php echo $instance['bloglovin']; ?>/" target="_blank"><img src="<?php echo THEME_DIR; ?>/img/bloglovin-icon.png" alt="bloglovin button"></a></li>	
					
		</ul>

<?php	echo $after_widget;
	}
	
	public function form($instance) {
		// outputs the options form on admin
		$args['title'] = esc_attr($instance['title']);
		
		$args['facebook'] = esc_attr($instance['facebook']);
		$args['twitter'] = esc_attr($instance['twitter']);
		$args['pinterest'] = esc_attr($instance['pinterest']);
		$args['instagram'] = esc_attr($instance['instagram']);
		$args['rss'] = esc_attr($instance['rss']);
		$args['bloglovin'] = esc_attr($instance['bloglovin']);
?>
		
		<?php wp_enqueue_style('rhd-social-icons', plugin_dir_url(__FILE__) . '/rhd-social-icons.css'); ?>
		
		<div class="rhd-social-icons-entries">
			<p><label for="<?php echo $this->get_field_id('title'); ?>">Widget Title (optional): </label><input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $args['title']; ?>" ></p>
	
			<h3>Sidebar link Handles:</h3>
					
			<p><label for="<?php echo $this->get_field_id('facebook'); ?>">Facebook URL: </label><input id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" placeholder="http://facebook.com/your-page-here" value="<?php echo $args['facebook']; ?>" ></p>
			
			<p><label for="<?php echo $this->get_field_id('twitter'); ?>">Twitter handle: </label><input id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" placeholder="@my-twitter-handle" value="<?php echo $args['twitter']; ?>" ></p>
			
			<p><label for="<?php echo $this->get_field_id('pinterest'); ?>">Pinterest username: </label><input id="<?php echo $this->get_field_id('pinterest'); ?>" name="<?php echo $this->get_field_name('pinterest'); ?>" type="text" placeholder="my-pinterest-username" value="<?php echo $args['pinterest']; ?>" ></p>
			
			<p><label for="<?php echo $this->get_field_id('instagram'); ?>">Instagram handle: </label><input id="<?php echo $this->get_field_id('instagram'); ?>" name="<?php echo $this->get_field_name('instagram'); ?>" type="text" placeholder="my-instagram-handle" value="<?php echo $args['instagram']; ?>" ></p>
			
			<p><label for="<?php echo $this->get_field_id('rss'); ?>">RSS link <em>(Optional)</em>:</label><input id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" type="text" placeholder="Leave blank for default RSS" value="<?php echo $args['rss']; ?>" ></p>
			
			<p><label for="<?php echo $this->get_field_id('bloglovin'); ?>">Bloglovin URL: </label><input id="<?php echo $this->get_field_id('bloglovin'); ?>" name="<?php echo $this->get_field_name('bloglovin'); ?>" type="text" placeholder="http://bloglovin.com/blog/1234567" value="<?php echo $args['bloglovin']; ?>" ></p>
		</div><!-- .rhd-social-icons-entries -->
		        
<?php
	}
}
// register Foo_Widget widget
function register_rhd_social_icons_widget() {
    register_widget( 'RHD_Social_Icons' );
}
add_action( 'widgets_init', 'register_rhd_social_icons_widget' );