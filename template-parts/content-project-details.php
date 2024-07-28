<?php
/**
 * Template part for displaying project details
 */

?>

<div class="project-details">

    <h5 class="title"><?php the_title()?></h5>
    <p class="text center"><?= substr(get_the_excerpt(), 0, 50)?></p>
    <a href="<?php the_permalink()?>" class="btn btn-primary sherpa-color">Read More</a>
    
    <!-- Add more details as needed -->
</div>
