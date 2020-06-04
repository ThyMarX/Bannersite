<?php
/*Template name: Customers*/
// Exit if accessed directly.


// THIS ISN'T USED YET BUT WILL BE IN THE FUTURE FOR THE CUSTOMER PAGE


if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
nectar_page_header( $post->ID );
$nectar_fp_options = nectar_get_full_page_options();

// Custom code stats here
require_once WP_CONTENT_DIR . '/themes/salient-child/config.php'; 

$query = "SELECT * FROM customer"; // Create Query
$result = mysqli_query($conn, $query);                    // Get Result
$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);	      // Fetch Data
mysqli_free_result($result);                              // Free Result
mysqli_close($conn);	                                  // Close Connection
?>

<style>
    .order-container{display:block;}
    .order-container > *{margin-bottom:40px;}
    .title{width:100%;text-align:center;border-bottom: 1px solid #ddd;padding-bottom:20px;}
    .order-title{display:flex;align-items:flex-end;margin-bottom:20px;margin-top:30px;}
    .job-nr{width:400px;}
    .order-date{width:300px;}
    .link-btn{font-size:20px!important;padding:30px 50px!important;width:282px;text-align:center;margin-right:30px;}
    /* For some reason menubar is fucked up, dunno why, so this is the best recovery for now */
    .admin-bar #header-outer, .logged-in.buddypress #header-outer {top:0!important;}
</style>

<div class="container-wrap">
    <div class="<?php if ( $nectar_fp_options['page_full_screen_rows'] !== 'on' ) { echo 'container'; } ?> main-content">
        <div class="order-container">
            <h1 class="title">Kundelist</h1>
            <div>
                <h3>Her kan i se alle kunderne i systemet, samt links til kundernes oversigtsider.</h3>
            </div>
            <iframe src="https://banners.msqtest.dk/wp-content/themes/salient-child/files/brugermanual-kunder.pdf" frameborder="0"></iframe>
            <?php foreach ($posts as $post){ 
                
            } ?>
        </div>
	</div><!--/container-->
</div><!--/container-wrap-->