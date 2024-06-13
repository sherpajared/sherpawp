<!DOCTYPE html>
<html <?php language_attributes();?>>
    <head>
        <meta charset="<?php bloginfo('charset')?>">
        <meta name="description" content="<?php blogInfo('description')?>">
        <title><?php bloginfo('name')?></title>
        <?php wp_head()?>
    </head>

    <!-- 'NavBar' - Bootstrap>Components-->   
    <body <?php body_class()?>>
        <?php get_template_part('template-parts/nav'); ?>

        <?php wp_body_open();
    ?>