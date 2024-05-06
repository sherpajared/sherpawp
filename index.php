<?php
    get_header();
     
            get_template_part('template-parts/nav');
            if(is_home()){    
                get_template_part('template-parts/image-slider');
            }
            ?>
            <div class="p-4 card-group gap justify-content-center">
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
        <?php get_template_part('template-parts/pagination');?>
        <?php get_footer()?>


