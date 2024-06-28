<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <?php
        // Start the loop.
        while ( have_posts() ) : the_post();

            // Include the project content template.
            get_template_part('template-parts/content-project');

            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;

        // End the loop.
        endwhile;
        ?>
    </main><!-- #main -->
</div><!-- #primary -->


<?php get_footer(); ?>
