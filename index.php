<?php
session_start();

require 'LoginService.php';

LoginService::checkLogin();
?>

<h1 style="text-align: center; margin-top: 50px; color: #517645;">
    Logged <br>
    <?php echo 'Private access information for user: ' . $_SESSION['user']['id']; ?>
</h1>


