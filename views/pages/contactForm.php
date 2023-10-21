
  <?php 

  $_SESSION['page']="contact";

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
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <!-- Section Title -->
                    <div class="section-title text-center m-bottom-40">
                        <h2 class="wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.6s">Contact</h2>
                        <div class="divider-center-small wow zoomIn" data-wow-duration="1s" data-wow-delay="0.6s"></div>
                        <p class="section-subtitle wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s"><em>If you have a problems with your account or any other question you can send to administrator of this website</em></p>
                    </div>
                </div> <!-- /.col -->
            </div>
            <div class="col-12 text-center">
                <?php 
                if(isset($_SESSION['successCon'])){
                    echo "<div class='alert alert-success'>".$_SESSION['successCon']."</div>";
                    unset($_SESSION['successCon']);
                }
                else{
                    echo "";
                }
                ?>
            </div>
            <div class="row m-bottom-100">
                <div class="col-md-7 col-sm-7 p-bottom-30">
                    <div class="contact-form row">
                        <form name="contactForm" id="contactForm" action="models/form_check/formContact.php" method="post">
                            <div class="col-sm-12 contact-form-item  text-center">
                                <label for="user"><em>To which admin or user are you sending a message:</em></label>&nbsp;
                                <select name="user" id="user" class="contact-form-item">
                                <option value=""></option>
                                    <?php 
                                    $users=getUsers();
                                    foreach($users as $user):
                                    ?>
                                <option value="<?=$user->id_user?>"><?=$user->role_name?>&nbsp;&nbsp;&nbsp;<?=$user->username?></option>
                                <?php
                                endforeach; ?>
                                </select>
                                <?=error("errorsFormC","user");?>
                            </div>
                            <div class="col-sm-12 contact-form-item ">
                                <textarea name="messageSMS" id="message" placeholder="Your Message" value="<?=signValues("messageSMS","dataFormC");?>"></textarea></br></br>
                                <?=error("errorsFormC","messageSMS");?>
                            </div>
                            <div class="col-sm-12 contact-form-item">
                                <input type="submit" class=" btn btn-main btn-theme " name="btnSubmitSMS"  data-lang="en" value="Send">
                            </div>
                        </form>
                    </div> <!-- /.contacts-form & inner row -->
                </div> <!-- /.col -->
                <!-- === Contact Information === -->
                <div class="col-md-5 col-sm-5 p-bottom-30">
                    <address class="contact-info">
                        <p class="m-bottom-30 wow slideInRight">Some useful information: </p>
                        <!-- === Location === -->
                        <div class="m-top-20 wow slideInRight">
                            <div class="contact-info-icon">
                                <i class="fa fa-location-arrow"></i>
                            </div>
                            <div class="contact-info-title">
                                Address:
                            </div>
                            <div class="contact-info-text">
                                149 Null Street, New York, NY 098
                            </div>
                        </div>
                        <!-- === Phone === -->
                        <div class="m-top-20 wow slideInRight">
                            <div class="contact-info-icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="contact-info-title">
                                Phone number:
                            </div>
                            <div class="contact-info-text">
                                +1-000-1111-3333
                            </div>
                        </div>
                        <!-- === Mail === -->
                        <div class="m-top-20 wow slideInRight">
                            <div class="contact-info-icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="contact-info-title">
                                Email:
                            </div>
                            <div class="contact-info-text">
                                supportBlog@gmail.com
                            </div>
                        </div>
                    </address>
                </div> <!-- /.col -->
            </div> <!-- /.row -->
        </div>
   </section>
  </body>
  <?php 
  }?>