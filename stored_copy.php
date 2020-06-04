<!-- ||||||||||||||||||||||||||||||---AJAX attempt---||||||||||||||||||||||||||||||||| -->

<?php
/*Template name: test_orderlist*/
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
    
    // When you press one of the submit buttons with name submit
	if(isset($_POST['submit'])){
        // When you update a order    
        if($_POST['submit'] == 'Update'){
            $order_ID = mysqli_real_escape_string($conn, $_POST["order_ID"]);
            $order_status = mysqli_real_escape_string($conn, $_POST["order_status"]);
    
            $query = "UPDATE orders SET 
                order_status = '$order_status'
                WHERE order_ID = {$order_ID}";
    
            if(mysqli_query($conn, $query)){
                echo 'Opdatering fuldendt';
            } else {
                echo "ERROR: " . mysqli_error($conn);
            }
        } 
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
        $query1 = "SELECT orders.order_ID, customer.name, orders.date_of_order, orders.order_status
                        FROM orders
                        INNER JOIN customer
                        ON orders.customer_FK=customer.customer_ID
                        WHERE orders.order_status != 'complete'
                        AND $searchChoice LIKE '%".$searchValue."%'
                        ORDER BY $order $sort";                         // Create Query1
    } else {
        $query1 = "SELECT orders.order_ID, customer.name, orders.date_of_order, orders.order_status
                        FROM orders
                        INNER JOIN customer
                        ON orders.customer_FK=customer.customer_ID
                        WHERE orders.order_status != 'complete'
                        ORDER BY $order $sort";                         // Create Query1
    }
	$result1 = mysqli_query($conn, $query1);                        // Get Result1
	$posts1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);             // Fetch Data1
	mysqli_free_result($result1);                                   // Free Result1

    // Show all orders
	$query2 = 'SELECT orders.order_ID, customer.name, orders.date_of_order, orders.order_status
                    FROM orders
                    INNER JOIN customer
                    ON orders.customer_FK=customer.customer_ID';    // Create Query2
	$result2 = mysqli_query($conn, $query2);                        // Get Result2
	$posts2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);             // Fetch Data2
    mysqli_free_result($result2);                                   // Free Result2
    
    mysqli_close($conn);                                            // Close Connection 

    $sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';

?>
<head><link rel="stylesheet" href="/wp-content/themes/salient-child/bannerform/bannerform-style.css"></head>
<style type="text/css">

    .flex.spaceBetween.hej > * {
        width: 25%;
    }
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

</style>

<div class="container-wrap">
	<div class="<?php if ( $nectar_fp_options['page_full_screen_rows'] !== 'on' ) { echo 'container'; } ?> main-content">

        <!-- The custom html -->
        <h2>Ikke afsluttede bestillinger:</h2>
        <form method="POST">
            <select name="searchChoice" id="searchChoice" style="width:150px;">
                <option value="order_ID">Bestilling ID</option>
                <option value="name">Kunde</option>
                <option value="date_of_order">Dato for bestilling</option>
                <option value="order_status">Bestilling status</option>
            </select>
            <input type="text" name="searchValue" id="searchValue" placeholder="Efterlad blank for at se alle" style="width:300px;">
            <input type="submit" name="search" value="Søg">
        </form> <br>
        <table id="orderTable" style="width: 100%;">
            <?php if(empty($posts1)){
                echo "<p>Alle bestillinger er afsluttet.</p>";
            } else { ?>
                <tr>
                    <th style="width:20%;">Bestilling ID <a href="<?="?order=order_ID&&sort=$sort"?>">Sort</a></th>
                    <th style="width:20%;">Kunde <a href="<?="?order=name&&sort=$sort"?>">Sort</a></th>
                    <th style="width:20%;">Dato for bestilling <a href="<?="?order=date_of_order&&sort=$sort"?>">Sort</a></th>
                    <th style="width:20%;">Bestilling status <a href="<?="?order=order_status&&sort=$sort"?>">Sort</a></th>
                </tr>            
            <?php } ?>
            
            <?php foreach($posts1 as $post) { ?>
            <tr>
                <form method="POST" class="flex spaceBetween">
                    <td> <?= $post['order_ID'];?> </td>
                    <td> <?= $post['name'];?> </td>
                    <td> <?= substr($post['date_of_order'], 0, 10);?> </td>
                    <td>
                        <p class="order_statusText"> <?= $post['order_status'];?></p>
                        <select class="order_statusInput" name="order_status" style="padding:5px; display:none; width:130px;">
                            <option value="order_recieved">Bestilling Modtaget</option>
                            <option value="design_ready">Design Klar</option>
                            <option value="design_aproved">Design Godkendt</option>
                            <option value="complete">Færdigt</option>
                        </select>
                    </td>
                    <td class="flex spaceBetween" style="width:100%; border:none;">
                        <input type="hidden" name="order_ID" value="<?= $post['order_ID'];?>">
                        <button class="update" style="height:30px;">Edit Order</button>
                        <button class="cancel" style="height:30px; display:none;">Cancel</button>
                        <input type="submit" name="submit" class="submit" value="Update" style="height:30px; padding:2px 15px !important; display:none;">
                    </td>
                </form>
            </tr> <?php 
            // echo '
            //     <tr id="orderEdit'.$post['order_ID'].'" style="display:hidden;">
            //         <td colspan="4"> hej </td>
            //     </tr>';
            } ?>
        </table>

        <h2 class="airTop2">Alle bestillinger:</h2>
        <table style="width: 80%;">
            <tr>
                <th style="width:20%;">Bestilling ID</th>
                <th style="width:20%;">Kunde</th>
                <th style="width:20%;">Dato for bestilling</th>
                <th style="width:20%;">Bestilling status</th>
            </tr>
            <?php 
                foreach($posts2 as $post) { ?>
                <tr>
                    <td> <?= $post['order_ID'];?> </td>
                    <td> <?= $post['name'];?> </td>
                    <td> <?= substr($post['date_of_order'], 0, 10);?> </td>
                    <td class="order_statusText"> <?= $post['order_status'];?></td>
                </tr>
            <?php } ?>
        
        </table>

	</div><!--/container-->
