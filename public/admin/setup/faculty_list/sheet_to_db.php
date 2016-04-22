<?php
session_start();
set_time_limit(0);
require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/auto_config.php';

$target_file = getenv("BASE_DIR") . "/uploads/" . $_GET['filename'];
//$_SESSION['filePathForStudentList'] = $target_file;
//header("Location: sheet_to_db.php");

$sql1 = "DROP TABLE IF EXISTS `bpdc-arcd-db`.`faculty_list`;"
        . "CREATE TABLE `bpdc-arcd-db`.`faculty_list` ( `psrn_no` VARCHAR(20) NOT NULL , "
        . "`full_name` VARCHAR(60) NOT NULL , `institute_email` VARCHAR(60) NOT NULL , "
        . "`personal_email` VARCHAR(60) NOT NULL , UNIQUE `institute_email` (`institute_email`), "
        . "UNIQUE `personal_email` (`personal_email`)) ENGINE = InnoDB;";
try {
    $stmt = $dbConn->prepare($sql1);
    $stmt->execute();
} catch (Exception $ex) {
    
}

$sql2 = "INSERT INTO `bpdc-arcd-db`.`faculty_list` (`psrn_no`, `full_name`, `institute_email`, `personal_email`) VALUES (?, ?, ?, ?)";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>FLUSH STUDENT LIST</title>
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
        </script>
        <?php
        flush();
        try {
            $stmt = $dbConn->prepare($sql2);
            $dbConn->beginTransaction();
            //start----*
            require_once $_SERVER["DOCUMENT_ROOT"] . '/../tools/sheet_to_db_main.php';
            class A extends sheet_to_db {

                protected function executer($row) {
                    $this->stmt->execute(array($row[0], $row[1], $row[2], $row[3]));
                }

            }
            $obj = new A($stmt, 'FACULTY-DETAILS', $target_file);
            $obj->operate();
            //end-----*
            $dbConn->commit();
            echo "New records created successfully";
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