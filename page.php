<?php
    get_header();
     
            
            if(is_home()){    
                get_template_part('template-parts/image-slider');
            }
            ?>
            <div class="p-4 card-group gap justify-content-center">
<div class="m-4">
  <?php the_post_thumbnail('post-preview'); ?>
  <div class="card-body">
    <h5 class="card-title"><?php the_title()?></h5>
    <p class="card-text"><?php the_content();?></p>
    <a href="<?php the_permalink()?>" class="btn btn-primary">Read More</a>
  </div>
</div>
</div>
<?php get_footer()?>