</div><!--/container-wrap-->
<?php print_r($_POST['list']); ?>

<script>
    // The display js
    order_statusText = document.getElementsByClassName("order_statusText");
    order_statusInput = document.getElementsByClassName("order_statusInput");
    update = document.getElementsByClassName("update");
    cancel = document.getElementsByClassName("cancel");
    submit = document.getElementsByClassName("submit");

    for (let i = 0; i < update.length; i++) {
        update[i].onclick = function(event){
            order_statusText[i].style.display = "none";
            order_statusInput[i].style.display = "block";
            update[i].style.display = "none";
            cancel[i].style.display = "block";
            submit[i].style.display = "block";
            event.preventDefault();
        };
        
        cancel[i].onclick = function(event){
            order_statusText[i].style.display = "block";
            order_statusInput[i].style.display = "none";
            update[i].style.display = "block";
            cancel[i].style.display = "none";
            submit[i].style.display = "none";
            event.preventDefault();
        };
    }
</script>

<?php get_footer(); ?>






<!-- ||||||||||||||||||||||||||||||---Wierd banner foreach attempt---||||||||||||||||||||||||||||||||| -->


<?php
/*Template name: test_orderlist*/
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
    
    // When you press one of the submit buttons with name submit
	if(isset($_POST['submit'])){
        // When you update a order    
        if($_POST['submit'] == 'Update'){
            $order_ID = mysqli_real_escape_string($conn, $_POST["order_ID"]);
            $order_status = mysqli_real_escape_string($conn, $_POST["order_status"]);
    
            $query = "UPDATE orders SET 
                order_status = '$order_status'
                WHERE order_ID = {$order_ID}";
    
            if(mysqli_query($conn, $query)){
                echo 'Opdatering fuldendt';
            } else {
                echo "ERROR: " . mysqli_error($conn);
            }
        } 
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
        $query1 = "SELECT orders.order_ID, customer.name, orders.date_of_order, orders.order_status
                        FROM orders
                        INNER JOIN customer
                        ON orders.customer_FK=customer.customer_ID
                        WHERE orders.order_status != 'complete'
                        AND $searchChoice LIKE '%".$searchValue."%'
                        ORDER BY $order $sort";                     // Create Query
    } else {
        $query1 = "SELECT orders.order_ID, customer.name, orders.date_of_order, orders.order_status
                        FROM orders
                        INNER JOIN customer
                        ON orders.customer_FK=customer.customer_ID
                        WHERE orders.order_status != 'complete'
                        ORDER BY $order $sort";                     // Create Query
    }
	$result1 = mysqli_query($conn, $query1);                        // Get Result
	$posts1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);             // Fetch Data
	mysqli_free_result($result1);                                   // Free Result

    // Show all orders
	$query2 = 'SELECT orders.order_ID, customer.name, orders.date_of_order, orders.order_status
                    FROM orders
                    INNER JOIN customer
                    ON orders.customer_FK=customer.customer_ID';    // Create Query
	$result2 = mysqli_query($conn, $query2);                        // Get Result
	$posts2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);             // Fetch Data
    mysqli_free_result($result2);                                   // Free Result

    // Get all the banners for every unfinished order in seperate posts
    foreach ($posts1 as $post){
        ${'postQuery'.$post['order_ID']}= 'SELECT * FROM banners WHERE order_FK = '.$post['order_ID'];              // Create Query
        ${'postResult3'.$post['order_ID']} = mysqli_query($conn, ${'postQuery'.$post['order_ID']});                 // Get Result
        ${'postsBanners'.$post['order_ID']}= mysqli_fetch_all(${'postResult3'.$post['order_ID']}, MYSQLI_ASSOC);    // Fetch Data
        mysqli_free_result(${'postResult3'.$post['order_ID']});                                                     // Free Result
    }
    mysqli_close($conn);                                            // Close Connection 

    $sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';
