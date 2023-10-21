<?php 

    session_start();
    include "../../config/connection.php";
    include "../functions/function.php";

    if($_POST["btnCreatAcc"]){
        
        $status = 201; 
        $message = null;
        $fName=$_POST["firstNameSg"];
        $lName=$_POST["lastNameSg"];
        $email=$_POST["emailSg"];
        $pass=$_POST["passwdSg"];
        $coPass=$_POST["passwdSgCon"];
        $username=$_POST["username"];
        $passL=strlen($pass);
        $errors=[];
        $data=[];

        $regName="/^[A-ZĆČĐŽŠ]{1}[a-zćčđžš]{2,15}(\s[A-ZČĆŠĐŽ]{1}[a-zčćšđž]{2,15})*$/";
        $regUsername="/^(?=[a-zA-Z0-9._]{8,20}$)(?!.*[_.]{2})[^_.].*[^_.]$/";

        if(!$fName){
            $errors['firstNameSg']="First name must be filed in";
        }
        else{
           
            if(!preg_match($regName,$fName)){
                $errors['firstNameSg']="First name has to start with one uppercase letter and length has to be at least 3 characters"; 
            }
            else{
                $data['firstNameSg']=$fName;
            }
        }

        if(!$lName){
            $errors['lastNameSg']="Last name must be filed in";
        }
        else{

            if(!preg_match($regName,$lName)){
                $errors['lastNameSg']="Last name has to start with one uppercase letter and length has to be at least 3 characters"; 
            }
            else{
                $data['lastNameSg']=$lName;
            }
            
        }

        if(!$username){
            $errors['username']="Username must be filed in";
           
        }
        elseif(getUsername($username)){
            $errors['username']="Username already in use";
        }
        else{
           
            if(!preg_match($regUsername,$username)){
                $errors['username']="Username must start with alphanumeric characters, its allow to use dot , underscore , and hyphen. The number of characters must be between 6 to 18."; 
            }
            else{
                $data['username']=$username;
            }
        }

        if(!$email){
            $errors['emailSg']="Email must be filed in";
        }
        elseif(getEmail($email)){
            $errors['emailSg']="Email already in use";
        }
        else{
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $errors['emailSg']="Email wasn't entered in an valid format";
            }
            else{
                $data['emailSg']=$email;
            }
        }

        if(!$pass){
            $errors['passwdSg']="Password must be filed in";
        }
        else{
            $regPass="/^(?=.*[a-zčćđžš])(?=.*[A-ZČĆĐŽŠ])(?=.*\d)(?=.*[@$!%*?])([A-ZČĆĐŽŠa-zčćđžš\d@$!%*?]){8,}$/";
            if(!preg_match ($regPass,$pass)){
                $errors['passwdSg']="Password length has to be at least 8 character and has to contain at least one uppercase letter, one lowercase, one number and one special character";
            }
            else{
                $data['passwdSg']=$pass;
            }
        }

        if(!$coPass){
            $errors['passwdSgCon']="Confirmed password must be filed in";
        }
        else{
            if($coPass!=$pass){
                $errors['passwdSgCon']="Confirmed password doesn't match the main password";
            }
            else{
                $data['passwdSgCon']=$coPass;
            }
        }

        if(count($errors)!=0){

            $_SESSION['errorsForm'] = $errors;
            $_SESSION['dataForm']=$data;
            header('Location: ../../index.php?page=signUp');
        }
        
           
        if(count($errors)==0){

            try{

                $message = "";
                $status = 201; 
                $passM=md5($pass);
                $randN=rand();
                $upit=signUp($fName,$lName,$email,$passM,$randN,$username);

                    if($upit){
                        $_SESSION['success']="Your account has been created now you need to log in";
                        header("Location: ../../index.php?page=login");
                    }
                    else{
                        header('Location: ../../index.php?page=signUp');
                    }
            }
            catch(PDOException $ex){

                header('Location: ../../index.php?page=signUp');
                $message = $ex->getMessage();
                $status = 500; 
                http_response_code($status);
            }
        }
    }
    else{
        header('Location: ../../index.php?page=signUp');
    }
?>