<?php 

    session_start();
    include "../functions/function.php";
    include "../../config/connection.php";

    if($_POST["btnUserLogIn"]){

        $email=$_POST["emailLog"];
        $pass=md5($_POST["passwdLog"]);
        $errors=[];
    
        if(!$email){
            $erros['emailLog']="Email must be filed out";
        }
        if(!$pass){
            $erros['passwdLog']="Password must be filed out";
        }
        
        if(count($errors)!=0){
            $_SESSION['errorsLog'] = $errors;
            header("Location: ../../index.php?page=login");
        }

        if(count($errors)==0){

            $user=logIn($email,$pass);
            
            if($user){
                $_SESSION['user']=$user;
                logPageLoginSuccessful($email);
                header("Location: ../../index.php?page=user");
            }
            else{

                $erros['btnUserLogIn']="";
                $erros['btnUserLogIn']="Incorrect email or password try again";
                logPageLogin($email);
                
                if(logInLocked($email)){
                    $erros['btnUserLogIn']="Your account has been locked due to multiple login attempts";
                    sendEmail($email);
                }

                $_SESSION['errorsLog']=$erros;
                header("Location: ../../index.php?page=login");
            }
        }
    }
    else{
        header("Location: ../../index.php?page=login");
    }
?>