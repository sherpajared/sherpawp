<div class="p-4 text-center justify-content-center">
  <div style="text-align: center;">
  <?php the_post_thumbnail('post-thumbnail', [
    'style'=> 'width: 50%; height: 100%; display: inline-block;']); ?>
  </div>
  <div class="body">
    <h5 class="title"><?php the_title()?></h5>
    <p class="text"><?= substr(get_the_excerpt(), 0, 50)?></p>
    <a href="<?php the_permalink()?>" class="btn btn-primary">Read More</a>
  </div>
</div>