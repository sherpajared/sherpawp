<?php
/**
 * home.php
 * 
 * The home-page, template used in place of front-page. User redirected here from clicking the navbar logo,
 * or anywhere that redirects to the home url.
 * 
 * @package sherpawp
 * 
 * @uses get_header()
 * @uses get_template_part('template-parts/hero')
 * @uses get_template_part('template-parts/conten-project) - Displays all projects
 * @uses get_footer()
 * 
 * @todo Add more click-through content to the homepage
 * @todo relocate  <style> content to style.css or elsewhere.
 *
 */
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