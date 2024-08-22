<?php
/**
 * page.php
 *  
 * Default template for a page
 * 
 * If the current page is the home page (blog index), it includes the image slider.
 * Otherwise, it displays the page content with a card layout for posts.
 * @package sherpawp 
 * @uses    get_header()
 * @uses    get_footer()
 * @uses    get_template_part('template-parts/image-slider')
 * 
 */
  get_header(); 
  if(is_home()){    
      get_template_part('template-parts/image-slider');
  }
?>

    <?php the_post_thumbnail('post-preview'); ?>
    <div class="sherpa-div-body">
      <h5 class="card-title"><?php the_title()?></h5>
      <p class="card-text"><?php the_content();?></p>
      <a href="<?php the_permalink()?>" class="btn btn-primary">Read More</a>
    </div><!-- .cart-body -->


<?php get_footer()?>