<header class="nav-solid" id="home">
        <nav class="navbar navbar-fixed-top">
            <div class="navigation">
                <div class="container-fluid">
                    <div class="row">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                            <!-- Logo -->
                            <div class="logo-container">
                                <div class="logo-wrap local-scroll">
                                  <a href="index.php?page=user">
                                    <img class="logo" src="assets/img/logo.png" alt="logo" data-rjs="2">
                                  </a>
                                </div>
                            </div>
                        </div> <!-- end navbar-header -->

                        <div class="col-md-8 col-xs-12 nav-wrap">
                            <div class="collapse navbar-collapse" id="navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                            <?php 
                            if(isset($_SESSION['user'])&& $_SESSION['user']->id_role==1){
                             $navA=getNavAdmin();
                              foreach($navA as $n):
                            ?>
                              <li><a href="<?=$n->nav_href?>"><?=$n->nav_text?></a></li>   
                            <?php 
                            endforeach;
                            }?>
                            <?php 
                            if(isset($_SESSION['user'])&& $_SESSION['user']->id_role==2){
                              $navU=getNavUser();
                              foreach($navU as $n):
                            ?>
                              <li><a href="<?=$n->nav_href?>"><?=$n->nav_text?></a></li>   
                            <?php 
                            endforeach;
                            }?>
                            
                            </ul>
                            
                            </div>
                        </div>

                    </div> <!-- /.row -->
                </div> <!--/.container -->
            </div> <!-- /.navigation-overlay -->
        </nav> <!-- /.navbar -->
</header>