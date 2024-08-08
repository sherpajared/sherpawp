<?php
function register_projects_cpt() {
    $labels = array(
        'name'               => _x( 'Projects', 'post type general name', 'your-text-domain' ),
        'singular_name'      => _x( 'Project', 'post type singular name', 'your-text-domain' ),
        'menu_name'          => _x( 'Projects', 'admin menu', 'your-text-domain' ),
        'name_admin_bar'     => _x( 'Project', 'add new on admin bar', 'your-text-domain' ),
        'add_new'            => _x( 'Add New', 'project', 'your-text-domain' ),
        'add_new_item'       => __( 'Add New Project', 'your-text-domain' ),
        'new_item'           => __( 'New Project', 'your-text-domain' ),
        'edit_item'          => __( 'Edit Project', 'your-text-domain' ),
        'view_item'          => __( 'View Project', 'your-text-domain' ),
        'all_items'          => __( 'All Projects', 'your-text-domain' ),
        'search_items'       => __( 'Search Projects', 'your-text-domain' ),
        'parent_item_colon'  => __( 'Parent Projects:', 'your-text-domain' ),
        'not_found'          => __( 'No projects found.', 'your-text-domain' ),
        'not_found_in_trash' => __( 'No projects found in Trash.', 'your-text-domain' )
    );

    $args = array(
        'labels'             => $labels,
        'description'        => __( 'Description.', 'your-text-domain' ),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'projects' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'taxonomies'         => array( 'category', 'post_tag' ) // Add relevant taxonomies if needed
    );

    register_post_type( 'project', $args );
}
add_action( 'init', 'register_projects_cpt' );
// Add meta box for gallery images on project post type
function project_gallery_meta_box() {
    add_meta_box(
        'project_gallery_meta_box',
        'Project Gallery Images',
        'project_gallery_meta_box_callback',
        'project', // Replace with your custom post type slug
        'normal',
        'high'
    );
}


