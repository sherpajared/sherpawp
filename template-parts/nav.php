<!--
PHP FUNCTIONS
navbar-brand - home_url()
d-flex - home_url(), added name 'search' to input tag





-->

<nav class="navbar navbar-expand-lg bg-body-tertiary" style="max-height: 76px;">
  <div class="container-fluid navbar-container">
  <div class="navbar-logo-container" <?php
    if(has_custom_logo()){
      echo sherpa_def_image_size(get_theme_mod('custom_logo'), 65, 0);
    }
    ?>
  <?php
        $logo_attr = array(
          'class' => 'mh-100',
        );
        $custom_logo = wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full');
        ?><a href = get_home_uri();><?php
        if(has_custom_logo()){
          
          the_custom_logo();
        }
        else{
          the_title();
        }

      
   
    ?></a>
    
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
   
    <?php 
   
    wp_nav_menu(
      array(
        'theme_location' => 'header-menu',
        'container_class' => 'collapse navbar-collapse',
        'container_id' => 'navbarSupportedContent',
        'menu_class' => 'navbar-nav me-auto mb-2 mb-lg-0',
        'walker' => new header_menu_walker(),
      )
    );?>
<div class="collapse navbar-collapse">
      <form class="d-flex" role="search" action="<?= get_home_url()?>">
        <input name="s" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
        
      </form>
  </div>
  <div class="d-flex">
  <button style="max-height: 76px;" class="btn diagonal text-nowrap w-auto  nav-contact h-50" type="submit">Contact Us!</button>
  </div>
    
   
    
    <?php


?>
  </div>
</nav>
