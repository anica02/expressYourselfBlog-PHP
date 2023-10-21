<?php

function logIn($email,$pass){
    global $conn;
    $query="SELECT * FROM user as u JOIN role as r ON u.id_role=r.id_role WHERE email=:email AND user_passwd=:user_passwd AND u_status=1";

    $stmt=$conn->prepare($query);
    $stmt->bindParam(':email',$email);
    $stmt->bindParam(':user_passwd',$pass);
    $stmt->execute();

    if($stmt->rowCount()==1){
        return $stmt->fetch();
    }
    else{
        return false;
    }

}

function signUp($fName,$lName,$email,$pass,$randN,$username){
    global $conn;
    $role=2;
    $status=1;

    $query="INSERT INTO user(id_role, user_first_name, user_last_name, username, email, user_passwd, u_status, rand_passwd) VALUES(:id_role,  :user_first_name, :user_last_name, :username, :email, :user_passwd, :u_status, :rand_passwd)";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id_role', $role);
    $stmt->bindParam(':user_first_name', $fName);
    $stmt->bindParam(':user_last_name', $lName);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':user_passwd', $pass);
    $stmt->bindParam(':u_status', $status);
    $stmt->bindParam(':rand_passwd', $randN);
    $stmt->execute();

    if($stmt->rowCount()==1){
        return true;
    }
    else{
        return false;
    }
}

function logPage(){

    $visitedPage = $_SERVER['REQUEST_URI'];
    $date = date("d/m/Y");
    $time= date("H:i:s");
    $ip = $_SERVER['REMOTE_ADDR'];
    $user = "unauthorized";

    if(isset($_SESSION['user'])){
        $user = $_SESSION['user']->email;
    }

    $content = $visitedPage."\t".$user."\t".$date ."\t". $time."\t".$ip."\n";

    $file = fopen(LOG_FAJL, "a");
    $write = fwrite($file, $content);
    if($write){
        fclose($file);
    }
}

function logPageLogin($account){

    $date=date("d/m/Y");
    $time=date("H:i:s");
    $userEmail=$account;

    $content =$date."\t".$time."\t".$userEmail."\n";

    $file = fopen(LOG_FAJL_ACCOUNT, "a");
    $write = fwrite($file, $content);
    if($write){
        fclose($file);
    }
}

function logPageLoginSuccessful($account){

    $date=date("d/m/Y");
    $time=date("H:i:s");
    $userEmail=$account;

    $content =$date."\t".$time."\t".$userEmail."\n";

    $file = fopen(LOG_FAJL_ACCOUNT_SUCCESSFUL, "a");
    $write = fwrite($file, $content);
    if($write){
        fclose($file);
    }
}

function logInLocked($email){

    $file = fopen(LOG_FAJL_ACCOUNT, "r");
    $contentFile = fread($file, filesize(LOG_FAJL_ACCOUNT));

    fclose($file);

    $contentFile = trim($contentFile);
    $array = explode("\n", $contentFile);
    $number=0;

    for($i=0; $i < count($array); $i++){
        list($date, $time, $account) = explode("\t", $array[$i]);

        $dateNow=date("d/m/Y");

        $timeNow=time();
        $dateTimeSec=strtotime($time);
        $rez=$timeNow-$dateTimeSec;

        if($dateNow == $date){

            if($rez <= 300){

                if($email==$account){
                    $number++;
                }
                else{
                   $number=0;
                }

                if($number >= 3){
                    accountLock($account);
                    return true;
                }
            }

        }
        else{
            return false;
        }
    }
}

function numberOfLogins(){

    $file = fopen(LOG_FAJL_ACCOUNT_SUCCESSFUL, "r");
    $contentFile = fread($file, filesize(LOG_FAJL_ACCOUNT_SUCCESSFUL));

    fclose($file);

    $contentFile = trim($contentFile);
    $array = explode("\n", $contentFile);
    $number=0;

    for($i=0; $i < count($array); $i++){
        list($date, $time, $user) = explode("\t", $array[$i]);

        $dateNow=date("d/m/Y");
        
        if($dateNow==$date){
           $number++;
        }
        else{
            $number=0;
        }
       
    }
    
    return $number;
}

