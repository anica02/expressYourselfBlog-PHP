<?php 
session_start();
header("Content-type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        include "../../config/connection.php";
        include "../functions/function.php";

        $userId=$_SESSION['user']->id_user;
        $userRole=$_SESSION['user']->id_role;
        $arrayPost;
          
        try{

            if(isset($_POST['search'])){

                $titleS=$_POST['search'];
                $page=$_POST['page'];
                
                if($page==0){
                    $arrayPost=postsByTitle($titleS);
                }
                else{
                    $arrayPost=postsByTitleU($titleS,$userId);
                }
               
            }
            elseif(isset($_POST['postD'])){
                
                $dateP=$_POST['postD'];
                $page=$_POST['page'];
                
                if($page==0){
                    $arrayPost=postsByDate($dateP);
                }
                else{
                    $arrayPost=postsByDateU($dateP,$userId);
                }
            
            }
            elseif(isset($_POST['tagN'])){

                $tagN=$_POST['tagN'];
                $page=$_POST['page'];
                
                if($page==0){
                    $arrayPost=getPostWithTagName($tagN);
                }
                else{
                    $arrayPost=getPostWithTagNameU($tagN,$userId);
                }
            }
            elseif(isset($_POST['oldPost'])){

                $arrayPost = getPosts();
            }
       
            if($arrayPost){

                $likedPosts=userLikedPosts();
                

                $answer = ["array" => $arrayPost, "postsLikes"=> $likedPosts,"uRole"=> $userRole, "userId"=>$userId];
                echo json_encode($answer);
                http_response_code(201);
            }
            else{
                http_response_code(500);
            }
        }catch(PDOException $exception){
            http_response_code(500);
        }
        
    }
    else{
        http_response_code(404);
    }
?>