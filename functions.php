<?php
    
function sherpa_init(){
    if(!is_admin()){
        wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/css/bootstrap.min.css');
        wp_enqueue_style('systemcss', get_template_directory_uri().'/style.css');
        wp_enqueue_script('bootjs', get_template_directory_uri().'/assets/js/bootstrap.min.js');
        wp_enqueue_script('sticky-header', get_template_directory_uri() . '/assets/js/sticky-header.js');
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
function sherpawp_customize_register( $wp_customize ){

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
    /* Customizer for Custom Colors to use in CSS */
    $wp_customize->add_setting('primary_color', array(
        'default'   => '#3498db',
        'transport' => 'refresh',
    ));

    $wp_customize->add_setting('secondary_color', array(
        'default'   => '#2ecc71',
        'transport' => 'refresh',
    ));

    // Add controls
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color_control', array(
        'label'    => __('Primary Color', 'mytheme'),
        'section'  => 'colors',
        'settings' => 'primary_color',
    )));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color_control', array(
        'label'    => __('Secondary Color', 'mytheme'),
        'section'  => 'colors',
        'settings' => 'secondary_color',
    )));
}
add_action('customize_register', 'sherpawp_customize_register');
//Add Custom Colors to head
function sherpawp_custom_colors() {
    // Get the colors from the customizer settings
    $primary_color = get_theme_mod('primary_color', '#3498db');
    $secondary_color = get_theme_mod('secondary_color', '#2ecc71');

    // Output the colors as CSS variables
    echo "<style>
        :root {
            --primary-color: $primary_color;
            --secondary-color: $secondary_color;
        }
    </style>";
}
add_action('wp_head', 'sherpawp_custom_colors');

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
function enqueue_custom_scripts() {
    wp_enqueue_script('sticky-header', get_template_directory_uri() . '/js/sticky-header.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
    //wp_enqueue_script();
require get_template_directory().'/template-parts/walker.php';
require get_template_directory().'/template-parts/widgets.php';

?>