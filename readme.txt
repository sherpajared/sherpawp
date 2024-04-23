WORDPRESS FUNCTIONS TO GET VARIABLES
======================================================
------------------------------------------------------

blogInfo(value) - gets info from WP dashboard based on parameter, 'name', 'description', 'charset',  etc..
https://developer.wordpress.org/reference/functions/bloginfo/

language_attributes() - used in html tag, adds attributes for WP

------------------------------------------------------
======================================================
NECESSARY WORDPRESS FUNCTIONS

<?php wp_head()?>
INCLUDE IN ALL <head> HTML TAGS

<body <?php body_class();?>>
adds classes to body element

<?php wp_body_open()?>
ADD TO START OF <body>

<?php wp_footer();?>
ADD TO END OF <body>