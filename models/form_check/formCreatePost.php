<?php 

    session_start();
    include "../../config/connection.php";
    include "../functions/function.php";

    if(isset($_POST['btnUpload'])){

        $title=$_POST['postTitle'];
        $desc=trim($_POST['postDes']);

        $tagName1="";
        $tagName2="";
        $tagName3="";
        $tagName4="";
        $tagName5="";
        $tagName6="";
        $tagId=[];

        if(isset($_POST['1'])){
            $tagName1=$_POST['1'];
            $tag=getTagsId($tagName1);

            foreach($tag as $t){
                array_push($tagId,$t);
            }
        }
        if(isset($_POST['2'])){
            $tagName2=$_POST['2'];
            $tag=getTagsId($tagName2);

            foreach($tag as $t){
                array_push($tagId,$t);
            }
        }
        if(isset($_POST['3'])){
            $tagName3=$_POST['3'];
            $tag=getTagsId($tagName3);

            foreach($tag as $t){
                array_push($tagId,$t);
            }
        }
        if(isset($_POST['4'])){
            $tagName4=$_POST['4'];
            $tag=getTagsId($tagName4);

            foreach($tag as $t){
                array_push($tagId,$t);
            }
        }
        if(isset($_POST['5'])){
            $tagName5=$_POST['5'];
            $tag=getTagsId($tagName5);

            foreach($tag as $t){
                array_push($tagId,$t);
            }
        }
        if(isset($_POST['6'])){
            $tagName6=$_POST['6'];
            $tag=getTagsId($tagName6);

            foreach($tag as $t){
                array_push($tagId,$t);
            }
        }
       
        $postDate=gmdate("Y-m-d");
        $userId=$_SESSION['user']->id_user;
        $imgDb="";
        $imgPathDb="";
        $errors=[];
        $data=[];

        $regTitle="/^[A-ZĆČĐŽŠ]{1}[a-zćčđžš0-9]{2,15}(\s[A-ZČĆĐŽŠa-zčćšđžš0-9)]{1,15})*$/";

        if(!$title){
            $errors['postTitle']="Title must be filed in";
        }
        elseif(!preg_match($regTitle,$title)){
            $errors['postTitle']="Title has to start with one uppercase letter and length has to be at least 3 characters"; 
        }
        else{
            $data['postTitle']=$title;
        }

        if(!$desc){
            $errors['postDes']="Description must be filed in";
        }
        else{
            $data['postDes']=$desc;
        }

        if(empty($tagId)){
            $errors['tagPost']="You need to choose a tag for your post";
        }
        else{
            $_SESSION['tagsId']=$tagId;
            $data['tagPost']=$tagId;
        }

        
       if(is_uploaded_file($_FILES['postImg']['tmp_name'])){

            $img = $_FILES["postImg"];
            $imgFileName=$_FILES['postImg']['name'];
            $tmpName = $img['tmp_name'];
            $imgName = time()."_".$img['name'];
            $imgPath = "../../assets/img/blog/$imgName";
            $imgOriginal="img/blog/$imgName";
           
            $fileType=strtolower(pathinfo($imgFileName,PATHINFO_EXTENSION));
            $err=0;

            if($fileType !="jpg" && $fileType !="png" && $fileType !="jpeg"){
               $err=1;
               $errors['postImg']="Image extension must be png or jpg";
            }

            if($err == 0){

                move_uploaded_file($tmpName,$imgPath);
                $dimen=getimagesize($imgPath);

                $imgWidth=$dimen[0];
                $imgHeight=$dimen[1];

                $newW=640;
                $newH=426;

                $imgExt=pathinfo($imgPath,PATHINFO_EXTENSION);
                $canvas = imagecreatetruecolor($newW, $newH);
           
                $upload=($imgExt=="png") ? imagecreatefrompng($imgPath) : imagecreatefromjpeg($imgPath);

                imagecopyresampled($canvas, $upload, 0, 0, 0, 0, $newW, $newH, $imgWidth, $imgHeight);   
                $imgDb = ($imgExt == "png") ? imagepng($canvas, "../../assets/img/blog/blog_img_".time().".png") : imagejpeg($canvas, "../../assets/img/blog/blog_img_".time().".jpg");
                if($imgExt == "png"){
                    $imgPathDb="img/blog/blog_img_".time().".png";
                }
                else{
                    $imgPathDb="img/blog/blog_img_".time().".jpg";
                }
            
                if(!$imgDb){
                    
                    $errors['postImg']="Something went wrong while adding post imagYou have ";
                }
            }
        }
       
       if(count($errors)!=0){

            $_SESSION['errorsPost'] = $errors;
            $_SESSION['dataPost']=$data;
            header('Location: ../../index.php?page=createPost');
       }

        if(count($errors)==0){

            try{

                $message = "";
                $status = 201; 
                
                $insertPost=insertPost($title,$desc,$postDate,$title,$imgPathDb,$imgOriginal,$userId);
                $idPost=lastPost();

                foreach($tagId as $t){
                    insertPostTag($t,$idPost);
                }

                header("Location: ../../index.php?page=userPosts");
                $_SESSION['successPost']="You have uploded your post";
            }
            catch(PDOException $ex){

                header("Location: ../../index.php?page=createPost");
                $message = $ex->getMessage();
                $status = 500; 
                http_response_code($status);
            }
        }
    }
    elseif(isset($_POST['btnEditPost'])){

        $title=$_POST['postTitle'];
        $desc=trim($_POST['postDes']);
        $postId=$_POST['postId'];
        $postId=(int)$postId;
        $errors=[];
        $data=[];

        $regTitle="/^[A-ZĆČĐŽŠ]{1}[a-zćčđžš0-9]{2,15}(\s[A-ZČĆĐŽŠa-zčćšđžš0-9)]{1,15})*$/";

        if(!$title){
            $errors['postTitle']="Title must be filed in";
        }
        else{
            if(!preg_match($regTitle,$title)){
                $errors['postTitle']="Title has to start with one uppercase letter and length has to be at least 3 characters"; 
            }
            else{
                $data['postTitle']=$title;
            }
        }

        if(!$desc){
            $errors['postDes']="Description must be filed in";
        }
        else{
            $data['postDes']=$desc;
        }

        if(count($errors)!=0){
            $_SESSION['errorsPost'] = $errors;
            $_SESSION['dataPost']=$data;
            header('Location: ../../index.php?page=editPost');
        }

        if(count($errors)==0){

            try{
                $message = "";
                $status = 201; 

                $editPost=updatePost($title,$desc,$postId);
            
                header("Location: ../../index.php?page=userPosts");
                $_SESSION['successPost']="You have updated your post";
            }
            catch(PDOException $ex){

                header("Location: ../../index.php?page=editPost");
                $message = $ex->getMessage();
                $status = 500; 
                http_response_code($status);
            }
        }
    }
    else{
        header('Location : ../../index.php?page=createPost');
    }
?>