?>
<head><link rel="stylesheet" href="/wp-content/themes/salient-child/bannerform/bannerform-style.css"></head>
<style type="text/css">

    .flex.spaceBetween.hej > * {
        width: 25%;
    }
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


    
.collapsible {
  background-color: #777;
  color: white;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

.active, .collapsible:hover {
  background-color: #555;
}

.collapsible:after {
  content: '\002B';
  color: white;
  font-weight: bold;
  float: right;
  margin-left: 5px;
}

.active:after {
  content: "\2212";
}

.content {
  padding: 0 30px;
  max-height: 0;
  overflow: hidden;
  transition: max-height 0.2s, padding 0.2s ease-in;
  background-color: white;
  border-radius: 0 0 4px 4px;
}





</style>

<div class="container-wrap">
	<div class="<?php if ( $nectar_fp_options['page_full_screen_rows'] !== 'on' ) { echo 'container'; } ?> main-content">

        <!-- The custom html -->
        <h2>Ikke afsluttede bestillinger:</h2>
        <form method="POST">
            <select name="searchChoice" id="searchChoice" style="width:150px;">
                <option value="order_ID">Bestilling ID</option>
                <option value="name">Kunde</option>
                <option value="date_of_order">Dato for bestilling</option>
                <option value="order_status">Bestilling status</option>
            </select>
            <input type="text" name="searchValue" id="searchValue" placeholder="Efterlad blank for at se alle" style="width:300px;">
            <input type="submit" name="search" value="Søg">
        </form> <br>
        <table id="orderTable" style="width: 100%;">
            <?php if(empty($posts1)){
                echo "<p>Alle bestillinger er afsluttet.</p>";
            } else { ?>
                <tr>
                    <th style="width:20%;">Bestilling ID <a href="<?="?order=order_ID&&sort=$sort"?>">Sort</a></th>
                    <th style="width:20%;">Kunde <a href="<?="?order=name&&sort=$sort"?>">Sort</a></th>
                    <th style="width:20%;">Dato for bestilling <a href="<?="?order=date_of_order&&sort=$sort"?>">Sort</a></th>
                    <th style="width:20%;">Bestilling status <a href="<?="?order=order_status&&sort=$sort"?>">Sort</a></th>
                </tr>            
            <?php } ?>
            
            <?php foreach($posts1 as $post) { 
                ${"order_ID".$post['order_ID']} =  $post['order_ID'];?>
                <tr>
                    <div class="flex spaceBetween">
                        <td> <?= $post['order_ID'];?> </td>
                        <td> <?= $post['name'];?> </td>
                        <td> <?= dateDisplay($post['date_of_order']);?> </td>
                        <td>
                            <?=$post['order_status'];?>
                            <!-- <select class="order_statusInput" name="order_status" style="padding:5px; display:none; width:130px;">
                                <option value="order_recieved">Bestilling Modtaget</option>
                                <option value="design_ready">Design Klar</option>
                                <option value="design_aproved">Design Godkendt</option>
                                <option value="complete">Færdigt</option>
                            </select> -->
                        </td>
                        <td class="flex spaceBetween" style="width:100%; border:none; background:white;">
                            <input type="hidden" name="order_ID" value="<?= $post['order_ID'];?>">
                            <button type="button" class="update" style="height:30px;">Edit Order</button>
                            <button type="button" class="cancel" style="height:30px; display:none;">Cancel</button>
                        </td>
                    </div>
                </tr> 

                <tr class="orderEdit">
                    <td colspan="4" style="padding:0; background-color:rgba(0,0,0,0.04);"> 
                        <form class="flex" style="padding:30px; justify-content:space-between;">
                            <div style="width: 47%;">
                                <h4>Job Nr.</h4>
                                <input type="text" name="job_nr" value="<?= $post['order_ID'];?>" style="background:white;">
                                <h4 class="airTop1">Kunde</h4>
                                <input type="text" name="customer" value="<?= $post['name'];?>" style="background:white;">
                            </div>

                            <div style="width: 47%;">
                                <h4>Bestillings status</h4>
                                <select class="order_statusInput" name="order_status" style="height: 48px;">
                                    <option value="order_recieved"<?php if($post['order_status']=='order_recieved'){echo 'selected="selected"';};?> >Bestilling Modtaget</option>
                                    <option value="design_ready"<?php if($post['order_status']=='design_ready'){echo 'selected="selected"';};?> >Design Klar</option>
                                    <option value="design_aproved"<?php if($post['order_status']=='design_aproved'){echo 'selected="selected"';};?> >Design Godkendt</option>
                                    <option value="complete">Færdigt</option>
                                </select>
                                <h4 class="airTop1">Dato for bestilling</h4>
                                <input type="date" name="date_of_order" value="<?= substr($post['date_of_order'], 0, 10);?>" style="background:white;">
                            </div>


                            <h4 class="airTop1">Uploads</h4>
                            <div class="fw">
                                <button type="button" class="collapsible">Designs</button>
                                <div class="content">
                                    <div class="flex spaceBetween">
                                        <?php foreach(${'postsBanners'.$post['order_ID']} as $post){ ?>
                                            <div class="airTop3" style="width:30%;">
                                                <p>
                                                    <?=$post['width'].'x'.$post['height'];
                                                    if ($post['design_link'] != ''){echo " <span style='font-weight:500;font-style:italic;'>Er allerede uploadet</span>";}?>
                                                </p>
                                                <input type="file">
                                            </div>

                                        <?php 
                                            ${"bannersOutput".${"order_ID".$post['order_ID']}} .= `<div class="airTop3" style="width:30%;"><p>`.$post['width'].`x`.$post['height'];
                                            if ($post['html_link'] != ''){
                                                ${"bannersOutput".${"order_ID".$post['order_ID']}} .= `<span style='font-weight:500;font-style:italic;'>Er allerede uploadet</span>`;
                                            }
                                            ${"bannersOutput".${"order_ID".$post['order_ID']}} .= `</p><input type="file" multiple></div>`;
                                    
                                            ${"zipOutput".${"order_ID".$post['order_ID']}} .= `<div class="airTop3" style="width:30%;"><p>`.$post['width'].`x`.$post['height'];
                                            if ($post['zip_link'] != ''){
                                                ${"zipOutput".${"order_ID".$post['order_ID']}} .= `<span style='font-weight:500;font-style:italic;'>Er allerede uploadet</span>`;
                                            }
                                            ${"zipOutput".${"order_ID".$post['order_ID']}} .= `</p><input type="file"></div>`;
                                        } ?>
                                    </div>
                                    <label for="designCheck<?=$post['banner_ID']?>" class="flex airTop2">
                                        <h5>Upload de valgte filer</h5>
                                        <input type="checkbox" name="designCheck<?=$post['banner_ID']?>" id="designCheck<?=$post['banner_ID']?>" style="width:20px;height:20px;">
                                    </label>
                                </div>

                                <button type="button" class="collapsible airTop3">Bannere</button>
                                <div class="content">
                                    <div class="flex spaceBetween">
                                        <?=${"bannersOutput".${"order_ID".$post['order_ID']}};?>
                                    </div>
                                    <label for="bannerCheck<?=$post['banner_ID']?>" class="flex airTop2">
                                        <h5>Upload de valgte filer</h5>
                                        <input type="checkbox" name="bannerCheck<?=$post['banner_ID']?>" id="bannerCheck<?=$post['banner_ID']?>" style="width:20px;height:20px;">
                                    </label>
                                </div>

                                <button type="button" class="collapsible airTop3">Zip filer</button>
                                <div class="content">
                                    <div class="flex spaceBetween">
                                        <?=${"zipOutput".${"order_ID".$post['order_ID']}};?>
                                    </div>
                                    <label for="zipCheck<?=$post['banner_ID']?>" class="flex airTop2">
                                        <h5>Upload de valgte filer</h5>
                                        <input type="checkbox" name="zipCheck<?=$post['banner_ID']?>" id="zipCheck<?=$post['banner_ID']?>" style="width:20px;height:20px;">
                                    </label>
                                </div>
                            </div>

                            <div class="flex spaceBetween airTop1">
                                <button class="bigBtn" style="background:red; border:none;">Slet bestilling</button>
                                <button type="submit" name="submit" class="submit bigBtn" style="height:30px; padding:2px 15px !important; display:none;">Update</button>
                            </div>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2 class="airTop2">Alle bestillinger:</h2>
        <table style="width: 80%;">
            <tr>
                <th style="width:20%;">Bestilling ID</th>
                <th style="width:20%;">Kunde</th>
                <th style="width:20%;">Dato for bestilling</th>
                <th style="width:20%;">Bestilling status</th>
            </tr>
            <?php 
                foreach($posts2 as $post) { ?>
                <tr>
                    <td> <?= $post['order_ID'];?> </td>
                    <td> <?= $post['name'];?> </td>
                    <td> <?= substr($post['date_of_order'], 0, 10);?> </td>
                    <td> <?= $post['order_status'];?></td>
                </tr>
            <?php } ?>
        
        </table>

	</div><!--/container-->
</div><!--/container-wrap-->
<?php print_r($_POST['list']); ?>

<script>
    // The display js
    // let order_statusText = document.getElementsByClassName("order_statusText");
    // let order_statusInput = document.getElementsByClassName("order_statusInput");
    let update = document.getElementsByClassName("update");
    let cancel = document.getElementsByClassName("cancel");
    let submit = document.getElementsByClassName("submit");
    let orderEdit = document.getElementsByClassName("orderEdit");

    for (let i = 0; i < update.length; i++) {
        update[i].onclick = function(event){
            // order_statusText[i].style.display = "none";
            // order_statusInput[i].style.display = "block";
            update[i].style.display = "none";
            cancel[i].style.display = "block";
            submit[i].style.display = "block";
            orderEdit[i].style.animation = "sizesIn 0.3s ease-out";
            orderEdit[i].style.animationPlayState = "running";
            orderEdit[i].style.display = "table-row";
            event.preventDefault();
        };
        
        cancel[i].onclick = function(event){
            // order_statusText[i].style.display = "block";
            // order_statusInput[i].style.display = "none";
            update[i].style.display = "block";
            cancel[i].style.display = "none";
            submit[i].style.display = "none";
            orderEdit[i].style.animation = "sizesOut 0.3s ease-out";
            orderEdit[i].style.animationPlayState = "running";
            setTimeout(function(){orderEdit[i].style.display = "none";}, 200);
            event.preventDefault();
        };
    }

    var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.maxHeight){
      content.style.maxHeight = null;
      content.style.padding = "0 30px";
    } else {
      content.style.padding = "30px";
      content.style.maxHeight = content.scrollHeight + 60 + "px";
    } 
  });
}
</script>

