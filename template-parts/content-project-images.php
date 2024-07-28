<?php
/**
 * Template part for displaying project images
 */

?>
<style>
.gallery-2{
    max-height: 60vh;
    width: 60%;
    height: 60vh;
    padding: 1em;
    margin: 2em;
   
}
.sherpa-gallery{
    display: grid;
    gap: 0 10px;
    grid-template-rows: 1fr;
    grid-template-columns: 2fr 6fr;
    width: auto;
    max-height: 60vh;
    height: 60vh;
    
}
.carousel-container{
    display: grid;
    grid-auto-rows: auto;
    grid-template-columns: 1fr;
    max-height: 100%;
    height: inherit;
    box-sizing: border-box;
    gap: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
}
.carousel-item-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: auto;
    box-sizing: border-box;
    border-radius: 5px; /* Rounded corners */
    overflow: hidden; /* Ensure content does not overflow */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19); /* Shiny effect */
    background-color: #fff; /* Optional background color for better contrast */
}

.carousel-img {
    width: 100%;
    object-fit: contain;

}
.main-sec-container{
    display: flex;
    align-items: center;
    justify-content: center;
    place-items: center;
    max-height: 90%;
    width: 90%;
    height: inherit;
    box-sizing: border-box;
    gap: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
    margin: auto;
    
    
}
.main-image-container{
    display: flex;
    border-radius: 10px;
    overflow: hidden;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100%;
    object-fit: contain;
    
}
.main-img{
    max-height: 100%;
    width: 100%;
    height: auto;
    object-fit: contain;

}

</style>
<div class="sherpa-gallery">
    <div class="carousel-container">
        <?php
        
                   $gallery_images = get_project_gallery_images(get_the_ID());
                    if(!empty($gallery_images)){
                        $first = true;
                        foreach($gallery_images as $src){
                            if($first){    
                                echo '<div class="carousel-item-container cast">';
                                $first = false;
                            }
                            else{
                                echo '<div class="carousel-item-container">';
                            }
                            echo '<img class="carousel-img" src="' . $src . '" main-img="' . $src . '" alt="image1">';
                            echo '</div>';
                        }
                    }

        ?>
        <!--<div class="carousel-item-container cast">
            <img 
                class="carousel-img"
                src="http://localhost/wordpress/wp-content/themes/sherpawp/assets/img/placeholders/sherpa3-2.png"
                main-img=""
                alt="image1"
            >
        </div>
        <div class="carousel-item-container">
            <img 
                class="carousel-img"
                src="http://localhost/wordpress/wp-content/themes/sherpawp/assets/img/placeholders/sherpa3-2.png"
                main-img=""
                alt="image2"
            >
        </div>
        <div class="carousel-item-container active">
            <img 
                class="carousel-img"
                src="http://localhost/wordpress/wp-content/themes/sherpawp/assets/img/placeholders/sherpa3-2.png"
                main-img=""
                alt="image3"
            >
        </div>
        <div class="carousel-item-container active">
            <img 
                class="carousel-img"
                src="http://localhost/wordpress/wp-content/themes/sherpawp/assets/img/placeholders/sherpa3-2.png"
                main-img=""
                alt="image4"
            >
        </div>-->
    </div>
    <div class="main-sec-container">
        <div class="lightbox main-image-container">
            <?php
                $gallery_images = get_project_gallery_images(get_the_ID());
                if(!empty($gallery_images)){
                    echo '<img class="main-img" src="' . $gallery_images[0] . '" alt="main-image">';
                }
            ?>
        </div>       
    </div>
</div>

<div class="project-images">
    <?php
    // Check if the post has a featured image (post thumbnail) and display it
    //echo '<div class="project-thumbnail">';
    if (has_post_thumbnail()) {
        
       //   the_post_thumbnail('large'); // Display the featured image with 'large' size
        
  }
    else{
        //echo '<img src="' . get_template_directory_uri() . '/assets/img/placeholders/sherpa3-2.png" alt="' . get_the_title() . '" />';
    }
    //echo '</div>';
    // Example: Display additional gallery images if available
    $gallery_images = get_post_meta(get_the_ID(), 'gallery_images', true); // Fetch gallery images meta data

    if ($gallery_images) {
        $gallery_images = explode(',', $gallery_images); // Split image URLs by comma if stored as a comma-separated string

        foreach ($gallery_images as $image_url) {
            ?>
            <img src="<?php echo esc_url($image_url); ?>" alt="">
            <?php
        }
    }
    ?>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  function initializeCarousel() {
    const carousel = document.querySelector('.multi-carousel');
    /***********/
  }

  initializeCarousel();
 
  // Listener for click
  document.querySelectorAll('.carousel-item-container').forEach(ele => {
    ele.addEventListener('click', function() {
      document.querySelectorAll('.carousel-item-container').forEach(item => {item.classList.remove('cast')});
      console.log("hellooo");

      //set active class and update image val
      this.classList.add('cast');
      console.log(this);
      const mainImageSrc = this.querySelector('img').getAttribute('main-img');
      console.log(mainImageSrc);
      document.querySelector('.lightbox img').setAttribute('src', mainImageSrc);
    });
  });
});
</script>
<?php function get_project_gallery_images($post_id) {
    // Retrieve the gallery images from the post meta
    $gallery_images = get_post_meta($post_id, 'project-gallery-images', true);

    // Initialize an array to store image sources
    $image_sources = array();

    // Check if there are any images
    if (!empty($gallery_images)) {
        foreach ($gallery_images as $attachment_id) {
            // Get the URL of the image
            $image_url = wp_get_attachment_url($attachment_id);
            // Add the image URL to the array
            if ($image_url) {
                $image_sources[] = $image_url;
            }
        }
    }

    // Return the array of image sources
    return $image_sources;
}
?>