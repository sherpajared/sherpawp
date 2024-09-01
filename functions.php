<?php
/**
 * functions.php - we're gonna need a bigger boat.
 * 
 * @package sherpawp
 * 
 * Table of Contents
 * 
 * 1. Sherpawp Init {#sherpa-init}
 * 2. Sherpawp Custom Functions/Customizer (#sherpa-custom)
 * 3. Sherpa Includes (#sherpa-includes)
 * 
 * @todo Document all functionality
 * @todo Move code outside functions.php wherever possible
 * @todo Optimize asset loading
 * 
 * @return void
 * 
 */

/**************************************************
 * 1. Theme Setup Functions
 *************************************************/
/**
 * sherpa_init()
 * 
 * Enqueues style sheets and scripts. Adds theme support for widgets, 
 * menus, and thumbnail image size, as well as adding post-preview image size
 * 
 * @uses wp_enqueu_style() Add native style sheet and boostrap style sheet.
 * @uses wp_enqueue_script Add js necessary js from /assets
 * @uses add_theme_support Adds support for widgets and menus
 * @uses add_image_size Adds custom post size for post-preview
 * @uses register_nav_menus() Registers navigation menus
 * 
 * @return void
 * 
 * @hook init runs on WP initialization
 */
function sherpa_init(){
    if(!is_admin()){
        wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/css/bootstrap.min.css');
        wp_enqueue_style('systemcss', get_template_directory_uri().'/style.css');
        wp_enqueue_script('bootjs', get_template_directory_uri().'/assets/js/bootstrap.min.js');
        wp_enqueue_script('sticky-header', get_template_directory_uri() . '/assets/js/sticky-header.js', array('jquery'), null, true);
    }
    add_theme_support('widgets');
    add_theme_support('menus');
    add_theme_support('post-thumbnails');
    add_image_size('post-preview', 280, 180, true);
    register_nav_menus(
        array(
            'header-menu' => 'Header Menu', 
            'footer-menu' => 'Footer Menu',
            'sidebar-menu' => 'Sidebar Menu'
        )
    );
    // register sidebars
}
add_action('init', 'sherpa_init');

/**
 * custom_admin_styles()
 * 
 * adds stylesheet for WP backend
 * 
 * @uses wp_enqueue_style() includes admin-style.css in WP backend
 * 
 * @return void
 * 
 * @hook admin_enqueue_scripts Runs when loading WP backend
 */

function custom_admin_styles() {
    wp_enqueue_style( 'admin-custom-style', get_template_directory_uri() . '/assets/css/admin-style.css' );
}
add_action( 'admin_enqueue_scripts', 'custom_admin_styles' );
/**************************************************
 * 2. Sherpawp Custom Functions/Customizer
 *************************************************/
/**
 * Widgets
 * 
 * Creates 3 sidebar widgets that can be used on the site
 * 
 * @uses register_sidebar
 * 
 * @param widget details
 * 
 * @todo Add Widgets to offer additional functionality
 * @todo move widgets entirely to their own file (widgets.php)
 * 
 * @return void
 * 
 * @hook widgets_init, when widgets are initialized
 */

