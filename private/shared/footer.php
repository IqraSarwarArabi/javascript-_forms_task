       <footer>
            <p>Copyright <?php echo date('Y'); ?>, Arbisoft </p>
        </footer>
        <script src="<?php echo url_for('/script/index.js') ?>"></script>
    </body>
</html>

<?php
  db_disconnect($db);
?>