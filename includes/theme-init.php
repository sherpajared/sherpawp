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