function viewedPages(){

    $file = fopen(LOG_FAJL, "r");
    $contentFile = fread($file, filesize(LOG_FAJL));

    fclose($file);

    $contentFile = trim($contentFile);
    $array = explode("\n", $contentFile);
    $number=0;
    $pages=array();


    for($i=0; $i < count($array); $i++){

        list($page, $user, $date,$time, $ip) = explode("\t", $array[$i]);

        $dateNow=date("d/m/Y");
        $timeNow=time();
        $dateTimeSec=strtotime($time);
        $pastdate = strtotime("-1 day");

        if ($dateNow==$date || $pastdate==$date){
            $rez=$timeNow-$dateTimeSec;
            
            if($rez <= 86400){
                $number++;
    
                 if(array_key_exists($page, $pages)){
                    $pages[$page] += 1;
                   
                 }
                 else{
                    $pages[$page] = 1;
                 }
            }
            
        }
    }

    $html="";

    foreach($pages as $key=>$value){

        $html.='<tr><td>'; 
        $html.=substr($key, strpos($key , "=")+1);
        $html.='</td><td>';
        $html.=round($value*100/$number, 0);
        $html.='%</td>';
        
    }
   echo $html;
    
}

function accountLock($userEmail){
    global $conn;
    $query="UPDATE user SET u_status=0 WHERE email='$userEmail'";

    if($conn->query($query) === TRUE){
        return true;
    }
    else{
        return false;
    }

}

function sendEmail($emailU){
    $message="Your account has been locked due to multiple login attempts, contact an admin of the website for help";
    $emailUser = $emailU;
    $to = "$emailUser";

    // definisanje naslova mail-a
    $subject = "Locked account";

    // definisanje posiljaoca mail-a
    $from = "php@gmail.com";
    $bcc = "mika.mikic@gmail.com";
    $headers = "From: $from";
    $headers .= "To: ".$to."\n";
    $headers .= 'Content-type: text/html; charset=UTF-8'. "\r\n";
    $headers .= "Bcc: $bcc\r\n";

    mail($to,$subject,$message,$headers);
}

function insertMsg($name,$email,$msg,$date){

    global $conn;

    $query="INSERT INTO message(id_msg,u_name,u_email,u_msg,create_date) VALUES(NULL,'$name','$email','$msg','$date')";

    if($conn->query($query) === TRUE){
        return true;
    }
    else{
        return false;
    }

}

function insertMsgRec($recId,$msgId){

    global $conn;

    $query="INSERT INTO message_recipient(id_message_r,id_recipient,id_message) VALUES(NULL,$recId,$msgId)";

    if($conn->query($query) === TRUE){
        return true;
    }
    else{
        return false;
    }

}

function updateUser($randN){
    global $conn;
    $query="UPDATE user SET u_status=1 WHERE rand_passwd=$randN";

    if($conn->query($query) === TRUE){
        return true;
    }
    else{
        return false;
    }
}

function signValues($session,$name){
    if(isset($_SESSION[$session][$name])){

        echo $_SESSION[$session][$name];
        unset($_SESSION[$session][$name]);
    }
    else{
        echo "";
    }
}

function tags(){
    global $conn;
    $query="SELECT tag_name FROM tag";
    return $conn->query($query)->fetchAll();
}

function getTagsId($name){
    global $conn;
    $query="SELECT id_tag FROM tag WHERE tag_name='$name'";
    return $conn->query($query)->fetch();
}

function dates(){
    global $conn;
    $query="SELECT DISTINCT post_date FROM post";
    return $conn->query($query)->fetchAll();
}

function error($session,$name){
    if(isset($_SESSION[$session][$name])){
        echo "<div class=' fontS alert alert-danger '>".$_SESSION[$session][$name]."</div>";
        unset($_SESSION[$session][$name]);
    }
    else{
       echo "";
    }
}