<?php get_footer(); ?>






<!-- ||||||||||||||||||||||||||||||---Unlink thingei 1---||||||||||||||||||||||||||||||||| -->


<?php
/*Template name: test_orderlist*/
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

    
            //echo '<script language="javascript">alert("message successfully sent")</script>';

            
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
                        WHERE orders.order_status != 'complete'
                        AND $searchChoice LIKE '%".$searchValue."%'
                        ORDER BY $order $sort";                     // Create Query
    } else {
        $query1 = "SELECT orders.order_ID, orders.job_nr, customer.name, orders.date_of_order, orders.order_status, orders.file_folder
                        FROM orders
                        INNER JOIN customer
                        ON orders.customer_FK=customer.customer_ID
                        WHERE orders.order_status != 'complete'
                        ORDER BY $order $sort";                     // Create Query
    }
	$result1 = mysqli_query($conn, $query1);                        // Get Result
	$posts1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);             // Fetch Data
	mysqli_free_result($result1);                                   // Free Result

    // Show all orders
	$query2 = 'SELECT orders.order_ID, orders.job_nr, customer.name, orders.date_of_order, orders.order_status
                    FROM orders
                    INNER JOIN customer
                    ON orders.customer_FK=customer.customer_ID';    // Create Query
	$result2 = mysqli_query($conn, $query2);                        // Get Result
	$posts2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);             // Fetch Data
    mysqli_free_result($result2);                                   // Free Result

    // Get all the banners for every unfinished order in seperate posts
    foreach ($posts1 as $post){
        ${'postQuery'.$post['order_ID']}= 'SELECT * FROM banners WHERE order_FK = '.$post['order_ID'];              // Create Query
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
            // $customer = mysqli_real_escape_string($conn, $_POST["customer"]);
            // $date_of_order = mysqli_real_escape_string($conn, $_POST["date_of_order"]);

            $query = "UPDATE orders 
                -- INNER JOIN customer
                -- ON orders.customer_FK=customer.customer_ID
                SET job_nr = '$job_nr', 
                order_status = '$order_status'
                -- date_of_order = '$date_of_order',
                -- orders.customer = '$customer'
                WHERE order_ID = $order_ID";
            if(mysqli_query($conn, $query)){
                //$targetDir = mysqli_real_escape_string($conn, $_POST["file_folder"]);
                //unlink("/var/www/msqtest.dk/banners/wp-content/themes/salient-child/files/q8/o1/b6/design/q8p1d.jpg");
                foreach (${'postsBanners'.$order_ID} as $post){
                    // Uploads design if file has been found
                    if(!$_POST["design_upload".$post['banner_ID']] == ""){
                        // If there already are files, delete them
                        if($currentFile = glob(WP_CONTENT_DIR."/themes/salient-child/files/".$cust_name."/o".$order_ID."/b".$post['banner_ID']."/design/*")){/*unlink($currentFiles);*/ echo "Der er en fil";}

                    }
                    // echo WP_CONTENT_DIR."/themes/salient-child/files/".$cust_name."/o".$order_ID."/b".$post['banner_ID']."/design/* <br><pre>";
                    // var_dump($currentFiles);
                    // echo "</pre><br>";

                    // Banner
                    if(!$_POST["banner_upload".$post['banner_ID']] == ""){
                        var_dump($_POST["design_upload".$post['banner_ID']]);
                        echo "<br>";
                    }
                    
                    // Zip
                    if(!$_POST["zip_upload".$post['banner_ID']] == ""){
                        var_dump($_POST["design_upload".$post['banner_ID']]);
                        echo "<br>";
                    }




                    //unlink the file in the place
                    // $tmpFile = $briefFile["tmp_name"];
                    // $fileName = $briefFile["name"];
                    // move_uploaded_file($tmpFile, "$targetDir/" . strtolower($fileName));
                    // $briefFilePath = "$targetDir/" . strtolower($fileName);
                    //var_dump($targetDir);
                    //echo '<br>Opdatering fuldendt';
                }
            } else {
                echo "ERROR: " . mysqli_error($conn);
            }
        } 
    }

    mysqli_close($conn);                                            // Close Connection 

    $sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';

    //var_dump(${'postsBanners1'});
