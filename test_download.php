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
    
	
	$query = 'SELECT * FROM `banners` WHERE `job_nr_FK` = 1'; // Create Query
	$result = mysqli_query($conn, $query);                    // Get Result
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);	      // Fetch Data
	mysqli_free_result($result);                              // Free Result
    mysqli_close($conn);	                                  // Close Connection

    $bannerCntr = 0;
?>

<head><link rel="stylesheet" href="/wp-content/themes/salient-child/bannerform/bannerform-style.css"></head>

<style>
    .g{background:grey;}
    .lg{background:lightgrey;}
    .mr{margin-right:20px;}
    .mb{margin-bottom:20px;}
</style>


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
                        
                            <?php foreach($posts as $post) : ?>
                                <?php $bannerCntr++; ?>

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
                                                            <p> <?= $post['']; ?> </p>
                                                            <p> <?= $post['width']; ?> x <?= $post['height']; ?> </p>
                                                        </div>
                                                    </div>
                                                    <div class="wpb_raw_code wpb_content_element wpb_raw_html vc_custom_1581501198456">
                                                        <div class="wpb_wrapper">
                                                            <div class="wpb_text_column image-nr">
                                                                <h5 style="margin-top: 10px;"> <?= $bannerCntr; ?> </h5>
                                                                <p class="refresh-icon" style="padding-bottom:0;font-weight:100;">↺</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="wpb_raw_code wpb_content_element wpb_raw_html vc_custom_1581501606261">
                                                        <div class="wpb_wrapper">
                                                            <iframe src="<?= $post['html_link']; ?>" class="iframe" style="width: <?= $post['width']; ?>px; height: <?= $post['height']; ?>px; opacity: 1; visibility: visible;"></iframe>
                                                        </div>
                                                    </div>
                                                    <a class="nectar-button small regular accent-color  regular-button download-button" style="visibility: visible;" href="<?= $post['zip_link']; ?>" data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff"><span>Download Zipfil</span></a>
                                                </div> 
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                    		<?php endforeach; ?>

                        </div> 
                    </div>
                </div> 
            </div>
        </div> 
        <div id="download-all" class="bigBtn btn">Download alle zipfiler</div> 
	</div><!--/container-->

    <center>
        <div class="airTop2 flex" style="width:1570px;">
            <div class="g" style="width:930px;height:180px;margin:0 320px 20px 320px;"></div>
            <div class="g mr" style="width:300px;height:600px;"></div>
            <div class="flex mr mb" style="width:930px;height:620px;">
                <div class="lg mb" style="width:930px;height:115px;"></div>
                <div class="lg mb" style="width:310px;height:34px;"></div>
                <div class="lg mb" style="width:930px;height:34px;"></div>
                <div class="lg mb" style="width:930px;height:34px;"></div>
                <div class="lg mb" style="width:730px;height:34px;"></div>
                <div>
                    <div class="lg mb" style="width:310px;height:34px;margin-right:300px;"></div>
                    <div class="lg mb" style="width:610px;height:34px;"></div>
                    <div class="lg mb" style="width:610px;height:34px;"></div>
                    <div class="lg mb" style="width:610px;height:34px;"></div>
                    <div class="lg mb" style="width:510px;height:34px;margin-right:100px;"></div>
                </div>
                <div class="g" style="width:300px;height:250px;margin-left:20px;"></div>
            </div>
            <div class="g mr" style="width:120px;height:600px;"></div>
            <div class="g" style="width:160px;height:600px;"></div>
            <div class="g" style="width:728px;height:90px;margin-left:320px;"></div>
        </div>
    </center>
</div><!--/container-wrap-->
<?php print_r($_POST['list']); ?>

<script src="/wp-content/themes/salient-child/ads/ads.js"></script>
<script>
    // The download all zipfiles button
    document.getElementById("download-all").addEventListener("click", function(){
        downloadBtns = document.getElementsByClassName("download-button");
        for (let i = 0; i < downloadBtns.length; i++) {
            window.open(downloadBtns[i].href);
        }
    });

    // The individual refresh buttons
    refreshBtns = document.getElementsByClassName("refresh-icon");
    iframes = document.getElementsByClassName("iframe");
    for (let i = 0; i < refreshBtns .length; i++) {
        refreshBtns[i].onclick = function(){iframes[i].src += '';};
    }
</script>

<?php get_footer(); ?>