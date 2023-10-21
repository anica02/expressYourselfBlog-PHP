<?php 
    $_SESSION['page']="user";

    if(!isset($_SESSION['user'])){
        http_response_code(404);
        echo "<b>404 PAGE NOT FOUND</b>";
    }
    else{
    ?>
    <body class="single_post_page" data-spy="scroll" data-target=".navbar-fixed-top" data-offset="100">
        <section class="blog-index">

        <!--Container-->
        <div class="container clearfix">
            <div class="row">
                <div class="col-sm-3 sidebar" id="filter">
                    <!-- Widget 1 -->
                    <?php 
                        $username=$_SESSION['user']->username;
                        $userRole=$_SESSION['user']->id_role;
                        $userId=$_SESSION['user']->id_user;
                    ?>
                    <div class="widget text-center">
                        <?php 
                        if($userRole==1){
                            echo "<h4>ADMIN PROFILE</h4>";
                        }
                        else{
                            echo"<h4>USER PROFILE</h4>";
                        }
                        ?>
                        <img src="assets/img/user.png" alt="profilna_slika" id="userImg"/>
                        <p class="username"><?=$username?></p>
                        <div>
                            <a href="index.php?page=userPosts"><p class="formFont2">My posts</p></a>
                            <a href="index.php?page=createPost"><p class="formFont2">Create post</p></a>
                            <a href="index.php?page=messages"><p class="formFont2">Messages</p></a>
                            <a href="index.php?page=logout"><p class="formFont2">Logout</p></a>
                        </div>
                    </div> <!--End widget-->  
                </div> <!-- /.col -->
           
                <div class="col-sm-6 position ">
                    <div class="row" id="posts">
                    <?php 
                        $allPosts=getPostsDesc();
                        postsShow($allPosts,$userId);
                    ?>
                    </div> <!-- /.inner-row -->
                </div> <!--/.col-->

                <div class="col-sm-3 sidebar">
                    <!-- Widget 1 -->
                    <div class="widget">
                        <h4>Posts by title</h4>
                        <form  class="search-form">
                        <input type="text" placeholder="Search" name="postTitleS" id="postTitleS">
                        <input type="button" class="submit-search" value="Ok" name="btnTitleP" id="btnTitleP">
                    </form>
                    </div>
                    <div class="widget">
                        <a href="#" class="oldPost"><h4>OLDER POSTS</h4></a>
                    </div>
                    
                    <!-- Widget 3 -->
                    <div class="widget">
                        <h4>Popular tags</h4>
                        <ul class="tag-list">
                            <?php 
                            $tagName=tags();
                            foreach($tagName as $tag){
                            ?>
                            <li>
                            <a href="#" data-id="<?=$tag->tag_name?>" class="tagName"><?=$tag->tag_name?></a>   
                            <?php } ?>
                        </ul>
                    </div> <!--End widget-->

                    <!--Widget 4-->
                    <div class="widget">
                        <h4>Archives</h4>
                        <ul class="cat-archives">
                        <?php 
                            $postDate=dates();
                            foreach($postDate as $date){
                            ?>
                            <li><a href="#" data-id="<?=$date->post_date?>" class="postByDate"><?php
                                    $date1=$date->post_date;
                                    $dateFormat1=date("d M Y", strtotime($date1));  
                                    echo $dateFormat1;?>
                            </a></li>
                            <?php } ?> 
                        </ul>
                    </div> <!--End widget-->
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section><!--End blog single section-->
</body>
<?php  }?>