?>
<head><link rel="stylesheet" href="/wp-content/themes/salient-child/bannerform/bannerform-style.css"></head>
<style type="text/css">
    .flex.spaceBetween.hej > * {
        width: 25%;
    }
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
        </form> <br>
        <table id="orderTable" style="width: 100%;">
            <?php if(empty($posts1)){
                echo "<p>Alle bestillinger er afsluttet.</p>";
            } else { ?>
                <tr>
                    <th style="width:20%;">Job nr. <a href="<?="?order=job_nr&&sort=$sort"?>">Sort</a></th>
                    <th style="width:20%;">Kunde <a href="<?="?order=name&&sort=$sort"?>">Sort</a></th>
                    <th style="width:20%;">Dato for bestilling <a href="<?="?order=date_of_order&&sort=$sort"?>">Sort</a></th>
                    <th style="width:20%;">Bestilling status <a href="<?="?order=order_status&&sort=$sort"?>">Sort</a></th>
                </tr>            
            <?php } ?>
            
            <?php foreach($posts1 as $post) { ?>
            <tr>
                <div class="flex spaceBetween">
                    <td> <?= $post['job_nr'];?> </td>
                    <td> <?= $post['name'];?> </td>
                    <td> <?= dateDisplay($post['date_of_order']);?> </td>
                    <td>
                        <?=$post['order_status'];?>
                        <!-- <select class="order_statusInput" name="order_status" style="padding:5px; display:none; width:130px;">
                            <option value="order_recieved">Bestilling Modtaget</option>
                            <option value="design_ready">Design Klar</option>
                            <option value="design_aproved">Design Godkendt</option>
                            <option value="complete">Færdigt</option>
                        </select> -->
                    </td>
                    <td class="flex spaceBetween" style="width:100%; border:none; background:white;">
                        <button type="button" class="edit" style="height:30px;">Edit Order</button>
                        <button type="button" class="cancel" style="height:30px; display:none;">Cancel</button>
                    </td>
                </div>
            </tr> 

            <tr class="orderEdit">
                <td colspan="4" style="padding:0; background-color:rgba(0,0,0,0.04);"> 
                    <form method="POST" class="flex" style="padding:30px; justify-content:space-between;">
                        <!-- Hidden inputs with info we use to POST -->
                        <input type="hidden" name="order_ID" value="<?=$post['order_ID']?>">
                        <input type="hidden" name="file_folder" value="<?=$post['file_folder']?>">
                        <input type="hidden" name="cust_name" value="<?=$post['name']?>">

                        <div style="width: 47%;">
                            <h4>Job Nr.</h4>
                            <input type="text" name="job_nr" value="<?= $post['job_nr'];?>" style="background:white;">
                            <!-- <h4 class="airTop1">Kunde</h4>
                            <input type="text" name="customer" value="<?= $post['name'];?>" style="background:white;"> -->
                        </div>

                        <div style="width: 47%;">
                            <h4>Bestillings status</h4>
                            <select name="order_status" style="height: 48px;">
                                <option value="order_recieved"<?php if($post['order_status']=='order_recieved'){echo 'selected="selected"';};?> >Bestilling Modtaget</option>
                                <option value="design_ready"<?php if($post['order_status']=='design_ready'){echo 'selected="selected"';};?> >Design Klar</option>
                                <option value="design_aproved"<?php if($post['order_status']=='design_aproved'){echo 'selected="selected"';};?> >Design Godkendt</option>
                                <option value="complete">Færdigt</option>
                            </select>
                            <!-- <h4 class="airTop1">Dato for bestilling</h4>
                            <input type="date" name="date_of_order" value="<?= substr($post['date_of_order'], 0, 10);?>" style="background:white;"> -->
                        </div>


                        <h4 class="airTop1 fw">Uploads</h4>
                        <div class="fw flex spaceBetween">
                            <?php $bannerNr = 0;
                            foreach(${'postsBanners'.$post['order_ID']} as $post){ 
                                $bannerNr++; ?>
                                <input type="hidden" name="banner_ID<?=$post['banner_ID']?>">
                                <div style="padding:10px; background:white; border-radius:5px; margin-bottom:30px;">
                                    <h5>Banner nr <?=$bannerNr?></h4>
                                    <p><?=$post['width'].'x'.$post['height'].",   ".$post['type'].",   ".$post['platform'];?></p>
                                    <div class="flex">
                                        <p style="width:60px;">Design:</p>
                                        <input type="file" name="design_upload<?=$post['banner_ID']?>">
                                        <p><?php if ($post['design_link'] != ''){echo " <span style='font-weight:500;font-style:italic;'>Er uploadet</span>";}?></p>
                                    </div>
                                    <div class="flex">
                                        <p style="width:60px;">Banner:</p>
                                        <input type="file" name="banner_upload<?=$post['banner_ID']?>" multiple>
                                        <p><?php if ($post['html_link'] != ''){echo " <span style='font-weight:500;font-style:italic;'>Er uploadet</span>";}?></p>
                                    </div>
                                    <div class="flex">
                                        <p style="width:60px;">Zipfil:</p>
                                        <input type="file" name="zip_upload<?=$post['banner_ID']?>">
                                        <p><?php if ($post['zip_link'] != ''){echo " <span style='font-weight:500;font-style:italic;'>Er uploadet</span>";}?></p>
                                    </div>
                                </div>
                            <?php } ?>                        
                        </div>

                        <div class="flex spaceBetween airTop3" style="flex-direction:row-reverse;">
                            <button type="submit" name="submit" value="update">Update</button>
                            <button type="submit" name="submit" value="delete" class="btn deleteBtn">Slet bestilling</button>
                        </div>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>

        <h2 class="airTop2">Alle bestillinger:</h2>
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
                    <td> <?= $post['order_status'];?></td>
                </tr>
            <?php } ?>
        
        </table>

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
</script>

