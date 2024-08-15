<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(); ?>
         
    </div><!-- .entry-content -->

    <?php
    
    ?>
        <div class="projects-archive">
        <h2>Our Projects</h2>
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
            
            if ($projects_query->have_posts()) :
                $primary_post;
                $primary_id;
                if($featured_projects_query->have_posts()){;
                    $posts = $featured_projects_query->posts;
                    $primary_post = $posts[0];
                    
                    $primary_id = $primary_post->ID;
                    $featured_projects_query->the_post();
                    
                    ?>
                    <div class="project-item primary-project">
                        <a href="<?php the_permalink()?>">
                            <?php the_post_thumbnail()?>
                    </a></div><?php
                }
                    
                while ($projects_query->have_posts()) : $projects_query->the_post(); 
                    if(get_the_ID() != $primary_id){ ?>   
                        <div class="project-item">
                            <a href="<?php the_permalink()?>">
                                <?php the_post_thumbnail() ?>
                                <h3><?php the_title(); ?></h3>
                            </a>
                        </div>
            <?php   } 
                 endwhile;
                wp_reset_postdata();
            else : ?>
                <p>No projects found.</p>
            <?php endif; ?>
        </div>
        </div>

    <footer class="entry-footer">
        <?php
        // Display edit link if user is logged in
        edit_post_link( __( 'Edit', 'textdomain' ), '<span class="edit-link">', '</span>' );
        ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
