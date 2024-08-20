<?php
/**
 * single.php
 * Template for displaying a list of posts
 * 
 * Uses bootstrap classes to display all posts as cards
 * 
 * @package sherpawp
 */
    get_header(); 
?>
<div class="p-4 card-group gap justify-content-center">
    <?php
        // show posts as default content
        if(have_posts()){
            while(have_posts()){
                the_post();
                get_template_part('template-parts/single-post');
            }
        }
    ?>
</div>

<?php get_footer()?>


