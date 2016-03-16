<?php
session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/auto_config.php';

$target_file = getenv("BASE_DIR") . "/uploads/" . $_GET['filename'];
//$_SESSION['filePathForStudentList'] = $target_file;
//header("Location: sheet_to_db.php");

$sql1 = "DROP TABLE IF EXISTS `bpdc-arcd-db`.`student_list`;"
        . "CREATE TABLE `bpdc-arcd-db`.`student_list` ( `bits_id` VARCHAR(20) NOT NULL , "
        . "`full_name` VARCHAR(60) NOT NULL , `institute_email` VARCHAR(60) NOT NULL , "
        . "`personal_email` VARCHAR(60) NOT NULL , UNIQUE `institute_email` (`institute_email`), "
        . "UNIQUE `personal_email` (`personal_email`)) ENGINE = InnoDB;";
try {
    $stmt = $dbConn->prepare($sql1);
    $stmt->execute();
} catch (Exception $ex) {
    
}

$sql2 = "INSERT INTO `bpdc-arcd-db`.`student_list` (`bits_id`, `full_name`, `institute_email`, `personal_email`) VALUES (?, ?, ?, ?)";
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
                x = Math.floor(x);
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
        $start_time = microtime(TRUE);
        try {
            $stmt = $dbConn->prepare($sql2);
            $dbConn->beginTransaction();

            $Reader = new SpreadsheetReader($target_file);
            $cnt = 0;
            while ($Reader->valid()) {
                $Reader->next();
                $cnt++;
            }
            $Reader->seek(0);
            $i = 0;
            foreach ($Reader as $key => $row) {
                $i++;
                if (!validate_row($row)) {
                    echo "!!SKIPPING $key";
                    continue;
                }
                if ($i > 1) {
                    $stmt->execute(array($row[0], $row[1], $row[2], $row[3]));
                }
                if ($i % 5 == 0) {
                    $current_time = microtime(TRUE);
                    $time_diff = $current_time - $start_time;
                    $percent_compl = (100 * $i / $cnt);
                    $approx_time_remain = ($time_diff / $percent_compl) * (100 - $percent_compl);
                    echo '<script>updateProgress(' . $percent_compl . ', ' . $approx_time_remain . ')</script>';
                    //ob_flush();
                    flush();
                }
                if ($i % 20 == 0) {
                    $current_time = microtime(TRUE);
                    $time_diff = $current_time - $start_time;
                    $percent_compl = (100 * $i / $cnt);
                    $approx_time_remain = ($time_diff / $percent_compl) * (100 - $percent_compl);
                    echo '<script>updateProgress(' . $percent_compl . ', ' . $approx_time_remain . ')</script>';
                    //ob_flush();
                    flush();
                }
            }
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