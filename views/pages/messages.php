
<?php 

  $numberOfPagesM = getNumberOfPagesM();
  $_SESSION['page']="message";
  $userId=$_SESSION['user']->id_user;

  if(!isset($_SESSION['user'])){

    http_response_code(404);
    header('Location: index.php?page=login');

  }
  else{
  ?>
  
  <body class="blog_index" data-spy="scroll" data-target=".navbar-fixed-top" data-offset="100">
    <!-- Preloader -->
    <div id="preloader">
        <div id="spinner"></div>
    </div>
    <!-- End Preloader-->
    <section class="blog-index">
        <div class="container clearfix">
            <div class="row msg-margin-b">
                <div class="col-md-8 col-md-offset-2">
                    <!-- Section Title -->
                    <div class="section-title text-center">
                        <h2 class="wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.6s">Messages</h2>
                        <div class="divider-center-small wow zoomIn" data-wow-duration="1s" data-wow-delay="0.6s"></div>
                        <p class="section-subtitle wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s"><em>Your inbox of messages users had sent you</em></p>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                <?php 
                if(isset($_SESSION['successMsg'])){
                    echo "<div class='alert alert-success'>".$_SESSION['successMsg']."</div>";
                    unset($_SESSION['successMsg']);
                }
                else{
                    echo "";
                }
                ?>
            </div>

            <div class="col-md-12 table-responsive " id="tableMsg">
                    <?php 
                     $msg=showUMsg($userId);
                     echo $msg;
                    ?>
            </div>
            <?php 
                $pag;
                if(!$msg){
                    echo "";
                }
                else{
                    $pag='<div class="col-md-12 text-center">
                            <nav aria-label="...">
                                <ul class="pagination">';
                                    for($i = 0; $i < $numberOfPagesM; $i++){
                                        if($i == 0){
                                            $pag.='<li class="page-item active"><a class="page-link post-pagination" href="#" data-limit='; $pag.=$i; $pag.='>'; $pag.=$i+1; $pag.='</a></li>';
                                        }
                                        if($i != 0){
                                            $pag.='<li class="page-item"><a class="page-link post-pagination" href="#" data-limit='; $pag.=$i; $pag.='>'; $pag.=$i+1; $pag.='</a></li>';
                                        }
                                    }
                    $pag.='</ul></nav></div>';
                    echo $pag;
                }
            ?>
        </div>         
    </section>
  </body>

   <?php }?>