<?php get_footer(); ?>










<!-- ||||||||||||||||||||||||||||||---Unlink thingie 2---||||||||||||||||||||||||||||||||| -->



<?php
/*Template name: test_orderlist*/
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

    
            //echo '<script language="javascript">alert("message successfully sent")</script>';

            
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
                        WHERE orders.order_status != 'complete'
                        AND $searchChoice LIKE '%".$searchValue."%'
                        ORDER BY $order $sort";                     // Create Query
    } else {
        $query1 = "SELECT orders.order_ID, orders.job_nr, customer.name, orders.date_of_order, orders.order_status, orders.file_folder
                        FROM orders
                        INNER JOIN customer
                        ON orders.customer_FK=customer.customer_ID
                        WHERE orders.order_status != 'complete'
                        ORDER BY $order $sort";                     // Create Query
    }
	$result1 = mysqli_query($conn, $query1);                        // Get Result
	$posts1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);             // Fetch Data
	mysqli_free_result($result1);                                   // Free Result

    // Show all orders
	$query2 = 'SELECT orders.order_ID, orders.job_nr, customer.name, orders.date_of_order, orders.order_status
                    FROM orders
                    INNER JOIN customer
                    ON orders.customer_FK=customer.customer_ID';    // Create Query
	$result2 = mysqli_query($conn, $query2);                        // Get Result
	$posts2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);             // Fetch Data
    mysqli_free_result($result2);                                   // Free Result

    // Get all the banners for every unfinished order in seperate posts
    foreach ($posts1 as $post){
        ${'postQuery'.$post['order_ID']}= 'SELECT * FROM banners WHERE order_FK = '.$post['order_ID'];              // Create Query
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
            // $customer = mysqli_real_escape_string($conn, $_POST["customer"]);
            // $date_of_order = mysqli_real_escape_string($conn, $_POST["date_of_order"]);

            $query = "UPDATE orders 
                -- INNER JOIN customer
                -- ON orders.customer_FK=customer.customer_ID
                SET job_nr = '$job_nr', 
                order_status = '$order_status'
                -- date_of_order = '$date_of_order',
                -- orders.customer = '$customer'
                WHERE order_ID = $order_ID";
            if(mysqli_query($conn, $query)){
                //$targetDir = mysqli_real_escape_string($conn, $_POST["file_folder"]);
                //unlink("/var/www/msqtest.dk/banners/wp-content/themes/salient-child/files/q8/o1/b6/design/q8p1d.jpg");
                foreach (${'postsBanners'.$order_ID} as $post){
                    // Uploads design if file has been found
                    $filePath = "/themes/salient-child/files/$cust_name/o$order_ID/b".$post['banner_ID'];
                    if($newFile = $_POST["design_upload".$post['banner_ID']]){
                        // If there already are files, delete them
                        if($currentFile = glob(WP_CONTENT_DIR."$filePath/design/*")){
                            unlink($currentFile);
                            echo "Der er en fil<br>";
                        }
                        // Move the new file to the directory
                        echo WP_CONTENT_DIR."$filePath/design/* <br><pre>";
                        var_dump($newFile);
                        echo "</pre>";
                        // $tmpFile = $newFile["tmp_name"];
                        // $fileName = $newFile["name"];
                        // move_uploaded_file($tmpFile, WP_CONTENT_DIR."$filePath/design/".strtolower($fileName));
                        echo "Den nye fil er uploaded";
                        // Update the banner in the database
                    }
                    // echo WP_CONTENT_DIR."/themes/salient-child/files/".$cust_name."/o".$order_ID."/b".$post['banner_ID']."/design/* <br><pre>";
                    // var_dump($currentFiles);
                    // echo "</pre><br>";

                    // Banner
                    if(!$_POST["banner_upload".$post['banner_ID']] == ""){
                        var_dump($_POST["design_upload".$post['banner_ID']]);
                        echo "<br>";
                    }
                    
                    // Zip
                    if(!$_POST["zip_upload".$post['banner_ID']] == ""){
                        var_dump($_POST["design_upload".$post['banner_ID']]);
                        echo "<br>";
                    }




                    //unlink the file in the place
                    // $tmpFile = $briefFile["tmp_name"];
                    // $fileName = $briefFile["name"];
                    // move_uploaded_file($tmpFile, "$targetDir/" . strtolower($fileName));
                    // $briefFilePath = "$targetDir/" . strtolower($fileName);
                    //var_dump($targetDir);
                    //echo '<br>Opdatering fuldendt';
                }
            } else {
                echo "ERROR: " . mysqli_error($conn);
            }
        } 
    }

    mysqli_close($conn);                                            // Close Connection 

    $sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';

    //var_dump(${'postsBanners1'});
