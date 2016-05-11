<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/auto_config.php';
$sql1 = "SELECT "
        . "`student_course_list`.`comp_code`,`student_course_list`.`section_code`,"
        . "`student_course_attendance_list`.`attendance` "
        . "FROM `student_course_list` JOIN `student_course_attendance_list` "
        . "ON `student_course_list`.`id` = `student_course_attendance_list`.`id`"
        . "WHERE `bits_id` = ?";
try {
    $stmt = $dbConn->prepare($sql1);
    $stmt->execute(array($_SESSION['user_data']['bits_id']));
    $data = array();
    while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($data, $result);
    }
} catch (Exception $ex) {
    
}
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
        <?php
        foreach ($data as $key => $value) {
            echo "{$value['comp_code']} - {$value['section_code']} - {$value['attendance']}<br>";
        }
        ?>
    </body>
</html>
