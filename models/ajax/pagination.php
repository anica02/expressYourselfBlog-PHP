
<?php 
session_start();
header("Content-type: application/json");

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        include "../../config/connection.php";
        include "../functions/function.php";

        try{
            if(isset($_POST['limit'])){
                $userId=$_SESSION['user']->id_user;
                $limit=$_POST['limit'];
                $content="";

                if($_POST['page']==1){
                    $content=getUsersLimit($limit);
                }
                else{
                    $content=getMessagesLimit($limit,$userId);
                }

                $answer = ["array" => $content];
                echo json_encode($answer);
                http_response_code(201);
            }
        }catch(PDOException $exception){
            http_response_code(500);
        }

    }else{
        http_response_code(404);
    }
?>