<?php
/*Template name: approveContent */
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
$job_NR = strstr(str_replace("/approval", "", $_SERVER['REQUEST_URI']),"/", true);

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
$query2 = "SELECT * FROM banners WHERE job_nr_FK = $job_NR AND approval_show = 1";
$result2 = mysqli_query($conn, $query2);
$posts2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
mysqli_free_result($result2);

if(isset($_POST['submit'])){
    $query3 = "UPDATE orders SET order_status = 'banner_approved' WHERE job_nr = $job_NR";
    if(mysqli_query($conn, $query3)){
        $displayClass = "visible";
        $mailResult = '<h2>Banneret er nu godkendt!</h2><h3>Vi vil straks fremstille de resterende bannere.</h3>';
    }
}

mysqli_close($conn);

$bannerCntr = 0;
?>
<head><link rel="stylesheet" href="/wp-content/themes/salient-child/bannerform/bannerform-style.css"></head>

<style type="text/css">
    .comment-list{padding:0!important;}
    .banner{position:relative;}
    .approve-content{display:flex;flex-direction:column-reverse;}
    .approve-content > *, .banner {margin-bottom:40px;}
    .title{text-align:center;}
    .content-text{margin-bottom:80px;}
    #approve-btn{background:green!important;padding:30px 50px!important;font-size:20px;}
    /* For some reason menubar is fucked up, dunno why, so this is the best recovery for now */
    .admin-bar #header-outer, .logged-in.buddypress #header-outer {top:0!important;}
</style>

<div class="container-wrap">
	<div class="<?php if ( $nectar_fp_options['page_full_screen_rows'] !== 'on' ) { echo 'container'; } ?> main-content">
        
        <!-- The comments and the comment form can't come after the 'foreach' for some reason -->
        <div class="approve-content">
            <?php comments_template();
            
            if($posts1[0]['order_status'] == 'up_for_approval'){ ?>
                <form method="post">
                    <button type="submit" name="submit" id="approve-btn">Godkend Banner</button>
                </form>
            <?php } else { echo "<h3 style='color:green;'>Banneret er allerede godkendt.</h3>"; }?>

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
                    </div> 
                <?php endforeach; ?>
            </div>

            <div class="content-text">
                <h3>Fortæl os om i godkender designet af bannerene, eller om der er noget der skal laves om.</h3>
                <h3>Hvis i godkender det, klik på knappen og så koder vi dem og sender dem til jer inden den givet deadline.</h3>
                <h3>Hvis i ikke godkender designet, så lad os snakke om det i kommentarene nedenunder, og vi vil hurtigst muligt sende det nye design.</h3>
                <h3>Hvis du gerne vil gense et banners start animation og de ikke refresher af sig selv, så klik på den runde pil under bannerets nummer.</h3>
                <h3>Mange tak.</h3>
            </div>

            <div class="title">
                <h1><?=$posts1[0]['name']." Banner godkendelse, Job nr. ".$posts1[0]['job_nr'];?></h1>
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