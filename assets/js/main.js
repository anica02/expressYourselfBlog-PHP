function editUser(){
        $('.btnEditUser').on('click', function(){

                var userId=$(this).data("id");
                var user=$(this);
               
                user.parent().parent().next('tr').find( "td > div").toggle();
                user.parent().parent().next('tr').find( "td > div > form > input#hiddenU" ).val(userId);
        });
}

function deleteUser(){
        $('.btnDeleteUser').on('click', function(){

                var user=$(this);
                var userId=$(this).data("id");
          
                $.ajax({ 
                        type: 'POST', 
                        url: 'models/form_check/ajax.php',
                        data: { 
                                uId:userId   
                        },
                        dataType: "text",
                        success: function(data,status,jqXHR){
                                console.log("Server data", data);
                                console.log(jqXHR.status);
                                if(jqXHR.status==200) {
                                        user.parent().parent().css("display","none");
                                        window.reload();
                                }
                        },
                        error: function(message){
                                console.log(`${message.status} ${message.statusText}`); 
                        } 
                }); 
        });     
}

editUser();
deleteUser();

messageView();
respondMsg();
deleteMsg();

pagination();

function messageView(){
        $('.btnMessageView').on('click', function(){

                var msg=$(this);
                msg.parent().parent().next('tr').next('tr').find("td > div").toggle();
                
        });
}

function respondMsg(){
        $('.btnResponseMsg').on('click', function(){

                var userEmail=$(this).data("uname");
                var msg=$(this);
               
                msg.parent().parent().next('tr').find( "td > div").toggle();
                msg.parent().parent().next('tr').find( "td > div > form > input#hiddenM" ).val(userEmail);
                msg.parent().parent().next('tr').find( "td > div > form > div#userEmail" ).html("<p>To: " + userEmail + "</p>"); 
        });
        
}

$('.btnDeleteP').on('click', function(){

        var post=$(this);
        var postId=$(this).data("id");

        $.ajax({ 
                type: 'POST', 
                url: 'models/form_check/ajax.php',
                data: { 
                        pId:postId
                
                },
                dataType: "text",
                success: function(data,status,jqXHR){
                        console.log("Server data", data);
                        console.log(jqXHR.status);
                        if(jqXHR.status==200) 
                                post.parent().parent().parent().css("display","none");
                },
                error: function(message){
                        console.log(`${message.status} ${message.statusText}`); 
                } 
        }); 
});



function deleteMsg(){
        $('.btnDeleteMsg').on('click', function(){

                var msg=$(this);
                var msgId=$(this).data("id");
        
                $.ajax({ 
                        type: 'POST', 
                        url: 'models/form_check/ajax.php',
                        data: { 
                                msgId:msgId
                                
                        },
                        dataType: "text",
                        success: function(data,status,jqXHR){
                                console.log("Server data", data);
                                console.log(jqXHR.status);
                                if(jqXHR.status==200) 
                                msg.parent().parent().css("display","none");
                                msg.parent().parent().next('tr').css("display","none");
                                msg.parent().parent().next('tr').next('tr').css("display","none");
                                location.reload();
                        },
                        error: function(message){
                                console.log(`${message.status} ${message.statusText}`); 
                        } 
                }); 
        });
}



function ajaxCallBack(url, method, data, result,xhr){

        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: "json",
            success:result,
            error: xhr
        });
}
    
