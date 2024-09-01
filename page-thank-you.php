<?php
/*
Template Name: Thank You
*/
get_header(); ?>

<div class="p-4 gap justify-content-center mx-auto thank-you-content" style="max-width: 50%;">
<?php
    // show posts as default content
?>
<h1><?php echo get_theme_mod('thank_you_header', $default_value='Thank you for your submission.'); ?></h1>
<p><?php echo get_theme_mod('thank_you_excerpt', $default_value='Your submission has been received. We will get back to you soon.');?></p>
<form class="d-flex" action="<?= get_home_url()?>" style="max-width: 80%;">
<input name="s" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
<button class="btn btn-outline-success" type="submit">Search</button></form>
</div> <!-- .p-4.gap.justify-content-center.mx-auto -->

<?php get_footer(); ?>
