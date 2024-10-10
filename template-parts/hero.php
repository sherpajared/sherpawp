<?php
/**
 * hero.php
 * 
 * Creates Hero Banner based on the type of post. Used in Home Page and Project Archive
 * 
 * @var string $hero_type - defines which kind of hero banner is used - passed to Customizer
 * @uses get_post_type - check post-type for hero banner conditional
 * @uses get_theme_mod - access customizer to get hero content 
 */ 
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
            <h1><?php echo get_theme_mod($hero_type . '_title', $default_value=true); ?></h1>
        </div><!-- .hero-banner-leftt -->
        <div class="hero-banner-right">
            <p><?php echo get_theme_mod($hero_type . '_subtitle', $default_value=true); ?></p>
            <a href="<?php echo home_url() . '/contact-us'?>" class="hero-btn sherpa-color-hover"><?php echo get_theme_mod($hero_type . '_button_text', $default_value=true); ?></a>
        </div><!-- .hero-banner-right -->
    </div><!-- .hero-banner-content -->
</section> <!-- .hero-benner -->
