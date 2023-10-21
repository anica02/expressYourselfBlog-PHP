<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php 
    
    if(isset($_GET['page'])){

        $page=$_GET['page'];

        switch($page){

            case "home": 
                echo    
                    "<title>Express yourself | Home </title>
                    <meta name='description' content='Express yourself - website where you can see what people have to say on 
                    on a given topic and write your one post'>
                    <meta name='keywords' content='blog,express,posts'>";
                    break;

            case "login": 
                echo    
                    "<title>Express yourself | Log in </title>
                    <meta name='description' content='Express yourself - Login your account  to catch up and add your new post '>
                    <meta name='keywords' content='log in, email, account, blogs'>"; 
                    break;

            case "signUp": 
                echo 
                    "<title>Express yourself | Sign Up </title>
                    <meta name='description' content='Express yourself - Sign up so you could create your account and begin writing your thoughts '>
                    <meta name='keywords' content='sign up,email, create, account, blogs'>";
                    break;

            case "user": 
                echo 
                    "<title>Express yourself | User </title>
                    <meta name='description' content='Express yourself - See what other people had posted on a certain topic '>
                    <meta name='keywords' content='title, tags, archives, posts, newest, profile, messages, user'>";
                    break;

            case "users": 
                echo 
                    "<title>Express yourself | Users </title>
                    <meta name='description' content='Express yourself - See what other people had posted on a certain topic '>
                    <meta name='keywords' content='users, email, contact, role, name'>";
                    break;

            case "createPost":
                echo 
                    "<title>Express yourself | Create post </title>
                    <meta name='description' content='Express yourself - Create new posts by adding title, description, tag and image to them'>
                    <meta name='keywords' content='title, blogs,tags, description, image, upload, posts'>"; 
                    break;
            case "editPost":
                 echo 
                    "<title>Express yourself | Edit post </title>
                    <meta name='description' content='Express yourself - Edit posts title and description'>
                    <meta name='keywords' content='title, blogs,tags, description, image, upload, posts'>"; 
                    break;

            case "singlePost":
                echo    
                    "<title>Express yourself | Single post </title>
                    <meta name='description' content='Express yourself - Details of a specific post'>
                    <meta name='keywords' content='title, blogs,tags, comment'>"; 
                    break;

            case "userPosts": 
                echo 
                    "<title>Express yourself | My posts </title>
                    <meta name='description' content='Express yourself - View your uploaded posts and edit them'>
                    <meta name='keywords' content='title, blogs,tags, posts, archives, newest'>"; 
                    break;

            case "messages": 
                echo 
                    "<title>Express yourself | Inbox </title>
                    <meta name='description' content='Express yourself - Messages that people have sent you'>
                    <meta name='keywords' content='inbox, messages, users, email, responde'>";                          
                    break;

            case "contactForm": 
                echo 
                    "<title>Express yourself | Contact </title>
                    <meta name='description' content='Express yourself - Send messages to other users or admins'>
                    <meta name='keywords' content='contact, message, send, admin, user'>";                   
                    break;

            case "author": 
                echo
                    "<title>Express yourself | Author </title>
                    <meta name='description' content='Express yourself - Author of this website'>
                    <meta name='keywords' content='author, website, information'>";                                   
                    break;

            case "statistics": 
                echo 
                    "<title>Express yourself | Statistics</title>
                    <meta name='description' content='Express yourself - Check your website statistics'>
                    <meta name='keywords' content='author, website, information'>"; 
                    break;
        }
       
    }
    else{
        echo 
            "<title>Express yourself </title>
            <meta name='description' content='Express yourself - website where you can see what people have to say on 
            on a given topic and write your one post'>
            <meta name='keywords' content='blog,express,posts'>";
    }
    ?>
    <!-- <title>Express yourself | Blog</title> -->
    
    <script src="https://kit.fontawesome.com/ce9a3cdf18.js" crossorigin="anonymous"></script>
    
    <!-- Favicons -->
    <link rel="shortcut icon" href="assets/img/icon.png">
    
    <!-- Google Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet" />
    
    <!-- Bootstrap CSS -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    
    <!-- CSS Files For Plugin -->
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/font-awesome/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/magnific-popup.css" rel="stylesheet" />
    <link href="assets/css/YTPlayer.css" rel="stylesheet" />
    <link href="assets/inc/owlcarousel/css/owl.carousel.min.css" rel="stylesheet" />
    <link href="assets/inc/owlcarousel/css/owl.theme.default.min.css" rel="stylesheet" />
    <link href="assets/inc/revolution/css/settings.css" rel="stylesheet" />
    <link href="assets/inc/revolution/css/layers.css" rel="stylesheet" />
    <link href="assets/inc/revolution/css/navigation.css" rel="stylesheet" />
    
    <!-- Custom CSS -->
    <link href="assets/css/mycss.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>