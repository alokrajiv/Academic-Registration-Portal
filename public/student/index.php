<?php
if (session_status() == PHP_SESSION_ACTIVE) {
    session_destroy();
}
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . '/../tools/auth_manager.php';
$auth_manager = new auth_manager();
$auth_manager->set_session("f2013119@dubai.bits-pilani.ac.in");
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
        <a href="attendance/">SEE ATTENDANCE</a>
        Logged in as <?=$_SESSION['user_data']['full_name']?>
        <?php
        ?>
    </body>
</html>
