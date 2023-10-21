
  <?php 
  $_SESSION['page']="signUp";
  ?>
  <body class="single_post_page" data-spy="scroll" data-target=".navbar-fixed-top" data-offset="100">

    <!-- Preloader -->
    <div id="preloader">
        <div id="spinner"></div>
    </div>
    <!-- End Preloader-->
    <!-- m-top-80 m-bottom-100 -->
    
    <div class="container heightCon marginTop">
        <div class="row">
            <div class="col-12">
                <div class="section-title text-center m-bottom-40">
                    <h2 class="wow fadeInDown" data-wow-duration="1s" data-wow-delay="0.6s">Create your account</h2>
                    <div class="divider-center-small wow zoomIn" data-wow-duration="1s" data-wow-delay="0.6s"></div>
                    <h6 class="section-subtitle wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.6s"><em>Already have an account?<a href="index.php?page=login" id="linkLogIn">&nbsp;Log in</a></em></h6>
                </div>
            </div>
            <div class="col-12 mt-30">
                <div id="signIn">
                    <form action="models/form_check/formSignUp.php" method="post" name="formSign" id="formSign">
                        <div class="row form-group ">
                            <div class="col-sm-6 formFont wow zoomIn">
                                <label for="fisrtNameSg">First name</label>
                                <input type="text" id="firstNameSg" name="firstNameSg" placeholder="Pera" value="<?=signValues("dataForm","firstNameSg");?>"/>
                                <?=error("errorsForm","firstNameSg");?>
                            </div>
                            <div class="col-sm-6 formFont wow zoomIn">
                                <label for="lastNameSg">Last name</label>
                                <input type="text" id="lastNameSg" name="lastNameSg"  placeholder="Perić" value="<?=signValues("dataForm","lastNameSg");?>"/>
                                <?=error("errorsForm","lastNameSg");?>
                            </div>
                        </div>
                        <div class="row form-group ">
                            <div class="col-sm-6 formFont wow zoomIn">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" placeholder="pera_peric" value="<?=signValues("dataForm","username")?>"/>
                                <?=error("errorsForm","username");?>
                            </div>
                            <div class="col-sm-6 formFont wow zoomIn">
                                <label for="emailSg">Email</label>
                                <input type="email" id="emailSg" name="emailSg"  placeholder="pera.peric@gmail.com" value="<?=signValues("dataForm","emailSg")?>"/>
                                <?=error("errorsForm","emailSg");?>
                            </div>
                        </div>
                        <div class="row form-group ">
                            <div class="col-sm-6 formFont wow zoomIn">
                                <label for="passwdSg">Password</label>
                                <input type="text" id="passwdSg" name="passwdSg"  placeholder="Pera21*" value="<?=signValues("dataForm","passwdSg")?>"/>
                                <?=error("errorsForm","passwdSg");?>
                            </div>
                            <div class="col-sm-6 formFont wow zoomIn">
                                <label for="passwdSgCon">Confirm password</label>
                                <input type="text" id="passwdSgCon" name="passwdSgCon" placeholder="Pera21*" value="<?=signValues("dataForm","passwdSgCon")?>"/>
                                <?=error("errorsForm","passwdSgCon");?>
                            </div>
                        </div>
                        <div class="col-sm-12 contact-form-item">
                            <input type="submit" class="btn btn-main btn-theme " name="btnCreatAcc" data-lang="en" value="CREATE MY ACCOUNT">
                        </div>
                        <div class="col-sm-12">
                            <p>By registering, you accept our terms of use and our privacy policy.</p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
  </body>

   