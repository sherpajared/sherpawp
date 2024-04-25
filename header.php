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
        <?php wp_body_open();
    ?>