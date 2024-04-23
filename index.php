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
    <!-- 'NavBar' - Bootstrap>Components-->    
        
        
        <?php
            get_template_part('template-parts/nav');
            // show posts as default content
            if(have_posts()){
                while(have_posts()){
                    the_post();
                    ?><h1><?php the_title()?></h1>
                    <p><?php the_excerpt()?></p>
                    <p><a href="<?php the_permalink();?>"><?php the_title();?></a></p>
                    <br>
                    <?php
                }
            }
        ?>

        <?php wp_footer()?>
    </body>
</html>

