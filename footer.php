<footer>
  <div class="container-fluid">
    <div class="row">      
      <div class="col border" style="min-width: 15em;">Sherpa</div>
      <div class="col border" style="min-width: 15em;">Sherpa</div>
      <div class="col border" style="min-width: 15em;">
<?php

    wp_nav_menu(
      array(
        'theme_location' => 'footer-menu',
        'container_class' => 'my_extra_menu_class'
      )
      );

?>
</div>
</div>
</div>
<script src="<?php echo get_template_directory_uri(); ?>/js/sticky-header.js"></script>
</footer>
<?php wp_footer()?>
</body>
</html>