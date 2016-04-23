<?php
require_once __DIR__."/set_env_variables.php";
try {
    $dbConn = new PDO(getenv("MYSQLCONNSTR_connection"),getenv("MYSQLCONNSTR_username"),getenv("MYSQLCONNSTR_password"));
    
} catch (PDOException $e) {
    echo("db_Connection!: " . $e->getMessage() . "<br/>");
    die("db error");
}
function setup_db($sqlFilePath){
    logger("setting up db...");
    $sql = file_get_contents($sqlFilePath); //file name should be name of SQL file with .sql extension.
    try {
        $qr = $dbConn->exec($sql);
    }
    catch (PDOException $e){
        logger($e->getMessage());
        die();
    }
}
$stmt = $dbConn->prepare("USE `bpdc-arcd-db`;");
$stmt->execute();