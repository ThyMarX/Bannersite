<?php
/*Template name: orderlist */
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
nectar_page_header( $post->ID );
$nectar_fp_options = nectar_get_full_page_options();

// ---------Custom HTML for the orderlist---------

require_once WP_CONTENT_DIR . '/themes/salient-child/config.php'; 

// Variable for counting how many layers we are in when we use the dltDir() function
$dirCntr = 0;
// Function for deleting everything in the folder
function dltDir($targetPath){
    // A counter so the variables can be dynamic
    $dirCntr++;
    // If the $targetPath is a existing dir then
    if(${"targetFiles".$dirCntr} = glob($targetPath."/*")){
        // For every file in that dir check
        for(${"i".$dirCntr} = 0; ${"i".$dirCntr} < count(${"targetFiles".$dirCntr}); ${"i".$dirCntr}++){
            // If that file is another dir then
            if(is_dir(${"targetFiles".$dirCntr}[${"i".$dirCntr}])){
                // Call this function again with the new dir path and then delete the empty dir
                dltDir(${"targetFiles".$dirCntr}[${"i".$dirCntr}]);
                rmdir(${"targetFiles".$dirCntr}[${"i".$dirCntr}]);
            } else { //If it's not a dir then delete the file
                unlink(${"targetFiles".$dirCntr}[${"i".$dirCntr}]);
            }
        }
    }
}
        
// Function to properly display the date
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

function categoryDisplay($input){
    if ($input == "q8"){return 4;}
    if ($input == "stark"){return 5;}
    if ($input == "apotek"){return 6;}
}

//Making the list order and sort
if(isset($_GET['order'])){
    $order = $_GET['order'];
} else {
    $order = 'order_ID';
}

if(isset($_GET['sort'])){
    $sort = $_GET['sort'];
} else {
    $sort = 'ASC';
}

// Show all the unfinished orders
if(isset($_POST['search'])){
    $searchValue = $_POST['searchValue'];
    $searchChoice = $_POST['searchChoice'];
    $query1 = "SELECT orders.order_ID, orders.job_nr, customer.name, orders.date_of_order, orders.order_status, orders.file_folder
                    FROM orders
                    INNER JOIN customer
                    ON orders.customer_FK=customer.customer_ID
                    WHERE orders.order_status != 'order_complete'
                    AND $searchChoice LIKE '%".$searchValue."%'
                    ORDER BY $order $sort";                     // Create Query
} else {
    $query1 = "SELECT orders.order_ID, orders.job_nr, customer.name, orders.date_of_order, orders.order_status, orders.file_folder
                    FROM orders
                    INNER JOIN customer
                    ON orders.customer_FK=customer.customer_ID
                    WHERE orders.order_status != 'order_complete'
                    ORDER BY $order $sort";                     // Create Query
}
$result1 = mysqli_query($conn, $query1);                        // Get Result
$posts1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);             // Fetch Data
mysqli_free_result($result1);                                   // Free Result

// Show all orders
$query2 = "SELECT orders.order_ID, orders.job_nr, customer.name, orders.date_of_order, orders.order_status
                FROM orders
                INNER JOIN customer
                ON orders.customer_FK=customer.customer_ID
                WHERE orders.order_status = 'order_complete'";    // Create Query
$result2 = mysqli_query($conn, $query2);                        // Get Result
$posts2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);             // Fetch Data
mysqli_free_result($result2);                                   // Free Result


// Get all the banners for every unfinished order in seperate posts
foreach ($posts1 as $post){
    ${'postQuery'.$post['order_ID']}= 'SELECT * FROM banners WHERE job_nr_FK = '.$post['job_nr'];              // Create Query
    ${'postResult3'.$post['order_ID']} = mysqli_query($conn, ${'postQuery'.$post['order_ID']});                 // Get Result
    $GLOBALS['postsBanners'.$post['order_ID']] = mysqli_fetch_all(${'postResult3'.$post['order_ID']}, MYSQLI_ASSOC);    // Fetch Data
    mysqli_free_result(${'postResult3'.$post['order_ID']});                                                     // Free Result
}

