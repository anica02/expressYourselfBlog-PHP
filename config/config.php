<?php

    define("BASE_URL", $_SERVER['DOCUMENT_ROOT'].'/blog/');

    define("ENV_FAJL", BASE_URL. "config/.env");
    define("LOG_FAJL", BASE_URL. "data/log.txt");
    define("LOG_FAJL_ACCOUNT", BASE_URL. "data/logAccount.txt");
    define("LOG_FAJL_ACCOUNT_SUCCESSFUL", BASE_URL. "data/logAccountSuccessful.txt");
    define("SERVER", env("SERVER"));
    define("DATABASE", env("DATABASE"));
    define("USERNAME", env("USERNAME"));
    define("PASSWORD", env("PASSWORD"));


    function env($marker){
        $dataArray = file(ENV_FAJL);
        $requiredValue = "";
    
        foreach($dataArray as $row){
            $row = trim($row);
    
            list($key, $value) = explode("=", $row);
    
            if($key == $marker){
                $requiredValue = $value;
                break;
            }
        }
    
        return $requiredValue;
    }
?>