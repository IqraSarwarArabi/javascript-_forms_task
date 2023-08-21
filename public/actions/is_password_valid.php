<?php 
require_once('../../private/initialize.php');
header('Content-Type: application/json');

if (isset($_GET["password"])) {
    $errors = [];
    $password = $_GET["password"];
    if (!has_length($password, array('min' => 7))) 
        $errors[] = "Password must contain 7 or more characters";
    if (!preg_match('/[A-Z]/', $password)) 
        $errors[] = "Password must contain at least 1 uppercase letter";
    if (!preg_match('/[a-z]/', $password)) 
        $errors[] = "Password must contain at least 1 lowercase letter";
    if (!preg_match('/[0-9]/', $password)) 
        $errors[] = "Password must contain at least 1 number";
    if (!preg_match('/[^A-Za-z0-9\s]/', $password)) 
        $errors[] = "Password must contain at least 1 symbol";
    echo json_encode($errors);
}
?>
