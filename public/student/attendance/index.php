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
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
        <meta name="viewport" content="width=device-width, initial-scale=1"> 
        <title>Attendance</title>
        <!--Jquery Plugin-->
        <script src="../../assets/js/jquery.min.js"></script>
        <script src="../../assets/js/jquery-ui.js"></script>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="../../assets/css/bootstrap-theme.min.css">
        <!--Custom CSS-->
        <link rel="stylesheet" type="text/css" href="../../assets/css/custom.css" />
        <!-- Latest compiled and minified JavaScript -->
        <script src="../../assets/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container custom-table">
           <table class="table table-bordered table-hover table-responsive">
                        <thead>
                            <tr>
                                <th>
                                    Comp_code
                                </th>
                                <th>
                                    Section
                                </th>
                                <th>
                                    Attendance
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $key => $value) {
                                    echo "<tr>
                                            <td>{$value['comp_code']}</td>
                                            <td>{$value['section_code']}</td>
                                            <td>{$value['attendance']} %</td>
                                        </tr>";
                           } ?>
                        </tbody>
                    </table> 

        <!--<?php
       // foreach ($data as $key => $value) {
         //   echo "{$value['comp_code']} - {$value['section_code']} - {$value['attendance']}<br>";
       // }
        ?>-->
        </div>
    </body>
</html>
