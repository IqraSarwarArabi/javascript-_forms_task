<?php     
    require_once('../private/initialize.php');
    include(SHARED_PATH . '/header.php'); 
    
    $users_result = find_all_users();
    $users = [];
    while ($row = mysqli_fetch_assoc($users_result)) {
        $users[] = $row; 
    }
?>

<main>
    <div class="wrapper">
        <?php if (empty($users)) { ?>
            <p class="message">No users found :)</p>
        <?php } else { ?>
            <ul class="user-list" id="userList">
                <?php foreach ($users as $user) { ?>
                    <li class="user">
                        <div class="user-info">
                            <p class="user-name"><?php echo $user['username']; ?></p>
                            <p class="user-email"><?php echo $user['email']; ?></p>
                            <p class="user-email">Github: <?php echo $user['github_username']; ?></p>
                        </div>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</main>

<?php include(SHARED_PATH . '/footer.php'); ?>
