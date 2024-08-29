<?php
/* * * * * * END CUSTOMIZE_REGISTER * * * * * */
/**
 * Registers the Form Builder page in the WordPress admin menu.
 *
 * This function adds a new menu item labeled "Form Builder" under the WordPress admin menu.
 * The menu item is accessible to users with the 'manage_options' capability.
 * Upon clicking, it renders the Form Builder settings page.
 */
function add_form_builder_menu() {
    add_menu_page(
        __('Form Builder', 'sherpawp'),
        __('Form Builder', 'sherpawp'),
        'manage_options',
        'form-builder',
        'render_form_builder_page',
        'dashicons-feedback',
        60
    );
}
add_action('admin_menu', 'add_form_builder_menu');
/**
 * Renders the Form Builder settings page.
 *
 * This function outputs the HTML for the Form Builder settings page, including
 * the settings form where users can manage form fields. The form uses the 'form_builder_settings'
 * settings group and displays the registered settings sections and fields.
 */
function render_form_builder_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Form Builder', 'sherpawp'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('form_builder_settings');
            do_settings_sections('form-builder');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}
/**
 * Registers settings, sections, and fields for the Form Builder.
 *
 * This function registers a setting for storing form fields, a section for managing
 * form fields, and a form field for displaying and managing the fields.
 */
function register_form_builder_settings() {
    register_setting('form_builder_settings', 'form_fields', 'sanitize_text_field');

    add_settings_section(
        'form_builder_section',
        __('Manage Form Fields', 'sherpawp'),
        'form_builder_section_callback',
        'form-builder'
    );

    add_settings_field(
        'form_fields',
        __('Form Fields', 'sherpawp'),
        'render_form_fields',
        'form-builder',
        'form_builder_section'
    );
}
add_action('admin_init', 'register_form_builder_settings');
/**
 * Outputs the description for the Form Builder section.
 *
 * This callback function displays a description or instructions for the
 * form fields management section.
 */
function form_builder_section_callback() {
    echo __('Add and arrange your form fields below:', 'sherpawp');
}
/**
 * Renders the form fields management interface.
 *
 * This function outputs the HTML for managing form fields, including
 * the ability to add, remove, and arrange form fields. It also includes
 * the necessary JavaScript for dynamically updating the fields.
 */
