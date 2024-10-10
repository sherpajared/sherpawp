<?php
/* * * * * * END CUSTOMIZE_REGISTER * * * * * */
/**
 * Registers the Form Builder page in the WordPress admin menu.
 *
 * This function adds a new menu item labeled "Form Builder" under the WordPress admin menu.
 * The menu item is accessible to users with the 'manage_options' capability.
 * Upon clicking, it renders the Form Builder settings page.
 */
function add_footer_menu() {
    add_menu_page(
        __('Footer Builder', 'sherpawp'),
        __('Footer Builder', 'sherpawp'),
        'manage_options',
        'footer_builder',
        'render_footer_builder_page',
        'dashicons-feedback',
        60
    );
}
add_action('admin_menu', 'add_footer_menu');
/**
 * Renders the Form Builder settings page.
 *
 * This function outputs the HTML for the Form Builder settings page, including
 * the settings form where users can manage form fields. The form uses the 'form_builder_settings'
 * settings group and displays the registered settings sections and fields.
 */
function render_footer_builder_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Footer Builder', 'sherpawp'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('footer_settings');
            do_settings_sections('footer_builder');
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
function register_footer_builder_settings() {
    register_setting('footer_settings', 'footer_columns', 'sanitize_text_field');

    add_settings_section(
        'footer_builder_section',
        __('Manage Footer Fields', 'sherpawp'),
        'footer_builder_section_callback',
        'footer_builder'
    );

    add_settings_field(
        'footer_columns',
        __('Footer Fields', 'sherpawp'),
        'render_footer_columns',
        'footer_builder',
        'footer_builder_section'
    );
}
add_action('admin_init', 'register_footer_builder_settings');
/**
 * Outputs the description for the Form Builder section.
 *
 * This callback function displays a description or instructions for the
 * form fields management section.
 */
function footer_builder_section_callback() {
    echo __('Add and arrange your footer fields below:', 'sherpawp');
}
/**
 * Renders the form fields management interface.
 *
 * This function outputs the HTML for managing form fields, including
 * the ability to add, remove, and arrange form fields. It also includes
 * the necessary JavaScript for dynamically updating the fields.
 */
