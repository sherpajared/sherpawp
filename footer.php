<?php
/**
 * footer.php 
 * 
 * Adds footer - used on all pages
 * 
 * @uses get_theme_mod - gets values from the WP Customizer
 * @uses is_active_sidebar() & dynamic_sidebar() in conjunction: if sidebar, display sidebar
 * 
 * @var string $footer_bg_color - background color for footer
 * @var string $footer_text_color - text color for footer
 * @var string $footer_text - content for the footer
 * 
 * @todo implement sections in the footer, working with customizer  
 * 
 * 
 */
// Get customizer settings
    $footer_bg_color = get_theme_mod('footer_background_color', '#333333');
    $footer_text_color = get_theme_mod('footer_text_color', '#ffffff');
    $footer_text = get_theme_mod('footer_text', '© 2024 My Website');
    $footer_columns = json_decode(get_option('footer_columns', json_encode(array())), true);
    
?>
</div>
<footer class="sherpa-footer">
    <style>

    </style>
    <div class="footer-container">
    <!--    <p><?php /*echo esc_html($footer_text); ?></p>
        <?php if (is_active_sidebar('footer-sidebar-1')) : ?>
            <div class="footer-widget-area">
                <?php dynamic_sidebar('footer-sidebar-1'); ?>
            </div>
        <?php endif; ?>
        <?php /if (is_active_sidebar('footer-sidebar-2')) : ?>
            <div class="footer-widget-area">
                <?php //dynamic_sidebar('footer-sidebar-2'); ?>
            </div>
        <?php endif; */?>
    </div> -->
        <?php 
            
            foreach($footer_columns['columns'] as $column){
                ?><div class="column">
                    <h3><?=$column['title']?></h3>
                    <hr>
                    <?php 
                        foreach($column['inputs'] as $entity){ 
                            $content = '<p>' . $entity['input'] . '</p>';
                            if(array_key_exists('link', $entity) && $entity['link'] != ""){
                                ?>
                                    <a href="<?=$entity['link']?>">
                                        <?= $content?>
                                    </a>
                                <?php
                            }
                            else{
                                echo $content;
                            }

                        ?> <!-- Loop to populate footer columns -->
                            
                    <?php
                        }
                    ?>
                </div><?php
            }?>
    <script>
        $(document).ready(function() {
            $(".my-scrollable-element").nanoScroller();
        });
    </script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri() . "/assets/js/slick.min.js";?>">
    <script type="text/javascript" src="<?php echo get_template_directory_uri() . "/assets/js/slick.js";?>">
</footer>
<?php wp_footer(); ?>
</body>
</html>
<?php