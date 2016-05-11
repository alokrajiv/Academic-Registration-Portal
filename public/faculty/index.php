<?php
session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <a href="attendance/">UPLOAD ATTENDANCE</a>
        Logged in as <?=$_SESSION['user_data']['full_name']?>
        <a href="/login/logout.php">LOGOUT</a>
        <?php
        ?>
    </body>
</html>