$(document).ready(function(){
        likes();
        readMore();

        $('.commDel').on('click', function(){

                var com=$(this);
                var comId=$(this).data("id");

                $.ajax({ 
                        type: 'POST', 
                        url: 'models/form_check/ajax.php',
                        data:   { 
                                   commDel:comId
                           
                        },
                        dataType: "text",
                        success:function(data,status,jqXHR){
                                console.log("Server data", data);
                                console.log(jqXHR.status);
                                if(jqXHR.status==200) {
                                com.parent().parent().parent().css("display","none");
                                location.reload();
                                }
                        },
                        error: function(message){
                                   console.log(`${message.status} ${message.statusText}`); 
                        } 
                }); 
        });

        $('.btnEditP').click(function(event){

                event.preventDefault();
                var postId=$(this).data("id");

                $.ajax({ 
                        type: 'POST', 
                        url: 'models/form_check/ajax.php',
                        data: { 
                                postEdit:postId
                                
                        },
                        dataType: "text",
                        success: function(data,status,jqXHR){
                                console.log("Server data", data);
                                console.log(jqXHR.status);
                                if(jqXHR.status==200) {
                                        console.log("jeste");
                                        console.log(postId);
                                        window.location="index.php?page=editPost";
                                }
                        },
                        error: function(message){
                                console.log(`${message.status} ${message.statusText}`); 
                        } 
                }); 
        });


        $('#btnTitleP').click(function(){
              
                let search=$("#postTitleS").val();
                let page=window.location.href;
                let pageHref=0;

                if(page=="http://127.0.0.1/blog/index.php?page=userPosts"){
                        pageHref=1;
                }
                console.log(page);
                let err="";

                if(search==""){
                  err=`<div class='alert alert-danger text-center'>No title has been given</div>`;
                  $('#posts').html(err);
                }
                else{
                        let data = {
                                search: search,
                                page:pageHref
                        }

                        ajaxCallBack("models/ajax/postFilter.php", "post", data, function(result,jqXhR){
                                printPosts(result);
                                likes();
                                readMore();
                        },function(xhr){
                                if(xhr.status == 500){
                                   let error="";
                                   error=`<div class='alert alert-danger text-center'>No posts have been found with this title</div>`;
                                   $('#posts').html(error);
                        }});
                }       
        });

        $('.postByDate').click(function(event){

                event.preventDefault();
                let postDate=$(this).data("id");
                let page=window.location.href;
                let pageHref=0;

                if(page=="http://127.0.0.1/blog/index.php?page=userPosts"){
                        pageHref=1;
                }

                let data = {
                        postD: postDate,
                        page:pageHref
                }

                ajaxCallBack("models/ajax/postFilter.php", "post", data, function(result){
                        printPosts(result);  
                        likes();
                        readMore();  
                },function(xhr){
                        if(xhr.status == 500){
                           let error="";
                           error=`<div class='alert alert-danger text-center'>No posts have been found with this date</div>`;
                           $('#posts').html(error);
                }});
        });

        $('.oldPost').click(function(event){

                event.preventDefault();
                let page=window.location.href;
                let pageHref=0;

                if(page=="http://127.0.0.1/blog/index.php?page=userPosts"){
                        pageHref=1;
                }

                let data = {
                       oldPost:1
                }

                ajaxCallBack("models/ajax/postFilter.php", "post", data, function(result){
                        printPosts(result);  
                        likes();
                        readMore();  
                },function(xhr){
                        if(xhr.status == 500){
                           let error="";
                           error=`<div class='alert alert-danger text-center'>No posts have been found with this date</div>`;
                           $('#posts').html(error);
                }});
        });

        $('.tagName').click(function(event){

                event.preventDefault();
                let tagName=$(this).data("id");
                let page=window.location.href;
                let pageHref=0;

                if(page=="http://127.0.0.1/blog/index.php?page=userPosts"){
                        pageHref=1;
                }

                let data = {
                        tagN: tagName,
                        page:pageHref
                }

                ajaxCallBack("models/ajax/postFilter.php", "post", data, function(result){
                        printPosts(result);  
                        likes();
                        readMore();  
                },function(xhr){
                        if(xhr.status == 500){
                           let error="";
                           error=`<div class='alert alert-danger text-center'>No posts have been found with this tag</div>`;
                           $('#posts').html(error);
                }});    
        });

        $('.post-pagination').click(function(e){

                e.preventDefault();
                let limit = $(this).data('limit');
                $("li.active").removeClass('active');
                $(this).parent().addClass('active');
                let page=window.location.href;
                let pageHref=0;

                if(page=="http://127.0.0.1/blog/index.php?page=users"){
                        pageHref=1;
                }

               
                let data = {
                    limit: limit,
                    page:pageHref
                }
               
                ajaxCallBack("models/ajax/pagination.php", "post", data, function(result){
                     if(pageHref==1){
                        showUsers(result);
                     }
                     else{
                        showUMsg(result);
                     }
                },function(xhr){
                        if(xhr.status == 500){
                           let error="";
                           error=`<div class='alert alert-danger text-center'>No users have been found</div>`;
                           $('#posts').html(error);
                }});
        });
});

function  pagination(){
        $('.post-pagination').click(function(e){

                e.preventDefault();
                console.log("ne");
                let limit = $(this).data('limit');
                $("li.active").removeClass('active');
                $(this).parent().addClass('active');
                let page=window.location.href;
                let pageHref=0;

                if(page=="http://127.0.0.1/blog/index.php?page=users"){
                        pageHref=1;
                }

               
                let data = {
                    limit: limit,
                    page:pageHref
                }
               
                ajaxCallBack("models/ajax/pagination.php", "post", data, function(result){
                     if(pageHref==1){
                        showUsers(result);
                     }
                     else{
                        showUMsg(result);
                     }
                },function(xhr){
                        if(xhr.status == 500){
                           let error="";
                           error=`<div class='alert alert-danger text-center'>No users have been found</div>`;
                           $('#posts').html(error);
                }});
        });
}
function readMore(){

        $('.read-more').click(function(event){

                event.preventDefault();
                var postId=$(this).data("id");

                $.ajax({ 
                        type: 'POST', 
                        url: 'models/form_check/ajax.php',
                        data: { 
                                pIdSing:postId
                                
                        },
                        dataType: "text",
                        success: function(data,status,jqXHR){
                                console.log("Server data", data);
                                console.log(jqXHR.status);
                                if(jqXHR.status==200) {
                                        console.log("jeste");
                                        console.log(postId);
                                        window.location="index.php?page=singlePost";
                                }
                        },
                        error: function(message){
                                console.log(`${message.status} ${message.statusText}`); 
                        } 
                });  
        });
}

