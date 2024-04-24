<?php
    
    function sherpa_init(){
        wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/css/bootstrap.min.css');
        wp_enqueue_style('systemcss', get_template_directory_uri().'/style.css');
        wp_enqueue_script('bootjs', get_template_directory_uri().'/assets/js/bootstrap.min.js');
        
    }
    add_action('init', 'sherpa_init')

    
    //wp_enqueue_script();
?>