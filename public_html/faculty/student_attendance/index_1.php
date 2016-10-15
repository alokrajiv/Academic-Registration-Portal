<?php
session_start();
if ($_POST) {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/auto_config.php';
    $sql1 = "SELECT "
            . "`student_list`.`full_name` AS 'student_name', "
            . "`faculty_list`.`full_name` AS 'faculty_name', "
            . "`faculty_course_list`.`psrn_no`, "
            . "`course_list`.`course_name`, "
            . "`student_course_attendance_list`.`comp_code`, "
            . "`student_course_attendance_list`.`section_code`, "
            . "`student_course_attendance_list`.`attendance` "
            . "FROM "
            . "`student_course_attendance_list` JOIN "
            . "`course_list` JOIN "
            . "`faculty_course_list` JOIN "
            . "`faculty_list` JOIN"
            . "`student_list`"
            . "ON"
            . " `student_course_attendance_list`.`comp_code` = `course_list`.`comp_code` AND"
            . " `student_course_attendance_list`.`bits_id` = `student_list`.`bits_id` AND"
            . " `faculty_course_list`.`comp_code` = `student_course_attendance_list`.`comp_code` AND "
            . "`faculty_course_list`.`section_code` = `student_course_attendance_list`.`section_code` AND"
            . " `faculty_course_list`.`psrn_no` = `faculty_list`.`psrn_no`"
            . "WHERE "
            . "`student_course_attendance_list`.`bits_id` = ? ";
    try {
        $stmt = $dbConn->prepare($sql1);
        $stmt->execute(array($_POST['bits_id']));
        $data = array();
        while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($data, $result);
        }
    } catch (Exception $ex) {

    }
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

        <div class="container custom-table" >
            <a href="/faculty/">BACK TO DASH</a>
            <form method="post" >
                STUDENT BITS-ID:&nbsp;&nbsp;&nbsp;<input type="text" name="bits_id" placeholder="Enter Here.. ">
                <button type="submit">GO</button>
            </form>
            <?php
            if (isset($data)) {
                if (count($data) === 0) {
                    ?>
                    <h3>NO STUDENT MATCHING THE DATA YOU PROVIDED!</h3>

                    <?php
                } else {
                    ?>
                    <br>
                    <h4><?= $data[0]['student_name'] ?></h4><br>
                    <table class="table table-bordered table-hover table-responsive" id="attendance-table">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    Course Name
                                </th>
                                <th class="text-center">
                                    Section No
                                </th>
                                <th class="text-center">
                                    Faculty Name
                                </th>
                                <th class="text-center">
                                    Attendance
                                </th>
                                <th class="text-center">
                                    Details
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data as $key => $value) {
                                echo "<tr onclick=''>
                                                <td class='text-center'>{$value['course_name']}</td>
                                                <td class='text-center'>{$value['section_code']}</td>
                                                <td class='text-center'>{$value['faculty_name']}</td>
                                                <td class='text-center'>{$value['attendance']} %</td>
                                                <td class='text-center'><button class='btn btn-primary' type='button' data-toggle='modal' data-target='#attendanceModal' >Click Here</button> </td>
                                            </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                }
            }
            ?>
        </div>
    </body>
</html>
