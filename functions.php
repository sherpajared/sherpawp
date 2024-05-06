<?php
    
function sherpa_init(){
    if(!is_admin()){
        wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/css/bootstrap.min.css');
        wp_enqueue_style('systemcss', get_template_directory_uri().'/style.css');
        wp_enqueue_script('bootjs', get_template_directory_uri().'/assets/js/bootstrap.min.js');
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
}
add_action('init', 'sherpa_init');

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
    //wp_enqueue_script();
require get_template_directory().'/template-parts/walker.php';

?>