<div class="card p-4 shadow border" style="max-width: 25em;">
  <div style="text-align: center;">
  <?php the_post_thumbnail('post-preview'); ?>
</div>
  <div class="card-body">
    <h5 class="card-title"><?php the_title()?></h5>
    <p class="card-text"><?= substr(get_the_excerpt(), 0, 50)?></p>
    <a href="<?php the_permalink()?>" class="btn btn-primary">Read More</a>
  </div>
</div>