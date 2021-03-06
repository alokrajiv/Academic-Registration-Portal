<?php

session_start();
require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/auto_config.php';
$target_dir = getenv("BASE_DIR") . "/uploads/";
$sheetFileType = pathinfo($_FILES["xlsx_file"]["name"], PATHINFO_EXTENSION);
$target_file = $target_dir . uniqid() . '.' . $sheetFileType;

$uploadOk = 1;
// Check if image file is a actual image or fake image
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["xlsx_file"]["size"] > 1000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if ($sheetFileType != "xls" && $sheetFileType != "xlsx" && $sheetFileType != "ods" && $sheetFileType != "csv") {
    echo "Sorry, Format allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["xlsx_file"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["xlsx_file"]["name"]) . " has been uploaded.";

        $inputFileName = $target_file;

//  Read your Excel workbook
        try {
            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($inputFileName);
        } catch (Exception $e) {
            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
        }
        $to_save_data = array();
//  Get worksheet dimensions
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $controlRowData = $sheet->rangeToArray('A' . 4 . ':' . $highestColumn . 4, NULL, TRUE, FALSE);
        echo("<br>{$controlRowData[0][2]}------{$controlRowData[0][5]}------{$controlRowData[0][7]}");
        array_push($to_save_data, array($controlRowData[0][2], $controlRowData[0][5], $controlRowData[0][7]));
//  Loop through each row of the worksheet in turn
        for ($row = 12; $row <= $highestRow; $row++) {
            //  Read a row of data into an array
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
            //var_dump($rowData);
            if (is_null($rowData[0][1])) {
                continue;
            }
            echo "<br>{$rowData[0][1]}------------{$rowData[0][11]}";
            flush();
            array_push($to_save_data, array($controlRowData[0][5], $controlRowData[0][7], $rowData[0][1], $rowData[0][11], json_encode($rowData)));
        }
        $_SESSION['attendance_data_to_process'] = $to_save_data;
        echo "<br><h2> --> Course {$controlRowData[0][2]}({$controlRowData[0][5]}) section:{$controlRowData[0][7]} <--  </h2><h3><a href=\"update.php?\">CLICK THIS LINK TO CONFIRM UPDATION OF ATTENDANCE!  </a></h3> <br><br><br><br><br><br><br><br><script>window.scrollTo(0,document.body.scrollHeight);</script>";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

function uniqid_base36($more_entropy = true) {
    $s = uniqid('', $more_entropy);
    if (!$more_entropy)
        return base_convert($s, 16, 36);

    $hex = substr($s, 0, 13);
    $dec = $s[13] . substr($s, 15); // skip the dot
    return base_convert($hex, 16, 36) . base_convert($dec, 10, 36);
}
