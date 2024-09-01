WORDPRESS FUNCTIONS TO GET VARIABLES
======================================================
------------------------------------------------------

blogInfo(value) - gets info from WP dashboard based on parameter, 'name', 'description', 'charset',  etc..
https://developer.wordpress.org/reference/functions/bloginfo/

language_attributes() - used in html tag, adds attributes for WP

KEY PRINCIPLE
the_title() - echos the title
get_the_title() - returns the value 
get_template_directory() - gets directory up to theme
get_template_directory_uri() - gets up to theme directory as http
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

======================================================
------------------------------------------------------
TEMPLATES

get_template_part();

======================================================
## ON ACTIVATION

To access Sherpa WP;

Navigate from Wordpress dashboard

Apparance>Themes

Click 'Add New Theme'

Click 'Upload Theme'

Select sherpawp.zip file *Wordpress will handle extraction

A Contact Us and Thank You page are generated.

=======================================================
Form Builder 
SherpaWP comes with a custom FormBuilder that functions similarly to WPForms