?>
<head><link rel="stylesheet" href="/wp-content/themes/salient-child/bannerform/bannerform-style.css"></head>
<style type="text/css">
    .flex.spaceBetween.hej > * {
        width: 25%;
    }
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
        </form> <br>
        <table id="orderTable" style="width: 100%;">
            <?php if(empty($posts1)){
                echo "<p>Alle bestillinger er afsluttet.</p>";
            } else { ?>
                <tr>
                    <th style="width:20%;">Job nr. <a href="<?="?order=job_nr&&sort=$sort"?>">Sort</a></th>
                    <th style="width:20%;">Kunde <a href="<?="?order=name&&sort=$sort"?>">Sort</a></th>
                    <th style="width:20%;">Dato for bestilling <a href="<?="?order=date_of_order&&sort=$sort"?>">Sort</a></th>
                    <th style="width:20%;">Bestilling status <a href="<?="?order=order_status&&sort=$sort"?>">Sort</a></th>
                </tr>            
            <?php } ?>
            
            <?php foreach($posts1 as $post) { ?>
            <tr>
                <div class="flex spaceBetween">
                    <td> <?= $post['job_nr'];?> </td>
                    <td> <?= $post['name'];?> </td>
                    <td> <?= dateDisplay($post['date_of_order']);?> </td>
                    <td>
                        <?=$post['order_status'];?>
                        <!-- <select class="order_statusInput" name="order_status" style="padding:5px; display:none; width:130px;">
                            <option value="order_recieved">Bestilling Modtaget</option>
                            <option value="design_ready">Design Klar</option>
                            <option value="design_aproved">Design Godkendt</option>
                            <option value="complete">Færdigt</option>
                        </select> -->
                    </td>
                    <td class="flex spaceBetween" style="width:100%; border:none; background:white;">
                        <button type="button" class="edit" style="height:30px;">Edit Order</button>
                        <button type="button" class="cancel" style="height:30px; display:none;">Cancel</button>
                    </td>
                </div>
            </tr> 

            <tr class="orderEdit">
                <td colspan="4" style="padding:0; background-color:rgba(0,0,0,0.04);"> 
                    <form method="POST" class="flex" style="padding:30px; justify-content:space-between;">
                        <!-- Hidden inputs with info we use to POST -->
                        <input type="hidden" name="order_ID" value="<?=$post['order_ID']?>">
                        <input type="hidden" name="file_folder" value="<?=$post['file_folder']?>">
                        <input type="hidden" name="cust_name" value="<?=$post['name']?>">

                        <div style="width: 47%;">
                            <h4>Job Nr.</h4>
                            <input type="text" name="job_nr" value="<?= $post['job_nr'];?>" style="background:white;">
                            <!-- <h4 class="airTop1">Kunde</h4>
                            <input type="text" name="customer" value="<?= $post['name'];?>" style="background:white;"> -->
                        </div>

                        <div style="width: 47%;">
                            <h4>Bestillings status</h4>
                            <select name="order_status" style="height: 48px;">
                                <option value="order_recieved"<?php if($post['order_status']=='order_recieved'){echo 'selected="selected"';};?> >Bestilling Modtaget</option>
                                <option value="design_ready"<?php if($post['order_status']=='design_ready'){echo 'selected="selected"';};?> >Design Klar</option>
                                <option value="design_aproved"<?php if($post['order_status']=='design_aproved'){echo 'selected="selected"';};?> >Design Godkendt</option>
                                <option value="complete">Færdigt</option>
                            </select>
                            <!-- <h4 class="airTop1">Dato for bestilling</h4>
                            <input type="date" name="date_of_order" value="<?= substr($post['date_of_order'], 0, 10);?>" style="background:white;"> -->
                        </div>


                        <h4 class="airTop1 fw">Uploads</h4>
                        <div class="fw flex spaceBetween">
                            <?php $bannerNr = 0;
                            foreach(${'postsBanners'.$post['order_ID']} as $post){ 
                                $bannerNr++; ?>
                                <input type="hidden" name="banner_ID<?=$post['banner_ID']?>">
                                <div style="padding:10px; background:white; border-radius:5px; margin-bottom:30px;">
                                    <h5>Banner nr <?=$bannerNr?></h4>
                                    <p><?=$post['width'].'x'.$post['height'].",   ".$post['type'].",   ".$post['platform'];?></p>
                                    <div class="flex">
                                        <p style="width:60px;">Design:</p>
                                        <input type="file" name="design_upload<?=$post['banner_ID']?>">
                                        <p><?php if ($post['design_link'] != ''){echo " <span style='font-weight:500;font-style:italic;'>Er uploadet</span>";}?></p>
                                    </div>
                                    <div class="flex">
                                        <p style="width:60px;">Banner:</p>
                                        <input type="file" name="banner_upload<?=$post['banner_ID']?>" multiple>
                                        <p><?php if ($post['html_link'] != ''){echo " <span style='font-weight:500;font-style:italic;'>Er uploadet</span>";}?></p>
                                    </div>
                                    <div class="flex">
                                        <p style="width:60px;">Zipfil:</p>
                                        <input type="file" name="zip_upload<?=$post['banner_ID']?>">
                                        <p><?php if ($post['zip_link'] != ''){echo " <span style='font-weight:500;font-style:italic;'>Er uploadet</span>";}?></p>
                                    </div>
                                </div>
                            <?php } ?>                        
                        </div>

                        <div class="flex spaceBetween airTop3" style="flex-direction:row-reverse;">
                            <button type="submit" name="submit" value="update">Update</button>
                            <button type="submit" name="submit" value="delete" class="btn deleteBtn">Slet bestilling</button>
                        </div>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>

        <h2 class="airTop2">Alle bestillinger:</h2>
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
                    <td> <?= $post['order_status'];?></td>
                </tr>
            <?php } ?>
        
        </table>

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
</script>

<?php get_footer(); ?>