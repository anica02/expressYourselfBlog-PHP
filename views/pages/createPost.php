<?php 
     
    $_SESSION['page']="create";
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
        <h2 class="wow fadeInDown no-margin" data-wow-duration="1s" data-wow-delay="0.6s"><strong>Share your thoughts with other people</strong></h2>
        <div class="divider-center-small wow zoomIn" data-wow-duration="1s" data-wow-delay="0.6s"></div>
    </div>

    <!--BLog single section-->
    <section id="blog-single" class="p-top-80 p-bottom-80">
        <!--Container-->
        <div class="container clearfix ">
            <div class="col-12">
               <form action="models/form_check/formCreatePost.php" method="post" enctype="multipart/form-data" id="formCP" name="formCP">
                    <div class="form-group formFont ">
                        <input type="text" id="postTitle" name="postTitle" placeholder="Post title" value="<?=signValues("dataPost","postTitle")?>"/>
                        <?=error("errorsPost","postTitle");?>
                    </div>
                    <div class="form-group formFont ">
                        <textarea placeholder="Post description" name="postDes" id="postDes"><?= 
                        signValues("dataPost","postDes");
                        ?></textarea>
                        <?=error("errorsPost","postDes");?>
                    </div>
                    <div class="form-group formFont2 " name="tagsPost">
                        <label class="formFont">Posts Tags:</label></br>
                        <?php $tags=tags();
                            $i=1;
                            if(isset($_SESSION['tagsId'])){
                                
                            }
                            foreach($tags as $t){?>
                               <input type="checkbox" name="<?=$i?>" value="<?=$t->tag_name?>"> <?=$t->tag_name?></br>
                            <?php
                            $i++; } ?>
                    </div>
                    <?=error("errorsPost","tagPost");?>
                    <div class="form-group">
                        <label class="formFont">Posts Image:</label>
                        <input type="file"  name="postImg" id="postImg"/>
                        <?=error("errorsPost","postImg");?>
                    </div>
                    <div class="col-sm-12 contact-form-item">
                       <input type="submit" class="btn btn-main btn-theme" name="btnUpload" data-lang="en" value="UPLOAD">
                    </div>
                </form>
            </div> 
            <!-- /.col -->
        </div> <!-- /.container -->
    </section><!--End blog single section-->
</body>
<?php }?>

  
 