<!DOCTYPE html>
<html <?php language_attributes();?>>
    <head>
        <meta charset="<?php bloginfo('charset')?>">
        <meta name="description" content="<?php blogInfo('description')?>">
        <title><?php bloginfo('name')?></title>
        <?php wp_head()?>
    </head>
    <body <?php body_class()?>>
        <?php wp_body_open()?>
        <h1>this is my index page</h1>


        <?php wp_footer()?>
    </body>
</html>