function insertPost($title,$desc,$date,$imgAlt,$imgSrc,$imgName,$userId){
    global $conn;
    $query="INSERT INTO post(id_post,title,desPost,img_src,img_src_original,img_alt,post_date,id_user,likes) VALUES(NULL,'$title','$desc','$imgSrc','$imgName','$imgAlt','$date',$userId, 0)";

    if($conn->query($query) === TRUE){
        return true;
    }
    else{
        return false;
    }
}

function updatePost($title,$desc,$postId){
    global $conn;
    $query="UPDATE post SET title='$title', desPost='$desc' WHERE id_post=$postId";

    if($conn->query($query) === TRUE){
        return true;
    }
    else{
        return false;
    }
}

function insertPostTag($idTag,$idPost){
    global $conn;
    $query="INSERT INTO post_tag(id_post_tag,id_post,id_tag) VALUES(NULL,$idPost,$idTag)";

    if($conn->query($query) === TRUE){
        return true;
    }
    else{
        return false;
    }
}

function getUsername($username){
    global $conn;
    $query="SELECT username FROM user WHERE username='$username'";
    $user=$conn->query($query);

    if($user->rowCount()==1){
        return true;
    }
    else{
        return false;
    }
}

function getEmail($email){
    global $conn;
    $query="SELECT email FROM user WHERE email='$email'";
    $user=$conn->query($query);

    if($user->rowCount()==1){
        return true;
    }
    else{
        return false;
    }
}

function lastPost(){
    global $conn;
    $query="SELECT id_post FROM post ORDER BY id_post DESC LIMIT 0,1";
    $post=$conn->query($query)->fetch();
    return $post->id_post;
}

function lastMessage(){
    global $conn;
    $query="SELECT id_msg FROM message ORDER BY id_msg DESC LIMIT 0,1";
    $msg=$conn->query($query)->fetch();
    return $msg->id_msg;
}

function isPostLiked($post,$user){
    global $conn;
    $query="SELECT liked FROM user_post_liked  WHERE id_post=$post AND id_user=$user";
    $like=$conn->query($query)->fetch();
    return $like;
}

function userLikedPosts(){
    global $conn;
    $query="SELECT * FROM user_post_liked";
    return $conn->query($query)->fetchAll();
}

function postId($where,$what){
    global $conn;
    $query="SELECT id_post AS id FROM post  WHERE $where='$what'";
    $id=$conn->query($query)->fetch();
    return $id->id;
}



function getUsersPosts($idUser){
    global $conn;
    $query="SELECT * FROM post p INNER JOIN user u ON p.id_user=u.id_user  WHERE p.id_user=$idUser";
    return $conn->query($query)->fetchAll();
}

function getPostsDescU($idUser){
    global $conn;
    $query="SELECT * FROM post p INNER JOIN user u ON p.id_user=u.id_user   WHERE p.id_user=$idUser ORDER BY p.id_post DESC";
    return $conn->query($query)->fetchAll();
}

function getPostsUserDate($idUser){
    global $conn;
    $query="SELECT post_date FROM post p INNER JOIN user u ON p.id_user=u.id_user  WHERE p.id_user=$idUser";
    return $conn->query($query)->fetchAll();
}

function getPostWithTagNameU($tagName,$idUser){
    global $conn;
    $query="SELECT * FROM post p INNER JOIN post_tag pt ON p.id_post=pt.id_post INNER JOIN tag t ON pt.id_tag=t.id_tag INNER JOIN user u ON p.id_user=u.id_user  WHERE p.id_user=$idUser AND tag_name='$tagName'";
    return $conn->query($query)->fetchAll();
}

function postsByDateU($dateP,$idUser){
    global $conn;
    $query="SELECT * FROM post p INNER JOIN user u ON p.id_user=u.id_user  WHERE p.id_user=$idUser AND post_date='$dateP'";
    return $conn->query($query)->fetchAll();
}

function postsByTitleU($pTitle,$idUser){
    global $conn;
    $query="SELECT * FROM post p INNER JOIN user u ON p.id_user=u.id_user  WHERE p.id_user=$idUser AND title='$pTitle'";
    return $conn->query($query)->fetchAll();
}

