<?php
/*Template name: test_download*/
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
nectar_page_header( $post->ID );
$nectar_fp_options = nectar_get_full_page_options();
?>

<!-- HTML for the banner form -->
<!-- Made by: Thomas Dyrholm Siemsen -->
<?php 
    require_once WP_CONTENT_DIR . '/themes/salient-child/config.php'; 
    
	
	$query = 'SELECT * FROM banners WHERE job_nr_FK = 1'; // Create Query
	$result = mysqli_query($conn, $query);                    // Get Result
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);	      // Fetch Data
	mysqli_free_result($result);                              // Free Result
    mysqli_close($conn);	                                  // Close Connection

    $bannerCntr = 0;
?>

<div class="container-wrap">
	<div class="<?php if ( $nectar_fp_options['page_full_screen_rows'] !== 'on' ) { echo 'container'; } ?> main-content">

        <!-- The html taken from the Wordpress version -->
        <div id="images-container" data-column-margin="default" data-midnight="dark" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row standard_section " style="padding-top: 0px; padding-bottom: 0px; ">
            <div class="row-bg-wrap" data-bg-animation="none" data-bg-overlay="false">
                <div class="inner-wrap">
                    <div class="row-bg" style="">
                    </div>
                </div>
                <div class="row-bg-overlay">
                </div>
            </div>
            <div class="col span_12 dark left">
	            <div class="vc_col-sm-12 wpb_column column_container vc_column_container col no-extra-padding instance-1" data-t-w-inherits="default" data-border-radius="none" data-shadow="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
		            <div class="vc_column-inner">
                        <div class="column-bg-overlay-wrap" data-bg-animation="none">
                            <div class="column-bg-overlay">
                            </div>
                        </div>
                        <div class="wpb_wrapper">
                        
                            <?php foreach($posts as $post) :
                                if ($post['conf_show'] == 1){
                                    $bannerCntr++; ?>

                                    <div data-midnight="" data-column-margin="default" data-bg-mobile-hidden="" class="wpb_row vc_row-fluid vc_row inner_row standard_section   image-div " style="padding-top: 0px; padding-bottom: 0px; ">
                                        <div class="row-bg-wrap">
                                            <div class="row-bg   " style="">
                                            </div> 
                                        </div>
                                        <div class="col span_12  left">
                                            <div class="vc_col-sm-12 wpb_column column_container vc_column_container col child_column no-extra-padding instance-2" data-t-w-inherits="default" data-shadow="none" data-border-radius="none" data-border-animation="" data-border-animation-delay="" data-border-width="none" data-border-style="solid" data-border-color="" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
                                                <div class="vc_column-inner">
                                                    <div class="column-bg-overlay-wrap" data-bg-animation="none">
                                                        <div class="column-bg-overlay">
                                                        </div>
                                                    </div>
                                                    <div class="wpb_wrapper">          
                                                        <div class="wpb_text_column wpb_content_element  image-details">
                                                            <div class="wpb_wrapper">
                                                                <p> <?= $post['type']; ?> </p>
                                                                <p> <?= $post['platform']; ?> </p>
                                                                <p> <?= $post['width']; ?> x <?= $post['height']; ?> </p>
                                                            </div>
                                                        </div>
                                                        <div class="wpb_raw_code wpb_content_element wpb_raw_html vc_custom_1581501198456">
                                                            <div class="wpb_wrapper">
                                                                <div class="wpb_text_column image-nr">
                                                                    <h5 style="margin-top: 10px;"> <?= $bannerCntr; ?> </h5>
                                                                    <p class="refresh-icon" style="padding-bottom: 0;">↺</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="wpb_raw_code wpb_content_element wpb_raw_html vc_custom_1581501606261">
                                                            <div class="wpb_wrapper">
                                                                <iframe src="<?= $post['html_link']; ?>" class="iframe" style="width: <?= $post['width']; ?>px; height: <?= $post['height']; ?>px; opacity: 1; visibility: visible;"></iframe>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                <?php }
                            endforeach; ?>
                        </div> 
                    </div>
                </div> 
            </div>
        </div> 
	</div><!--/container-->
</div><!--/container-wrap-->
<?php print_r($_POST['list']); ?>

<script src="/wp-content/themes/salient-child/ads/ads.js"></script>
<script>
    // The individual refresh buttons
    refreshBtns = document.getElementsByClassName("refresh-icon");
    iframes = document.getElementsByClassName("iframe");
    for (let i = 0; i < refreshBtns .length; i++) {
        refreshBtns[i].onclick = function(){iframes[i].src += '';};
    }
</script>

<?php get_footer(); ?>