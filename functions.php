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
        
    }
    add_action('init', 'sherpa_init')

    
    //wp_enqueue_script();
?>