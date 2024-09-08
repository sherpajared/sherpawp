<?php

/**
 * Create the 'Project' Category with 'Project - Featured' as a child
 * 
 * Function Start
 *      checks if 'Project' category exists
 *      - true  :   continue
 *      - false :   Create 'Project' Category
 * Continue
 *      checks if 'Project - Featured' exists
 *      - true  : terminate
 *      - false : Create 'Project - Featured' Category
 *      
 * @return void
 * @todo add categories that should be created when theme is added
 * @todo handle hierarchy - multiple Parents with same child? i.e: Page - Featured, Project - Featured?
 * 
 */
function create_my_cat() {
    if (file_exists(ABSPATH . '/wp-admin/includes/taxonomy.php')) {
        require_once(ABSPATH . '/wp-admin/includes/taxonomy.php');
        if(!get_cat_ID('Project')){
            wp_create_category('Project');
        }
        // Get the ID of the parent category
        $project_id = get_cat_ID('Project');

        // If the parent category exists and the child category doesn't exist yet
        if ($project_id && !get_cat_ID('Project - Featured')) {
            // Create the child category under the parent category
            wp_create_category('Project - Featured', $project_id);
        }
    }
}
add_action('after_setup_theme', 'create_my_cat');
/**
 * sherpa_create_page()
 * 
 * @param $args - array: @var title
 *                       @var content
 *                       @var 
 * 
 */
function create_contact_us_page() {
    // Check if the page already exists
    $page_check = get_page_by_title('Contact Us');
    if (!isset($page_check->ID)) {
        // Fetch form fields from the form builder settings
        $form_fields = json_decode(get_option('form_fields', json_encode(array())), true);
        $form_content = '';

        // Generate the form structure
        if (!empty($form_fields)) {
            $form_content .= '<form action="" method="post">';
            $form_content .= '<div class="form-row">';
            $count = 0;
            foreach ($form_fields as $field) {
                $field_group = sanitize_title($field['group']);
                
                if($count != $field_group){
                    $form_content .= '</div><div class="form-row">';   
                    $count++;   
                }
                $form_content .= '<div class="form-group">';
                switch ($field['type']) {
                    case 'text':
                        $form_content .= '<label>' . esc_html($field['label']) . '</label><input type="text" name="' . sanitize_title($field['label']) . '">';
                        break;
                    case 'email':
                        $form_content .= '<label>' . esc_html($field['label']) . '</label><input type="email" name="' . sanitize_title($field['label']) . '">';
                        break;
                    case 'textarea':
                        $form_content .= '<label>' . esc_html($field['label']) . '</label><textarea name="' . sanitize_title($field['label']) . '"></textarea>';
                        break;
                }
                $form_content .= '</div>';
            }
            $form_content .= '<button type="submit" class="btn btn-primary">Sign in</button>';
            $form_content .= '</form>';
        }

        // Create the Contact Us page
        $contact_page = array(
            'post_title'    => 'Contact Us',
            'post_content'  => $form_content, // Insert the dynamically generated form content
            'post_status'   => 'publish',
            'post_type'     => 'page',
        );
        $page_id = wp_insert_post($contact_page);
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'page-contact-us.php');
        }
    }
}
add_action('after_switch_theme', 'create_contact_us_page');
/**
 * create_thank_you_page()
 * -Creates a thank you page that responds to form submission
 * @uses page_template - page-thank-you.php
 */
function create_thank_you_page() {
    // Check if the page already exists
    $page = get_page_by_path('thank-you');

    // If the page doesn't exist, create it
    if (!$page) {
        $page_id = wp_insert_post(array(
            'post_title'     => 'Thank You',
            'post_name'      => 'thank-you',
            'post_content'   => '<h1>Thank You!</h1><p>Your submission has been received. We will get back to you soon.</p>',
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'page_template'  => 'page-thank-you.php', // Assign the custom template
        ));

        // Optional: Add metadata or any other customization to the page here
    }
}
add_action('after_switch_theme', 'create_thank_you_page');
/**
 * sherpawp_get_defaults()
 * 
 * @return array of default values used in customizer
 * @see sherpawp_write_defaults() - uses this function
 * 
 */
function sherpawp_get_defaults(){
    return array(
        'primary-color'     =>  '#3498db',
        'secondary_color'   =>  '#2ecc71',
        'accent_color'      =>  '#ababab',
        'footer_background_color'   =>  '#333333',
        'footer_text_color'         =>  '#ffffff',
        'footer_text'               =>   __( '© 2024 My Website', 'sherpawp' ),
        'home_title'                =>  'Welcome to Our Website',
        'home_subtitle'             =>  'Your Success, Our Commitment',
        'home_button_text'          =>  'Learn More'

    );

}

/**
 * sherpawp_write_defaults()
 *
 * writes defaults to Wordpress DB on theme activation 
 * @return void
 * @see functions.php -> @func sherpa_customizer_register()
 * 
 */
function sherpawp_write_defaults() {
    $settings = sherpawp_get_defaults();
    foreach ($settings as $setting => $default_value) {
        if (get_theme_mod($setting) === false) {
            set_theme_mod($setting, $default_value);
        }
    }
}
add_action('after_switch_theme', 'sherpawp_write_defaults');

function create_json_form_submission_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'form_submissions';

    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            form_id mediumint(9) NOT NULL,
            submission_data text NOT NULL,
            submission_time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
add_action('after_switch_theme', 'create_json_form_submission_table');
function sherpawp_register_menus() {
    register_nav_menus(array(
        'header-menu' => __('Header Menu', 'sherpawp'),
    ));
}
add_action('after_setup_theme', 'sherpawp_register_menus');
function my_theme_setup_default_menu() {
    // Check if the menu exists
    $menu_name = 'Header Menu';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    // If the menu doesn't exist, create it
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);

        // Add default items to the menu
        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Projects'),
            'menu-item-url' => home_url('/projects'),
            'menu-item-status' => 'publish'
        ));

        wp_update_nav_menu_item($menu_id, 0, array(
            'menu-item-title' => __('Contact Us'),
            'menu-item-url' => home_url('/contact-us'),
            'menu-item-status' => 'publish'
        ));

        // Assign the menu to the primary menu location
        if (!has_nav_menu('header-menu')) {
            $locations = get_theme_mod('nav_menu_locations');
            $locations['header-menu'] = $menu_id;
            set_theme_mod('nav_menu_locations', $locations);
        }
    }
}
add_action('after_switch_theme', 'my_theme_setup_default_menu');
