<?php
/*Template name: downloadContent */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
nectar_page_header( $post->ID );
$nectar_fp_options = nectar_get_full_page_options();

// ----Custom code starts here----
function dateDisplay($input){
    $monthInt = substr($input, 5, 2);
    if($monthInt == "01"){$monthStr = "Jan";}
    else if($monthInt == "02"){$monthStr = "Feb";}
    else if($monthInt == "03"){$monthStr = "Mar";}
    else if($monthInt == "04"){$monthStr = "Apr";}
    else if($monthInt == "05"){$monthStr = "May";}
    else if($monthInt == "06"){$monthStr = "Jun";}
    else if($monthInt == "07"){$monthStr = "Jul";}
    else if($monthInt == "08"){$monthStr = "Aug";}
    else if($monthInt == "09"){$monthStr = "Sep";}
    else if($monthInt == "10"){$monthStr = "Oct";}
    else if($monthInt == "11"){$monthStr = "Nov";}
    else if($monthInt == "12"){$monthStr = "Dec";}
    return substr($input, 0, 5) . $monthStr . substr($input, 7, 3);
}


require_once WP_CONTENT_DIR . '/themes/salient-child/config.php'; 

// We get the job_nr from the title of the page itself
$job_NR = strstr(str_replace("/download", "", $_SERVER['REQUEST_URI']),"/", true);

// Get the orders details
$query1 = "SELECT orders.job_nr, customer.name, orders.date_of_order, orders.order_status
    FROM orders
    INNER JOIN customer
    ON orders.customer_FK = customer.customer_ID
    WHERE orders.job_nr = $job_NR";
$result1 = mysqli_query($conn, $query1);
$posts1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);
mysqli_free_result($result1);

//Get the banners for the order
$query2 = "SELECT * FROM banners WHERE job_nr_FK = $job_NR";
$result2 = mysqli_query($conn, $query2);
$posts2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
mysqli_free_result($result2);

if(isset($_POST['submit'])){
    $query3 = "UPDATE orders SET order_status = 'order_complete' WHERE job_nr = $job_NR";
    if(mysqli_query($conn, $query3)){
        $displayClass = "visible";
        $mailResult = '<h2>Bestillingen er nu afsluttet!</h2><h3>Mange tak for jeres samarbejde, pøj pøj for nu :-)</h3>';
    }
}

mysqli_close($conn);

$bannerCntr = 0;
?>
<head><link rel="stylesheet" href="/wp-content/themes/salient-child/bannerform/bannerform-style.css"></head>

<style type="text/css">
    .comment-list{padding:0!important;}
    .banner{position:relative;display:flex;flex-direction:column;}
    .approve-content{display:flex;flex-direction:column-reverse;}
    .approve-content > *, .banner {margin-bottom:40px;}
    .title{text-align:center;}
    .content-text{margin-bottom:80px;}
    .refresh-icon{font-weight:100;}
    #approve-btn{background:green!important;padding:30px 50px!important;font-size:20px;}
    .download-button{width:120px;margin-top:10px;}
    /* For some reason menubar is fucked up, dunno why, so this is the best recovery for now */
    .admin-bar #header-outer, .logged-in.buddypress #header-outer {top:0!important;}
</style>

<div class="container-wrap">
	<div class="<?php if ( $nectar_fp_options['page_full_screen_rows'] !== 'on' ) { echo 'container'; } ?> main-content">
        
        <!-- The comments and the comment form can't come after the 'foreach' for some reason -->
        <div class="approve-content">
            <?php if($posts1[0]['order_status'] != 'order_complete'){ ?>
                <form method="post">
                    <h3>Klik på knappen for fortælle os at alt er som det skal være.</h3>
                    <button type="submit" name="submit" id="approve-btn">Afslut bestilling</button>
                </form>
            <?php } else { echo "<h3 style='color:green;'>Bestillingen er afsluttet.</h3>"; }?>

            <div id="download-all" class="bigBtn btn">Download alle zipfiler</div> 

            <div class="images-container">
                <?php foreach($posts2 as $post) :
                    $bannerCntr++; ?>

                    <div class="banner">          
                        <div class="image-details">
                            <div>
                                <p> <?= $post['type']; ?> </p>
                                <p> <?= $post['platform']; ?> </p>
                                <p> <?= $post['width']; ?> x <?= $post['height']; ?> </p>
                            </div>
                        </div>
                        <div class="image-nr">
                            <h5 style="margin-top: 10px;"> <?= $bannerCntr; ?> </h5>
                            <p class="refresh-icon" style="padding-bottom: 0;">↺</p>
                        </div>
                        <iframe src="<?= $post['html_link']; ?>" class="iframe" style="width: <?= $post['width']; ?>px; height: <?= $post['height']; ?>px; opacity: 1; visibility: visible;"></iframe>
                        <a class="nectar-button small regular accent-color  regular-button download-button" style="visibility: visible;" href="<?= $post['zip_link']; ?>" data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff"><span>Download Zipfil</span></a>
                    </div> 
                <?php endforeach; ?>
            </div>

            <div class="content-text">
                <h3>Her kan du se de online færdigelavede bannerne og download alle deres filer i en zipfil via knappen under dem.</h3>
                <h3>Hvis du gerne vil gense et banners start animation og de ikke refresher af sig selv, så klik på den runde pil under bannerets nummer.</h3>
                <h3>Mange tak for jobbet.</h3>
                <h3>-Venlig hilsen Marketsquare</h3>
            </div>

            <div class="title">
                <h1><?=$posts1[0]['name']." Banner download, Job nr. ".$posts1[0]['job_nr'];?></h1>
                <h2>Bestilt den <?=dateDisplay($posts1[0]['date_of_order']);?></h2>
            </div>
        </div>

        <div id="mailResult" class="<?=$displayClass?> popUp">
            <div class="popUpContent mailResultStyle">
                <span class="closePopUp">&times;</span>
                <?=$mailResult?>
            </div>
        </div>
	</div><!--/container-->
</div><!--/container-wrap-->

<script src="/wp-content/themes/salient-child/ads/ads.js"></script>
<script src="/wp-content/themes/salient-child/banners/banner.js"></script>
<script>
    // The download all zipfiles button
    document.getElementById("download-all").addEventListener("click", function(){
        downloadBtns = document.getElementsByClassName("download-button");
        for (let i = 0; i < downloadBtns.length; i++) {
            window.open(downloadBtns[i].href);
        }
    });
</script>