function likes(){

        $('.like').click(function(){

                var heart=$(this);
                var postId=$(this).data("id");
                var userId=$(this).data("value");

                if($(heart).hasClass("liked")){

                        $(this).removeClass("liked");

                        $.ajax({ 
                                type: 'POST', 
                                url: 'models/form_check/ajax.php',
                                data: { 
                                        postDL:postId,
                                        uIdDL:userId
                                        
                                },
                                dataType: "text",
                                success: function(data,status,jqXHR){
                                        console.log("Server data", data);
                                        console.log(jqXHR.status);
                                        if(jqXHR.status==200) {
                                                console.log("jeste");
                                                console.log(postId);
                                        }
                                },
                                error: function(message){
                                        console.log(`${message.status} ${message.statusText}`); 
                                }        
                        }); 

                        $lajkovi=$(this).parent().parent().find('[class*="likedN"]').html();
                        $lajkoviMin=parseInt($lajkovi)-1;
                        $(this).parent().parent().find('[class*="likedN"]').html($lajkoviMin);
                        console.log("dislajk");
                }
                else{
                
                        $.ajax({ 
                                type: 'POST', 
                                url: 'models/form_check/ajax.php',
                                data: { 
                                        postL:postId,
                                        uIdL:userId
                                        
                                },
                                dataType: "text",
                                success: function(data,status,jqXHR){
                                        console.log("Server data", data);
                                        console.log(jqXHR.status);
                                        if(jqXHR.status==200) {
                                                console.log("jeste");
                                                console.log(userId);
                                        }
                                },
                                error: function(message){
                                        console.log(`${message.status} ${message.statusText}`); 
                                } 
                        }); 

                        $(this).addClass("liked");
                        $lajkovi=$(this).parent().parent().find('[class*="likedN"]').html();
                        $lajkoviPlus=parseInt($lajkovi)+1;
                        $(this).parent().parent().find('[class*="likedN"]').html($lajkoviPlus);
                        console.log("lajk");      
                }
        });
}


function printPosts(posts){

        let liked=posts.postsLikes;
        let user=posts.userId;
        let userR=posts.uRole;
        let likes="";
        let html = "";
        let commCount=0;
       
        for(p of posts.array){
               
                html+=  `<div class="col-xs-12 m-bottom-40">
                                <div class="blog wow zoomIn" data-wow-duration="1s" data-wow-delay="0.7s">
                                        <div class="blog-media">`;
                                        likes=`<i class='fas fa-heart like' data-id="${p.id_post}" data-value="${posts.userId}"></i>`;
                                        for(l of liked){
                                                if(p.id_post==l.id_post && l.id_user==posts.userId){
                                                likes=`<i class='fas fa-heart like liked' data-id="${p.id_post}" data-value="${posts.userId}"></i>`;
                                                }
                                        }
                                        
                                        if(p.img_src==""){
                                                html+=likes;
                                                html+="</div>";
                                        }
                                        else{
                                                html+=likes;
                                                html+=`<img src="assets/${p.img_src}" alt="${p.img_alt}"></div>`;
                                        }

                         html+=`<div class="blog-post-info clearfix">
                                <span class="time fL"><i class="fa fa-calendar"></i>
                                        ${p.post_date}
                                </span>
                                <span class="comments ml-10"><i class="fas fa-user"> </i>${p.username}</span>
                                <span class="comments  ml-10"><i class="fas fa-heart numL" ></i><span class="likedN">`;
                        
                                if(p.likes == 0){
                                html+=0;
                                }
                                else{
                                html+=p.likes;
                                }                   
                        html+=` </span></span>
                        </div>
                        <div class="blog-post-body">
                                <h4>${p.title}</h4>
                                <p class="p-bottom-20">`;
                                let des="";
                                if(p.desPost.length<=110){
                                des=p.desPost;
                                }
                                else{
                                des=p.desPost.substring(0,110)+"...";
                                }
                                html+=des;
                                html+=`
                                </p>
                                <a href="#" class="read-more" data-id="${p.id_post}">Read More >></a>`;
                        
                                if(userR==1){
                                html+=`
                                <input type="button" class="btn btn-main btn-theme f-r btnDeleteP" data-id="${p.id_post}"  value="Delete post"/>`;
                                }
                        
                html+=`</div><!--post body-->                   
                       </div> <!-- /.blog -->
                </div>`;  
        }

        $('#posts').html(html);
}

