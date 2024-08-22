<?php

$form_fields = json_decode(get_option('form_fields', json_encode(array())), true);
get_template_part('template-parts/contact-form.php');
if (!empty($form_fields)) {
    echo '<form action="" method="post">';
    $count = 0;
    echo '<div class="form-row">';
    foreach ($form_fields as $field) {
        $field_group = sanitize_title($field['group']);
        echo $field_group;
        if($count != $field_group){
            $form_content .= '</div><div class="form-row">';   
            $count++;   
        }
        echo '<div class="form-group">';
        switch ($field['type']) {
            case 'text':
                echo '<label>' . esc_html($field['label']) . '</label><input class="form-control" type="text" name="' . sanitize_title($field['label']) . '">';
                break;
            case 'email':
                echo '<label>' . esc_html($field['label']) . '</label><input class="form-control" type="email" name="' . sanitize_title($field['label']) . '">';
                break;
            case 'textarea':
                echo '<label>' . esc_html($field['label']) . '</label><textarea name="' . sanitize_title($field['label']) . '"></textarea>';
                break;
        }
        echo '</div>';
    }
    echo '<button type="submit" class="btn btn-primary">Submit</button>';
    echo '</form>';
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $form_fields = json_decode(get_option('form_fields', json_encode(array())), true);
    $form_data = array();

    foreach ($form_fields as $field) {
        $field_name = sanitize_title($field['label']);
        $form_data[$field_name] = sanitize_text_field($_POST[$field_name]);
    }

    // Process the form data (e.g., send email, save to database)
    wp_mail('youremail@example.com', 'New Contact Message', print_r($form_data, true));
}

