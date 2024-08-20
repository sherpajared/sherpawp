<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title('<h1 class="entry-title">', '</h1>'); ?>
            </header><!-- .entry-header -->
            <div class="project-content">
                <?php
                    the_content();
                    $HAS_CAPTION = false;
                // Include template parts for project details and images
                    if ($HAS_CAPTION){ ?>
                        <div class="detail-section">
                            <?php get_template_part('template-parts/content', 'project-details'); ?>
                        </div><!-- .detail-section -->
                        <div class="gallery-1">
                            <?php get_template_part('template-parts/content', 'project-images'); ?>
                        </div><!-- .gallery-1 -->
                <?php
                    }
                    else{ ?>
                        <div class="gallery-2">
                            <?php get_template_part('template-parts/content', 'project-images'); ?>
                        </div><!-- .gallery-2 --><?php
                    }
                ?>
                </div><!-- .project-contentt -->
            </article><!-- #post-<?php the_ID(); ?> -->
        <?php endwhile; // End loop through posts (project). ?>
    </main><!-- #main .site-main -->
</div><!-- #primary .content-area -->

<?php get_footer(); ?>
