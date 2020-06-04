<!-- HTML for the banner form -->
<!-- Made by: Thomas Dyrholm Siemsen -->
<?php 
    // Wordpress default php
    if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }
    get_header();
    nectar_page_header( $post->ID );
    $nectar_fp_options = nectar_get_full_page_options();

    // Custom made php
    require_once WP_CONTENT_DIR . '/themes/salient-child/config.php'; 
    
    $searchChoice = $_GET['sc'];
    $searchValue = $_GET['sv'];

    // //Making the list order and sort
    // if(isset($_GET['order'])){
    //     $order = $_GET['order'];
    // } else {
    //     $order = 'order_ID';
    // }

    // if(isset($_GET['sort'])){
    //     $sort = $_GET['sort'];
    // } else {
    //     $sort = 'ASC';
    // }
    
    // Show all the unfinished orders
    $valueToSearch = $_POST['valueToSearch'];
    $searchChoice = $_POST['searchChoice'];
    $query1 = "SELECT orders.order_ID, customer.name, orders.date_of_order, orders.order_status
                    FROM orders
                    INNER JOIN customer
                    ON orders.customer_FK=customer.customer_ID
                    WHERE orders.order_status != 'complete'
                    AND $searchChoice LIKE '%".$valueToSearch."%'
                    ORDER BY $order $sort";                         // Create Query1
	$result1 = mysqli_query($conn, $query1);                        // Get Result1
	$posts1 = mysqli_fetch_all($result1, MYSQLI_ASSOC);             // Fetch Data1
	mysqli_free_result($result1);                                   // Free Result1
    
    mysqli_close($conn);                                            // Close Connection 

    // $sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';

    if(empty($posts1)){
        echo "<p>Alle bestillinger er afsluttet.</p>";
    } else {
        echo `
            <tr>
                <th style='width:20%;'>Bestilling ID </th>
                <th style='width:20%;'>Kunde </th>
                <th style='width:20%;'>Dato for bestilling </th>
                <th style='width:20%;'>Bestilling status </th>
            </tr>            
            `;
        foreach($posts1 as $post) {
            echo `
            <tr>
                <form method="POST" class="flex spaceBetween">
                    <td> ` . $post['order_ID'] . `</td>
                    <td> ` . $post['name'] . `</td>
                    <td> ` . substr($post['date_of_order'], 0, 10) . `</td>
                    <td>
                        <p class="order_statusText"> ` . $post['order_status'] . `</p>
                        <select class="order_statusInput" name="order_status" style="padding:5px; display:none; width:130px;">
                            <option value="order_recieved">Bestilling Modtaget</option>
                            <option value="design_ready">Design Klar</option>
                            <option value="design_aproved">Design Godkendt</option>
                            <option value="complete">Færdigt</option>
                        </select>
                    </td>
                    <td class="flex spaceBetween" style="width:100%; border:none;">
                        <input type="hidden" name="order_ID" value="` . $post['order_ID'] . `">
                        <button class="update" style="height:30px;">Edit Order</button>
                        <button class="cancel" style="height:30px; display:none;">Cancel</button>
                        <input type="submit" name="submit" class="submit" value="Update" style="height:30px; padding:2px 15px !important; display:none;">
                    </td>
                </form>
            </tr> `;
        }
    }
?>


<script>
    // AJAX stuff
    function showTable(){
        sc = document.getElementById("searchChoice").value;
        sv = document.getElementById("searchValue").value;
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "/wp-content/themes/salient-child/test_orderDBstuff.php?sc="+sc+"&&sv="+sv,false);
        xmlhttp.send(null);
        document.getElementById("orderTable").innerHTML = xmlhttp.responseText;
    }

</script>