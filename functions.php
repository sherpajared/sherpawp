<?php
    
function sherpa_init(){
    if(!is_admin()){
        wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/css/bootstrap.min.css');
        wp_enqueue_style('systemcss', get_template_directory_uri().'/style.css');
        wp_enqueue_script('bootjs', get_template_directory_uri().'/assets/js/bootstrap.min.js');
        wp_enqueue_script('sticky-header', get_template_directory_uri() . '/assets/js/sticky-header.js', array('jquery'), null, true);

    }
    add_theme_support('widgets');
    add_theme_support('menus');
    add_theme_support('post-thumbnails');

    add_image_size('post-preview', 280, 180, true);
    register_nav_menus(
        array(
            'header-menu' => 'Header Menu', 
            'footer-menu' => 'Footer Menu',
            'sidebar-menu' => 'Sidebar Menu'
        )
    );
    // register sidebars

}

add_action('init', 'sherpa_init');
function custom_admin_styles() {
    wp_enqueue_style( 'admin-custom-style', get_template_directory_uri() . '/assets/css/admin-style.css' );
}
add_action( 'admin_enqueue_scripts', 'custom_admin_styles' );

add_action( 'widgets_init', function(){    
        register_sidebar( array(
            'id'            => 'sidebar-1',
            'name'          => 'Primary Sidebar', 'sherpawp',
            'description'   => 'A short description of the sidebar.',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) ); 
        register_sidebar( array(
            'id'            => 'footer-sidebar-1',
            'name'          => 'Footer Sidebar1', 'sherpawp',
            'description'   => 'A short description of the sidebar.',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
        register_sidebar( array(
            'id'            => 'footer-sidebar-2',
            'name'          => 'Footer Sidebar-2', 'sherpawp',
            'description'   => 'A short description of the sidebar.',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ) );
});

function sherpa_custom_logo_setup(){
    $defaults = array(
        'height'                => 100,
        'width'                 => 400,
        'flex-height'           => true,
        'flex-width'            => true,
        'header-text'           => array('site-title', 'site-description'),
        'unlink-homepage-logo'  => false,
    );
    add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'sherpa_custom_logo_setup');
function sherpawp_customize_register( $wp_customize ){

    $wp_customize -> add_section( 'sherpawp_slider_settings', array(
        'title'             => __('Slider Image Settings'),
        'description'       => __('Edit slider image settings'),
        //'panel'             =>
        'priority'          => 160,
        'capability'        => 'edit_theme_options',
        //'theme_supports'    => 
    ));
    $wp_customize->add_setting( 'setting_id', array(
        'type' => 'theme_mod', // or 'option'
        'capability' => 'edit_theme_options',
        'theme_supports' => '', // Rarely needed.
        'default' => '',
        'transport' => 'refresh', // or postMessage
        'sanitize_callback' => 'sanitize_text_field',
        //'sanitize_js_callback' => '', // Basically to_json.
    ) );
    $wp_customize->add_control( 'setting_id', array(
        'type' => 'text',
        // Within the section.'priority' => 10, 
        'section' => 'Slider Image Settings', // Required, core or custom.
        'label' => __( 'Some text' ),
        'description' => __( 'This is a date control with a red border.' ),
        'input_attrs' => array(
          'class' => 'my-custom-class-for-js',
          'style' => 'border: 1px solid #900',
          'placeholder' => __( 'mm/dd/yyyy' ),
        ),
      ) );
    /******************
     * Customizer:
     * Color Selector
     * creates css variables based on Colors selected:
     * var(--primary-color)
     * var(--secondary-color)
    */
    $wp_customize->add_setting('primary_color', array(
        'default'   => '#3498db',
        'transport' => 'refresh',
    ));

    $wp_customize->add_setting('secondary_color', array(
        'default'   => '#2ecc71',
        'transport' => 'refresh',
    ));
    $wp_customize->add_setting('accent_color', array(
        'default'   => '#ababab',
        'transport' => 'refresh',
    ));

    // Add controls
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color_control', array(
        'label'    => __('Primary Color', 'sherpawp'),
        'section'  => 'colors',
        'settings' => 'primary_color',
    )));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color_control', array(
        'label'    => __('Secondary Color', 'sherpawp'),
        'section'  => 'colors',
        'settings' => 'secondary_color',
    )));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color_control', array(
        'label'    => __('Accent Color', 'sherpawp'),
        'section'  => 'colors',
        'settings' => 'accent_color',
    )));
    /* END CUSTOM COLORS */
    /* FOOTER SETTINGS */
    $wp_customize->add_section( 'sherpawp_footer_settings', array(
        'title'       => __( 'Footer Settings', 'sherpawp' ),
        'description' => __( 'Customize the footer area', 'mytheme' ),
        'priority'    => 160,
    ) );

    // Add setting for footer background color
    $wp_customize->add_setting( 'footer_background_color', array(
        'default'   => '#333333',
        'transport' => 'refresh',
    ) );

    // Add control for footer background color
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_background_color_control', array(
        'label'    => __( 'Footer Background Color', 'mytheme' ),
        'section'  => 'sherpawp_footer_settings',
        'settings' => 'footer_background_color',
    ) ) );

    // Add setting for footer text color
    $wp_customize->add_setting( 'footer_text_color', array(
        'default'   => '#ffffff',
        'transport' => 'refresh',
    ) );

    // Add control for footer text color
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_text_color_control', array(
        'label'    => __( 'Footer Text Color', 'mytheme' ),
        'section'  => 'sherpawp_footer_settings',
        'settings' => 'footer_text_color',
    ) ) );

    // Add setting for footer text
    $wp_customize->add_setting( 'footer_text', array(
        'default'           => __( '© 2024 My Website', 'mytheme' ),
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    // Add control for footer text
    $wp_customize->add_control( 'footer_text_control', array(
        'label'    => __( 'Footer Text', 'mytheme' ),
        'section'  => 'sherpawp_footer_settings',
        'settings' => 'footer_text',
        'type'     => 'text',
    ) );
    /* End Footer Settings */
    /* Customize Hero Banner */
    $wp_customize->add_section('hero_section', array(
        'title' => __('Hero Section', 'mytheme'),
        'priority' => 30,
    ));

    $wp_customize->add_setting('hero_title', array(
        'default' => 'Welcome to Our Website',
        'transport' => 'refresh',
    ));

    $wp_customize->add_setting('hero_subtitle', array(
        'default' => 'Your Success, Our Commitment',
        'transport' => 'refresh',
    ));

    $wp_customize->add_setting('hero_button_text', array(
        'default' => 'Learn More',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('hero_title_control', array(
        'label' => __('Hero Title', 'mytheme'),
        'section' => 'hero_section',
        'settings' => 'hero_title',
    ));

    $wp_customize->add_control('hero_subtitle_control', array(
        'label' => __('Hero Subtitle', 'mytheme'),
        'section' => 'hero_section',
        'settings' => 'hero_subtitle',
    ));

    $wp_customize->add_control('hero_button_text_control', array(
        'label' => __('Hero Button Text', 'mytheme'),
        'section' => 'hero_section',
        'settings' => 'hero_button_text',
    ));
    /* End Hero */
}
add_action('customize_register', 'sherpawp_customize_register');
function sherpawp_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#3498db');
    $secondary_color = get_theme_mod('secondary_color', '#2ecc71');
    $accent_color = get_theme_mod('accent_color', '#ababab');
    ?>
    <style type="text/css">
        :root {
            --primary-color: <?php echo esc_attr($primary_color); ?>;
            --secondary-color: <?php echo esc_attr($secondary_color); ?>;
            --accent-color: <?php echo esc_attr($accent_color); ?>
        }
    </style>
    <?php
}
add_action('wp_head', 'sherpawp_customizer_css');
//Add Custom Colors to head
function sherpawp_custom_colors() {
    // Get the colors from the customizer settings
    $primary_color = get_theme_mod('primary_color', '#3498db');
    $secondary_color = get_theme_mod('secondary_color', '#2ecc71');

    // Output the colors as CSS variables
    echo "<style>
        :root {
            --primary-color: $primary_color;
            --secondary-color: $secondary_color;
        }
    </style>";
}
add_action('wp_head', 'sherpawp_custom_colors');

function sherpa_def_image_size($image, $container_height, $type, $redirect=''){
    $image_out = wp_get_attachment_image_src($image, 'full');
    $width =($image_out[1]*$container_height)/$image_out[2];

    if($type == 0){
        return 'style="width: '. $width . 'px;"';
    }
    if($type == 1){
        if($redirect != ''){
            return '<a href= ' . $redirect . '<img src="' . $image_out[0] . '" style="width:' . $width . 'px;"></a>';
        }
        else{
            return '<img src="' . $image_out[0] . '" style="width:' . $width . 'px;">';
        }
    
    }
    
}
//Callable functions
function the_placeholder_image($size = 'post-thumbnail', $attr = '', $class = '') {

    $placeholder_url = get_template_directory_uri() . '/assets/img/placeholders/sherpa1080p.png';
        
    // Determine the size attributes for the placeholder image
    $sizes = array(
        'thumbnail' => array(320, 180),   // 16:9 aspect ratio
        'medium' => array(640, 360),      // 16:9 aspect ratio
        'medium_large' => array(768, 432),// 16:9 aspect ratio
        'large' => array(1024, 576),      // 16:9 aspect ratio
        'full' => array(1920, 1080),      // 16:9 aspect ratio (HD resolution)
    );

    $width = isset($sizes[$size][0]) ? $sizes[$size][0] : '';
    $height = isset($sizes[$size][1]) ? $sizes[$size][1] : '';

    // Add width and height attributes if specified
    $size_attr = '';
    if ($width) {
        $size_attr .= 'width="' . $width . '" ';
    }
    if ($height) {
        $size_attr .= 'height="' . $height . '" ';
    }

    echo '<img src="' . esc_url($placeholder_url) . '" ' . $size_attr;

    // Add additional attributes from $attr parameter
    if (!empty($attr)) {
        foreach ($attr as $key => $value) {
            echo $key . '="' . esc_attr($value) . '" ';
        }
    }

    echo 'alt="' . esc_attr(get_the_title()) . '">';
}
// Add CPTS
// Register Projects Custom Post Type
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
            
            <table id="newmeta" class="sherpa-custom-field-table">
            <thead class="sherpa-thead">
            <tr>
            <th class="left sherpa-th"><label for="image" class="sherpa-table-label">Image</label></th>
            <th class="right sherpa-th"><label for="Caption" class="sherpa-table-label">Caption</label></th>
            </tr>
            </thead>
            <tbody class="sherpa-custom-field-body" id="sherpa-gallery-body">
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
                        </tr>
                        </tbody>
                    </table>

        </div>
        <input id="project-gallery-images" name="project-gallery-images" value="<?php echo esc_attr(json_encode($gallery_images)); ?>" />
        
    </div>
    <script>
    jQuery(document).ready(function($) {
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
                const rowAdd = document.getElementById('sherpa-add').cloneNode(true);
                //gets the ID of a selected image
                let newAttachmentIds = newAttachment[0].id;
                //adds it to the total list of all image ids in an input field
                attachmentIds = attachmentIds.concat(newAttachmentIds);
                $('project-gallery-images').val(JSON.stringify(attachmentIds));
                console.log(attachmentIds);
                //the select buttons div container class is called replace me because when a user 
                let newImageLocation = document.getElementById("replace-me");
                newImageLocation.classList.remove("gallery-add");
                newImageLocation.classList.add("gallery-image");
                newImageLocation.innerHTML = '';
                let newDiv = document.createElement('div');
                let x = "img" + (document.querySelectorAll(".gallery-row").length+1);
                newDiv.id = x;
                newDiv.classList.add("gallery-image");
                let newImage = document.createElement('img');
                newImage.src = newAttachment[0].url;
                newImageLocation.appendChild(newDiv);
                newDiv.appendChild(newImage);
                document.getElementById("sherpa-gallery-body").appendChild(rowAdd);
                attachmentIds.forEach(function(attachmentId) {
                    wp.media.attachment(attachmentId).fetch().done(function(attachment) {
                        var imageUrl = attachment.url;
                        $('#gallery-images-container').append('<li><img src="' + imageUrl + '" class="gallery-image-preview" /></li>');
                    });
                });
            });

            customUploader.open();
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

function enqueue_custom_scripts() {
    //wp_enqueue_script('sticky-header', get_template_directory_uri() . '/js/sticky-header.js', array(), null, true);
    wp_enqueue_script('navbar-js', get_template_directory_uri() . '/assets/js/navbar-vp-optimize.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
    //wp_enqueue_script();
require get_template_directory().'/template-parts/walker.php';
require get_template_directory().'/template-parts/widgets.php';

?>