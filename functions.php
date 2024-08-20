<?php
/* * * * * * INIT * * * * * *
*   Enqueue Boostrap and native css files    
*   Enqueue Bootstrap scripts
*   Add widget, Menu and Thumbnail support
*   Register Nav menus
*   Custom Image size
*
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
/* * * * * * END INIT * * * * * */

/* * * * * * ADMIN_ENQUEUE_SCRIPTS * * * * * *
* Add admin-style.css for backend styling on CPT
*/
function custom_admin_styles() {
    wp_enqueue_style( 'admin-custom-style', get_template_directory_uri() . '/assets/css/admin-style.css' );
}
add_action( 'admin_enqueue_scripts', 'custom_admin_styles' );
/* * * * * * END ADMIN_ENQUEUE_SCRIPTS * * * * * */
/* * * * * * WIDGETS_INIT * * * * * *
*   Register Sidebar Widgets
*   Add widgets here
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
/* * * * * * END WIDGETS_INIT * * * * * */
/* * * * * * AFTER_THEME_SETUP * * * * * *
*   Adds default values for custom logo 
*       -Custom Logo Used in header
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
/* * * * * * END AFTER_THEME_SETUP * * * * * */
/* * * * * * CUSTOMIZE_REGISTER * * * * * *
* Add functionality to Customzie section in WP backend
*   -Image Slider Images
*   -Select Site Colors
*    -Generate Hero Banner Content
*    TODO:   Select Font
*            Select which colors to be used where
*            Revisit existing code to quicken load times
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

    /* 
    Add Controls
    Settings:   primary_color
                secondary_color
                accent_color    
    */
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
}
add_action('customize_register', 'sherpawp_customize_register');
/* * * * * * END CUSTOMIZE_REGISTER * * * * * */

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

function sherpa_def_image_size($image, $container_height, $type, $redirect=''){
    $image_out = wp_get_attachment_image_src($image, 'full');
    $width =($image_out[1]*$container_height)/$image_out[2];

    if($type == 0){
        return 'style="width: '. $width . 'px;"';
    }
    if($type == 1){
        if($redirect != ''){
            return '<a href= ' . $redirect . '<img src="' . $image_out[0] . '" style="width:' . $width . 'px;"></a>';
        }
        else{
            return '<img src="' . $image_out[0] . '" style="width:' . $width . 'px;">';
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
?>