function getPosts(){
    global $conn;
    $query="SELECT  * FROM post p INNER JOIN user u ON p.id_user=u.id_user";
    return $conn->query($query)->fetchAll();
}

function getPostsDesc(){
    global $conn;
    $query="SELECT * FROM post p INNER JOIN user u ON p.id_user=u.id_user  ORDER BY id_post DESC";
    return $conn->query($query)->fetchAll();
}

function getPostWithTagName($tagName){
    global $conn;
    $query="SELECT DISTINCT * FROM post p INNER JOIN post_tag pt ON p.id_post=pt.id_post INNER JOIN tag t ON pt.id_tag=t.id_tag INNER JOIN user u ON p.id_user=u.id_user WHERE tag_name='$tagName'";
    return $conn->query($query)->fetchAll();
}

function postsByDate($dateP){
    global $conn;
    $query="SELECT * FROM post p INNER JOIN user u ON p.id_user=u.id_user WHERE post_date='$dateP'";
    return $conn->query($query)->fetchAll();
}

function postsByTitle($pTitle){
    global $conn;
    $query="SELECT * FROM post p INNER JOIN user u ON p.id_user=u.id_user  WHERE title='$pTitle'";
    return  $conn->query($query)->fetchAll();
}

function getNavIndidivual(){
    global $conn;
    $query="SELECT nav_text,nav_href FROM nav WHERE id_role=3";
    return $conn->query($query)->fetchAll();
}

function getNavUser(){
    global $conn;
    $query="SELECT nav_text,nav_href FROM nav WHERE id_role IN (2,3) AND nav_text NOT IN ('Users')";
    return $conn->query($query)->fetchAll();
}

function getNavAdmin(){
    global $conn;
    $query="SELECT nav_text,nav_href FROM nav WHERE id_role IN (2,3,1)";
    return $conn->query($query)->fetchAll();
}

function convertDate($date){
    $dateFormat=date("d M Y", strtotime($date->post_date));
    return $dateFormat;
}

function convertDateArray($date){
    foreach($date as $d){
    $dateFormat=date("d M Y", strtotime($d->post_date));
    return $dateFormat;
    }
}

function postsShow($array,$idU){

    foreach($array as $post){
    ?>
        <div class="col-xs-12 m-bottom-40">
            <div class="blog wow zoomIn" data-wow-duration="1s" data-wow-delay="0.7s">
                <div class="blog-media">
                    <?php
                    $idU=(string)$idU;
                    $likedPost=isPostLiked($post->id_post,$idU);

                    if($likedPost==true){
                        $like="<i class='fas fa-heart like liked' data-id="; $like.=$post->id_post; $like.=" data-value="; $like.=$idU; $like.="></i>";
                    }
                    else{
                        $like="<i class='fas fa-heart like' data-id="; $like.=$post->id_post; $like.=" data-value="; $like.=$idU; $like.="></i>";
                    }

                    if($post->img_src==NULL){
                        echo $like;
                    }
                    else{
                        echo $like;
                    ?>
                    <img src="assets/<?=$post->img_src?>" alt="<?=$post->img_alt?>">
                      <?php }?>
                </div><!--post media-->

                <div class="blog-post-info clearfix">
                    <span class="time fL"><i class="fa fa-calendar"></i><?php
                        $date=$post->post_date;
                        $dateFormat=date("d M Y", strtotime($date));
                        echo $dateFormat;
                    ?></span>
                    <span class="comments ml-10"><i class="fas fa-user"> </i><?=$post->username?></span>
                    <span class="comments  ml-10"><i class="fas fa-heart numL" ></i><span class="likedN">
                    <?php
                        if($post->likes == 0){
                            echo 0;
                        }
                        else{
                            echo $post->likes;
                        }
                     ?></span></span>
                    <span class='comments'><i class='fa fa-comments'></i>
                    <?php
                        $commentC=commentCount($post->id_post);
                            echo $commentC." comments";
                        ?>
                    </span>
                </div><!--post info-->

                <div class="blog-post-body">
                    <h4><?=$post->title?></h4>
                    <p class="p-bottom-20"><?php

                    $des="";
                    if(strlen($post->desPost)<=110){
                        $des=$post->desPost;
                    }
                    else{
                        $des=substr($post->desPost,0,110)."...";
                    }
                    echo $des;
                    ?></p>

                    <a href="#" class="read-more" data-id="<?=$post->id_post?>">Read More >></a>
                    <?php
                     if($idU==1){
                    ?>
                    <input type="button" class="btn btn-main btn-theme f-r btnDeleteP" data-id="<?=$post->id_post?>"  value="Delete post"/>
                    <?php
                    }
                    else {
                        echo "";
                    }
                    ?>
                </div><!--post body-->
            </div> <!-- /.blog -->
        </div>
<?php }
}

