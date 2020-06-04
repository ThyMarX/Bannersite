<?php 
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
get_header();
nectar_page_header( $post->ID );
$nectar_fp_options = nectar_get_full_page_options();

require_once WP_CONTENT_DIR . '/themes/salient-child/config.php'; 

$customerQuery = 'SELECT * FROM customers'; 
$custonerResult = mysqli_query($conn, $customerQuery);   
$customerPosts = mysqli_fetch_all($custonerResult, MYSQLI_ASSOC);
mysqli_free_result($custonerResult);  

echo "<pre>";
var_dump($customerPosts);
echo "</pre>";

// $query = "INSERT INTO orders(job_nr, customer_FK, order_status, design_link, download_link, file_folder) 
//     VALUES (11, 2, 'order_recieved', '', '', 'https://banners.msqtest.dk/wp-content/themes/salient-child/inc/q8/project1/')
//     INNER JOIN customer
//     ON orders.customer_FK=customer.customer_ID";

// $query = "INSERT INTO orders(job_nr, customer_FK, order_status) 
//     VALUES (11, 2, 'order_recieved')
//     INNER JOIN customer
//     ON orders.customer_FK=customer.customer_ID";
// mysqli_query($conn, $query);


mysqli_close($conn);
header("Location: /bannerform/");
exit;
?>