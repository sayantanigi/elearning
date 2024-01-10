 //Sweetalert function
 function alert_func(data) {
    swal({title: data[0], type: data[1], confirmButtonColor: data[2]});
 }

 function alert_response(data,redirectURL) {

   //swal({title: data[0], type: data[1], confirmButtonColor: data[2]});

    swal({
        title: data[0],
        type: data[1],
        confirmButtonColor: data[2]
    }, function() {
        window.location = redirectURL;
    });
}

function resolvePromise(data){
   console.log(data);
}

//Function for fetching level details
function fetchLevelDetails(courseId,courseLvl){

    //var courseLvl = $('.tab-content .active').attr('id'); 
    return new Promise(function (resolve, reject) { 
        $.ajax({
             url: baseUrl+"course/getLevelDetails",
             type: 'post',
             dataType: 'html',
             data: {courseId:courseId,courseLvl:courseLvl},
        })
        .done(function(responseData) {
            var data = JSON.parse(responseData);
            if(data.check = 'success'){
               resolvePromise(data); 
               var lvlDetail = data.lvlDetail;
               //Appending vendor details on deal preview 
               $('#level_price').text('$'+Math.round(lvlDetail.lvlCost));

               if(lvlDetail.totalChapter>1){
                  $('#chapter_count').text(lvlDetail.totalChapter+' Chapters');
               }else{
                  $('#chapter_count').text(lvlDetail.totalChapter+' Chapter');
               }

               if(lvlDetail.totalHours>1){
                  $('#lvl_duration').text(lvlDetail.totalHours+' Hours');
               }else{
                  $('#lvl_duration').text(lvlDetail.totalHours+' Hour');
               }
               
               $('#currentlVL').text(lvlDetail.courseLvl);
               $('#course_lvl_img').html('<img src="'+baseUrl+'uploads/'+lvlDetail.imageSrc+'/'+lvlDetail.image+'" class="label-courseimg">');

               if(lvlDetail.purchaseCount>0){
                  $('#purchase-course').html('<i class="far fa-check-circle"></i>&nbsp;Purchased').attr('disabled',true);
               }else{
                  $('#purchase-course').html('<i class="far fa-shopping-cart"></i>&nbsp;Buy Now').attr('disabled',false);
               }

                if(lvlDetail.wishlisted == "yes"){
                  $('#add-course-to-wishlist').html('<i class="far fa-check-circle"></i>&nbsp;Wishlisted').attr('disabled',true);
               }else{
                  $('#add-course-to-wishlist').html('<i class="far fa-heart"></i>&nbsp;Add to Wishlist').attr('disabled',false);
               }

               $("#level_details").html(lvlDetail.description);
               $("#purchaseCount").text(data.purchaseCount);
            }
             
        })
        .fail(function(data) {
            console.log(data);
        });
    });    
}

//Show content more or less
function showMoreLess() {
   var dots = document.getElementById("dots");
   var moreText = document.getElementById("more");
   var btnText = document.getElementById("myBtn");

   if (dots.style.display === "none") {
     dots.style.display = "inline";
     btnText.innerHTML = "Read more"; 
     moreText.style.display = "none";
   } else {
     dots.style.display = "none";
     btnText.innerHTML = "Read less"; 
     moreText.style.display = "inline";
   }
}

//Function for fetching level details
function getLevelChapters(courseId,courseLvl,subjectId){

    //var courseLvl = $('.tab-content .active').attr('id'); 
    
    $.ajax({
         url: baseUrl+"course/getLevelChapters",
         type: 'post',
         dataType: 'html',
         data: {courseId:courseId,courseLvl:courseLvl,subjectId:subjectId},
    })

    .done(function(responseData) {
        var data = JSON.parse(responseData);
        //console.log(data);
        if(data.check = 'success'){
           //Appending chapter list on chapter list modal 
           $('#chapterList').html(data.lvlChapterHtml);
           $("#chaptereModal").modal('show');
        }
         
    })
    .fail(function(data) {
       //console.log(data);
    });
}

$(document).ready(function () {

     var courseId = $("#courseId").val();
     var courseLvl = $("#initLvl").val();
     
     //Fetching current selected level details
     fetchLevelDetails(courseId,courseLvl);
});

//Tab On Click Handler
$(document).on('click','.click_on_tab',function(event){
     event.preventDefault();
     var courseId = $("#courseId").val();
     var courseLvl = $(this).data('lvl');
     $("#initLvl").val(courseLvl);
     
     fetchLevelDetails(courseId,courseLvl);
});

//Fetching chapter list under subject
$(document).on('click','.showLevelChapters',function(e){
     e.preventDefault();
     var courseId = $("#courseId").val();
     var courseLvl = $("#initLvl").val();
     var subjectId = $(this).data('sid');

     getLevelChapters(courseId,courseLvl,subjectId);
});

//Fetching chapter list under subject
$(document).on('click','.showMoreLess',function(e){
    e.preventDefault();

    var index = $(this).data('index');
    var state = $(this).data('state');
    
    if(state == "less"){
       $("#dots_"+index).css({'display':'none'});
       $(this).data('state','more');
       $(this).text("Read less");
       $("#more_"+index).css({'display':'inline'});
    }else{
       $("#dots_"+index).css({'display':'inline'});
       $(this).data('state','less');
       $(this).text("Read more");
       $("#more_"+index).css({'display':'none'});
    } 

    return false;
});