function render_footer_columns() {

    $footer_columns = get_option('footer_columns', json_encode(array()));

    ?>
    <div id="footer-columns-container">
        <label for="column-count"><?php _e('Number of Columns (Max 4)', 'sherpawp'); ?></label>
        <input type="number" id="column-count" name="column-count" min="1" max="4" value="1" />
        <button type="button" id="add-column" class="button"><?php _e('Add Column', 'sherpawp'); ?></button>
        <div id="columns-container">
            <!-- Columns will be dynamically added here -->
        </div>
    </div>
    <textarea id="footer-columns-data" name="footer_columns" style=""><?php echo esc_textarea($footer_columns); ?></textarea>

    <script>
(function($) {
    $(document).ready(function() {
        // Templates
        var columnTemplate = '<div class="footer-column"><h3><?php _e("Column", "sherpawp"); ?> <span class="column-number"></span><br><input type="text" class="column-title-input"/></h3>\
                              <div class="column-inputs"></div>\
                              <button type="button" class="button add-input"><?php _e("Add Input", "sherpawp"); ?></button>\
                              <button type="button" class="button remove-column"><?php _e("Remove Column", "sherpawp"); ?></button></div>';
        var typeSelect = '  <select class="data-type">\
                                <option value="text">Text</option>\
                                <option value="textarea">Textarea</option>\
                            </select>';
        var binder = '<div class="binder"></div>';
        var anchorTemplate = '<input type="text" class="column-text input-link">';
        var textAreaTemplate = '<div class="input-field"><textarea class="input-data input-area input-excerpt"></textarea></div>';
        var inputTemplate = '<div class="input-field"><input type="text" class="input-data column-text" placeholder="Enter text"/><span class="link-span">Link: <input type="text" class="input-link"/></span></div>';
        var selectTemplate = typeSelect + '<button type="button" class="button remove-input"><?php _e("Remove Input", "sherpawp"); ?></button>'
        var columnsContainer = $('#columns-container');
        var footerColumnsData = $('#footer-columns-data');

        // Load saved columns
        function loadColumns() {
    // Parse the JSON data stored in the hidden textarea
            var footerData = JSON.parse(footerColumnsData.val() || '{}');
            
            // Check if the `columns` property exists, otherwise default to an empty array
            var columns = footerData.columns || [];

            // Clear the existing columns from the container
            columnsContainer.empty();
            
            // Loop through each column and its inputs
            $.each(columns, function(index, column) {
                var columnElement = $(columnTemplate);  // Create a new column element
                columnElement.find('.column-number').text(index + 1);  // Set the column number
                var count=0;
                columnElement.find('.column-title-input').val(column.title);
                // Loop through each input in the column and populate the fields
                $.each(column.inputs, function(i, input) {
                    var inputElement;  // Create a new input element
                    
                    console.log("SHERPA:DEBUG:"+i+": "+input.type);
                    switch(input.type){
                        case "text":
                            inputElement=$(inputTemplate);
                            inputElement.find('.input-data').val(input.input);
                            inputElement.find('.input-link').val(input.link);
                            break;
                        case "textarea":
                            inputElement=$(textAreaTemplate);
                            inputElement.find('.input-data').val(input.input);
                            console.log("SHERPA:DEBUG::"+input.input);
                            break;
                    }
                      // Set the input value
                        columnElement.find('.column-inputs').append(binder);
                        columnElement.find('.binder').last().append(inputElement);
                        columnElement.find('.binder').last().append(selectTemplate);

                        // Find the most recently added .data-type element and set its value
                        const newSelect = columnElement.find('.column-inputs').find('.binder').last().find('.data-type').last();
                        newSelect.val(input.type).change();
                        newSelect.prop('name', 'select' + count);
                        newSelect.find('option[value="' + input.type + '"]').attr('selected', 'selected');

                    count++;


                });

                // Append the column element to the container
                columnsContainer.append(columnElement);
                
            });
            $('#column-count').val(columns.length);
        }


        // Save columns to the hidden textarea
        function saveColumns() {
        var columns = [];
    
        // Loop through each column and gather inputs
        columnsContainer.find('.footer-column').each(function(index, column) {
            var inputs = [];
            var colTitle = $(this).find('.column-title-input').val();
            $(column).find('.input-data').each(function() {
                var theLink="test";
                console.log("SHERPA:DEBUGLINK:"+theLink);
                if($(this).siblings('.link-span').find('.input-link').length>=0){
                    theLink = $(this).siblings('.link-span').find('.input-link').val();
                    
                }
                var data = {
                    input: $(this).val(),
                    type: $(this).closest('.input-field').siblings('.data-type').val(),
                    link: theLink
                }
                console.log("SHERPA::TEST:DATA: "+data);
                inputs.push(data);
            });
            columns.push({ title: colTitle, inputs: inputs });
        });

        // Wrap the columns array inside an object
        var data = {
            columns: columns
        };

        // Save the object as a JSON string in the hidden textarea
        footerColumnsData.val(JSON.stringify(data));
    }


        // Add new column
        $('#add-column').on('click', function() {
            var currentColumnCount = $('.footer-column').length;
            if (currentColumnCount >= 4) {
                alert('<?php _e("Maximum of 4 columns allowed.", "sherpawp"); ?>');
                return;
            }
            $('#column-count').val(currentColumnCount+1);
            var newColumn = $(columnTemplate);
            newColumn.find('.column-number').text(currentColumnCount + 1);
            columnsContainer.append(newColumn);

            saveColumns();
        });

        // Add new input field to a column
        $(document).on('click', '.add-input', function() {
            var column = $(this).closest('.footer-column');
            var newInput = $(inputTemplate);
            column.find('.column-inputs').append(binder);
            column.find('.binder').last().append(newInput);
            column.find('.binder').last().append(selectTemplate);
            saveColumns();
        });

        // Remove input field
        $(document).on('click', '.remove-input', function() {
            $(this).closest('.binder').remove();
            saveColumns();
        });

        // Remove column
        $(document).on('click', '.remove-column', function() {
            var currentColumnCount = $('.footer-column').length;
            $('#column-count').val(currentColumnCount-1);
            $(this).closest('.footer-column').remove();

            // Reorder column numbers
            columnsContainer.find('.footer-column').each(function(index) {
                $(this).find('.column-number').text(index + 1);
            });

            saveColumns();
        });

        // Update when the number of columns is changed manually
        $('#column-count').on('change', function() {
            var selectedCount = parseInt($(this).val());
            if (selectedCount < 1 || selectedCount > 4) {
                alert('<?php _e("Please select a number between 1 and 4.", "sherpawp"); ?>');
                return;
            }
            while ($('.footer-column').length < selectedCount) {
                $('#add-column').click();
            }
            while ($('.footer-column').length > selectedCount) {
                $('.footer-column').last().remove();
            }

            saveColumns();
        });
        $(document).on('change', '.data-type', function(){
                var selected = $(this).val();
                setType(selected, this);

        });
        function setType(selected, element){
            console.log("SHERPA:TEST:SELECTED" + selected);
                switch(selected){
                    case "textarea":
                        $(element).closest('.binder').find('.input-field').replaceWith(textAreaTemplate);
                        break;
                    case "text":
                        $(element).closest('.binder').find('.input-field').replaceWith(inputTemplate);
                        break;
                }
            saveColumns();
        }
        // Ensure saveColumns is called before form submission
        $('form').on('submit', function() {
            saveColumns();

        });

        // Initial load of columns
        loadColumns();
    });
})(jQuery);

    </script>
    
    <?php
}
