<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo url_for('/styles/index.css'); ?>">
    <link rel="stylesheet" href="<?php echo url_for('/styles/theme.css'); ?>">
    <script src="<?php echo url_for('script/jquery.js') ?>"></script>
    <script src="<?php echo url_for('script/index.js') ?>"></script>
    <title>Javascript <?php if(isset($page_title)) { echo '- ' . h($page_title); } ?></title>
</head>
<body>
    <header>
        <h1>Javascript !</h1>
        <nav> 
            <div>          
                <?php echo '<a href="' . url_for('/pages/signup.php') . '">Signup</a>'; ?>
            </div>
            <div>
                <label class="toggle-control">
                    <input type="checkbox" id="theme-toggle" onchange="toggle_theme()">
                    <span class="control"></span>
                </label> 
            </div>
        </nav>
    </header>
    <div class="message">
        <?php echo display_session_message(); ?>
    </div>
