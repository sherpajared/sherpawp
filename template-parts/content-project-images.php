<?php
/**
 * content-project-images.php 
 * 
 * @var $gallery_images - gallery images used to populate image carousel
 * @var $gallery_captions - matched to $gallery_images, should always be the same length
 * 
 */
?>

<div class="sherpa-gallery nano">
    <div class="carousel-controller">
        <button id="project-slider-prev" class="slider-control up slick-prev"></button>
        <div class="carousel-container nano-content">
            <?php
                $gallery_captions = get_project_gallery_captions(get_the_ID());                 
                $gallery_images = get_project_gallery_images(get_the_ID());
                $gallery_images = is_array($gallery_images) ? $gallery_images : array($gallery_images);
                $gallery_captions = is_array($gallery_captions) ? $gallery_captions : array($gallery_captions);
                if(!empty($gallery_images)){
                    $first = true;
                    foreach($gallery_images as $index => $src){
                        if($first){    
                            echo '<div class="carousel-item-container cast"><pre class="caption hidden" pull-caption>' . 
                            (isset($gallery_captions[$index]) && !is_null($gallery_captions[$index]) ? $gallery_captions[$index] : '') .
                            '</pre>';
                            $first = false;
                        }
                        else{
                            echo '<div class="carousel-item-container"><pre class="caption hidden" pull-caption>' . 
                            (isset($gallery_captions[$index]) && !is_null($gallery_captions[$index]) ? $gallery_captions[$index] : '') . $gallery_captions[$index] 
                            . '</pre>';
                        }
                        echo '<img class="carousel-img" src="' . $src . '" main-img="' . $src . '" alt="image">';
                        echo '</div>';
                    }
                }
            ?>
            <div class="sherpa-bright-overlay"></div>
        </div><!-- .carousel-container.nano-content -->
    <button id="project-slider-next" class="slider-control down"></button>
    </div><!-- .carousel-controller -->
    <div class="main-sec-container">
        <div class="lightbox main-image-container">
            <?php
                $gallery_images = get_project_gallery_images(get_the_ID());
                
                $gallery_captions = get_project_gallery_captions(get_the_ID());
                if(!empty($gallery_images)){
                    echo '<figure class="main-fig">';
                    echo '<img class="main-img" src="' . $gallery_images[0] . '" alt="main-image"><div class="sherpa-bright-overlay"></div>';
                    echo '<figcaption class="caption" put-caption>' . $gallery_captions[0] . '</figcaption></figure>';
                }
                
            ?>
              
        </div> <!-- .lightbox.main-image-container --> 
         
    </div>  <!-- .main-sec-container -->
</div> <!-- .sherpa-gallery-nano -->

<div class="project-images">
    <?php
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
</div> <!-- .project-images -->
<script>
/* Run on DOM Loaded, 
    Jquery to init slick slider on .carousel-container
*/
document.addEventListener('DOMContentLoaded', function() {
    $(document).ready(function(){
        $('.carousel-container').slick({
        infinite: false,
        slidesToShow: 3,
        slidesToScroll: 1,
        vertical: true,
        variableWidth: false,
        nextArrow: '#project-slider-next',
        prevArrow: '#project-slider-prev',  
    });
});
/*    
function initializeCarousel() {
    const carousel = document.querySelector('.multi-carousel');
}
initializeCarousel();
 */

<?php
/**
 * evenListener(click)
 * 
 * When .carousel-item-container in .carousel-container is clicked, it is cast to the main image in .lightbox
 */
?>
  document.querySelectorAll('.carousel-item-container').forEach(ele => {
    ele.addEventListener('click', function() {
      document.querySelectorAll('.carousel-item-container').forEach(item => {item.classList.remove('cast')});
      
        console.log("sherpa::content-project-images")
      //set active class and update image val
      this.classList.add('cast');
      let caption = this.querySelectorAll('[pull-caption]');
      
      const mainImageSrc = this.querySelector('img').getAttribute('main-img');
      const mainCaption = document.querySelector('[put-caption]');
      mainCaption.innerText = caption[0].innerText;
     
      document.querySelector('.lightbox img').setAttribute('src', mainImageSrc);
    });
  });
});
</script>

<?php 
/**
 * get_project_gallery_images()
 * 
 * Queries database for images stored under the current post 
 * 
 * @param $post_id
 * @return $image_sources array
 */
function get_project_gallery_images($post_id) {
    // Retrieve the gallery images from the post meta
    
    $gallery_images = get_post_meta($post_id, 'project-gallery-images', true);
    $gallery_images = is_array($gallery_images) ? $gallery_images : array($gallery_images);
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
/**
 * get_project_gallery_captions()
 * 
 * @param $post_id
 * @return $galler_captions array
 * 
 */
function get_project_gallery_captions($post_id){
    $gallery_captions = get_post_meta($post_id, 'project-gallery-captions', true);
    return $gallery_captions;
}
?>