function postsEdit($array){

    foreach($array as $post){
    ?>
        <div class="col-xs-12 m-bottom-40">
            <div class="blog wow zoomIn" data-wow-duration="1s" data-wow-delay="0.7s">
                <div class="blog-media">
                    <?php
                    if($post->img_src==NULL){
                        echo "";
                    }
                    else{
                    ?>
                    <img src="assets/<?=$post->img_src?>" alt="<?=$post->img_alt?>">
                    <?php }?>
                </div><!--post media-->
                <div class="blog-post-info clearfix">
                    <span class="time fL"><i class="fa fa-calendar"></i><?php
                        $date=$post->post_date;
                        $dateFormat=date("d M Y", strtotime($date));
                        echo $dateFormat;
                    ?></span>
                    <span class="comments ml-10" ><i class="fas fa-user"> </i><?=$post->username?></span>
                    <span class="comments  ml-10"><i class="fas fa-heart numL" ></i><span class="likedN">
                        <?php
                        if($post->likes == 0){
                            echo 0;
                        }
                        else{
                            echo $post->likes;
                        }
                        ?>
                        </span></span>
                        <span class='comments'><i class='fa fa-comments'></i>
                        <?php
                        $commentC=commentCount($post->id_post);
                            echo $commentC." comments";
                        ?>
                    </span>
                </div><!--post info-->

                <div class="blog-post-body">
                    <h4><?=$post->title?></h4>
                    <p class="p-bottom-20"><?php
                    $des="";

                    if(strlen($post->desPost)<=110){
                        $des=$post->desPost;
                    }
                    else{
                        $des=substr($post->desPost,0,110)."...";
                    }
                    echo $des;
                    ?></p>

                       <a href="#" class="read-more" data-id="<?=$post->id_post?>">Read More >></a>
                       <span class="f-r">

                       <input type="button" class="btn btn-main btn-theme btnEditP" data-id="<?=$post->id_post?>" data-class="<?=$post->img_src?>"  value="Edit post"/>
                       <input type="button" class="btn btn-main btn-theme mar-l-2 btnDeleteP" data-id="<?=$post->id_post?>"  value="Delete post"/>
                       </span>

                </div><!--post body-->
            </div> <!-- /.blog -->
        </div>
<?php }
}

function postById($id){
    global $conn;
    $query="SELECT * FROM post p INNER JOIN user u ON p.id_user=u.id_user WHERE id_post=$id";
    return $conn->query($query)->fetch();
}

function getTagsPost($post){
    global $conn;
    $query="SELECT tag_name FROM tag t INNER JOIN post_tag pt ON t.id_tag=pt.id_tag WHERE id_post=$post";
    return $conn->query($query)->fetchAll();
}

function commentCount($postId){
    global $conn;
    $query="SELECT COUNT(id_comment) as comNum FROM comment WHERE id_post=$postId";
    $com=$conn->query($query)->fetch();
    return $com->comNum;
}
function allComents(){
    global $conn;
    $query="SELECT * FROM comment";
    return $conn->query($query)->fetchAll();
}

function commentsMain($post){
    global $conn;
    $query="SELECT * FROM comment c INNER JOIN user u ON c.id_user=u.id_user WHERE id_post=$post";
    return $conn->query($query)->fetchAll();
}


