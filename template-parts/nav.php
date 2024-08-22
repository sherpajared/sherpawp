<!--
PHP FUNCTIONS
navbar-brand - home_url()
d-flex - home_url(), added name 'search' to input tag
-->
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="max-height: 76px;">
  <div class="container-fluid navbar-container">
  <div class="navbar-logo-container" 
  <?php 
    $placeholder_logo = get_template_directory_uri() . '/assets/img/placeholders/sherpa4-1.png';
    if(has_custom_logo()){ 
        echo sherpa_def_image_size(get_theme_mod('custom_logo'), 65, 0); 
    }
    else{
          echo sherpa_def_image_size($placeholder_logo, 65, 0);
    }
     ?>>
  <?php
  $logo_attr = array(
      'class' => 'mh-100',
  );

  ?>
  <a href="<?php echo home_url(); ?>">
    <?php
    if(has_custom_logo()){
        the_custom_logo();
    } else {
        ?><img src="<?php echo $placeholder_logo; ?>" alt="Placeholder Logo"><?php
    }
    ?>
  </a>
</div><!-- .navbar-logo-container -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse row-reverse mr-1" id="navbarSupportedContent">
    <form class="d-flex" role="search" action="<?= get_home_url()?>">
        <input name="s" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form> <!-- .d-flex -->
    <?php
    
    if(has_nav_menu('header-menu')){
      wp_nav_menu(
        array(
          'theme_location' => 'header-menu',
          'container_class' => 'collapse navbar-collapse row-reverse mr-1',
          'container_id' => 'navbarSupportedContent',
          'menu_class' => 'navbar-nav me-auto mb-2 mb-lg-0',
          'walker' => new header_menu_walker(),
        )
      );
    }?>
<div>

  </div>
  <?php
  ?>
  </div>
</nav><!-- .navbar.navbar-expand-lg.bg-body-tertiary -->
