
<?php 

    $_SESSION['page']="singlePost";
    $userRole=$_SESSION['user']->id_role;

    if(!isset($_SESSION['user'])){

        http_response_code(404);
        header('Location: index.php?page=login');
    }
    else{?>

    <body class="blog_index" data-spy="scroll" data-target=".navbar-fixed-top" data-offset="100">
        <!-- Preloader -->
        <div id="preloader">
            <div id="spinner"></div>
        </div>
        <section id="blog-single" class="p-top-80 p-bottom-80">
            <!--Container-->
            <div class="container clearfix">
                <div class="row">
                    <div class="col-sm-12">
                        <!--Post Single-->
                        <?php
                        $userId=$_SESSION['user']->id_user;

                        if(isset($_SESSION['singlePostId'])){

                            $postId=$_SESSION['singlePostId'];
                            $post=postById($postId);
                            singlePost($post,$userRole);
                        }
                        ?>
                        <!--End post single-->            
                    </div> <!-- /.col -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section><!--End blog single section-->
    </body>
<?php } ?>