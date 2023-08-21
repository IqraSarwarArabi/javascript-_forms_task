<?php

  function find_all_users() {
    global $db;
    $sql = "SELECT * FROM users ";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    return $result;
  }

  function insert_user($user) {
    global $db;
    $sql = "INSERT INTO users ";
    $sql .= "(username, email, password, github_username) ";
    $sql .= "VALUES (";
    $sql .= "'" . db_escape($db, $user['username']) . "',";
    $sql .= "'" . db_escape($db, $user['email']) . "',";
    $sql .= "'" . db_escape($db, $user['password']) . "',";
    $sql .= "'" . db_escape($db, $user["github"]) . "'";
    $sql .= ")";
    echo $sql;
    $result = mysqli_query($db, $sql);
    if($result) {
      return true;
    } else {
      echo mysqli_error($db);
      db_disconnect($db);
      exit;
    }
  }

  function is_username_unique($username) {
    global $db; 
    $sql = "SELECT COUNT(*) FROM users ";
    $sql .= "WHERE username = '" . db_escape($db, $username) . "'";
    $result = mysqli_query($db, $sql);
    confirm_result_set($result);
    $row = mysqli_fetch_row($result);
    mysqli_free_result($result);
    $count = $row[0];
    return intval($count) === 0; 
  }

  function is_email_unique($email) {
    global $db;
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE email='" . db_escape($db, $email) . "'";
    $users = mysqli_query($db, $sql);
    $users_count = mysqli_num_rows($users);
    mysqli_free_result($users);
    return intval($users_count) === 0;
  }

?>