// When you press one of the submit buttons with name submit
if(isset($_POST['submit'])){
    // When you update a order    
    if($_POST['submit'] == 'update'){
        // get the values
        $order_ID = mysqli_real_escape_string($conn, $_POST["order_ID"]);
        $job_nr = mysqli_real_escape_string($conn, $_POST["job_nr"]);
        $order_status = mysqli_real_escape_string($conn, $_POST["order_status"]);
        $cust_name = strtolower(mysqli_real_escape_string($conn, $_POST["cust_name"]));
        $approval_link = mysqli_real_escape_string($conn, $_POST["approval_link"]);
        $download_link = mysqli_real_escape_string($conn, $_POST["download_link"]);
        // $customer = mysqli_real_escape_string($conn, $_POST["customer"]);
        // $date_of_order = mysqli_real_escape_string($conn, $_POST["date_of_order"]);
        $query = "UPDATE orders                 -- Here we have lines commented out, which is for updating date and customer
            -- INNER JOIN customer
            -- ON orders.customer_FK=customer.customer_ID
            SET job_nr = '$job_nr', 
            order_status = '$order_status'
            -- date_of_order = '$date_of_order',
            -- orders.customer = '$customer'
            WHERE order_ID = $order_ID";
        if(mysqli_query($conn, $query)){
            // If the order status is set to up_for_approval, make the new approval page and set the link in the db
            if ($approval_link == "" && $order_status == "up_for_approval"){
                $post_data = array(
                    'post_title' => "approval$job_nr",
                    'post_content' => '',
                    'post_type' => 'page',
                    'page_template' => 'approveContent.php',
                    'post_status' => 'publish',
                    'comment_status' => 'open',
                    'post_category' => array(categoryDisplay($cust_name))
                );
                if(wp_insert_post($post_data)){
                    $query3 = "UPDATE orders SET approval_link = 'https://banners.thomasdsiemsen.com/approval$job_nr/' WHERE job_nr = $job_nr";
                    mysqli_query($conn, $query3);
                }
            }
            // If the order status is set to order_delivered, make the new download page and set the link in the db
            if ($download_link == "" && $order_status == "order_delivered"){
                $post_data = array(
                    'post_title' => "download$job_nr",
                    'post_content' => '',
                    'post_type' => 'page',
                    'page_template' => 'downloadContent.php',
                    'post_status' => 'publish',
                    'comment_status' => 'closed',
                    'post_category' => array(categoryDisplay($cust_name))
                );
                if(wp_insert_post($post_data)){
                    $query3 = "UPDATE orders SET download_link = 'https://banners.thomasdsiemsen.com/download$job_nr/' WHERE job_nr = $job_nr";
                    mysqli_query($conn, $query3);
                }
            }
            // Update the banners info
            foreach (${'postsBanners'.$order_ID} as $post){
                // The directory for the banner
                $targetDir = "/themes/salient-child/files/$cust_name/o$job_nr/b".$post['banner_ID'];

                // Approval
                if ($_POST["approvel_check".$post['banner_ID']] == "on") {
                    $query = "UPDATE banners 
                    SET approval_show = 1
                    WHERE banner_ID = ".$post['banner_ID'];
                } else {
                    $query = "UPDATE banners 
                    SET approval_show = 0
                    WHERE banner_ID = ".$post['banner_ID'];
                }
                mysqli_query($conn, $query);

                // Image
                // Uploads if the file has been found
                if(!empty($_FILES["image_upload".$post['banner_ID']]["name"][0])){
                    // If there already are files, delete them
                    if($currentFile = glob(WP_CONTENT_DIR."$targetDir/banner/images/*")){
                        for($i = 0; $i < count($currentFile); $i++){
                            unlink($currentFile[$i]);
                        }
                    }
                    // Move the new files to the directory
                    $newFiles = $_FILES["image_upload".$post['banner_ID']];
                    for ($i = 0; $i < count($_FILES["image_upload".$post['banner_ID']]["name"]); $i++) { 
                        $tmpFile = $newFiles["tmp_name"][$i];
                        $fileName = $newFiles["name"][$i];
                        if(move_uploaded_file($tmpFile, WP_CONTENT_DIR."$targetDir/banner/images/".$fileName)){
                            // Update the banner in the database 
                            $query = "UPDATE banners SET img_check = 1 WHERE banner_ID = ".$post['banner_ID'];
                            mysqli_query($conn, $query);//if statement that makes plusses a success counter
                        }
                    }                       
                }
                
                // Banner
                // Uploads if the file has been found
                if(!empty($_FILES["banner_upload".$post['banner_ID']]["name"][0])){
                    // If there already are files, delete them
                    if($currentFile = glob(WP_CONTENT_DIR."$targetDir/banner/*")){
                        for($i = 0; $i < count($currentFile); $i++){
                            if(!is_dir($currentFile[$i])){unlink($currentFile[$i]);}
                        }
                    }
                    // Move the new files to the directory
                    $newFiles = $_FILES["banner_upload".$post['banner_ID']];
                    for ($i = 0; $i < count($_FILES["banner_upload".$post['banner_ID']]["name"]); $i++) { 
                        $tmpFile = $newFiles["tmp_name"][$i];
                        $fileName = $newFiles["name"][$i];
                        if(move_uploaded_file($tmpFile, WP_CONTENT_DIR."$targetDir/banner/".strtolower($fileName))){
                            // If it's a html file
                            if(substr($fileName, -4) == "html"){
                                // Update the banner in the database 
                                $filePath = "https://banners.thomasdsiemsen.com/wp-content$targetDir/banner/".strtolower($fileName);
                                $query = "UPDATE banners SET html_link = '$filePath' WHERE banner_ID = ".$post['banner_ID'];
                                mysqli_query($conn, $query); // insert an if statement that makes plusses a success counter
                            }
                        }
                    }                       
                }
                
                // Zip
                if($_FILES["zip_upload".$post['banner_ID']]['name'] != ""){
                    // If there already are files, delete them
                    if($currentFile = glob(WP_CONTENT_DIR."$targetDir/zip/*")){
                        for($i = 0; $i < count($currentFile); $i++){
                            unlink($currentFile[$i]);
                        }
                    }
                    // Move the new file to the directory
                    // ALSO MAKE IT CHECK IF IT'S A ZIP FILE OR SOMETHING
                    $newFile = $_FILES["zip_upload".$post['banner_ID']];
                    $tmpFile = $newFile["tmp_name"];
                    $fileName = $newFile["name"];
                    if(move_uploaded_file($tmpFile, WP_CONTENT_DIR."$targetDir/zip/".strtolower($fileName))){
                        // Update the banner in the database 
                        $filePath = "https://banners.thomasdsiemsen.com/wp-content$targetDir/zip/".strtolower($fileName);
                        $query = "UPDATE banners SET zip_link = '$filePath' WHERE banner_ID = ".$post['banner_ID'];
                        mysqli_query($conn, $query);
                    }
                }

                // Tell the user that everything has been done correctly 
                // SHOULD MAKE A ERROR COUNTER AND MAKE SURE THIS ONLY HAPPENS IF EVERYTHING WAS DONE CORRECTLY
                $displayClass = "visible";
                $mailResult = '<h2>Success!</h2><h3>Du har opdateret bestillingen.</h3>';
            }
        } else {
            $displayClass = "visible";
            $mailResult = '<h2>Noget gik galt!</h2><h3>Bestillingen kunne ikke opdateres.</h3><h4>"ERROR: "'. mysqli_error($conn).'</h4>';
        }
    } else if ($_POST['submit'] == 'deleteOrder'){
        $job_nr = mysqli_real_escape_string($conn, $_POST["job_nr"]);
        $cust_name = strtolower(mysqli_real_escape_string($conn, $_POST["cust_name"]));
        
        // Delete the directories on the server for the order
        $targetOrderPath = WP_CONTENT_DIR."/themes/salient-child/files/$cust_name/o$job_nr";
        dltDir($targetOrderPath);
        echo $targetOrderPath;
        if(rmdir($targetOrderPath)){
            $dirCntr = 0;
            // If done delete the orders banners entries in the db
            $query4 = "DELETE FROM `banners` WHERE `job_nr_FK` = $job_nr";
            if(mysqli_query($conn, $query4)){
                // If done delete the order entry in the db
                $query5 = "DELETE FROM `orders` WHERE `job_nr` = $job_nr";
                if(mysqli_query($conn, $query5)){
                    $displayClass = "visible";
                    $mailResult = '<h2>Success!</h2><h3>Du har slettet bestillingen.</h3>';
                } else {
                    $displayClass = "visible";
                    $mailResult = '<h2>Noget gik galt!</h2><h3>Bestillingen kunne ikke slettes fra databasen.</h3><h4>"ERROR: "'. mysqli_error($conn).'</h4>';
                }
            } else {
                $displayClass = "visible";
                $mailResult = '<h2>Noget gik galt!</h2><h3>Bestillingens bannere kunne ikke slettes fra databasen.</h3><h4>"ERROR: "'. mysqli_error($conn).'</h4>';
            }
        } else {
            $displayClass = "visible";
            $mailResult = '<h2>Noget gik galt!</h2><h3>Bestillingens mappe på serveren kunne ikke slettes.</h3><h4>"ERROR: "'. mysqli_error($conn).'</h4>';
        }

        //dltOrderDir(WP_CONTENT_DIR."/themes/salient-child/files/test/hej");
    } else if ($_POST['submit'] == 'testPhp') {
        $job_nr = mysqli_real_escape_string($conn, $_POST["job_nr"]);
        // $order_status = mysqli_real_escape_string($conn, $_POST["order_status"]);
        // $cust_name = strtolower(mysqli_real_escape_string($conn, $_POST["cust_name"]));
        // $approval_link = mysqli_real_escape_string($conn, $_POST["approval_link"]);
        // $download_link = mysqli_real_escape_string($conn, $_POST["download_link"]);

        // $post_data = array(
        //     'post_title' => "download$job_nr",
        //     'post_content' => '',
        //     'post_type' => 'page',
        //     'page_template' => 'downloadContent.php',
        //     'post_status' => 'publish',
        //     'comment_status' => 'closed',
        //     'post_category' => array(categoryDisplay($cust_name))
        // );
        // echo categoryDisplay($cust_name)." $cust_name<br>";

        // // Lets insert the post now.
        // if (wp_insert_post( $post_data )){
        //     echo $_SERVER['REQUEST_URI'];
        // }
        $query3 = "UPDATE orders SET approval_link = 'https://banners.thomasdsiemsen.com/approval$job_nr/' WHERE job_nr = $job_nr";
        echo "$query3 <br>";
        if(mysqli_query($conn, $query3)){
            echo "Hurrah det gik";
        } else {echo "Det gik ikke";}
    }
}

