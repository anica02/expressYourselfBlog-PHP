<?php 

    session_start();
    include "../functions/function.php";
    include "../../config/connection.php";

    if($_POST["btnComment"]){

        $commId=$_POST["commId"];
        $commId=(int)$commId;
        $comment=$_POST["message"];
        $uId=$_SESSION['user']->id_user;
        $uId=(int)$uId;
        $postId=$_SESSION['singlePostId'];
        $postId=(int)$postId;
        $err="";
        $insertMC;

        if(!$comment){
            $err="Comment must be filed out";
        }
        
        if($err!=""){
            $_SESSION['errorCom'] = $err;
            header('Location: ../../index.php?page=singlePost');
        }        
        else{

            $insertMC=insertMainComm($postId,$uId,$comment);
            
            if($insertMC){
               
                header("Location: ../../index.php?page=singlePost");
            }
            else{
                 header("Location: ../../index.php?page=singlePost");
            }
        }
        
    }
    else{
        header("Location: ../../index.php?page=singlePost");
    }
?>