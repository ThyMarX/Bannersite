<?php 
    // Define the destinations
    define('ROOT_URL', 'https://banners.thomasdsiemsen.com/');
    define('DB_HOST', 'thomasdsiemsen.com.mysql');
    define('DB_USER', 'thomasdsiemsen_com_gamesite');
    define('DB_PASS', '123456');
    define('DB_NAME', 'thomasdsiemsen_com_gamesite');

	// Create Connection
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

	// Check Connection
	if(mysqli_connect_errno()){
		// Connection Failed
		echo 'Failed to connect to MySQL '. mysqli_connect_errno();
	}

?>