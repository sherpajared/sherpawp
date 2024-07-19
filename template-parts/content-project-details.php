<?php
/**
 * Template part for displaying project details
 */

?>

<div class="project-details">
    <!-- Example: Display project details like categories, tags, etc. -->

    
    <!-- Example: Display custom fields -->
    <div class="custom-fields">
        <?php
        $custom_fields = get_post_meta($post->ID, 'custom_fields', true);
        if (!empty($custom_fields)) {
            echo '<ul>';
            foreach ($custom_fields as $field_name => $field_value) {
                echo '<li><strong>' . esc_html($field_name) . ':</strong> ' . esc_html($field_value) . '</li>';
            }
            echo '</ul>';
        }
        ?>
    </div>
    
    <!-- Add more details as needed -->
</div>
