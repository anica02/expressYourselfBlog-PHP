<?php 
session_start();
include('../../config/connection.php');
include('../functions/function.php');

if(isset($_POST['pId'])){ 

    $postId=intval($_POST['pId']);
    $query1="DELETE FROM post_tag WHERE id_post=$postId";
    $query2="DELETE FROM comment WHERE id_post=$postId";
    $query3="DELETE FROM user_post_liked WHERE id_post=$postId";
    $query4="DELETE FROM post WHERE id_post=$postId";

    try { 
        $conn->query($query1)->rowCount() > 0 ? http_response_code(200) : 
        http_response_code(500); 

        $conn->query($query2)->rowCount() > 0 ? http_response_code(200) : 
        http_response_code(500); 

        $conn->query($query3)->rowCount() > 0 ? http_response_code(200) : 
        http_response_code(500); 

        $conn->query($query4)->rowCount() > 0 ? http_response_code(200) : 
        http_response_code(500); 

    }catch(PDOException $e) { 
        http_response_code(500); 
    }
}

elseif(isset($_POST['pIdSing'])){ 

    $postId=intval($_POST['pIdSing']);
    $_SESSION['singlePostId']=$postId;

    try { 
        $_SESSION['singlePostId']!=null ? http_response_code(200) : 
        http_response_code(500); 
        
    }catch(PDOException $e) { 
        http_response_code(500); 
    }
}

elseif(isset($_POST['postEdit'])){ 

    $postId=intval($_POST['postEdit']);
    $_SESSION['postIdEdit']=$postId;

    try { 
        $_SESSION['postIdEdit']!=null ? http_response_code(200) : 
        http_response_code(500); 
        
    }catch(PDOException $e) { 
        http_response_code(500); 
    }
}

elseif(isset($_POST['postL'])){ 

    $postId=intval($_POST['postL']);
    $userId=intval($_POST['uIdL']);
    $like=1;
    $query1="UPDATE post SET likes=likes+$like WHERE id_post=$postId";
    $query2="INSERT INTO user_post_liked(id_user,id_post,liked) VALUES($userId,$postId,1)";

    try { 
        $conn->query($query1)->rowCount() >= 0 ? http_response_code(200) : 
        http_response_code(500); 

        $conn->query($query2)->rowCount() >= 0 ? http_response_code(200) : 
        http_response_code(500); 
    }catch(PDOException $e) { 
        http_response_code(500); 
    }
}

elseif(isset($_POST['postDL'])){ 

    $postId=intval($_POST['postDL']);
    $userId=intval($_POST['uIdDL']);
    $like=1;
    $query1="UPDATE post SET likes=likes-$like WHERE id_post=$postId";
    $query2="DELETE FROM user_post_liked WHERE id_user=$userId AND id_post=$postId";

    try { 
        $conn->query($query1)->rowCount() >= 0 ? http_response_code(200) : 
        http_response_code(500); 

        $conn->query($query2)->rowCount() >= 0 ? http_response_code(200) : 
        http_response_code(500); 
    }catch(PDOException $e) { 
        http_response_code(500); 
    }
}

elseif(isset($_POST['uId'])){ 

    $userId=intval($_POST['uId']);
    
    $query1="DELETE FROM post WHERE id_user=$userId";
    $query2="DELETE FROM user_post_liked WHERE id_user=$userId";
    $query3="DELETE FROM message_recipient WHERE id_recipient=$userId";
    $query4="DELETE FROM comment WHERE id_user=$userId";
    $query6="DELETE FROM user WHERE id_user=$userId";

    try { 
        $conn->query($query2)->rowCount() > 0 ? http_response_code(200) : 
        http_response_code(500);

        $conn->query($query3)->rowCount() > 0 ? http_response_code(200) : 
        http_response_code(500); 

        $conn->query($query4)->rowCount() > 0 ? http_response_code(200) : 
        http_response_code(500); 

        $conn->query($query1)->rowCount() >= 0 ? http_response_code(200) : 
        http_response_code(500); 

        $conn->query($query6)->rowCount() > 0 ? http_response_code(200) : 
        http_response_code(500); 
    }catch(PDOException $e) { 
        http_response_code(500); 
    }
}

