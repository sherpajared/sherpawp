<?php
/**
 * widgets.php
 * 
 * includes widgets to be initialzied in functions.php
 * 
 * @package sherpawp
 * @todo Create widgets with more functionality
 */

/**
 * Most_Viewed_Widget
 * 
 * Displays most viewed post of a particular type
 * Tracks view on each post
 * 
 * @extends WP_Widget
 */
class Most_Viewed_Widget extends WP_Widget {
	/**
     * Constructor method for Most_Viewed_Widget
     * Registed by widget_init
     * 
     */
    public function __construct() {
		parent::__construct(
			'sherpa-most-viewed',  // Base ID
			'Sherpa Most Viewed'   // Name
		);
		add_action( 'widgets_init', function() {
			register_widget( 'Most_Viewed_Widget' );
		});
	}
	public $args = array(
		'before_title'  => '<h4 class="widgettitle">',
		'after_title'   => '</h4>',
		'before_widget' => '<div class="widget-wrap">',
		'after_widget'  => '</div>',
	);
    /**
     * Widget display on the front end
     * Outputs the most viewed posts
     * 
     * @param array $args     - Display arguments: before_title, after_title, before_widget and after_widget
     * @param array $instance - Setting for any particular instance of the widget
     */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];
		if ( ! empty( $instance['title'] ) ) {
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		$query_args = array(
			'meta_key'  	 => 'views',
			'post_type' 	 => 'post',
			'posts_per_page' => 2,
			'orderby' 		 => 'meta_value_num',
			'order'			 => 'DESC'
		);
		$myposts = new WP_Query($query_args);

		if ($myposts->have_posts()) {
			while($myposts->have_posts()) {
				$myposts->the_post();
				get_template_part('template-parts/post-small');
			}
		}
		wp_reset_postdata();
		
		echo $args['after_widget'];
	}
/**
 * Widget form in the admin panel
 * Outputs the options form on the admin side
 * 
 * @param array $instance - the current settings of the widget
 */
	public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( '', 'text_domain' );
		$text  = ! empty( $instance['text'] ) ? $instance['text'] : esc_html__( '', 'text_domain' );
		$comment  = ! empty( $instance['comment'] ) ? $instance['comment'] : esc_html__( '', 'text_domain' );
		
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Title:', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php echo esc_html__( 'Text:', 'text_domain' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" cols="30" rows="10"><?php echo esc_attr( $text ); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'comment' ) ); ?>"><?php echo esc_html__( 'Comment:', 'text_domain' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'comment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'comment' ) ); ?>" type="text" cols="30" rows="10"><?php echo esc_attr( $comment ); ?></textarea>
		</p>
		<?php
	}
/**
 * Processes the widget options to be saved.
 *
 * @param array $new_instance New settings for this instance as input by the user via the form.
 * @param array $old_instance Old settings for this instance.
 * @return array Updated settings to be saved.
 */
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['text']  = ( ! empty( $new_instance['text'] ) ) ? $new_instance['text'] : '';
		$instance['comment']  = ( ! empty( $new_instance['comment'] ) ) ? $new_instance['comment'] : '';
		return $instance;
	}
}
$most_viewed = new Most_Viewed_Widget();
class Recent_Posts_Widget extends WP_Widget {
    function __construct() {
        parent::__construct(
            'recent_posts_widget',
            __('Recent Posts', 'mytheme'),
            array('description' => __('A widget to display recent posts', 'mytheme'))
        );
    }

    public function widget($args, $instance) {
        echo $args['before_widget'];
        if (!empty($instance['title'])) {
            echo $args['before_title'] . apply_filters('widget_title', $instance['title']) . $args['after_title'];
        }

        $query_args = array(
            'posts_per_page' => 5,
            'post_status'    => 'publish',
        );
        $recent_posts = new WP_Query($query_args);
        if ($recent_posts->have_posts()) {
            echo '<ul>';
            while ($recent_posts->have_posts()) {
                $recent_posts->the_post();
                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
            echo '</ul>';
            wp_reset_postdata();
        }

        echo $args['after_widget'];
    }

    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : __('Recent Posts', 'mytheme');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('Title:', 'mytheme'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}
/**
 * Image_Gallery_Widget
 * 
 * A custom widget that displays an image gallery from user-provided URLs.
 *
 * @package sherpawp
 * 
 * @extends WP_Widget
 */
class Image_Gallery_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'image_gallery_widget', // Base ID
            'Image Gallery Widget', // Widget name
            array( 'description' => 'Displays an image gallery' )
        );
    }

    // Widget form (admin panel)
    /**
     * Widget form in the admin panel.
     * Outputs the options form on the admin side.
     *
     * @param array $instance The current settings for the widget.
     */
    public function form($instance) {
        // Output admin widget options form
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $images = ! empty( $instance['images'] ) ? $instance['images'] : '';

        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'images' ); ?>"><?php _e( 'Image URLs (comma-separated):' ); ?></label>
            <textarea class="widefat" rows="5" id="<?php echo $this->get_field_id( 'images' ); ?>" name="<?php echo $this->get_field_name( 'images' ); ?>"><?php echo esc_textarea( $images ); ?></textarea>
        </p>
        <?php
    }

    // Widget update/save
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['images'] = ( ! empty( $new_instance['images'] ) ) ? sanitize_text_field( $new_instance['images'] ) : '';

        return $instance;
    }

    // Widget display on front-end
    public function widget($args, $instance) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        $images = ! empty( $instance['images'] ) ? explode( ',', $instance['images'] ) : array();

        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }

        if ( ! empty( $images ) ) {
            echo '<div class="image-gallery-widget">';
            foreach ( $images as $image_url ) {
                if ( ! empty( $image_url ) ) {
                    echo '<img src="' . esc_url( $image_url ) . '" alt="">';
                }
            }
            echo '</div>';
        }

        echo $args['after_widget'];
    }
}

// Register the widget



function register_custom_widgets() {
    register_widget('Most_Viewed_Widget');
    register_widget('Recent_Posts_Widget');
	register_widget( 'Image_Gallery_Widget' );
};
add_action('widgets_init', 'register_custom_widgets');
?>
