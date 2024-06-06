<div class="p-4 text-center justify-content-center">
  <div style="text-align: center;">
  <?php
      		$post_id = get_the_ID();
          $views = (int)get_post_meta($post_id, 'views', true);
          update_post_meta($post_id, 'views', $views+1);
          $views = (int)get_post_meta($post_id, 'views', true);
          echo "Views: " . $views . "<br>";
  ?>
  <?php the_post_thumbnail('post-thumbnail', [
    'style'=> 'width: 50%; height: 100%; display: inline-block; margin-top: 1em;']); ?>
  </div>
  <div class="body">
    
    <h5 class="title"><?php the_title()?></h5>
    <p class="text center"><?= substr(get_the_excerpt(), 0, 50)?></p>
    <a href="<?php the_permalink()?>" class="btn btn-primary">Read More</a>
  </div>
  <p></p>
</div>