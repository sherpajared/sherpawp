<?php
    get_header();

    
            if(is_home()){    
                get_template_part('template-parts/image-slider');
            }
            ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="p-4 card-group gap justify-content-center col-md" style="align-items: flex-start;">
                    <?php
                        
                        $args = ['post_type' => 'post'];
                        $myposts = new WP_Query($args);
                        if($myposts->have_posts()){
                            while($myposts->have_posts()){
                                $myposts->the_post();
                                get_template_part('template-parts/post'); 

                            }
                        }
                        wp_reset_postdata();
                        
                    ?>
                </div>
               <div class="col-lg-2 bg-light p-2">
                    <?php dynamic_sidebar( 'sidebar-1' );?>
                </div>
            </div>
                    </div>
        <?php get_template_part('template-parts/pagination');?>
        <?php get_footer()?>


