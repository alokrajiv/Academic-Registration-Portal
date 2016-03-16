<?php

require_once $_SERVER["DOCUMENT_ROOT"].'/../configs/auto_config.php';

function cache_to_array($path) {
    // If you need to parse XLS files, include php-excel-reader
    //require('spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
    $Reader = new SpreadsheetReader($path);
    $sheets = $Reader->Sheets();
    $matrixData = [];
    foreach ($sheets as $sheetNo => $sheetName) {
        $Reader->ChangeSheet($sheetNo);
        $matrix = [];
        $meta['sheetNo'] = $sheetNo;
        $meta['sheetName'] = $sheetName;
        $matrix['meta'] = $meta;
        $data = [];
        foreach ($Reader as $row) {
            array_push($data, $row);
        }
        $matrix['data'] = $data;
        array_push($matrixData, $matrix);
    }
    return $matrixData;
}

$matrixData = cache_to_array('template_bits_attendance.xlsx');
echo count($matrixData)." sheets were found. Parsing all sheets.";

