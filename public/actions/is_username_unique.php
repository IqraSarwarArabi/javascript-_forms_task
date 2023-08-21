<?php 
require_once('../../private/initialize.php');
header('Content-Type: application/json');

if (isset($_GET["username"])) {
    echo json_encode(is_username_unique($_GET["username"]));
}
?>
