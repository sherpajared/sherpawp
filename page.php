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
      <div class="header-container">
      <h1 class="content-header"><?php the_title()?></h5>
</div>
  <div class="blocker">
      <?php the_content();?>




<?php get_footer()?>