<?php

use Akeneo\Component\SpreadsheetParser\SpreadsheetParser;

require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/auto_config.php';

abstract class sheet_to_db {

    public $stmt,$sheetToRead,$target_file;

    public function __construct($stmt,$sheetToRead,$target_file) {
        $this->stmt = $stmt;
        $this->sheetToRead = $sheetToRead;
        $this->target_file = $target_file;
    }

    public function operate() {
        $start_time = microtime(TRUE);
        $target_file = $this->target_file;
        $sheetToRead = $this->sheetToRead;
        $inputFileType = PHPExcel_IOFactory::identify($target_file);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $sheets = $objReader->listWorksheetInfo($target_file);
        $currSheet = -1;
        foreach ($sheets as $index => $sheet) {
            if ($sheet['worksheetName'] == $sheetToRead) {
                //var_dump($sheet);
                $currSheet = $sheet;
            }
        }
        if ($currSheet === -1) {
            die("Expected sheet not found. exiting....!");
        }
        flush();
        $objReader->setLoadSheetsOnly($sheetToRead);

        //Switching to high-performance library

        $workbook = SpreadsheetParser::open($target_file);
        $myWorksheetIndex = $workbook->getWorksheetIndex($sheetToRead);
        $i = 0;
        $totRows = intval($currSheet['totalRows']);
        foreach ($workbook->createRowIterator($myWorksheetIndex) as $rowIndex => $row) {
            $i++;
            if (!validate_row($row)) {
                echo "!!SKIPPING $rowIndex";
                continue;
            }
            if ($i > 1) {
                $this->executer($row);
                //var_dump($row);
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
        }
        echo "Found data on $i rows out of $totRows present rows";
    }
    
    abstract protected function executer($row);

}
