<?php
// Function to create a category and make it a child of another category
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
