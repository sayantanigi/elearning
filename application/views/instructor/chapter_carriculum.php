<?php
   /*print"<pre>";
   print_r($mediaFiles);
   print"</pre>";exit;*/
?>
<div class="dashboard-content">
    <div class="container">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('instructor/chapters/'.$subjectId)?>"><?=$subjectDetail->subjectName?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?=$chapterDetail->chapterName?></li>
          </ol>
        </nav>

        <div class="row m-1">

            <div class="card shadow curriculum-row mb-4 d-none" id="dropZoneDiv">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-9 d-flex"><h6 class="title my-auto"><?=$title?></h6></div>
                        <div class="col-md-3 right-side"><div class="dashboard-table__text cancelled dropzone_display" data-dtype="hide"><a href="#uploadedCurriculumMedia"><i class="fa fa-times"></i>&nbsp;Close Upload Section</a></div></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="control-label">Upload Chapter Curriculum</label>
                            <div id="postDropzone" class="postDropzone">
                                <div class="dropzone-file-area">
                                    <input type="hidden" id="subjectId" name="subjectId" value="<?php echo ($subjectId)?$subjectId:''?>">
                                    <input type="hidden" id="chapterId" name="chapterId" value="<?php echo ($chapterId)?$chapterId:''?>">
                                    <div class="dz-message" data-dz-message><span><h3 class='title'>Drop files here or click to upload screenshot</h3><p class='text'> You have to upload the screenshot for your software to satisfy the customers </p></span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow curriculum-row">
              <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-6 d-flex"><h6 class="title my-auto">Chapter Summary</h6></div>
                    </div>
               </div>
               <div class="card-body">
                 <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3">
                       <img src="<?=base_url('uploads/chapter/'.$chapterDetail->chapterImage)?>" alt="<?=$chapterDetail->chapterName?>">
                    </div>  
                    <div class="col-lg-9 col-md-9 col-sm-9">
                      <?=strip_tags(htmlspecialchars_decode($chapterDetail->summary))?>
                    </div>  
                  </div>  
               </div>
             </div>  

            <div class="card shadow curriculum-row mt-4">
               <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-6 d-flex"><h6 class="title my-auto">Chapter Objectives</h6></div>
                    </div>
               </div>
               <div class="card-body">
                   <?=strip_tags(htmlspecialchars_decode($chapterDetail->summary))?>
               </div>
            </div> 

            <div class="card shadow curriculum-row mt-4" id="uploadedCurriculumMedia">
               <div class="card-header py-3">
                    <div class="row">
                        <div class="col-md-9 d-flex"><h6 class="title my-auto">Curriculum Media</h6></div>
                        <div class="col-md-3 right-side"><div class="dashboard-table__text completed dropzone_display" data-dtype="show"><a href="javascript:void(0);"><i class="fa fa-upload"></i>&nbsp;Upload Curriculum Media</a></div></div>
                    </div>
               </div>
                <div class="card-body" id="mediaContainer">
                     
                </div>
            </div>
         
        </div>
    </div>
</div>

