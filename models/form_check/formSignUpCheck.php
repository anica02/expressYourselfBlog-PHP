<?php 

    include "../config/connection.php";
    include "../functions/function.php";

    $randN=$_GET['code'];
    $updateUser=updateUser($randN);
    if($updateUser){
        header('Location: ../logIn.php');
    }
    else{
        header('Location: ../signUp.php');
    }

?>