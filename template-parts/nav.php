<!--
PHP FUNCTIONS
navbar-brand - home_url()
d-flex - home_url(), added name 'search' to input tag





-->

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <div class="w-100">
  <?php
    /*if (has_custom_logo()) {
        the_custom_logo();
    }else{*/
      ?>
      <a class="navbar-brand site-title" href="<?= get_home_url()?>"?>
        <img class="custom-logo" src="<?= get_template_directory_uri().'/assets/img/placeholders/sherpa1080p.png'?>" alt="1920x1080">
      </a>
      <?php
    //}
    ?></div>
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
      <form class="d-flex" role="search" action="<?= get_home_url()?>">
        <input name="s" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
    <?php


?>
  </div>
</nav>