function insertMainComm($postId,$userId,$comm){
    global $conn;
    $query="INSERT INTO comment (id_post,id_user,comment) VALUES ($postId,$userId,'$comm')";

    if($conn->query($query) === TRUE){
        return true;
    }
    else{
        return false;
    }
}



function singlePost($post,$userRole){
    ?>
        <div class='postSingle'>
            <div class='postMedia'>
                <img alt='<?=$post->img_src?>' src='assets/<?=$post->img_src_original?>'>
            </div><!--Post image-->
            <div class='postMeta clearfix'>
                <div class='postMeta-info'>
                    <span class='metaAuthor'><i class='fa fa-user'></i><?=$post->username?></span>
                    <span class='metaComment'><i class='fa fa-comments'></i>
                        <?php
                        $commentC=commentCount($post->id_post);
                            echo $commentC." comments";
                        ?>
                    </span>
                    <span class="metaComment"><i class="fas fa-heart" ></i><span class="likedN">
                            <?php
                            if($post->likes == 0){
                                echo 0;
                            }
                            else{
                                echo $post->likes;
                            }
                            ?>
                        </span></span>
                </div>
                <div class='postMeta-date'>
                    <span class='metaDate'><i class='fa fa-calendar'></i> <?php
                         $date=$post->post_date;
                         $dateFormat=date("d M Y", strtotime($date));
                        echo $dateFormat;
                    ?></span>
                </div>
            </div><!--Post meta-->

            <div class='postTitle'>
                <h1><?=$post->title?></h1>
                <div class='divider-small'></div>
            </div> <!--Post title-->
            <p><?=$post->desPost?></p>
            <div class='postTags clearfix'>
                <h4><i class='fa fa-tags'></i>Tags :</h4>
                <ul class='list-inline'>
                    <?php
                    $tagName=getTagsPost($post->id_post);
                    foreach($tagName as $tg){
                    ?>
                     <li><a href='#'><?=$tg->tag_name?></a></li>
                    <?php
                    }?>
                </ul>
            </div>
        </div>

        <!--Comments-->
        <div class="comments m-top-60">
            <h4><?php
            $commentC=commentCount($post->id_post);
            echo $commentC. " comments";
            ?></h4>

            <!--Entries container-->
            <div class="entriesContainer">
                <!--Comments and replys-->

                <ul class="comments-list clearfix">
                <?php
                $mainCom=commentsMain($post->id_post);
                foreach($mainCom as $comm):
                ?>

                <li class="margin-bottom">
                    <div class="comment">
                        <div class="img">
                            <i class="fa fa-user"></i>
                        </div>
                        <div class="commentContent">
                            <div class="commentsInfo">
                                <div class="author"><?=$comm->username?></div>
                                <!-- <div class="date"><a href="#">January 19, 2017 at 12 am</a></div> -->
                            </div>
                            <p class="expert"><?=$comm->comment?></p>
                        </div>

                        <div class="reply-btn">
                            
                            <?php 
                            $bin="<i class='fas fa-trash-alt commDel' data-id="; $bin.=$comm->id_comment; $bin.="></i>";
                            if($userRole==1){
                                echo $bin;
                            }
                            else{
                                echo "";
                            }
                            ?>
                           
                        </div>
                    </div>
                </li>
                    
                <?php
                endforeach;
                ?>

                </ul> <!--End comments and replys-->

            </div><!--End  entries container -->

        </div><!--End comments-->

        <div class="respond m-top-60">
            <h4 class="m-bottom-20">Leave a comment</h4>

            <!--Reply form-->
            <div class="replyForm">
                <form method="post" action="models/form_check/formComment.php">
                    <input type="hidden" name="commId" id="commId"/>
                    <textarea  placeholder="Message *" name="message" id="message" cols="45" rows="10"></textarea>
                    <input type="submit" class="btn btn-main m-bottom-40 "  name="btnComment" value="Post Comment">
                </form>

                <!--Reply form message-->
                <?php
                if(isset($_SESSION['sucessCom'])){
                    $succ="<div id='success'><h2>".$_SESSION['successCom']."</h2></div>";
                    echo $succ;
                }
                elseif(isset($_SESSION['errorCom'])){
                    $err="<div id='error'><h2>".$_SESSION['errorCom']."</h2></div>";
                    echo $err;
                }
                else{
                    echo "";
                }
                ?>
                <!--End reply form message-->
            </div><!--End reply form-->
        </div><!--End respond-->
<?php
}



