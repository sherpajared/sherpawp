<div class="card p-4 shadow border" style="width: 5rem;">
  <img src="..." class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?php the_title()?></h5>
    <p class="card-text"><?= substr(get_the_excerpt(), 0, 50)?></p>
    <a href="<?php the_permalink()?>" class="btn btn-primary">Read More</a>
  </div>
</div>