<?php 

    session_start();
    include "config/connection.php";
    include "models/functions/function.php";
    logPage();
   
    if(isset($_GET['page'])){

        switch($_GET['page']){

            case 'signUp': 
                include "views/fixed/head.php";
                include "views/fixed/headerLogin.php";
                include "views/pages/signUp.php";
                break;

            case 'login': 
                include "views/fixed/head.php";
                include "views/fixed/headerLogin.php";
                include "views/pages/login.php";
                break;

            case 'user': 
                include "views/fixed/head.php";
                include "views/fixed/header.php";
                include ("views/pages/user.php");
                break;

            case 'home': 
                include "views/fixed/head.php";
                include "views/fixed/header.php";
                include ("views/pages/user.php");
                break;

            case 'logout':
                include ("views/pages/logout.php");
                break;

            case 'blogs': 
                include "views/fixed/head.php";
                include "views/fixed/header.php";
                include ("views/pages/blogs.php");
                break;

            case 'singlePost': 
                include "views/fixed/head.php";
                include "views/fixed/header.php";
                include ("views/pages/singlePost.php");
                break;

            case 'userPosts':
                include "views/fixed/head.php";
                include "views/fixed/header.php";
                include ("views/pages/userPosts.php");
                break;

            case 'createPost': 
                include "views/fixed/head.php";
                include "views/fixed/header.php";
                include ("views/pages/createPost.php");
                break;

            case 'contactForm': 
                include "views/fixed/head.php";
                include "views/fixed/header.php";
                include ("views/pages/contactForm.php");
                break;

            case 'author': 
                include "views/fixed/head.php";
                include "views/fixed/header.php";
                include ("views/pages/author.php");
                break;

            case 'messages': 
                include "views/fixed/head.php";
                include "views/fixed/header.php";
                include ("views/pages/messages.php");     
                break;

            case 'users': 
                include "views/fixed/head.php";
                include "views/fixed/header.php";
                include ("views/pages/users.php");          
                break;

            case 'editPost': 
                include "views/fixed/head.php";
                include "views/fixed/header.php";
                include ("views/pages/editPost.php");                 
                break;

            case 'statistics': 
                include "views/fixed/head.php";
                include "views/fixed/header.php";
                include ("views/pages/statistics.php");                     
                break;
        }
    }
    else{
        include "views/fixed/head.php";
        include "views/fixed/headerLogin.php";
        include "views/pages/login.php";
    }
    include "views/fixed/footer.php";
?>