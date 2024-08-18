<!DOCTYPE html>
<html <?php language_attributes();?>>
    <head>
        <meta charset="<?php bloginfo('charset')?>">
        <meta name="description" content="<?php blogInfo('description')?>">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri()."/assets/css/nanoscroller.css"?>">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() . "/assets/css/slick.css";?>">
        <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() . "/assets/css/slick-theme.css";?>">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        
        <script src="<?php echo get_template_directory_uri().'/assets/js/slick.min.js'?>"></script>
        <script src="<?php echo get_template_directory_uri().'/assets/js/slick.js'?>"></script>
        <script src="<?php echo get_template_directory_uri().'/assets/js/nanoscroller.js'?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

        <title><?php bloginfo('name')?></title>
        <?php wp_head()?>
    </head>

    <!-- 'NavBar' - Bootstrap>Components-->   
    <body <?php body_class()?>>
        
        <?php get_template_part('template-parts/nav'); ?>

        <?php wp_body_open();
    ?>