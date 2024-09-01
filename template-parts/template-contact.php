<?php
$form_fields = json_decode(get_option('form_fields', json_encode(array())), true);
?>
<div class="form-container grid-container">
<?php
if (!empty($form_fields)) {
    echo '<form class="contact-form" action="' . esc_url(admin_url('admin-post.php')) . '" method="post">';
    echo '<input type="hidden" name="action" value="custom_form_submission">';
    echo wp_nonce_field('custom_form_action', 'custom_form_nonce', true, false);
    echo '<h2 class="contact-header">Contact Us</h2>';
    $count = 0;
    echo '<div class="form-group">';
    foreach ($form_fields['fields'] as $field) {
        $field_group = sanitize_title($field['group']);
       
        if($count != $field_group){
            echo '</div><div class="form-group">';   
            $count++;   
        }
        echo '<div class="form-field">';
        $label = sanitize_title($field['label']);
        echo '<script>console.log("SHERPA::DEBUG:' . $field['type'] . '");</script>';
        switch ($field['type']) {
            case 'text':
                echo '<label>' . $label . '</label><input class="form-control" type="text" name="' . $label . '"/>';
                break;
            case 'email':
                echo '<label>' . $label . '</label><input class="form-control" type="email" name="' . $label . '"/>';
                break;
            case 'textarea':
                echo '<label>' . $label . '</label><textarea name="' . $label . '"></textarea>';
                break;
            case 'radio':
                echo '<label>' . $label . '</label><div class="radio-container">';
                foreach($field['options'] as $option){
                    echo '<div class="binding-agent radio-label-bind"><input id="' . sanitize_title($option) . '" type="radio" class="radio" name="'. $label . '" value="' . sanitize_title($option) . '" />
                    <label for="' . sanitize_title($option) . '">' . $option . '</label></div>';
                }
                echo '</div>';
                break;
            case 'dropdown':
                //echo '<script>console.log("SHERPA::DEBUG:' . $field['type'] . '");</script>';
                echo '<label>' . $field['label'] . '</label><div class="dropdown-container"><select class="dropdown dropdown-'. $label . 
                '" name="' . $label . '" id="' . $label . '">';
                foreach($field['options'] as $option){
                    echo '<option value="' . sanitize_title($option) . '">'. $option . '</option>';
                }
                echo '</select></div>';
                break;
        }
        echo '</div>';
    }
    echo '<button type="submit" class="form-submit btn btn-primary">Submit</button>';
    echo '</form>';
}
?>
</div>
<?php
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
function classify($str){
    return strtolower(str_replace(' ', '-', $str));
}

