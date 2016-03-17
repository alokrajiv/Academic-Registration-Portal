<?php
session_start(); //session start

require_once $_SERVER["DOCUMENT_ROOT"].'/../vendor/google/apiclient/src/Google/autoload.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/auto_config.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../configs/debugger.php';

//Insert your cient ID and secret 
//You can get it from : https://console.developers.google.com/
$client_id = '543618368896-pdttlgf1v8caca51dp017npqu1qgcei4.apps.googleusercontent.com'; 
$client_secret = 'lLkfNni6luZREbSfwx8PBbm_';
$redirect_uri = getenv("CUSTOMCONNSTR_BASE_URL").'/login/google-login-redirect/';

//incase of logout request, just unset the session var
if (isset($_GET['logout'])) {
  unset($_SESSION['access_token']);
}