function showUsers(users){
        let html="";

        html=`<table class='table table-striped'>
              <thead><tr><th scope='col'>Id role</th><th scope='col'>First Name</th><th scope='col'>Last Name</th><th scope='col'>Email</th><th scope='col'>Status</th>
              <th scope='col'></th><th scope='col'></th></tr></thead><tbody>`;

        for(user of users.array){
                html+=`<tr scope='row'><td>${user.id_role}</td>
                        <td>${user.user_first_name}</td>
                        <td>${user.user_last_name}</td>
                        <td>${user.email}</td>
                        <td>${user.u_status}</td>
                        <td> 
                        <input type="button" class="btn btn-main btn-theme btnDeleteUser" data-id='${user.id_user}' value="Delete user"/>
                        </td>
                        <td>
                        <input type="button" class="btn btn-main btn-theme btnEditUser"  data-id='${user.id_user}' value="Edit user"/>
                        </td>
                        </tr>`;

                        html+=`<tr><td colspan='7'>
                        <div class="dataUser">
                        <h6>Things you as admin can change</h6>
                        <form action="models/form_check/ajax.php" method="post" name="formEditUser">
                        <input type="hidden" name="idUser" id="hiddenU" value=""/>
                        <p id="userId" name="idUser"></p>
                        <lable>Role:</lable></br>
                        </br>
                                <select name="role" id="role" class="form-control">
                                <option value="">Choose users role</option>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                                <option value="3">Other</option>
                                </select></br>
                        <lable>Status:</lable></br></br>
                                <select name="status" id="status"class="form-control">
                                <option value="">Choose users account status</option>
                                <option value="1">Active</option>
                                <option value="2">Passive</option>
                                </select></br></br>

                        <input type="submit" name="btnUsersData" value="Edit" class="btn btn-main btn-theme"/>
                        </form></div></tr>`;

        }

        html+="</tbody></table>";

        $('#tableUser').html(html);
        editUser();
        deleteUser();
   
}


function showUMsg(msg){
        let html="";

        if(msg){
                 html+=`<table class='table'> 
                <thead><tr><th scope='col'>User name</th><th scope='col'>User email</th><th scope='col'>Message</th><th scope='col'>Date</th></tr></thead><tbody>`;

                for(m of msg.array){
                        html+=`<tr  scope='row'>
                        <td>${m.u_name}</td>
                        <td>${m.u_email}</td>
                        <td>`;
                        let msgSub="";
                        if(m.u_msg.length<=10){
                                msgSub=m.u_msg;
                        }
                        else{
                                msgSub=m.u_msg.substring(0,7)+ " ...";
                        }
    
    
                        html+=msgSub;
    
                        html+=`</td>
                        <td>${m.create_date}</td>
                        <td>
                        <input type="button" class="btn btn-main btn-theme btnMessageView" value="View"/>
                        </td>
                        <td>
                        <input type="button" class="btn btn-main btn-theme btnDeleteMsg" data-id='${m.id_msg}' value="Delete message"/>
                        </td>
                        <td>
                        <input type="button" class="btn btn-main btn-theme  btnResponseMsg" data-id='${m.id_msg}' data-uname='${m.u_email}' value="Responde"/>
                        </td></tr>`;
    
                        html+=`<tr><td colspan='7'>
                                <div class="col-md-12 dataUser">
                                <h6>Send a reply</h6>
                                <form action="models/form_check/ajax.php" method="post" name="formMessageReply">
                                        <input type="hidden" name="email" id="hiddenM" value=""/>
                                        <div id="userEmail" name="userEmail"></div>
                                        </br>
                                        <div class="col-sm-12 contact-form-item ">
                                        <textarea name="message" id="message" placeholder="Your Message"></textarea>
                                        </div>
                                        <input type="submit" name="btnMssReply" value="Reply" class="btn btn-main btn-theme"/>
                                </form>
                                </div>
                                </td></tr>`;
    
    
                        html+=`<tr><td colspan='7'>
                                <div class="col-md-12 dataUser">
                                        <div class="col-sm-12 contact-form-item">
                                        <textarea name="message" id="userMsg" placeholder="Your Message"> ${m.u_msg}'</textarea>
                                        </div>
                                </div>
                        </td></tr>`;
                }
    
                html+="</tbody></table>";
        }
        else{
           html="<div class='alert alert-danger text-center'>You have no messages</div>";
        }
    
        $('#tableMsg').html(html);

        messageView();
        respondMsg();
        deleteMsg();
}
