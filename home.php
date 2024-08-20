<?php
    get_header();
    get_template_part('template-parts/hero'); 
?>
<style>
    .home-container{
        width: 80%;
        margin: auto;
        padding: auto;
    }
</style>
<div class="home-container content-project-container">
    <?php get_template_part('template-parts/content-project'); ?>
</div><!-- .home-container.content-project-container -->
<?php
    get_footer();