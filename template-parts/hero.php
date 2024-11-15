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
    $home_title = get_theme_mod('hero_title', 'Welcome to Our Website');
    $home_caption = get_theme_mod('hero_caption', 'Your Success, Our Commitment');
    $home_button_text = get_theme_mod('hero_cta', 'Learn More');
    $home_image_1 = get_theme_mod('hero_image_1', '');
    $home_image_2 = get_theme_mod('hero_image_2', '');
    $home_image_3 = get_theme_mod('hero_image_3', '');
?>
<section class="sherpa-hero-section">
<div class="sherpa-hero-slide">
  <div class="sherpa-hero-slide-image" style="background-image: url('<?php echo esc_url($home_image_1);?>')"></div>
  <div class="sherpa-hero-slide-image" style="background-image: url('<?php echo esc_url($home_image_2);?>')"></div>
  <div class="sherpa-hero-slide-image" style="background-image: url('<?php echo esc_url($home_image_3);?>')"></div>
</div>
<div class="sherpa-kenburns">
<h1 class="sherpa-heading white text-shadow"><?php echo $home_title?></h1>
<?php if($home_caption){?><h4 class="sherpa-heading white text-shadow"><?php echo $home_caption?></h4><?php }?>
    <button class="hero-btn mtop-1">Contact Us</button>
</div>
</section>

