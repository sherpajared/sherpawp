<?php

/**
 *  content-project.php  
 * 
 * Generates Project grid, starting with a featured product and filling in with the rest of projects
 * Hovering a project gives it a black blur with title and excerpt
 * 
 * Used in: archive-project.php 
 * 
 * @todo Create product filter that can hide projects missing a certain category
 *          -Likely use an attribute with defining characteristics on container 
 * 
 * @var $freatured_args array - gets a list of Featured projects
 * @var $args array - gets a list of all projects
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    ?>
    <div class="binder project-archive">
    <div class="sherpa-module-container">
        <div class="sherpa-text-block sherpa-col">
            <div class="sherpa-header">        
                <h2><?php echo (get_theme_mod('project_gallery_title')) ? (get_theme_mod('project_gallery_title', $default_value="true")) : ('Our Projects'); ?></h2>
            </div>
            <div class="sherpa-p">
                <p><?php echo (get_theme_mod('project_gallery_caption')) ? (get_theme_mod('project_gallery_caption', $default_value="true")) : ('These are our projects'); ?></p>  
            </div>
        </div>
</div>
<div class="sherpa-module-container">
    <h1 class="sherpa-header primary">Check out our work</h1>
    <div class="projects-grid">
        <?php
        // Query and Loop for projects
        $featured_args = array(
            'post_type' => 'project',
            'posts_per_page' => -1, // Get all featured projects
            'tax_query' => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'slug',
                    'terms'    => 'project-featured', // Replace with the actual slug of your "Featured" category
                ),
            ),
        );
        $featured_projects_query = new WP_Query($featured_args);
        $args = array(
            'post_type' => 'project',
            'posts_per_page' => -1, // Get all projects
        );
        $projects_query = new WP_Query($args);
        /**
         * Populate grid
         * First checks if there are any Featured posts.
         * If there are featured posts, adds the first in the list to a 2x2 space on the grid.
         * Then continues to populate the grid regularly, skipping the first featured image.
         * 
         */
        if ($projects_query->have_posts()) :
            $primary_post = null;
            $primary_id = null;
            if ($featured_projects_query->have_posts()) {
                $posts = $featured_projects_query->posts;
                $primary_post = $posts[0];
                $primary_id = $primary_post->ID;
                $featured_projects_query->the_post();
                ?>
                <div class="project-block-hover project-item featured">
                    <a class="anchor-container-hover" href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail(); ?>
                        <div class="block-hover-caption">
                            <div class="blur"></div>
                            <div class="hover-caption-text">
                                <h1><?php the_title();?></h1>
                                <?php if(the_excerpt()) {echo '<p>' . the_excerpt() . '</p>';}?>
                            </div> <!-- .hover-caption-text -->
                        </div> <!-- .block-hover-caption -->
                    </a> <!-- .anchor-container-hover -->
                </div>
                <?php
                // Reset post data after featured project loop
                wp_reset_postdata();
            }
            while ($projects_query->have_posts()) : $projects_query->the_post();
                if (get_the_ID() != $primary_id) { ?>   
                <div class="project-block-hover project-item">
                    <a class="anchor-container-hover" href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail(); ?>
                        <div class="block-hover-caption">
                            <div class="blur"></div>
                            <div class="hover-caption-text">
                                <h1><?php the_title();?></h1>
                                <?php if(!empty(the_excerpt())) {echo '<p>' . the_excerpt() . '</p>';}?>
                            </div> <!-- .hover-caption-text -->
                        </div> <!-- .block-hover-caption -->
                    </a>
                </div> <!-- .project-block-hover.project-item -->
                <?php }
            endwhile;
            wp_reset_postdata();
        else : ?>
            <p>No projects found.</p>
        <?php endif; ?>
        </div> <!-- .projects-grid -->
        </div>
    </div> <!-- .projects-archive -->
</article><!-- #post-## -->
