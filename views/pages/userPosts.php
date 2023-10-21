
<?php 
 
  $_SESSION['page']="userPost";
  if(!isset($_SESSION['user'])){

    http_response_code(404);
    header('Location: index.php?page=login');
  }
  else{?>

  <?php 
   $userId=$_SESSION['user']->id_user;
  ?>
  <body class="blog_index" data-spy="scroll" data-target=".navbar-fixed-top" data-offset="100">
    <!-- Preloader -->
    <div id="preloader">
        <div id="spinner"></div>
    </div>
    <!-- End Preloader-->
        <div class="section-title-bg text-center m-bottom-40 ">
            <h2 class="wow fadeInDown no-margin" data-wow-duration="1s" data-wow-delay="0.6s"><strong>My posts</strong></h2>
            <div class="divider-center-small wow zoomIn" data-wow-duration="1s" data-wow-delay="0.6s"></div>
            <p class="section-subtitle wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s">Section where you can edit your posts</p>
        </div>

        <div class="col-12 text-center">
            <?php 
            if(isset($_SESSION['successPost'])){
                echo "<div class='alert alert-success'>".$_SESSION['successPost']."</div>";
                unset($_SESSION['successPost']);
            }
            else{
                echo "";
            }
                
            ?>
        </div>

        <section class="blog-index">
            <!--Container-->
            <div class="container clearfix">
                <div class="row">

                    <div class="col-sm-4 sidebar" id="filter">
                        <!-- Widget 1 -->
                        <div class="widget">
                            <h4>Posts by title</h4>
                            <form  class="search-form">
                                <input type="text" placeholder="Search" name="postTitleS" id="postTitleS">
                                <input type="button" class="submit-search" value="Ok" name="btnTitleP" id="btnTitleP">
                            </form>
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
                                $postDate=getPostsUserDate($userId);
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

                    <div class="col-sm-8">
                        <div class="row" id="posts">
                        <?php 
                            $allPosts=getUsersPosts($userId);
                            if(!$allPosts){
                                echo "<div class='alert alert-danger text-center'>You haven't uploaded any posts yet</div>";
                            }
                            else{
                                postsEdit($allPosts);
                            }
                        ?>
                        </div> <!-- /.inner-row -->
                    </div> <!-- /.col -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section><!--End blog single section-->
  </body>
<?php } ?>