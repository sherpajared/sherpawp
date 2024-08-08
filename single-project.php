<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
                </header><!-- .entry-header -->

                <section class="project-content">
                    <?php
                    the_content();
                    $HAS_CAPTION = false;
                    ?>

                    <?php
                    // Include template parts for project details and images
                    if ($HAS_CAPTION){
                        ?>
                        <div class="detail-section">
                            <?php get_template_part('template-parts/content', 'project-details'); ?>
                        </div>
                        <div class="gallery-1">
                            <?php get_template_part('template-parts/content', 'project-images'); ?>
                        </div>
                    <?php
                    }else{ ?>
                        <div class="gallery-2">
                            <?php get_template_part('template-parts/content', 'project-images'); ?>
                        </div><?php
                    }
                    
                    

                    ?>
                </div><!-- .entry-content -->
            </article><!-- #post-<?php the_ID(); ?> -->
        <?php endwhile; // End of the loop. ?>
    </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
