<?php 
require_once('../../private/initialize.php');
header('Content-Type: application/json');

if (isset($_GET["email"])) {
    $response = array();
    $isUnique = is_email_unique($_GET["email"]);
    if ($isUnique) {
        $response["isUnique"] = true;
    } else {
        $response["isUnique"] = false;
        $response["error"] = "Email is not unique.";
    }
    echo json_encode($response);
}
?>
