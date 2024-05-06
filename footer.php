<footer>
<?php

    wp_nav_menu(
      array(
        'theme_location' => 'footer-menu',
        'container_class' => 'my_extra_menu_class'
      )
      );
?>
</footer>
<?php wp_footer()?>
</body>
</html>