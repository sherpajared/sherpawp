<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(); ?>
         
    </div><!-- .entry-content -->

    <?php
    // Display custom fields or additional project details as needed
    ?>

    <footer class="entry-footer">
        <?php
        // Display edit link if user is logged in
        edit_post_link( __( 'Edit', 'textdomain' ), '<span class="edit-link">', '</span>' );
        ?>
    </footer><!-- .entry-footer -->
</article><!-- #post-## -->