function showUsers(){

    $users=getUsersLimit();
    
    $show="<table class='table table-striped'> ";
    $show.="<thead><tr><th scope='col'>Id role</th><th scope='col'>First Name</th><th scope='col'>Last Name</th><th scope='col'>Email</th><th scope='col'>Status</th>
    <th scope='col'></th><th scope='col'></th></tr></thead><tbody>";

    foreach($users as $u){

        $show.="<tr  scope='row'>"; $show.="<td>"; $show.=$u->id_role; $show.="</td>";
        $show.="<td>"; $show.=$u->user_first_name; $show.="</td>";
        $show.="<td>"; $show.=$u->user_last_name; $show.="</td>";
        $show.="<td>"; $show.=$u->email; $show.="</td>";
        $show.="<td>"; $show.=$u->u_status; $show.="</td>";
        $show.="<td>";
        $show.='<input type="button" class="btn btn-main btn-theme btnDeleteUser" data-id='; $show.=$u->id_user; $show.=' value="Delete user"/>';
        $show.="</td>";
        $show.="<td>";
        $show.='<input type="button" class="btn btn-main btn-theme btnEditUser"  data-id='; $show.=$u->id_user; $show.=' value="Edit user"/>';
        $show.="</td>";
        $show.="</tr>";
        $show.="<tr><td colspan='7'>";
        $show.='<div class="dataUser">
        <h6>Things you as admin can change</h6>
        <form action="models/form_check/ajax.php" method="post" name="formEditUser">
         <input type="hidden" name="idUser" id="hiddenU" value=""/>
            <p id="userId" name="idUser"></p>
            <lable>Role:</lable></br>
            </br>
                 <select name="role" id="role" class="form-control">
                     <option value="">Choose users role</option>
                     <option value="1">Admin</option>
                     <option value="2">User</option>
                     <option value="3">Other</option>
                 </select></br>
             <lable>Status:</lable></br></br>
                 <select name="status" id="status"class="form-control">
                     <option value="">Choose users account status</option>
                     <option value="1">Active</option>
                     <option value="2">Passive</option>
                 </select></br></br>

             <input type="submit" name="btnUsersData" value="Edit" class="btn btn-main btn-theme"/>
        </form>
     </div>';
        $show.="</tr>";
    }

    $show.="</tbody></table>";
    echo $show;

}

function getUsersMsg($userId){
    global $conn;
    $query="SELECT * FROM message m INNER JOIN message_recipient mr ON m.id_msg=mr.id_message WHERE id_recipient=$userId";
    return $conn->query($query)->fetchAll();
}

