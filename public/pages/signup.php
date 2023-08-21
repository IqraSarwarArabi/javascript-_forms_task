<?php     
    require_once('../../private/initialize.php');
    $page_title = 'Signup';
    include(SHARED_PATH . '/header.php'); 
?>
<main>
    <div class="profile">
        <h1>Sign Up</h1>
        <form id="form">
            <div class="signup">
                <div>
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" 
                    required onkeyup="is_username_unique(event, '<?php echo url_for('/actions/is_username_unique.php'); ?>')">
                </div>
                <span class="msg" id="username-msg"></span>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                    required onblur="is_email_valid(event, '<?php echo url_for('/actions/is_email_valid.php'); ?>')">
                </div>
                <span class="msg" id="email-msg"></span>
                <div>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" 
                    required onblur="is_password_valid(event, '<?php echo url_for('/actions/is_password_valid.php'); ?>')">
                </div>
                <span class="msg" id="password-msg"></span>
                <div>
                    <label for="password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" 
                    required onblur="is_confirm_password_valid(event)">
                </div>
                <span class="msg" id="confirm-password-msg"></span>
                <div>
                    <label for="github">Github Username</label>
                    <input type="text" id="github" name="github" required>
                </div>
                <span class="msg" id="github-username-msg"></span>
                <a class="back-link" id="github-verify" onclick="user_exists()">Verify Gitub Username</a>
                <a class="btn" id="signup-btn" onclick="can_submit(event, '<?php echo url_for('/actions/signup.php'); ?>')">Sign Up</a>                
                <a class="back-link" href="<?php echo url_for('index.php'); ?>"> Back to Home</a>
            </div>
        </form>
    </div>
</main>

<?php include(SHARED_PATH . '/footer.php'); ?>