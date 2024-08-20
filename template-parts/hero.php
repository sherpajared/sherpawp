<?php 
    $hero_type = null;
    if(is_home()){
        $hero_type = "home";
    }
    else if(get_post_type() == "project"){
        $hero_type = "projects";
    }
?>
<section class="hero-banner">
    <div class="hero-banner-content">
        <div class="hero-banner-left">
            <h1><?php echo get_theme_mod($hero_type . '_title'); ?></h1>
        </div><!-- .hero-banner-leftt -->
        <div class="hero-banner-right">
            <p><?php echo get_theme_mod($hero_type . '_subtitle'); ?></p>
            <a href="#about" class="hero-btn sherpa-color-hover"><?php echo get_theme_mod($hero_type . '_button_text'); ?></a>
        </div><!-- .hero-banner-right -->
    </div><!-- .hero-banner-content -->
</section> <!-- .hero-benner -->