function showUMsg($userId){

    $users=getMessagesLimit(0,$userId);

    if($users){

        $show="<table class='table'> ";
        $show.="<thead><tr><th scope='col'>User name</th><th scope='col'>User email</th><th scope='col'>Message</th><th scope='col'>Date</th></tr></thead><tbody>";
    
        foreach($users as $u){

            $show.="<tr  scope='row'>";
            $show.="<td>"; $show.=$u->u_name; $show.="</td>";
            $show.="<td>"; $show.=$u->u_email; $show.="</td>";
            $show.="<td>";
            $msgSub="";
            if(strlen($u->u_msg)<=10){
                $msgSub=$u->u_msg;
            }
            else{
                $msgSub=substr($u->u_msg,0,7)."...";
            }


        $show.=$msgSub;

        $show.="</td>";

        $show.="<td>"; $show.=$u->create_date; $show.="</td>";

        $show.="<td>";
        $show.='<input type="button" class="btn btn-main btn-theme btnMessageView" value="View"/>';
        $show.="</td>";

        $show.="<td>";
        $show.='<input type="button" class="btn btn-main btn-theme btnDeleteMsg" data-id='; $show.=$u->id_msg; $show.=' value="Delete message"/>';
        $show.="</td>";

        $show.="<td>";
        $show.='<input type="button" class="btn btn-main btn-theme  btnResponseMsg" data-id='; $show.=$u->id_msg; $show.=' data-uname='; $show.=$u->u_email; $show.=' value="Responde"/>';
        $show.="</td>";

        $show.="</tr>";

        $show.="<tr><td colspan='7'>";
        $show.='<div class="col-md-12 dataUser">
            <h6>Send a reply</h6>
            <form action="models/form_check/ajax.php" method="post" name="formMessageReply">
            <input type="hidden" name="email" id="hiddenM" value=""/>
                <div id="userEmail" name="userEmail"></div>
                </br>
                <div class="col-sm-12 contact-form-item ">
                <textarea name="message" id="message" placeholder="Your Message"></textarea>
                </div>
                <input type="submit" name="btnMssReply" value="Reply" class="btn btn-main btn-theme"/>
            </form>
            </div>';
        $show.="</td></tr>";


        $show.="<tr><td colspan='7'>";
        $show.='<div class="col-md-12 dataUser">
                    <div class="col-sm-12 contact-form-item">
                    <textarea name="message" id="userMsg" placeholder="Your Message">'; $show.=$u->u_msg; $show.='</textarea>
                    </div>
                </div>';
        $show.="</td></tr>";
    }
        $show.="</tbody></table>";
       
        return $show;
    }
    else{
       echo "<div class='alert alert-danger text-center'>You have no messages</div>";
       return false;
    }
}

function getUsers(){
    global $conn;
    $query="SELECT id_user,username, user_first_name,user_last_name, name AS role_name FROM user u INNER JOIN role r WHERE u.id_role=r.id_role";
    return $conn->query($query)->fetchAll();
}

function getUserId($email){
    global $conn;
    $query="SELECT id_user FROM user WHERE email='$email'";
    return $conn->query($query)->fetch();
}


define("POST_OFFSET", 4);

function getUsersLimit($limit=0){

    global $conn;
   
    $query = "SELECT * FROM user LIMIT :limit, :offset";
    $select = $conn->prepare($query);

    $limit = ((int) $limit) * POST_OFFSET;
    $select->bindParam(":limit", $limit, PDO::PARAM_INT);

    $offset = POST_OFFSET;
    $select->bindParam(":offset", $offset, PDO::PARAM_INT);

    $select->execute();
    $result = $select->fetchAll();
    return $result;

}

function getMessagesLimit($limit=0,$userId){

    global $conn;

    $query="SELECT * FROM message m INNER JOIN message_recipient mr ON m.id_msg=mr.id_message WHERE id_recipient=$userId ORDER BY id_msg DESC LIMIT :limit, :offset";

    $select = $conn->prepare($query);

    $limit = ((int) $limit) * POST_OFFSET;
    $select->bindParam(":limit", $limit, PDO::PARAM_INT);


    $offset = POST_OFFSET;
    $select->bindParam(":offset", $offset, PDO::PARAM_INT);

    $select->execute();
    $result = $select->fetchAll();
    return $result;

}

function getNumberOfUsers(){
    global $conn;
    $query = "SELECT COUNT(*) as number FROM user";
    $number = $conn->query($query)->fetch();
    return $number;
}

function getNumberOfMessages(){
    global $conn;
    $query = "SELECT COUNT(*) as number FROM message";
    $number = $conn->query($query)->fetch();
    return $number;
}


function getNumberOfPages(){
    $numberOfPosts = getNumberOfUsers();
    $numberOfPages = ceil($numberOfPosts->number / POST_OFFSET);
    return $numberOfPages;
}

function getNumberOfPagesM(){
    $numberOfPosts = getNumberOfMessages();
    $numberOfPages = ceil($numberOfPosts->number / POST_OFFSET);
    return $numberOfPages;
}



?>