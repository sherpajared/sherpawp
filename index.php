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
     
            get_template_part('template-parts/nav');
            get_template_part('template-parts/image-slider');
            ?>
            <div class="p-4 card-group gap">
        <?php
            // show posts as default content
            if(have_posts()){
                while(have_posts()){
                    the_post();
                    get_template_part('template-parts/post');

                }
            }
        ?>
        </div>

        <?php wp_footer()?>
    </body>
</html>

