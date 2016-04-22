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

        $Reader = new SpreadsheetReader($target_file);
        $sheets = $Reader->Sheets();
        echo "<br>" . count($sheets) . " sheets founds. The first will be taken automatically.";
        echo "<br>The entire faculty table is going to be flushed and loaded with this data.";
        
        echo '<a href="sheet_to_db.php?filename=' . basename($target_file) . '">CONFIRM</a>';
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
