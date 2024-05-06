<?php
    get_header();
     
            get_template_part('template-parts/nav');
            
            ?>
        <div class="p-4 gap justify-content-center mx-auto" style="max-width: 50%;">
        <?php
            // show posts as default content
        ?>
        <h2>Sorry, we couldn't find what you're looking for.</h2><br>
        <h3>Try to search something below:</h3><br>
        <form class="d-flex" action="<?= get_home_url()?>" style="max-width: 80%;">
        <input name="s" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button></form>
        </div>
        <?php get_footer()?>