add_action( 'widgets_init', function(){    
        register_sidebar( array(
            'id'            => 'sidebar-1',
            'name'          => 'Primary Sidebar', 'sherpawp',
            'description'   => 'A short description of the sidebar.',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) ); 
        register_sidebar( array(
            'id'            => 'footer-sidebar-1',
            'name'          => 'Footer Sidebar1', 'sherpawp',
            'description'   => 'A short description of the sidebar.',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
        register_sidebar( array(
            'id'            => 'footer-sidebar-2',
            'name'          => 'Footer Sidebar-2', 'sherpawp',
            'description'   => 'A short description of the sidebar.',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
});

/**
 * sherpa_custom_logo_setup()
 * 
 * adds inherent attributes to custom logo
 * 
 * @uses add_theme_support for custom logo with specified styles and attributes
 * @return void
 * 
 * @hook after_setup_theme, follows init funcitons 
 */
function sherpa_custom_logo_setup(){
    $defaults = array(
        'height'                => 100,
        'width'                 => 400,
        'flex-height'           => true,
        'flex-width'            => true,
        'header-text'           => array('site-title', 'site-description'),
        'unlink-homepage-logo'  => false,
    );
    add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'sherpa_custom_logo_setup');

/**
 * sherpawp_customize_register
 * 
 * @param $wp_customize - native WP when hook runs
 * 
 * @todo Add customizable Contact form
 * @todo Add modifiable sections to the footer
 * @todo Select Font
 * @todo Specify color location
 * 
 * @hook customize_register
 */
function sherpawp_customize_register( $wp_customize ){


    /* * * IMAGE SLIDER * * *
    *   Set Slider attributes
    * Set Placeholder
    * Set images
    * * * * * * * * * * * * */
    $wp_customize -> add_section( 'sherpawp_slider_settings', array(
        'title'             => __('Slider Image Settings'),
        'description'       => __('Edit slider image settings'),
        //'panel'             =>
        'priority'          => 160,
        'capability'        => 'edit_theme_options',
        //'theme_supports'    => 
    ));
    $wp_customize->add_setting( 'setting_id', array(
        'type' => 'theme_mod', // or 'option'
        'capability' => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
        'default' => '',
        'transport' => 'refresh', // or postMessage
        'sanitize_callback' => 'sanitize_text_field',
        //'sanitize_js_callback' => '', // Basically to_json.
    ) );
    $wp_customize->add_control( 'setting_id', array(
        'type' => 'text',
        // Within the section.'priority' => 10, 
        'section' => 'Slider Image Settings', // Required, core or custom.
        'label' => __( 'Some text' ),
        'description' => __( 'This is a date control with a red border.' ),
        'input_attrs' => array(
          'class' => 'my-custom-class-for-js',
          'style' => 'border: 1px solid #900',
          'placeholder' => __( 'mm/dd/yyyy' ),
        ),
      ) );
    /**
     * Color Selector
     * 
     * @var primary_color string - set with color selector
     * @var secondary_color string - set with color selector
     * @var accent_color string - set with color selector
     * 
     *  
     *  */  
    /******************
     * Customizer:
     * Color Selector
     * creates css variables based on Colors selected:
     * var(--primary-color),    var(--primary-color-r/g/b)
     * var(--secondary-color),  var(--secondary-color-r/g/b)
     * var(--accent-color),     var(--accent-color-r/g/b)
    */
    $wp_customize->add_setting('primary_color', array(
        'default'   => '#3498db',
        'transport' => 'refresh',
    ));

    $wp_customize->add_setting('secondary_color', array(
        'default'   => '#2ecc71',
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('accent_color', array(
        'default'   => '#ababab',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color_control', array(
        'label'    => __('Primary Color', 'sherpawp'),
        'section'  => 'colors',
        'settings' => 'primary_color',
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color_control', array(
        'label'    => __('Secondary Color', 'sherpawp'),
        'section'  => 'colors',
        'settings' => 'secondary_color',
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color_control', array(
        'label'    => __('Accent Color', 'sherpawp'),
        'section'  => 'colors',
        'settings' => 'accent_color',
    )));
    /* END CUSTOM COLORS */
    /* FOOTER SETTINGS 
    *   Content 
    *   Background & Text Colors
    */
    $wp_customize->add_section( 'sherpawp_footer_settings', array(
        'title'       => __( 'Footer Settings', 'sherpawp' ),
        'description' => __( 'Customize the footer area', 'sherpawp' ),
        'priority'    => 160,
    ) );

    // Add setting for footer background color
    $wp_customize->add_setting( 'footer_background_color', array(
        'default'   => '#333333',
        'transport' => 'refresh',
    ) );

    // Add control for footer background color
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_background_color_control', array(
        'label'    => __( 'Footer Background Color', 'sherpawp' ),
        'section'  => 'sherpawp_footer_settings',
        'settings' => 'footer_background_color',
    ) ) );

    // Add setting for footer text color
    $wp_customize->add_setting( 'footer_text_color', array(
        'default'   => '#ffffff',
        'transport' => 'refresh',
    ) );

    // Add control for footer text color
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_text_color_control', array(
        'label'    => __( 'Footer Text Color', 'sherpawp' ),
        'section'  => 'sherpawp_footer_settings',
        'settings' => 'footer_text_color',
    ) ) );

    // Add setting for footer text
    $wp_customize->add_setting( 'footer_text', array(
        'default'           => __( '© 2024 My Website', 'sherpawp' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    // Add control for footer text
    $wp_customize->add_control( 'footer_text_control', array(
        'label'    => __( 'Footer Text', 'sherpawp' ),
        'section'  => 'sherpawp_footer_settings',
        'settings' => 'footer_text',
        'type'     => 'text',
    ) );
    /* End Footer Settings */
    /* Customize Hero Banners 
    *   $heroes contains a list of all hero-banner types
    *   Based on post types, i.e. 
    *            $hero_type = null;
    *            if(is_home()){
    *                $hero_type = "home";
    *            }
    *            else if(get_post_type() == "project"){
    *                $hero_type = "projects";
    *            }
    *            echo $hero_type . 'hero-part';
    *    
    */
    $heroes = ['home', 'projects'];
    $wp_customize->add_section('hero_section', array(
        'title' => __('Hero Section', 'sherpawp'),
        'priority' => 30,
    ));
    foreach($heroes as $hero){
        $wp_customize->add_setting($hero . '_title', array(
            'default'   =>  'Welcome to Our Website',
            'transport' =>  'refresh',
        ));
        $wp_customize->add_setting($hero . '_subtitle', array(
            'default'   =>  'Your Success, Our Commitment',
            'transport' =>  'refresh',
        ));
        $wp_customize->add_setting($hero . '_button_text', array(
            'default'   =>  'Learn More',
            'transport' =>  'refresh',
        ));
        $wp_customize->add_control($hero . '_title_control', array(
            'label'     =>  __(ucfirst($hero) . ' Title', 'sherpawp'),
            'section'   => 'hero_section',
            'settings'  => $hero . '_title',
        ));
        $wp_customize->add_control($hero . '_subtitle_control', array(
            'label'     =>  __(ucfirst($hero) . ' Subtitle', 'sherpawp'),
            'section'   =>  'hero_section',
            'settings'  =>  $hero . '_subtitle',
        ));
        $wp_customize->add_control($hero . '_button_control', array(
            'label'     => __(ucfirst($hero) . ' Button', 'sherpawp'),
            'section'   =>  'hero_section',
            'settings'  =>  $hero . '_button_text',
        ));
    }
    /**
     * Thank You 
     * 
     * 
     */
    $wp_customize->add_section('thank_you_section', array(
        'title'     => __('Thank You Template', 'sherpawp'),
        'priority'  => 30,
    ));
    $wp_customize->add_setting('thank_you_header', array(
        'default'   => 'We have recieved your submission.',
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('thank_you_excerpt', array(
        'default'   => 'We will reach out to you as soon as possible!',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('thank_you_header_control', array(
        'label'     => 'Thank You Header',
        'section'   => 'thank_you_section',
        'settings'  =>  'thank_you_header',
    ));
    $wp_customize->add_control('thank_you_excerpt_control', array(
        'label'     => 'Thank You Excerpt',
        'section'   => 'thank_you_section',
        'settings'  => 'thank_you_excerpt',
        'type'      => 'textarea',
    ));

}
add_action('customize_register', 'sherpawp_customize_register');

/* * * * * * WP_HEAD * * * * * *
* Creates CSS Variables for each of the colors selected in customizer
* Standalone color + rgb for each color:
* var(--primary-color),    var(--primary-color-r/g/b)
* var(--secondary-color),  var(--secondary-color-r/g/b)
* var(--accent-color),     var(--accent-color-r/g/b)
*/
function sherpawp_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#3498db');
    $secondary_color = get_theme_mod('secondary_color', '#2ecc71');
    $accent_color = get_theme_mod('accent_color', '#ababab');
    // hex_to_rgb defined directly after this function - splits the hex into 3 rgb values
    $primary_rgb = hex_to_rgb($primary_color);
    $secondary_rgb = hex_to_rgb($secondary_color);
    $accent_rgb = hex_to_rgb($accent_color);
    
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
            --primary-color-r: <?php echo $primary_rgb[0]; ?>;
            --primary-color-g: <?php echo $primary_rgb[1]; ?>;
            --primary-color-b: <?php echo $primary_rgb[2]; ?>;
            
            --secondary-color: <?php echo esc_attr($secondary_color); ?>;
            --secondary-color-r: <?php echo $secondary_rgb[0]; ?>;
            --secondary-color-g: <?php echo $secondary_rgb[1]; ?>;
            --secondary-color-b: <?php echo $secondary_rgb[2]; ?>;
            
            --accent-color: <?php echo esc_attr($accent_color); ?>;
            --accent-color-r: <?php echo $accent_rgb[0]; ?>;
            --accent-color-g: <?php echo $accent_rgb[1]; ?>;
            --accent-color-b: <?php echo $accent_rgb[2]; ?>;
        }
    </style>
    <?php
}
add_action('wp_head', 'sherpawp_customizer_css');
/* * * * * * END WP_HEAD * * * * * */
function hex_to_rgb($hex) {
    $hex = ltrim($hex, '#');
    if (strlen($hex) == 6) {
        list($r, $g, $b) = array(substr($hex, 0, 2), substr($hex, 2, 2), substr($hex, 4, 2));
    } elseif (strlen($hex) == 3) {
        list($r, $g, $b) = array(str_repeat(substr($hex, 0, 1), 2), str_repeat(substr($hex, 1, 1), 2), str_repeat(substr($hex, 2, 1), 2));
    } else {
        return false;
    }
    $r = hexdec($r);
    $g = hexdec($g);
    $b = hexdec($b);
    return array($r, $g, $b);
}
/* * * * * * END WP_HEAD ADD ON * * * * * */
/**
 * sherpa_def_image_size
 * @param $image - Image
 * @param $container_height 
 * @param $type - determines if output is an element or inline style
 * @param $redirect - adds a src for href
 * @todo refactor - Used in nav.php for logo, confusing and unneccessary functionality
 */
function sherpa_def_image_size($image, $container_height, $type, $redirect=''){
    // Check if the input is an ID or a URL
    if (is_numeric($image)) {
        $image_out = wp_get_attachment_image_src($image, 'full');
    } else {
        // Assuming it's a URL, get image size directly from the file
        $image_info = getimagesize($image);
        $image_out = array($image, $image_info[0], $image_info[1]);  // URL, width, height
    }

    $width = ($image_out[1] * $container_height) / $image_out[2];

    if ($type == 0) {
        return 'style="width: '. $width . 'px;"';
    }
    if ($type == 1) {
        if ($redirect != '') {
            return '<a href="' . esc_url($redirect) . '"><img src="' . esc_url($image_out[0]) . '" style="width:' . $width . 'px;"></a>';
        } else {
            return '<img src="' . esc_url($image_out[0]) . '" style="width:' . $width . 'px;">';
        }
    }
}
//Callable functions
function the_placeholder_image($size = 'post-thumbnail', $attr = '', $class = '') {

    $placeholder_url = get_template_directory_uri() . '/assets/img/placeholders/sherpa1080p.png';
        
    // Determine the size attributes for the placeholder image
    $sizes = array(
        'thumbnail' => array(320, 180),   // 16:9 aspect ratio
        'medium' => array(640, 360),      // 16:9 aspect ratio
        'medium_large' => array(768, 432),// 16:9 aspect ratio
        'large' => array(1024, 576),      // 16:9 aspect ratio
        'full' => array(1920, 1080),      // 16:9 aspect ratio (HD resolution)
    );

    $width = isset($sizes[$size][0]) ? $sizes[$size][0] : '';
    $height = isset($sizes[$size][1]) ? $sizes[$size][1] : '';

    // Add width and height attributes if specified
    $size_attr = '';
    if ($width) {
        $size_attr .= 'width="' . $width . '" ';
    }
    if ($height) {
        $size_attr .= 'height="' . $height . '" ';
    }

    echo '<img src="' . esc_url($placeholder_url) . '" ' . $size_attr;

    // Add additional attributes from $attr parameter
    if (!empty($attr)) {
        foreach ($attr as $key => $value) {
            echo $key . '="' . esc_attr($value) . '" ';
        }
    }

    echo 'alt="' . esc_attr(get_the_title()) . '">';
}
function handle_custom_form_submission() {
    global $wpdb;

    // Check if the nonce is valid
    if (!isset($_POST['custom_form_nonce']) || !wp_verify_nonce($_POST['custom_form_nonce'], 'custom_form_action')) {
        wp_die('Security check failed.');
    }

    // Collect and sanitize all form data
    $submission_data = array();
    foreach ($_POST as $field_key => $field_value) {
        if ($field_key !== 'action' && $field_key !== '_wpnonce') {
            $submission_data[$field_key] = sanitize_text_field($field_value);
        }
    }

    // Convert the sanitized form data to JSON
    $json_data = wp_json_encode($submission_data);
    $form_id = 1; // Example form ID, change it as needed

    // Insert the JSON data into the custom table
    $result = $wpdb->insert(
        $wpdb->prefix . 'form_submissions',
        array(
            'form_id' => $form_id,
            'submission_data' => $json_data,
        ),
        array('%d', '%s')
    );

    // Check if insertion was successful
    if ($result === false) {
        error_log('Database insertion failed: ' . $wpdb->last_error);
        wp_die('There was an error processing your submission. Please try again.');
    } else {
        error_log('Database insertion succeeded: ' . print_r($wpdb->insert_id, true));
    }
    // Redirect after processing
    wp_redirect(home_url('/thank-you'));
    exit;
}
add_action('admin_post_custom_form_submission', 'handle_custom_form_submission');
add_action('admin_post_nopriv_custom_form_submission', 'handle_custom_form_submission');
function fetch_form_submissions() {
    global $wpdb;

    $form_id = isset($_POST['form_id']) ? intval($_POST['form_id']) : 0;
    $table_name = $wpdb->prefix . 'form_submissions';

    $submissions = $wpdb->get_results(
        $wpdb->prepare("SELECT * FROM $table_name WHERE form_id = %d ORDER BY submission_time DESC", $form_id)
    );

    if (!empty($submissions)) {
        foreach ($submissions as $submission) {
            // Decode the JSON data
            $data = json_decode($submission->submission_data, true);

            // Display each field from the submission
            foreach ($data as $field_key => $field_value) {
                if ($field_key !== 'custom_form_nonce' && $field_key !== '_wp_http_referer') {
                    echo '<p><strong>' . esc_html(ucfirst($field_key)) . ':</strong> ' . esc_html($field_value) . '</p>';
                }
            }

            echo '<p><strong>Submitted on:</strong> ' . esc_html($submission->submission_time) . '</p><hr>';
        }
    } else {
        echo '<p>No submissions found for this form.</p>';
    }

    wp_die();
}
add_action('wp_ajax_fetch_form_submissions', 'fetch_form_submissions');
add_action('wp_ajax_nopriv_fetch_form_submissions', 'fetch_form_submissions');
// Add CPTS
// Register Projects Custom Post Type
function CONSOLE_DEBUG($message){
    echo '<script>console.log("' . $message . '");</script>';
}

function enqueue_custom_scripts() {
    //wp_enqueue_script('sticky-header', get_template_directory_uri() . '/js/sticky-header.js', array(), null, true);
    wp_enqueue_script('navbar-js', get_template_directory_uri() . '/assets/js/navbar-vp-optimize.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
    //wp_enqueue_script();
require get_template_directory().'/template-parts/walker.php';
require get_template_directory().'/template-parts/widgets.php';
require get_template_directory().'/cpts/project-cpt.php';
require get_template_directory().'/includes/theme-init.php';
require get_template_directory().'/includes/form-builder.php';
?>