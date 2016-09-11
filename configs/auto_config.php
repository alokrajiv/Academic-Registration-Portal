<?php

require_once __DIR__ . "/db_config.php";
//require_once __DIR__."/debugger.php";
require_once __DIR__ . "/set_env_variables.php";
require_once __DIR__ . "/../vendor/autoload.php";

function checkIfLoggedInAs($type) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if ($_SESSION['user_data']['type'] !== $type) {
        safeRedirect("/");
    }
}

function safeRedirect($new_url) {
    if (!headers_sent()) {
        header("Location: $new_url");
    } else {
        echo "<script>window.location.href = '$new_url';</script>";
    }
    exit();
}
