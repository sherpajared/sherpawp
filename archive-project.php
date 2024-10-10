<?php 
/**
 * archive-project.php 
 * 
 * Page to display all projects in an archive for users to navigate to individual projects
 * 
 * @uses get_header()
 * @uses get_template_part('template-parts/hero')
 * @uses get_footer()
 * 
 * @todo Add filtering functionality by category. 
 */
    get_header();
    get_template_part('template-parts/hero');
    ?>
    <div class="sherpa-div-body content-project-container">
        <?php get_template_part('template-parts/content-project'); ?>
    </div>
        <?php
    get_footer();
