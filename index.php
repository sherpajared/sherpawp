<?php
/**
 *  index.php
 *  
 * Final fallback template when no other template matches the page query
 * 
 * Displays all posts as cards with a sidebar menu. If it is the homepage, 
 * an image slider is displayed at the top. Adds pagination for navigating posts.
 * 
 * @package sherpawp
 * 
 * @uses get_header()
 * 
 * @uses get_template_part('template-parts/image-slider')
 * @uses get_template_part('template-parts/post')
 * @uses Widget: dynamic_sidebar  
 * @uses get_template_part('template-parts/pagination')
 * 
 * @uses get_footer() 
 * 
 * @var WP_Query $myposts Query object for retrieving posts.
 * 
 */    

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
        </div> <!-- .p-4.card-group.gap.justify-content-center.col-md -->
    </div> <!-- .row -->
</div> <!-- .container-fluid -->
<?php get_template_part('template-parts/pagination');?>
<?php get_footer()?>