function render_form_fields() {
    $form_fields = get_option('form_fields', json_encode(array()));
    ?>
    <div id="form-fields-container">
        <!-- JavaScript will dynamically add fields here -->
    </div>
    <button type="button" id="create-group" class="button"><?php _e('Create Group', 'sherpawp'); ?></button>
    <button type="button" id="add-field" class="button"><?php _e('Add Field', 'sherpawp'); ?></button>
    <textarea id="form-fields-data" name="form_fields" style=""><?php echo esc_textarea($form_fields); ?></textarea>
    <textarea id="testertester"></textarea>

    <script>
    (function($){
        
        $(document).ready(function(){
            var fieldTemplate = '<div class="form-field"><input type="text" class="field-label" placeholder="Field Label" />\
            <select class="field-type">\
                <option value="text">Text</option>\
                <option value="email">Email</option>\
                <option value="textarea">Textarea</option>\
                <option value="radio">Radio</options>\
                <option value="dropdown">Dropdown</options>\
            </select>\
            <button type="button" class="button-primary remove-field">Remove</button>';
            var optionTemplate ='<div class="option-container">\
                                    <button type="button" class=" btn-primary button add-option">Add Radio Button</button>\
                                </div>';
            var optionContent = '<div class="enter-option-container">\
                                <input type="text" class="radio-option field-option" />\
                                <button type="button" class="sherpa-btn-close">&times;</button>\
                                </div>';
            var ddTemplate = '<div class="dd-container">\
                                <button type="button" class="button-primary button add-option'
            var groupTemplate ='<div class="field-group"><button type="button" class="button remove-group">Remove Group</button></div>';
            var groupHeader = '<div class="field-header"><h2>Title:</h2> <input type="text" class="field-label" id="form-title" placeholder="Form Title" /> <h3>Subtitle:</h3> <input type="text" id="form-subtitle" class="field-label" /></div>';
            var formFieldsContainer = $('#form-fields-container');
            var formFieldsData = $('#form-fields-data');
            var testertester = $('#testertester');
            /**
             * loadFields
             * @var formFieldsContainer - the container that holds all of the fields
             * @var fieldElement - the given most recent element to be appended to formFieldContainer
             * 
             * @todo refactor radio and dropdown options using a function
             */
            function loadFields() {
                var formData = JSON.parse(formFieldsData.val());
                fields = formData.fields;
                formFieldsContainer.empty();
                formFieldsContainer.append(groupHeader);
                formFieldsContainer.find('#form-title').val(formData.title);
                formFieldsContainer.find('#form-subtitle').val(formData.subtitle);

                var count = 0;
                $.each(fields, function(index, field) {
                    
                    var fieldGroup = $(groupTemplate);
                    if(count==field.group){
                        formFieldsContainer.append(fieldGroup);
                        count++;
                    }
                    let groups = formFieldsContainer.find('.field-group');
                    fieldElement = $(fieldTemplate);
                    fieldElement.find('.field-label').val(field.label);
                    fieldElement.find('.field-type').val(field.type);
                    fieldElement.append('</div>');
                    groups.last().append(fieldElement);
                    switch(field.type){
                        case "radio": 
                            groups.last().find('.form-field').last().append(optionTemplate);
                            var thisRad = groups.last().find('.option-container').last();
                            console.log(field.options);
                            $.each(field.options, function(){
                                console.log($(this));
                                thisRad.append(optionContent);
                                thisRad.find('.radio-option').last().val(this);
                            });
                            break;
                        case "dropdown":

                            
                    }
                });
            }
            function populateOptions(containerClass, optionClass){

            }
            function saveFields() {
                var fields = [];
                var title = $('#form-title').val();
                var subtitle = $('#form-subtitle').val();
                
                formFieldsContainer.find('.field-group').each(function(groupIndex){
                    $(this).find('.form-field').each(function(){
                        var label = $(this).find('.field-label').val();
                        var type = $(this).find('.field-type').val();
                        
                        var options = null;
                        if(type=="radio" || type=="dropdown"){
                            options = [];
                            console.log("before");
                            console.log($(this));
                            $(this).find('.field-option').each(function(){
                                options.push($(this).val());
                                console.log("during");
                            });
                        }                    
                        fields.push({
                            label: label,
                            type: type,
                            group: groupIndex,
                            options: options
                             
                        });
                    });
                });
                let formData = {
                    title: title,
                    subtitle: subtitle,
                    fields: fields
                };
                console.log(formData);
                var j = JSON.stringify(formData);
                formFieldsData.val(JSON.stringify(formData)); // Save the fields with group information as JSON
            }           
            $('#add-field').on('click', function(){
                let groups = formFieldsContainer.find('.field-group');
                console.log(groups);
                groups.last().append(fieldTemplate);
            });
            $('#create-group').on('click', function(){
                formFieldsContainer.append(groupTemplate); 
            });
            /**
             * on-click radi-container
             * @todo Add saving functionality
             * @todo get remove button visible and working
             * @var optionTemplate - container holding radio options
             * @var radioOptions - Input field with remove button
             *  
             */
            $(document).on('click', '.add-radio', function(){
                $(this).closest('.option-container').append(optionContent);
            });
            $(document).on('click', '.remove-group', function(){
                $(this).closest('.field-group').remove();
            });
            $(document).on('click', '.remove-field', function(){
                $(this).closest('.form-field').remove();
                saveFields();
            });
            $(document).on('change', '.field-option', function(){
                saveFields();
            });
            formFieldsContainer.on('change', '.field-label, .field-type', function(event) {
                var targetClass = '';
                console.log("SHERPA::CHANGE:DETECTED");
                if ($(event.target).hasClass('field-label')) {
                    console.log("SHERPA::CHANGE:FIELD-LABEL");
                    targetClass = 'field-label';
                    
                } else if ($(event.target).hasClass('field-type')) {
                    console.log("SHERPA::CHANGE:FIELD-TYPE");
                    if($(this).val() == "radio"){
                        $(this).closest('.form-field').append(optionTemplate);
                        $(this).closest('.form-field').find('add-option').addClass('add-radio');
                    }
                    else if($(this).val() == "dropdown"){
                        $(this).closest('.form-field').append(optionTemplate);
                        $(this).closest('.form-field').find('add-option').addClass('add-dropdown');
                    }
                    else{
                        console.log("yadmudda: "+$(this).val());
                    }
                }
                console.log("SHERPA::CHANGE:ERROR");

                // Now you can use `targetClass` to handle the event differently based on the class
                saveFields();
            });
            loadFields();
        });
    })(jQuery);
    </script>
    <?php
}