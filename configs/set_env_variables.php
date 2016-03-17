<?php

if(!getenv("CUSTOMCONNSTR_PROD")){
    //loading dev_env.php if not production
    require_once __DIR__."/dev_env.php";
    putenv("BASE_DIR=".__DIR__."/../");
}