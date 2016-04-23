<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/../tools/auth_manager.php';
$obj = new auth_manager();
$obj->getUserData();
