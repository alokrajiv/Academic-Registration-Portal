<?php
session_start();
set_time_limit(0);
require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/auto_config.php';
//set_time_limit(0);
$target_file = getenv("BASE_DIR") . "/uploads/" . $_GET['filename'];
//$_SESSION['filePathForStudentList'] = $target_file;
//header("Location: sheet_to_db.php");

$sql1 = "DROP TABLE IF EXISTS `bpdc-arcd-db`.`faculty_course_list`;"
        . "CREATE TABLE `bpdc-arcd-db`.`faculty_course_list` "
        . "( `psrn_no` VARCHAR(20) NOT NULL , `comp_code` INT NOT NULL ,"
        . " `section_code` VARCHAR(5) NOT NULL , `id` INT NOT NULL AUTO_INCREMENT ,"
        . " PRIMARY KEY (`id`)) ENGINE = InnoDB;";
$sql3 = "DROP TABLE IF EXISTS `bpdc-arcd-db`.`course_list`;"
        . "CREATE TABLE `bpdc-arcd-db`.`course_list` "
        . "( `course_name` VARCHAR(80) NOT NULL , `comp_code` INT NOT NULL ,"
        . "  `id` INT NOT NULL AUTO_INCREMENT ,"
        . " PRIMARY KEY (`id`)) ENGINE = InnoDB;";
try {
    $stmt = $dbConn->prepare($sql1);
    $stmt->execute();
    $stmt = $dbConn->prepare($sql3);
    $stmt->execute();
} catch (Exception $ex) {
    
}

$sql2 = "INSERT INTO `bpdc-arcd-db`.`faculty_course_list` (`psrn_no`, `comp_code`, `section_code`) VALUES (?, ?, ?)";
$sql4 = "INSERT INTO `bpdc-arcd-db`.`course_list` (`course_name`, `comp_code`) VALUES (?, ?);";

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>COURSE-STUDENT DETAIL</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <h2>INSERTION PROGRESS BAR</h2>
            <div class="progress" style="width:70%">
                <div id="progress_bar_width" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                     aria-valuemin="0" aria-valuemax="100" style="width:100%">
                    Preparing to start insertion!!
                </div>
            </div>
            <div id="time_remain">

            </div>
        </div>
        <script>
            var progressBar = $('#progress_bar_width');
            var timeRemain = $('#time_remain');

            var updateProgress = function (x, y) {
                x = Math.ceil(x);
                y = Math.floor(y);
                var minute = Math.floor(y / 60),
                        second = y - 60 * minute;
                progressBar.css('width', x + '%');
                progressBar.html(x + '% Complete');
                timeRemain.html(minute + ' minutes and ' + second + ' seconds remaining.')
            }

            setTimeout(rep, 1000);
            function rep() {
                window.scrollTo(0, document.body.scrollHeight);
                setTimeout(rep, 1000);
            }
        </script>
        <?php
        flush();
        $course_id_name = array();
        try {
            $stmt = $dbConn->prepare($sql2);
            $dbConn->beginTransaction();
            //start----*
            require_once $_SERVER["DOCUMENT_ROOT"] . '/../tools/sheet_to_db_main.php';

            class A extends sheet_to_db {

                protected function executer($row) {
                    if(!isset($data[$row[0]])){
                        $this->data[$row[0]] = $row[4];
                    }
                    $this->stmt->execute(array($row[5], $row[0], $row[1]));
                }

            }

            $obj = new A($stmt, 'COURSE-INSTRUCTOR DETAILS', $target_file);
            $course_id_name = $obj->operate();
            $data_input = array();
            foreach ($course_id_name as $key => $value) {
                array_push($data_input, array($key,$value));
            }
            class B extends sheet_to_db {

                protected function executer($row) {
                    $this->stmt->execute(array($row[1], $row[0]));
                }

            }
            $stmt = $dbConn->prepare($sql4);
            $obj_B = new B($stmt, 'COURSE-INSTRUCTOR DETAILS', $target_file);
            $course_id_name = $obj_B->operate_alt($data_input);
            //end-----*
            $dbConn->commit();
            echo "New records created successfully";
            echo '<script>updateProgress(100, 0)</script>';
            //ob_flush();
            flush();
        } catch (PDOException $e) {
            $dbConn->rollback();
            echo "Error: " . $e->getMessage();
        }

        function validate_row($row) {
            return true;
        }
        ?>


    </body>
</html>