elseif(isset($_POST['msgId'])){ 

    $msgId=intval($_POST['msgId']);
    $query1="DELETE FROM message_recipient WHERE id_message=$msgId";
    $query2="DELETE FROM message WHERE id_msg=$msgId";

    try { 
        $conn->query($query1)->rowCount() >= 0 ? http_response_code(200) : 
        http_response_code(500); 

        $conn->query($query2)->rowCount() >= 0 ? http_response_code(200) : 
        http_response_code(500); 
    }catch(PDOException $e) { 
        http_response_code(500); 
    }
}

elseif(isset($_POST['commDel'])){ 

    $commId=intval($_POST['commDel']);
    $query1="DELETE FROM comment WHERE id_comment=$commId";

    try { 
        $conn->query($query1)->rowCount() >= 0 ? http_response_code(200) : 
        http_response_code(500); 
    }catch(PDOException $e) { 
        http_response_code(500); 
    }
}

elseif(isset($_POST['btnMssReply'])){ 

    $userEmailRec=$_POST["email"];
    $msg=$_POST["message"];
    $mssgDate=gmdate("Y-m-d");

    $userIdRec=getUserId($userEmailRec);
    $userIdRec=$userIdRec->id_user;
    $userName=$_SESSION['user']->user_first_name;
    $userEmail=$_SESSION['user']->email;
   
    if(empty($msg)){
        http_response_code(500); 
    }
    else{
        try { 
      
            $query1="INSERT INTO message (u_name,u_email,u_msg,create_date) VALUES ('$userName','$userEmail','$msg',' $mssgDate') ";
            $conn->query($query1)->rowCount() >= 0 ? http_response_code(200) : 
            http_response_code(500); 

            $lastMsgId=lastMessage();
            $query2="INSERT INTO message_recipient (id_recipient,id_message) VALUES ($userIdRec,$lastMsgId)";
            $conn->query($query2)->rowCount() >= 0 ? http_response_code(200) : 
            http_response_code(500); 

            $_SESSION['successMsg']="You have successfully replied to the selected message";
            header('Location: ../../index.php?page=messages');

        }catch(PDOException $e) { 
        http_response_code(500); 
        }
    }
}

elseif(isset($_POST['btnUsersData'])){

    $role=$_POST['role'];
    $status=$_POST['status'];
    $userId=$_POST['idUser'];
    var_dump($role,$status,$userId);
       
    if(!empty($role) && !empty($status)){
        $roleInt=intval($role);
        $statusInt=intval($status);
        $userIdInt=intval($userId);
        $query="UPDATE user SET id_role=$roleInt, u_status=$statusId WHERE id_user=$userIdInt";

        try { 
            $update=$conn->query($query)->rowCount() > 0 ? http_response_code(200) : 
            http_response_code(500); 

            if($update){
                header("Location: ../../index.php?page=users");
            }    
           
        }catch(PDOException $e) { 
            echo "Error";
            http_response_code(500); 
        }
    }
    elseif(!empty($role)){

        $roleInt=intval($role);
        $userIdInt=intval($userId);
        $query1="UPDATE user SET id_role=$roleInt WHERE id_user=$userIdInt";

        try { 
            $update=$conn->query($query1)->rowCount() > 0 ? http_response_code(200) : 
            http_response_code(500); 
                    
            if($update){
                header("Location: ../../index.php?page=users");
            }
                    
        }catch(PDOException $e) { 
            http_response_code(500); 
        }
    }
    elseif(!empty($status)){

        $statusInt=intval($status);
        $userIdInt=intval($userId);

        if($statusInt==1){

            $query2="UPDATE user SET u_status=1 WHERE id_user=$userIdInt";

            try { 
                $update=$conn->query($query2)->rowCount() > 0 ? http_response_code(200) : 
                http_response_code(500); 

                if($update){
                    header("Location: ../../index.php?page=users");
                }
            }catch(PDOException $e) { 
                http_response_code(500); 
            }
        }
        else{

            $query2="UPDATE user SET u_status=0 WHERE id_user=$userIdInt";

            try { 
                $update=$conn->query($query2)->rowCount() > 0 ? http_response_code(200) : 
                http_response_code(500); 

                if($update){
                    header("Location: ../../index.php?page=users");
                }
            }catch(PDOException $e) { 
                http_response_code(500); 
            }
        }
    }
}
?>