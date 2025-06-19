<!-- db_config.php  -->
<?php
// Database configuration
// $db_host = "sql311.byethost13.com";
// $db_user = "b13_39239332";
// $db_password = "nandaaulia1004#";
// $db_name = "b13_39239332_blog_dinamis";

$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "blog_dinamis";

// Create database connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>