// Callback function to display meta box content
// Callback function to display meta box content
function project_gallery_meta_box_callback($post) {
    // WordPress nonce for security
    wp_nonce_field(basename(__FILE__), 'project_gallery_nonce');
    
    // Retrieve the current gallery images
    $gallery_images = get_post_meta($post->ID, 'project-gallery-images', true);
    $gallery_captions = get_post_meta($post->ID, 'project-gallery-captions', true); // Use true to return a single value

    ?>
    <div>
        <label for="project-gallery-images">Gallery Images:</label>
        <div id="gallery-images-container">
            
            <table id="sherpa-table" class="sherpa-custom-field-table">
            <thead class="sherpa-thead">
            <tr>
            <th class="left sherpa-th"><label for="image" class="sherpa-table-label">Image</label></th>
            <th class="right sherpa-th"><label for="Caption" class="sherpa-table-label">Caption</label></th>
            </tr>
            </thead>
            <tbody class="sherpa-custom-field-body" id="sherpa-gallery-body">
                        <tr class="gallery-row hide" id="row-hidden">
                                <td class="left">
                                    <div class="td-border">
                                        <div id="img0 hide" class="gallery-image"><img src=""></div>
                                    </div>
                                </td>
                                <td class="right">
                                        <div class="td-border">
                                        <div id="caption" class="gallery-caption"><textarea id="gallery-caption0" name="caption" rows="2" cols="25"></textarea>
                                        <button type="button" class="sherpa-btn-close" aria-label="Close" id="remove0"aria-label="Close">&times;</button></div>
                                    </div>
                                </td>
                            </tr>
            <?php
            if (!empty($gallery_images)) {
                
                    ?>
                        <?php
                        $count = 1;
                        $custom = ['class' => 'sherpa-limit-img'];
                        foreach ($gallery_images as $attachment_id) { ?>
                            <tr class="gallery-row">
                                <td class="left">
                                    <div class="td-border">
                                    <?php echo '<div id="img' . $count . '" class="gallery-image">' . wp_get_attachment_image($attachment_id, false) . '</div>'; ?>
                                    </div>
                                </td>
                                <td class="right">
                                    <div class="td-border">
                                    <?php echo '<div id="caption" class="gallery-caption"><textarea id="gallery-caption' . $count . '" name="caption" rows="2" cols="25"></textarea>';?>
                                    <?php echo '<button type="button" class="sherpa-btn-close" aria-label="Close" id="remove' . $count . '"aria-label="Close">&times;</button></div>';?>
                                    </div>
                                </td>
                            </tr>
                            <?php 
                            $count = $count + 1; 
                        } 
            }
                        ?>
                        <tr class="gallery-row" id="sherpa-add">
                            <td id="newmetaleft" class="full">                               
                                <div class="td-border full">
                                    <div class="gallery-add" id="replace-me">
                                        <button id="upload_gallery_images_button" class="button">Select Images</button>
                                    </div>
                                </div>
                            </td>
                            <td class="right">
                                <div class="td-border"></div>
                    </td>
                        </tr>
                        </tbody>
                    </table>

        </div>
        <input id="project-gallery-images" name="project-gallery-images" value="<?php echo esc_attr(json_encode($gallery_images)); ?>" />
        
    </div>
    <script>
    jQuery(document).ready(function($) {
        function updateHiddenField(ids) {
            $('#project-gallery-images').val(JSON.stringify(ids));
        }
        function getCurrentIds(){
            var currentAttachmentIds = $('#project-gallery-images').val();
            if (currentAttachmentIds) {
                currentAttachmentIds = JSON.parse(currentAttachmentIds);
            } else {
                currentAttachmentIds = [];
            }
            return currentAttachmentIds;
        }
        var customUploader;
        attachmentIds = [];
        $('#upload_gallery_images_button').click(function(e) {
            e.preventDefault();

            if (customUploader) {
                customUploader.open();
                return;
            }

            customUploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Images',
                button: {
                    text: 'Select'
                },
                multiple: true
            });

            customUploader.on('select', function() {
                //gets the attachment that was selected
                var newAttachment = customUploader.state().get('selection').map(function(attachment) {
                    attachment = attachment.toJSON();
                    return attachment;
                });
                //clones the table row that contains the select image button
                let newRow = document.getElementById('row-hidden').cloneNode(true);
                console.log(newRow);
                newRow.id = "row0";
                newRow.classList.remove("hide");
                console.log(newRow);
                const addRow = document.getElementById('sherpa-add');
                const table = document.getElementById('sherpa-gallery-body')
                newRow.querySelector('img').src = newAttachment[0].url;
                //gets the ID of a selected image
                let newAttachmentIds = newAttachment[0].id;
                //adds it to the total list of all image ids in an input field
                attachmentIds = attachmentIds.concat(newAttachmentIds);

            // Concatenate new IDs with the existing ones
                let currentAttachmentIds = getCurrentIds();
                attachmentIds = currentAttachmentIds.concat(newAttachmentIds);
                $('#project-gallery-images').val(JSON.stringify(attachmentIds));
                console.log(attachmentIds);
                //the select buttons div container class is called replace me because when a user 
                table.insertBefore(newRow, addRow);

            });


    // Event listener for remove buttons
            
            customUploader.open();
        });
        $(document).on('click', '.sherpa-btn-close', function() {
                // Extract the index from the button ID
                console.log("hellooo");
                var idString = $(this).attr('id');
                var index = parseInt(idString.match(/\d+$/)[0], 10) - 1; // Subtract 1 to get zero-based index
                let currIds = getCurrentIds();
                // Remove the parent row
                $(this).closest('.gallery-row').remove();

                // Remove the attachment ID from the array at the specified index
                currIds.splice(index, 1);

                // Update the hidden field
                updateHiddenField(currIds);

                // Reassign IDs to remaining remove buttons and rows
                $('.gallery-row').each(function(i) {
                    $(this).find('.sherpa-btn-close').attr('id', 'remove' + (i + 1));
                });
            });

    });

    </script>
    <?php
}


add_action('add_meta_boxes', 'project_gallery_meta_box');
// Save meta box data


function save_project_gallery_meta_box($post_id) {
    if (!isset($_POST['project_gallery_nonce']) || !wp_verify_nonce($_POST['project_gallery_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }

    if ('page' === $_POST['post_type'] && !current_user_can('edit_page', $post_id)) {
        return $post_id;
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    $gallery_images = json_decode(stripslashes($_POST['project-gallery-images']));

    update_post_meta($post_id, 'project-gallery-images', $gallery_images);
}
add_action('save_post', 'save_project_gallery_meta_box');

function save_project_gallery_meta_data($post_id) {
    // Check if nonce is set
    if (!isset($_POST['project_gallery_nonce'])) {
        return;
    }

    // Verify nonce
    if (!wp_verify_nonce($_POST['project_gallery_nonce'], 'project_gallery_meta_box')) {
        return;
    }

    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Check if the user has permissions to save data
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Save gallery images data
    if (isset($_POST['gallery_images'])) {
        update_post_meta($post_id, 'gallery_images', sanitize_text_field($_POST['gallery_images']));
    }
}
add_action('save_post', 'save_project_gallery_meta_data');