<script>
  var subjectId = $("#subjectId").val();
  var chapterId = $("#chapterId").val();
  var fileCount,countUpload = 0;   

  //Fetch chapter curriculum from controller
  function loadCurriculumMedia(subjectId,chapterId,loadType="internal"){
     // POST to server using $.post or $.ajax
     $.ajax({
        method: 'POST',
        url: baseUrl+'instructor/loadAjaxChapterCurriculum/'+subjectId+'/'+chapterId+'/html',
         beforeSend: function() {
            //$("#curriculum_loader").removeClass('d-none');
         },
         success:function(curriculumHTML){
            var parsedHTML = JSON.parse(curriculumHTML);
            $("#mediaContainer").html(parsedHTML);
            setTimeout(function(){
                //$("#curriculum_loader").addClass('d-none');
                if(loadType == "internal"){
                     $('html, body').animate({
                        scrollTop: $("#uploadedCurriculumMedia").offset().top
                     }, 500);
                }     
            },1000);
         }
      });
   } 
         
   $(document).ready(function(){

      loadCurriculumMedia(subjectId,chapterId,"pageOnLoad");

      $("#curriculum_upload").on("change",function(){
          fileCount = $(this)[0].files.length;
      });

      $(".dropzone_display").on("click",function(){
           var displayType = $(this).data('dtype');

           if(displayType == "show"){
              $("#dropZoneDiv").removeClass("d-none");
                $('html, body').animate({
                    scrollTop: $("#dropZoneDiv").offset().top
                }, 500);
           }else{
              $("#dropZoneDiv").addClass("d-none");
           }
           
      });

      var dZUpload = $('#postDropzone').dropzone({
        url: baseUrl+'instructor/uploadChapterCurriculum',
        params: {subjectId:subjectId,chapterId:chapterId},
        addRemoveLinks: true,
        dictResponseError: 'Error uploading file!',
        dictDefaultMessage: "<h3 class='title'>Drop files here or click to upload file</h3><p class='text'> You have to upload the screenshot for your software to satisfy the customers </p>",
        acceptedFiles: ".jpeg,.jpg,.png,.mp4,.mp3,.pdf,.doc,.docx,.csv,.xls,.ppt,.pptx",
        success: function (file, response) {
          var data = jQuery.parseJSON( response );
          file.id = data.media_id;
          
          if(data.check == "success"){
             alert_func([data.msg, "success", "#A5DC86"]);
             loadCurriculumMedia(subjectId,chapterId);
             return true;
          }else{
             alert_func([data.msg, "error", "#DD6B55"]);
             return false;
          }  
        },
        init: function(){
           //console.log('dropzone initialized!'); 
           /*thisDropzone = this;  

           $.get(baseUrl+'instructor/loadAjaxChapterCurriculum/'+subjectId+'/'+chapterId+'/rawData',function (data){
                if(data == null){
                  return;
                }
                
                $.each(JSON.parse(data), function (key, value){
                  var mockFile = { name:value.mediaOgName, size: value.fileSize,type:value.mediaType,id:value.mediaId };

                  thisDropzone.emit("addedfile", mockFile);
                  thisDropzone.options.thumbnail.call(thisDropzone, mockFile, baseUrl+'uploads/chapter_curriculum/'+value.mediaFile);

                  thisDropzone.emit("complete", mockFile);
                });
          });*/

          this.on("removedfile", function(file){
            $.ajax({
              type: 'POST',
              url: baseUrl+'instructor/deleteCurriculumContent',
              data: {mediaId: file.id,subjectId:subjectId,chapterId:chapterId},
              dataType: 'html',
              success: function(data){
                var rep = JSON.parse(data);
                if(rep.check == "success"){
                   alert_func([rep.msg, "success", "#A5DC86"]);
                   //Rest dropzone
                   dZUpload[0].dropzone.removeAllFiles();  
                   //Refreshing curriculum media div
                   loadCurriculumMedia(subjectId,chapterId);
                }else{
                   alert_func([rep.msg, "error", "#DD6B55"]); 
                }
              }
            });
          });
        }
      });

      $('#mediaContainer').sortable({
         handle: ".draggable",
         update: function (event, ui) {
            var data = $(this).sortable('serialize');

            // POST to server using $.post or $.ajax
            $.ajax({
                data: data,
                method: 'POST',
                url: baseUrl+'instructor/saveChaptercurriculumOrder/'+subjectId+'/'+chapterId,
                 beforeSend: function() {
                    //Display loader
                    //$("#curriculum_loader").removeClass('d-none');
                 },
                 success:function(responseData){
                    var data = JSON.parse(responseData);
                    //console.log(data);
                    if(data.check == "success"){
                        //Load curriculum data 
                        //$("#curriculum_loader").addClass('d-none');
                        loadCurriculumMedia(subjectId,chapterId);
                        alert_func([data.msg, "success", "#A5DC86"]);
                    }else{
                        alert_func([data.msg, "error", "#DD6B55"]); 
                    }
                 }
            });
          }
      });

      //Delete curriculum content
      $(document).on('click','.delete_curriculum_content',function(e){
          e.preventDefault();
          var mediaId = $(this).data('mid');
          var formData = {mediaId:mediaId,subjectId:subjectId,chapterId:chapterId};

          swal({
            title: 'Are You sure want to delete this items?',
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
                     url:baseUrl+'instructor/deleteCurriculumContent',
                     method:'POST',
                     data: formData,
                      beforeSend: function() {
                         //Display loader
                        //$("#curriculum_loader").removeClass('d-none');
                      },
                      success:function(responseData){
                         var data = JSON.parse(responseData);
                         //console.log(data);
                         if(data.check == "success"){
                            //Load curriculum data 
                            //$("#curriculum_loader").addClass('d-none');
                            //Rest dropzone
                            dZUpload[0].dropzone.removeAllFiles();  
                            //Refreshing curriculum media div
                            loadCurriculumMedia(subjectId,chapterId);
                            alert_func([data.msg, "success", "#A5DC86"]);
                         }else{
                            alert_func([data.msg, "error", "#DD6B55"]); 
                         }
                      }
                  });
               }
           });       
       });
  });
</script>    
