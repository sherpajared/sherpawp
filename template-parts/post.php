<div class="card m-2 shadow border justify-content-center" style="width: 22em; max-width: 98%;">
  <div id="post-inner" style="text-align: center; margin-top: 1em;">
  <?php 
    if(has_post_thumbnail()){
      the_post_thumbnail('post-preview'); 
    }
    else{}
  ?>
</div><!-- #post-inner -->
  <div class="card-body">
    <h5 class="card-title text-center"><?php the_title()?></h5>
    <p class="text-muted text-center">
      <?php
        $cat = get_the_category();
        if(is_array($cat)){
          foreach($cat as $cat_obj){
            echo '<a href="'.$cat_obj->taxonomy.'/'.$cat_obj->slug.'">'.$cat_obj->name.'</a>';
          }
        }
      ?>
    </p> <!-- .text-muted.text-center -->
   
    <p class="text-muted text-center"><?php the_time("F Y")?></p>
    <p class="card-text"><?= substr(get_the_excerpt(), 0, 150)?></p>
    <a href="<?php the_permalink()?>" class="btn btn-primary">Read More</a>
  </div> <!-- .card-body -->
</div> <!-- .card.m-2.shadow.border.justify-content-center -->