<?php 
require_once('../../private/initialize.php');

if(is_post_request()) {
  $user['username'] = $_POST['username'] ?? '';
  $user['email'] = $_POST['email'] ?? '';
  $user['password'] = $_POST['password'] ?? '';
  $user['github'] = $_POST['github'] ?? '';
  
  $result = insert_user($user);
  return $result;
}
else
  return false;

?>