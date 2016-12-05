<?php
session_start();
if ($_POST) {
    require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/auto_config.php';
    $sql1 = "SELECT DISTINCT "
            . "`student_course_marklist`.`bits_id`, `student_course_marklist`.`data`, `student_course_marklist`.`comp_code`, `course_list`.`course_name`, `student_list`.`full_name` "
            . "FROM `student_course_marklist` JOIN `student_list` JOIN `course_list` "
            . "ON `student_course_marklist`.`bits_id` = `student_list`.`bits_id` AND `student_course_marklist`.`comp_code` = `course_list`.`comp_code` "
            . "WHERE `student_course_marklist`.`bits_id` = ?";
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
            <h3>SEE STUDENT MARKS</h3>
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
                    <h4><?= $data[0]['full_name'] ?></h4><br>

                    <?php
                    $data_all = $data;
                    foreach ($data_all as $data) {
                        echo '<h5>' . $data['course_name'] . '</h5>';
                        $str = $data['data'];
                        $object = unserialize(base64_decode($str));
                        echo '<table border="2">';

                        echo '<tr>';
                        foreach ($object[0] as $heading) {
                            echo '<td>' . $heading . '</td>';
                        }
                        echo '</tr>';

                        echo '<tr>';
                        foreach ($object[1] as $val) {
                            echo '<td>' . $val . '</td>';
                        }
                        echo '</tr>';

                        echo '</table>';
                    }
                }
            }
            ?>
        </div>

    </body>
</html>