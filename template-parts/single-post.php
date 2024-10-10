<div class="p-4 text-center justify-content-center">
  <div style="text-align: center;">
  <?php
    $post_id = get_the_ID();
    $views = (int)get_post_meta($post_id, 'views', true);
    update_post_meta($post_id, 'views', $views+1);
    $views = (int)get_post_meta($post_id, 'views', true);
    echo "Views: " . $views . "<br>";
  ?>
  <?php 
    if (has_post_thumbnail($post->ID)) {
      // If post has thumbnail, display it
      if(get_post_type() != 'projects'){
        echo "who shotcha";
        the_post_thumbnail($size);
      }
    } 
    else {
        // If no thumbnail, display placeholder image
        echo '<img src="' . get_template_directory_uri() . '/assets/img/placeholders/sherpa3-2.png" alt="' . get_the_title() . '" />';
    } 
  ?>
  </div>
  <div class="body">
    <h5 class="title"><?php the_title()?></h5>
    <p class="text center"><?= substr(get_the_excerpt(), 0, 50)?></p>
    <a href="<?php the_permalink()?>" class="btn btn-primary sherpa-color">Read More</a>
  </div>
  <p></p>
</div>