mysqli_close($conn);                                            // Close Connection 

$sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';

//var_dump(${'postsBanners1'});
?>
<head><link rel="stylesheet" href="/wp-content/themes/salient-child/bannerform/bannerform-style.css"></head>
<style type="text/css">
    th:last-child, td:last-child{
        width: 20%;
    }
    td:nth-child(2){
        border-left-style: solid !important;
        border-left-width: 1px !important;
        border-color: #ececec !important;
    }
    .order_statusText{
        padding-bottom: 0 !important;
    }

    .orderEdit{
        display: none;
        overflow: hidden;
    }

    .deleteBtn{
        background: red !important;
        color: white;
        padding: 18px 20px;
        border: none;
        font: inherit;
        font-size: 14px;
        font-weight: 600;
    }
    .btn.deleteBtn:hover{
        background-color: red !important;
    }
</style>

<div class="container-wrap">
	<div class="<?php if ( $nectar_fp_options['page_full_screen_rows'] !== 'on' ) { echo 'container'; } ?> main-content">

        <!-- The custom html -->
        <h2>Ikke afsluttede bestillinger:</h2>
        <form method="POST">
            <select name="searchChoice" id="searchChoice" style="width:150px;">
                <option value="order_ID">Job nr.</option>
                <option value="name">Kunde</option>
                <option value="date_of_order">Dato for bestilling</option>
                <option value="order_status">Bestilling status</option>
            </select>
            <input type="text" name="searchValue" id="searchValue" placeholder="Efterlad blank for at se alle" style="width:300px;">
            <input type="submit" name="search" value="Søg">
            
            <button type="submit" name="submit" value="testPhp">Test Php</button>
        </form> <br>
        <table id="orderTable" style="width: 100%;">
            <?php if(empty($posts1)){
                echo "<p>Alle bestillinger er afsluttet.</p>";
            } else { ?>
                <tr>
                    <th style="width:20%;">Job nr. <a href="<?="?order=job_nr&&sort=$sort"?>">Sorter</a></th>
                    <th style="width:20%;">Kunde <a href="<?="?order=name&&sort=$sort"?>">Sorter</a></th>
                    <th style="width:20%;">Dato for bestilling <a href="<?="?order=date_of_order&&sort=$sort"?>">Sorter</a></th>
                    <th style="width:20%;">Bestilling status <a href="<?="?order=order_status&&sort=$sort"?>">Sorter</a></th>
                </tr>            
            <?php } ?>
            
            <?php foreach($posts1 as $post) { ?>
            <tr>
                <div class="flex spaceBetween">
                    <td> <?= $post['job_nr'];?> </td>
                    <td> <?= $post['name'];?> </td>
                    <td> <?= dateDisplay($post['date_of_order']);?> </td>
                    <td> <?= statusDisplay($post['order_status']);?> </td>
                    <td class="flex spaceBetween" style="width:100%; border:none; background:white;">
                        <button type="button" class="edit" style="height:30px;">Opdater bestilling</button>
                        <button type="button" class="cancel" style="height:30px; display:none;">Afbrud</button>
                    </td>
                </div>
            </tr> 

            <tr class="orderEdit">
                <td colspan="4" style="padding:0; background-color:rgba(0,0,0,0.04);"> 
                    <form method="POST" enctype="multipart/form-data" class="flex" style="padding:30px; justify-content:space-between;">
                        <!-- Hidden inputs with info we use to POST -->
                        <input type="hidden" name="order_ID" value="<?=$post['order_ID'];?>">
                        <input type="hidden" name="file_folder" value="<?=$post['file_folder'];?>">
                        <input type="hidden" name="cust_name" value="<?=$post['name'];?>">
                        <input type="hidden" name="date_of_order" value="<?=$post['date_of_order'];?>">
                        <input type="hidden" name="approval_link" value="<?=$post['approval_link'];?>">
                        <input type="hidden" name="download_link" value="<?=$post['download_link'];?>">

                        <div style="width: 47%;">
                            <h4>Job Nr.</h4>
                            <input type="text" name="job_nr" value="<?= $post['job_nr'];?>" style="background:white;">
                            <!-- <h4 class="airTop1">Kunde</h4>
                            <input type="text" name="customer" value="<?= $post['name'];?>" style="background:white;"> -->
                        </div>

                        <div style="width: 47%;">
                            <h4>Bestillings status</h4>
                            <select name="order_status" style="height: 48px;">
                                <option value="order_recieved"<?php if($post['order_status']=='order_recieved'){echo 'selected="selected"';};?> >Bestilling modtaget</option>
                                <option value="up_for_approval"<?php if($post['order_status']=='up_for_approval'){echo 'selected="selected"';};?> >Klar til godkendelse</option>
                                <option value="banner_approved"<?php if($post['order_status']=='banner_approved'){echo 'selected="selected"';};?> >Banner godkendt</option>
                                <option value="order_delivered"<?php if($post['order_status']=='order_delivered'){echo 'selected="selected"';};?> >Bestiling afleveret</option>
                                <option value="order_complete">Bestilling afsluttet</option>
                            </select>

                            <!-- <h4 class="airTop1">Dato for bestilling</h4>
                            <input type="date" name="date_of_order" value="<?= substr($post['date_of_order'], 0, 10);?>" style="background:white;"> -->
                        </div>


                        <h4 class="airTop1 fw">Uploads</h4>
                        <div class="fw flex spaceBetween">
                            <?php $bannerNr = 0;
                            foreach(${'postsBanners'.$post['order_ID']} as $post){ 
                                $bannerNr++; ?>
                                <input type="hidden" name="banner_ID<?=$post['banner_ID'];?>">
                                <div style="padding:10px; background:white; border-radius:5px; margin-bottom:30px;width:415px;">
                                    <div class="flex spaceBetween">
                                        <h5>Banner nr <?=$bannerNr?></h4>
                                        <p style="font-weight:14px;"><?=$post['width'].' x '.$post['height'].", ".$post['type'].", ".$post['platform'];?></p>
                                    </div>
                                    <div class="flex">
                                        <label class="flex" style="width:auto;margin-right:173px;" for="approvel_check<?=$post['banner_ID'];?>">
                                            <p>Vis til godkendelse:</p>
                                            <input type="checkbox" style="margin-top:7px;" name="approvel_check<?php echo $post['banner_ID'];?>" id="approvel_check<?php echo $post['banner_ID'];?>" <?php if ($post['approval_show'] == 1){echo "checked";} ?>>
                                        </label>
                                    </div>
                                    <div class="flex"> 
                                        <p style="width:71px;">Images:</p>
                                        <input type="file" style="margin-top:2px;" name="image_upload<?=$post['banner_ID'];?>[]" multiple>
                                        <?php if ($post['img_check'] == 1){echo " <p style='font-weight:500;font-style:italic;'>Er uploadet</p>";}?>
                                    </div>
                                    <div class="flex">
                                        <p style="width:71px;">HTML & JS:</p>
                                        <input type="file" style="margin-top:2px;" name="banner_upload<?=$post['banner_ID'];?>[]" multiple>
                                        <?php if ($post['html_link'] != ''){echo " <p style='font-weight:500;font-style:italic;'>Er uploadet</p>";}?>
                                    </div>
                                    <div class="flex">
                                        <p style="width:71px;">Zipfil:</p>
                                        <input type="file" style="margin-top:2px;" name="zip_upload<?=$post['banner_ID'];?>">
                                        <?php if ($post['zip_link'] != ''){echo " <p style='font-weight:500;font-style:italic;'>Er uploadet</p>";}?>
                                    </div>
                                </div>
                            <?php } ?>                        
                        </div>

                        <div class="flex spaceBetween airTop3" style="flex-direction:row-reverse;">
                            <button type="submit" name="submit" value="update">Opdater</button>
                            <button type="button" class="btn deleteBtn dltBtnPopUp">Slet bestilling</button>
                        </div>

                        <!-- Confirmation for deleting -->
                        <div class="<?=$displayClass?> popUp dltPopUp">
                            <div class="popUpContent mailResultStyle">
                                <span class="closeDltOrd">&times;</span>
                                <h2>Advarsel!</h2>
                                <div class="flexNW spaceBetween">
                                    <h3 style="max-width:300px">Vil du virkelig slette bestillingen med job nummer: <strong><?= $post['job_nr_FK'];?></strong>?</h3>
                                    <button type="submit" name="submit" value="deleteOrder" class="btn deleteBtn">Slet bestilling</button>
                                <div>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>

        <h2 class="airTop2">Afsluttede bestillinger:</h2>
        <table style="width: 80%;">
            <tr>
                <th style="width:20%;">Job nr.</th>
                <th style="width:20%;">Kunde</th>
                <th style="width:20%;">Dato for bestilling</th>
                <th style="width:20%;">Bestilling status</th>
            </tr>
            <?php 
                foreach($posts2 as $post) { ?>
                <tr>
                    <td> <?= $post['job_nr'];?> </td>
                    <td> <?= $post['name'];?> </td>
                    <td> <?= substr($post['date_of_order'], 0, 10);?> </td>
                    <td> <?= statusDisplay($post['order_status']);?></td>
                </tr>
            <?php } ?>
        
        </table>

        <!-- Where the mail result popUp message gets echo'ed -->
        <div id="mailResult" class="<?=$displayClass?> popUp">
            <div class="popUpContent mailResultStyle">
                <span class="closePopUp">&times;</span>
                <?=$mailResult?>
            </div>
        </div>
	</div><!--/container-->
</div><!--/container-wrap-->
<?php print_r($_POST['list']); ?>

<script>
    // The display js
    let edit = document.getElementsByClassName("edit");
    let cancel = document.getElementsByClassName("cancel");
    let orderEdit = document.getElementsByClassName("orderEdit");

    for (let i = 0; i < edit.length; i++) {
        edit[i].onclick = function(event){
            edit[i].style.display = "none";
            cancel[i].style.display = "block";
            orderEdit[i].style.animation = "sizesIn 0.3s ease-out";
            orderEdit[i].style.animationPlayState = "running";
            orderEdit[i].style.display = "table-row";
            event.preventDefault();
        };
        
        cancel[i].onclick = function(event){
            edit[i].style.display = "block";
            cancel[i].style.display = "none";
            orderEdit[i].style.animation = "sizesOut 0.3s ease-out";
            orderEdit[i].style.animationPlayState = "running";
            setTimeout(function(){orderEdit[i].style.display = "none";}, 200);
            event.preventDefault();
        };
    }

    // popUp feedback window
    let mailResult = document.getElementById('mailResult');
    let span2 = document.getElementsByClassName("closePopUp")[0];
    span2.onclick = function() {mailResult.classList.remove("visible");}
    window.addEventListener("click", function(){
        if (event.target == mailResult) {
            mailResult.classList.remove("visible");
        } 
    });

    // Delete button popup window
    let dltBtn = document.getElementsByClassName("dltBtnPopUp")
    let closeDltOrd = document.getElementsByClassName("closeDltOrd");
    let dltWindow = document.getElementsByClassName("dltPopUp");
    for (let i = 0; i < dltBtn.length; i++) {
        dltBtn[i].onclick = function() {dltWindow[i].classList.add("visible");}
    }
    for (let i = 0; i < closeDltOrd.length; i++) {
        closeDltOrd[i].onclick = function() {dltWindow[i].classList.remove("visible");}
    }

    for (let i = 0; i < dltWindow.length; i++) {
        window.addEventListener("click", function(){
            if (event.target == dltWindow[i]) {
                dltWindow[i].classList.remove("visible");
            } 
        });
    }
</script>

<?php get_footer(); ?>