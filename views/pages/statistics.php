
  <?php 
  
  $_SESSION['page']="statistics";
  $userId=$_SESSION['user']->id_user;

  if(!isset($_SESSION['user'])){

    http_response_code(404);
    header('Location: index.php?page=login');
  }
  elseif($_SESSION['user']->id_role!=1){

    http_response_code(404);
    header('Location: index.php?page=user');
  }
  elseif($_SESSION['user']->id_role==1){
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
              <h2 class="wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.6s">Statistics</h2>
              <div class="divider-center-small wow zoomIn" data-wow-duration="1s" data-wow-delay="0.6s"></div>
                <p class="section-subtitle wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s"><em>Check your website statistics</em></p>
              </div>
            </div>

            <div class="col-md-12 table-responsive ">
              <h6>Today's number of logins: <span id="loginNumber"><?=numberOfLogins();?></span></h6>
            </div>
            <div class="col-md-12 table-responsive ">
              <table class="table table-hover">
                    <thead class="text-warning">
                      <th>PAGE</th>
                      <th>%</th>
                    </thead>
                    <tbody>
                      <?php viewedPages(); ?>
                    </tbody>
              </table>
            </div>    
        </div>  
    </div>         
   </section>
  </body>
   <?php }?>