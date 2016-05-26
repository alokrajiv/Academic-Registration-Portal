<?php
session_start();
set_time_limit(0);
require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/auto_config.php';
//set_time_limit(0);
//$_SESSION['filePathForStudentList'] = $target_file;
//header("Location: sheet_to_db.php");

$sql1 = "CREATE TABLE IF NOT EXISTS `bpdc-arcd-db`.`student_course_attendance_list` "
        . "( `comp_code` INT NOT NULL , `section_code` VARCHAR(5) NOT NULL ,"
        . " `bits_id` VARCHAR(20) NOT NULL , `attendance` INT NOT NULL ,"
        . " `data` TEXT NOT NULL , "
        . "PRIMARY KEY (`comp_code`,`section_code`,`bits_id`)) "
        . "ENGINE = InnoDB;";
try {
    $stmt = $dbConn->prepare($sql1);
    $stmt->execute();
} catch (Exception $ex) {
    
}

$sql2 = "INSERT INTO `bpdc-arcd-db`.`student_course_attendance_list` "
        . "(`comp_code`, `section_code`, `bits_id`, `attendance`, `data`) "
        . "VALUES (?, ?, ?, ?, ?)"
        . "ON DUPLICATE KEY UPDATE `comp_code` = ?, `section_code` = ?, "
        . "`bits_id` = ?, `attendance` = ?, `data` = ?"
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
        try {
            $start_time = microtime(TRUE);
            $stmt = $dbConn->prepare($sql2);
            $dbConn->beginTransaction();
            //start----*
            $i = 1;
            $data = $_SESSION['attendance_data_to_process'];
            $meta = $data[0];
            $totRows = count($data);
            while ($i < count($data)) {
                $row = $data[$i];
                if (!validate_row($row)) {
                    echo "!!SKIPPING $rowIndex";
                    continue;
                }
                if ($i > 1) {
                    $stmt->execute(array($row[0], $row[1], $row[2], $row[3], $row[4], $row[0], $row[1], $row[2], $row[3], $row[4]));
                }
                if ($i % 5 == 0) {
                    $current_time = microtime(TRUE);
                    $time_diff = $current_time - $start_time;
                    $percent_compl = (100 * $i / $totRows);
                    $approx_time_remain = ($time_diff / $percent_compl) * (100 - $percent_compl);
                    echo '<script>updateProgress(' . $percent_compl . ', ' . $approx_time_remain . ')</script>';
                    //ob_flush();
                    flush();
                }
                $i++;
            }
            //end-----*
            $dbConn->commit();
            echo "New $i records created successfully";
            echo '<script>updateProgress(100, 0)</script>';
            //ob_flush();
            echo '<br><a href="/faculty/">BACK TO DASH</a>';
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