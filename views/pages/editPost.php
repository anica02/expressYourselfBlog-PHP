<?php 
     
    $_SESSION['page']="editPost";
    $post;

    if(!isset($_SESSION['user'])){

        http_response_code(404);
        header('Location: index.php?page=login');
    } 
    else{
   ?>
    <body class="single_post_page" data-spy="scroll" data-target=".navbar-fixed-top" data-offset="100">
        <!-- Preloader -->
        <div id="preloader">
            <div id="spinner"></div>
        </div>
        <!-- End Preloader-->

        <div class="section-title-bg text-center m-bottom-20 ">
            <h2 class="wow fadeInDown no-margin" data-wow-duration="1s" data-wow-delay="0.6s"><strong>Edit your post</strong></h2>
            <div class="divider-center-small wow zoomIn" data-wow-duration="1s" data-wow-delay="0.6s"></div>
        </div>

        <!--BLog single section-->
        <section id="blog-single" class="p-top-80 p-bottom-80">
            <!--Container-->
            <div class="container clearfix ">
               <?php 
                if(isset($_SESSION['postIdEdit'])){
                   $idPost=$_SESSION['postIdEdit'];
                   $post=postById($idPost);
                ?>

                <div class="col-12 form-margin ">
                    <form action="models/form_check/formCreatePost.php" method="post" enctype="multipart/form-data" id="formCP" name="formCP" >
                        <input type="hidden" name="postId" value="<?php 
                        if($post!=""){
                            echo $post->id_post;
                        }
                        ?>"/>
                        <div class="form-group formFont">
                            <input type="text" id="postTitle" name="postTitle"  placeholder="Post title" value="<?php 
                            if($post!=""){
                                echo $post->title;
                            }
                            else{
                                signValues("dataPost","postTitle");
                            }
                            ?>"/>
                            <?=error("errorsPost","postTitle");?>
                        </div>

                        <div class="form-group formFont">
                            <textarea placeholder="Post description" name="postDes" id="postDes"><?php 
                                if($post!=""){
                                echo $post->desPost;
                                }
                                else{
                                signValues("dataPost","postDes");
                                }
                            ?></textarea>
                            <?=error("errorsPost","postDes");?>
                        </div>

                        <div class="col-sm-12 contact-form-item">
                            <input type='submit' class='btn btn-main btn-theme' name='btnEditPost' data-lang='en' value='Edit'>
                        </div>
                    </form>
                </div>
               <?php 
            }?>
           <!-- /.col -->
       </div> <!-- /.container -->
   </section><!--End blog single section-->
</body>

<?php }?>

 
