<?php 

    session_start();
    include "../../config/connection.php";
    include "../functions/function.php";

    if(isset($_POST["btnSubmitSMS"])){
     
        $name=$_SESSION['user']->user_first_name;
        $email=$_SESSION['user']->email;
        $message=trim($_POST["messageSMS"]);
        $userId=$_POST['user'];
        $mssgDate=gmdate("Y-m-d");
            
        $errors=[];
        $data=[];
       
        $regName="/^[A-ZĆČĐŽŠ]{1}[a-zćčđžš]{2,15}(\s[A-ZČĆŠĐŽ]{1}[a-zčćšđž]{2,15})*$/";

        if(!$name){
            $errors['nameSMS']="Name must be filed in";
        }
        else{
           
            if(!preg_match($regName,$name)){
                $errors['nameSMS']="First name has to start with one uppercase letter and length has to be at least 3 characters"; 
            }
            else{
                $data['nameSMS']=$name;
            }
        }

        if(!$email){
            $errors['emailSMS']="Email must be filed in";
        }
        else{
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['emailSMS']="Email wasn't entered in an valid format";
            }
            else{
                $data['emailSMS']=$email;
            }
        }

           
        if(!$message){
            $errors['messageSMS']="Message must be filed in";
        }
        else{
            $data['messageSMS']=$message;
        }

        if($userId==""){
            $errors['user']="User must be choosen";
        }
        else{
            $data['user']=$userId;
        }

        if(count($errors)!=0){
            $_SESSION['errorsFormC'] = $errors;
            $_SESSION['dataFormC']=$data;
            header('Location: ../../index.php?page=contactForm');
        }

        if(count($errors)==0){
            try{

                $userId=(int)$userId;
                $send=insertMsg($name,$email,$message,$mssgDate);
                $lastMsgId=lastMessage();
                insertMsgRec($userId,$lastMsgId);
                    
                $_SESSION['successCon']="Your message has been sent";
                header("Location: ../../index.php?page=contactForm");
                    
            }
            catch(PDOException $ex){
                header("Location: ../../index.php?page=contactForm");
                $message = $ex->getMessage();
                $status = 500; 
                http_response_code($status);
            }
        }
    }
    else{
        header("Location: ../../index.php?page=contactForm");
    }
    
?>