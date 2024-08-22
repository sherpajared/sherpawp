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