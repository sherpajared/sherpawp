<?php
/**
 * Template part for displaying project images
 */

?>
<style>
.gallery-2{
    max-height: 80vh;
    padding: 1em;
    margin: 2em;
   
}
.sherpa-gallery{
    display: grid;
    gap: 10px;
    grid-template-rows: 1fr;
    grid-template-columns: 2fr 5fr;
    width: 100%;
    min-width: 100%;
    max-height: 80vh;
    height: 80vh;
    
}
.carousel-container{
    display: grid;
    grid-template-rows: 1fr 1fr 1fr 1fr;
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
    border-radius: 10px; /* Rounded corners */
    overflow: hidden; /* Ensure content does not overflow */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19); /* Shiny effect */
    background-color: #fff; /* Optional background color for better contrast */
}

.carousel-img {
    object-fit: contain;

}
.main-image-container{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    width: 100%;

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
        <div class="carousel-item-container cast">
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
        </div>
    </div>
    <div class="main-sec-container">
        <div class="lightbox main-image-container">
            <img class="main-img" src="http://localhost/wordpress/wp-content/themes/sherpawp/assets/img/placeholders/sherpa3-2.png" alt="main-image">
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
  document.querySelectorAll('carousel-item-container').forEach(ele => {
    ele.addEventListener('click', function() {
      document.querySelectorAll('carousel-item-container').forEach(item => {item.classList.remove('active')});
      

      //set active class and update image val
      this.classList.add('active');
        console.log(this);
      const mainImageSrc = this.querySelector('img').getAttribute('main-img');
      console.log(mainImageSrc);
      document.querySelector('.lightbox img').setAttribute('src', mainImageSrc);
    });
  });
});
</script>
