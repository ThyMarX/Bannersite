<?php
/*Template name: Stark*/
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
nectar_page_header( $post->ID );
$nectar_fp_options = nectar_get_full_page_options();

// Custom code stats here
require_once WP_CONTENT_DIR . '/themes/salient-child/config.php'; 

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
function statusDisplay($input){
    if ($input == "order_recieved"){return "Bestilling modtaget";}
    if ($input == "up_for_approval"){return "Klar til godkendelse";}
    if ($input == "banner_approved"){return "Banner godkendt";}
    if ($input == "order_delivered"){return "Bestiling afleveret";}
    if ($input == "order_complete"){return "Bestilling afsluttet";}
}


$query = "SELECT orders.job_nr, customer.name, orders.date_of_order, orders.order_status, orders.approval_link, orders.download_link
    FROM orders
    INNER JOIN customer
    ON orders.customer_FK = customer.customer_ID
    WHERE customer.name = 'stark'
    ORDER BY orders.date_of_order ASC"; // Create Query
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
            <h1 class="title">Stark Banner bestillinger</h1>
            <div>
                <h3>Hej Stark</h3>
                <h3>Her her i jeres oversigt over alle jeres bannerbestillinger hos os.</h3>
                <h3>Både dem nuværende og afsluttede.</h3>
            </div>
            <?php foreach ($posts as $post){ 
                $counter = 0;?>
                <div class="order-title">
                    <h2 class="job-nr">Bestilling job nr. <?=$post['job_nr'];?></h2>
                    <h3 class="order-date">Bestilt den <?=dateDisplay($post['date_of_order']);?></h3>
                    <h3>Bestillings status: <?=statusDisplay($post['order_status']);?></h3>
                </div>
                <?php if($post['approval_link'] != "") { ?>
                    <a class="nectar-button small regular accent-color regular-button link-btn" style="visibility: visible;" href="<?= $post['approval_link']; ?>" data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff"><span>Godkendelses Side</span></a>
                <?php } else {$counter++;}
                if($post['download_link'] != "") {?>
                    <a class="nectar-button small regular accent-color regular-button link-btn" style="visibility: visible;" href="<?= $post['download_link']; ?>" data-color-override="false" data-hover-color-override="false" data-hover-text-color-override="#fff"><span>Download Side</span></a>
                <?php } else {$counter++;}
                if ($counter == 2){echo "<h3>Ikke nogen links givet endnu.</h3>";}
            } ?>
        </div>
	</div><!--/container-->
</div><!--/container-wrap-->