//Purchasing course
$(document).on('click','#purchase-course',function(e){
     e.preventDefault();
     var courseId  = $("#courseId").val();
     var courseLvl = $("#initLvl").val();

     swal({
         title: 'Are You sure want to purchase '+courseLvl+' level of this course?',
         type: 'warning',
         showCancelButton: true,
         confirmButtonColor: '#A5DC86',
         cancelButtonColor: '#DD6B55',
         confirmButtonText: 'Yes',
         cancelButtonText: 'No',
         closeOnConfirm: true,
         closeOnCancel: true
     }, function(isConfirm){

         if (isConfirm) {

             $.ajax({
                 url: baseUrl+"course/purchaseCourse",
                 method: 'post',
                 data: {courseId:courseId,courseLvl:courseLvl},
                  beforeSend: function() {
                     $('.overlayer').fadeIn();
                  }
            })
            .done(function(responseData) {
                var data = JSON.parse(responseData);
                $('.overlayer').fadeOut();
                //console.log(data);
                if(data.check == 'success'){
                   setTimeout(function(){
                        var redirectURL = baseUrl+'student/instructor/'+courseId+'/'+courseLvl;
                        //Displaying success message to student 
                        alert_response([data.msg, "success", "#A5DC86"],redirectURL);
                        $('#purchase-course').html('<i class="far fa-check-circle"></i>&nbsp;Purchased').attr('disabled',true);
                   },100);
                }else{
                    setTimeout(function(){
                        //Displaying success message to student 
                        alert_func([data.msg, "error", "#DD6B55"]);
                        if(data.status != 'purchased'){
                           $('#purchase-course').html('<i class="far fa-shopping-cart"></i>&nbsp;Buy Now').attr('disabled',false); 
                        }else{
                           $('#purchase-course').html('<i class="far fa-check-circle"></i>&nbsp;Purchased').attr('disabled',true);
                        }
                   },100);
                }
            })
            .fail(function(data) {
               //console.log(data);
            });

        }
    });        

}); 

//Forget password form submit handler
$(document).on('submit','#user-forget-password',function(e){
     e.preventDefault();
     var formData  = new FormData(this);

     $.ajax({
        url: baseUrl+"process-forgot-password",
        method: 'post',
        data: formData,
        contentType:false,
        processData:false,
        beforeSend: function() {
           //$('.overlayer').fadeIn();
           //$("#forget-password-submit").text('Please wait...').attr('disabled',true);
        }
    })
    .done(function(responseData) {
        var data = JSON.parse(responseData);
        $('.overlayer').fadeOut();
        $("#forget-password-submit").text('Submit').attr('disabled',false);
        //console.log(data);
        if(data.check == 'success'){
            //Displaying response message to user 
            alert_func([data.msg, "success", "#A5DC86"]);
        }else{
           //Displaying response message to user 
           alert_func([data.msg, "error", "#DD6B55"]);
        }
    })
    .fail(function(data) {
       //console.log(data);
    });

});     

//Reset password form submit handler
$(document).on('submit','#user-reset-password',function(e){
     e.preventDefault();
     var formData  = new FormData(this);

     var new_password = $("#new_password").val();
     var confirm_password = $("#confirm_password").val();

     if(new_password != confirm_password){
        var passwordErr = "Password & confirm password doesn't match";
        alert_func([passwordErr, "error", "#DD6B55"]);
        return false;
     }

     $.ajax({
        url: baseUrl+"process-reset-password",
        method: 'post',
        data: formData,
        contentType:false,
        processData:false,
        beforeSend: function() {
           $('.overlayer').fadeIn();
           $("#reset-password-submit").text('Please wait...').attr('disabled',true);
        }
    })
    .done(function(responseData) {
        var data = JSON.parse(responseData);
        $('.overlayer').fadeOut();
        $("#reset-password-submit").text('Reset Password').attr('disabled',false);
        //console.log(data);
        if(data.check == 'success'){
            //Displaying response message to user 
            var redirectURL = baseUrl;
            alert_response([data.msg, "success", "#A5DC86"],redirectURL);
        }else{
           //Displaying response message to user 
           alert_func([data.msg, "error", "#DD6B55"]);
        }
    })
    .fail(function(data) {
       //console.log(data);
    });
});      


//Purchasing course
$(document).on('click','#add-course-to-wishlist',function(e){
    e.preventDefault();
    var courseId  = $("#courseId").val();
    var courseLvl = $("#initLvl").val();

    $.ajax({
      url: baseUrl+"course/addCourseWishlist",
      method: 'post',
      data: {courseId:courseId,courseLvl:courseLvl},
      beforeSend: function() {
         $('.overlayer').fadeIn();
      }
    })
    .done(function(responseData) {
        var data = JSON.parse(responseData);
        $('.overlayer').fadeOut();
        //console.log(data);
        if(data.check == 'success'){
            //Displaying success message to student 
            alert_func([data.msg, "success", "#A5DC86"]);
            $('#add-course-to-wishlist').html('<i class="far fa-check-circle"></i>&nbsp;Wishlisted').attr('disabled',true);
        }else{
            //Displaying success message to student 
            alert_func([data.msg, "error", "#DD6B55"]);
            $('#add-course-to-wishlist').html('<i class="far fa-shopping-cart"></i>&nbsp;Add to Wishlist').attr('disabled',false); 
        }
    })
    .fail(function(data) {
       //console.log(data);
    });


});    



