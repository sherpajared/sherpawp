<?php
/**
 * Template part for displaying project images
 */

?>
<style>
    .gallery-section{
        display: flex;
        justify-content: center;
    }
    .gallery{
        width: 80%;
    }
    .gallery-main-img{
        width: auto;
        height: 600px;
        object-fit: cover;
    }
    .multi-carousel {
  overflow: hidden;
}

.multi-carousel-inner {
  display: flex;
  flex-direction: column;
  /* Adjust as needed for your design */
}

.multi-carousel-item {
  flex: 1 0 33.33%; /* Adjust to fit 3 items */
  height: 600px;
}

div[withcaption="false"]{

}
</style>

<div class="gallery vertical">
  <div class="row">
    <div class="col-4 col-sm-3">
      <div class="multi-carousel vertical"  carousel-items="3">
        <div class="multi-carousel-inner">
          <div class="multi-carousel-item active">
            <div class="image-wrapper">
            <img
              src="http://localhost/wordpress/wp-content/themes/sherpawp/assets/img/placeholders/sherpa3-2.png"
              main-image="http://localhost/wordpress/wp-content/themes/sherpawp/assets/img/placeholders/sherpa3-2.png"
              alt="sherpa-placeholder"
              class="active w-100"
            /></div>
            
          </div>
          <div class="multi-carousel-item">
            <div class="img-wrapper"><img
              src="https://picsum.photos/200/300"
              main-image="https://picsum.photos/200/300"
              alt="picsum1"
              class="w-100"
            /></div>
           
          </div>
          <div class="multi-carousel-item">
            <div class="img-wrapper"><img
              src="https://picsum.photos/200/300"
              main-image="https://picsum.photos/200/300"
              alt="picsum2"
              class="w-100"
            /></div>
           
          </div>
          <div class="multi-carousel-item">
            <div class="img-wrapper"><img
              src="https://picsum.photos/200/300"
              main-image="https://picsum.photos/200/300"
              alt="picsum3"
              class="w-100"
            /></div>
            
          </div>
        </div>
        <button
          class="carousel-control-prev"
          tabindex="0"
          type="button"
          data-slide="prev"
        >
          <span
            class="carousel-control-prev-icon"
            aria-hidden="true"
          ></span>
        </button>
        <button
          class="carousel-control-next"
          tabindex="0"
          type="button"
          data-slide="next"
        >
          <span
            class="carousel-control-next-icon"
            aria-hidden="true"
          ></span>
        </button>
      </div>
    </div>
    <div class="col-8 col-sm-9">
      <div class="lightbox" data-lightbox-init>
        <img
          src="http://localhost/wordpress/wp-content/themes/sherpawp/assets/img/placeholders/sherpa3-2.png"
          alt="sherpa-placeholder"
          class="gallery-main-img active w-100"
        />
        
      </div>
    </div>
  </div>
</div>
<div class="project-images">
    <?php
    // Check if the post has a featured image (post thumbnail) and display it
    echo '<div class="project-thumbnail">';
    if (has_post_thumbnail()) {
        
        the_post_thumbnail('large'); // Display the featured image with 'large' size
        
    }
    else{
        echo '<img src="' . get_template_directory_uri() . '/assets/img/placeholders/sherpa3-2.png" alt="' . get_the_title() . '" />';
    }
    echo '</div>';
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
  document.querySelectorAll('.multi-carousel-item').forEach(ele => {
    ele.addEventListener('click', function() {
      document.querySelectorAll('.multi-carousel-item').forEach(item => {item.classList.remove('active')});
      

      //set active class and update image val
      this.classList.add('active');
        console.log(this);
      const mainImageSrc = this.querySelector('img').getAttribute('main-image');
      console.log(mainImageSrc);
      document.querySelector('.lightbox img').setAttribute('src', mainImageSrc);
    });
  });
});
</script>
