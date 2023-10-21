
  <?php 
 
  $_SESSION['page']="author";

  if(!isset($_SESSION['user'])){

    http_response_code(404);
    header('Location: index.php?page=login');
  }
  else{
  ?>
  <body class="homepage_slider" data-spy="scroll" data-target=".navbar-fixed-top" data-offset="100">
    
    <div id="preloader">
        <div id="spinner"></div>
    </div>

    <section class="blog-index">
      <div class="container clearfix">
        <div class="col-md-8 col-md-offset-2">
          <!-- Section Title -->
          <div class="section-title text-center ">
            <h2 class="wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.6s">Author</h2>
              <div class="divider-center-small wow zoomIn" data-wow-duration="1s" data-wow-delay="0.6s"></div>
                <p class="section-subtitle wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s"><em>Some information on the author of the website</em></p>
              </div>
          </div> 
       
          <!-- /.col -->
  
          <div class="row margin">
            <div class="col-12 col-lg-6" id="authorImg">
              <img src="assets/img/me.jpg" alt="author"/>
          </div>

          <div class="col-12 col-lg-6">
            <div class="card py-3  paddingX" id="authorText">
              <div class="card-body">
                <h4 class="card-title">My name is Anica Radenković</h4>
                <h6 class="card-subtitle mb-2 text-muted">Here's something about me</h6>
                <p class="card-text fontSize">Date of birth: 14.02.2002</p>
                <p class="card-text fontSize">Status: Student</p>
                <p class="card-text fontSize">Place of study: ICT College</p>
                <p class="card-text fontSize">Module: Web programming</p>
                <p class="card-text fontSize">Title after graduation: Professional Engineer of Electrical Engineering and Computing</p>
                <p class="card-text fontSize">Objective: Acquiring adequate knowledge, expertise and skills to work in creative places in the field of programming</p>
              </div>
              <a href="models/export/export_to_word.php" class="btn btn-main btn-theme">EXPORT TO WORD</a>       
            </div>
          </div>
        </div>
      </div>
    </section>
  </body>
   <?php } ?>
   