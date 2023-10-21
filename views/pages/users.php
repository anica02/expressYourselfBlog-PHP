
  <?php 

  $numberOfPages = getNumberOfPages();
  $_SESSION['page']="users";

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
      <div class="row m-bottom-100 ">
        <div class="col-md-8 col-md-offset-2">
            <!-- Section Title -->
            <div class="section-title text-center m-bottom-40">
              <h2 class="wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.6s">Users</h2>
              <div class="divider-center-small wow zoomIn" data-wow-duration="1s" data-wow-delay="0.6s"></div>
                <p class="section-subtitle wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s"><em>Edit users privileges</em></p>
              </div>
            </div>
            <a href="models/export/export_to_excel.php" class="btn btn-main btn-theme">EXPORT TO EXCEL</a>
            <div class="col-md-12 table-responsive " id="tableUser">
                      <?php 
                      showUsers();
                      ?>
            </div>
            <div class="col-md-12 text-center margin100">
              <nav aria-label="...">
                <ul class="pagination">
                  <?php
                    for($i = 0; $i < $numberOfPages; $i++):
                        if($i == 0):
                    ?>
                        <li class="page-item active"><a class="page-link post-pagination" href="#" data-limit="<?=$i?>"><?=($i+1)?></a></li>
                        <?php
                        endif;
                        if($i != 0):
                        ?>
                          <li class="page-item"><a class="page-link post-pagination" href="#" data-limit="<?=$i?>"><?=($i+1)?></a></li>
                        <?php
                        endif;
                    endfor;
                    ?>
                </ul>
              </nav>
            </div>
          </div>
        </div>
        
   </section>
  </body>
   <?php }?>
