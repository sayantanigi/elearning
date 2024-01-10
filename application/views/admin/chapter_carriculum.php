<?php
    /*print"<pre>";
    print_r($imageFiles);
    print"</pre>";exit;*/
?> 
    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)"><?=$title?></a></li>
                </ol>
            </div>
            <!-- row -->
            <div class="row">   
                 <input type="hidden" id="subjectId" value="<?=$subjectId?>">
                <input type="hidden" id="chapterId" value="<?=$chapterId?>">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"> <?=$title?> </h4>
                        </div>
                        <div class="card-body">
                            
                            <input type="file" id="curriculum_upload" name="chapterCurriculumFile" multiple>
                            <!-- <hr>
                            <div class="form-group">
                                <button class="btn btn-disable btn-primary" type="button">Disable Test</button>
                                <button class="btn btn-danger btn-destroy" type="reset">Destroy</button>
                                <button class="btn btn-success btn-recreate">Recreate</button>
                                <button class="btn btn-info btn-refresh" type="reset">Refresh</button>
                                <button class="btn btn-outline-secondary btn-clear" type="button">Clear</button>
                            </div> -->

                        </div>
                    </div>

                    <div class="card" id="uploaded_curriculum_media">
                        <div class="card-header">
                            <h4 class="card-title">curriculum Media</h4>
                        </div>
                        <div id="curriculum_loader" class="show d-none"></div>
                        <div class="card-body" id="sortable">
                             <?php 
                                if(count($mediaFiles)>0){
                                  foreach($mediaFiles as $key => $media){ 
                                    $mediaPath = base_url('uploads/chapter_curriculum/'.$media->mediaFile);
                             ?>      
                                <div class="preview-image-curriculum image-container-frame" id='curriculum_<?=$media->mediaId?>'>
                                   
                                   <?php if($media->mediaType == "image"){ ?>  
                                        <div class="curriculum-content">
                                           <a href="<?=$mediaPath?>" data-fancybox="gallery" data-caption="curriculum_image">  
                                             <img alt="image" src="<?=$mediaPath?>" class="curriculum-main" title="curriculum_image" alt="curriculum_image">
                                           </a>  
                                        </div>
                                        <div class="file-footer-caption" title="<?=$media->mediaOgName?>">
                                            <div class="file-caption-info"><?=$media->mediaOgName?></div>
                                        </div>
                                    <?php } ?>    

                                    <?php if($media->mediaType == "video"){ ?>  
                                         <div class="curriculum-content">
                                            <a href="<?=$mediaPath?>" data-fancybox="gallery" data-caption="curriculum_image">
                                                <video class="curriculum-main" controls>
                                                  <source src="<?=$mediaPath?>" type="video/mp4">
                                                </video>
                                            </a>    
                                         </div>
                                          <div class="file-footer-caption" title="<?=$media->mediaOgName?>">
                                            <div class="file-caption-info"><?=$media->mediaOgName?></div>
                                        </div>
                                    <?php } ?> 

                                    <?php if($media->mediaType == "audio"){ ?>  
                                        <div class="curriculum-content">
                                            <div class="curriculum-audio-content">
                                              <i class="fas fa-file-audio-o" area-hidden="true"></i>
                                              <audio class="curriculum-audio-main" controls>
                                              <source src="<?=$mediaPath?>" type="audio/mpeg">
                                            </div>
                                        </div>
                                        <div class="file-footer-caption" title="<?=$media->mediaOgName?>">
                                            <div class="file-caption-info"><?=$media->mediaOgName?></div>
                                        </div>
                                    <?php } ?>    

                                    <?php if($media->mediaType == "document"){ ?>  
                                        <div class="curriculum-content">
                                            <div class="curriculum-doc-content">
                                                <i class="fas fa-file" area-hidden="true"></i>
                                            </div>
                                        </div>
                                         <div class="file-footer-caption" title="<?=$media->mediaOgName?>">
                                            <div class="file-caption-info"><?=$media->mediaOgName?></div>
                                        </div>
                                    <?php } ?> 

                                    <div class="curriculum-icons">
                                        <a href="<?=$mediaPath?>" download><i class="fas fa-download"></i></a>
                                         <!--<a href="<?=$mediaPath?>" data-fancybox="gallery" data-caption="curriculum_image">
                                             <i class="fas fa-search-plus"></i>
                                         </a>-->
                                         <a href="javascript:void(0);" class="delete_curriculum_content" data-mid="<?=$media->mediaId?>"><i class="fas fa-trash-alt"></i></a>
                                         
                                         <span class="file-drag-handle drag-handle-init text-primary draggable" title="Move / Rearrange"><i class="fas fa-arrows-alt"></i></span>
                                    </div>
                                </div>
                            <?php } }else{ ?> 
                                <div class="form-group text-center">
                                    No media file is uploaded at this moment!
                                </div> 
                            <?php } ?>    
                        </div>
                    </div>
                    <!--<div class="form-group">  
                        <button type="button" class="btn btn-success" onclick="loadCurriculumMedia(<?=$subjectId?>,<?=$chapterId?>)">Fetch Curriculum Media</button>
                    </div>-->  
                </div>
            </div>
        </div>  
    </div>                  

    <script>
        var pageSlug = "chapter_curriculum"; 
        var subjectId = $("#subjectId").val();
        var chapterId = $("#chapterId").val();
        var fileCount;
        var countUpload = 0;

        //Fetch chapter curriculum from controller
        function loadCurriculumMedia(subjectId,chapterId){
            // POST to server using $.post or $.ajax
            $.ajax({
                method: 'POST',
                url: adminUrl+'subject/loadAjaxChapterCurriculum/'+subjectId+'/'+chapterId,
                 beforeSend: function() {
                    $("#curriculum_loader").removeClass('d-none');
                 },
                 success:function(curriculumHTML){
                    var parsedHTML = JSON.parse(curriculumHTML);
                    $("#sortable").html(parsedHTML);
                    setTimeout(function(){
                        $("#curriculum_loader").addClass('d-none');
                    },1000);
                 }
            });
        } 

        $(document).ready(function(){

            // the file input
            $curriculumUpload = $('#curriculum_upload'), initPlugin = function() {           

                $curriculumUpload.fileinput({
                    theme: 'fa5',
                    uploadUrl: adminUrl+'subject/uploadChapterCurriculum/'+subjectId+'/'+chapterId,
                    initialPreviewAsData: true,
                    initialPreview: [],
                    initialPreviewConfig: [],
                    slugCallback: function (filename) {
                        return filename.replace('(', '_').replace(']', '_');
                    }
                });
            };    

            // initialize file upload plugin
            initPlugin();

            $("#curriculum_upload").on("change",function(){
                 fileCount = $(this)[0].files.length;
            });

            // `disable` and `enable` methods
            $(".btn-disable").on('click', function() {
                var $btn = $(this);
                if (!$curriculumUpload.data('fileinput')) {
                   initPlugin();
                }
                if ($curriculumUpload.attr('disabled')) {
                    $curriculumUpload.fileinput('enable');
                    $btn.html('Disable').removeClass('btn-primary').addClass('btn-secondary');
                } else {
                    $curriculumUpload.fileinput('disable');
                    $btn.html('Enable').removeClass('btn-secondary').addClass('btn-primary');
                }
            });
         
            // destroy method
            $(".btn-destroy").on('click', function() {
                if ($curriculumUpload.data('fileinput')) {
                    $curriculumUpload.fileinput('destroy');
                }
            });
         
            // recreate plugin after destroy
            $(".btn-recreate").on('click', function() {
                if ($curriculumUpload.data('fileinput')) {
                    return;
                }
                initPlugin();
            });
         
            // refresh plugin with new options 
            $(".btn-refresh").on('click', function() {
                if (!$curriculumUpload.data('fileinput')) {
                    // just normal init when plugin is not initialized
                    $curriculumUpload.fileinput({previewClass:'bg-info'}); 
                } else {
                    // refresh already initialized plugin with new options
                    $curriculumUpload.fileinput('refresh', {previewClass:'bg-info'});
                }
            });
            
            // clear/reset the file input
            $(".btn-clear").on('click', function() {
                $curriculumUpload.fileinput('clear');
            });

            //Jquery UI sorting handler
            //$( "#sortable" ).sortable();

             $('#sortable').sortable({
                 handle: ".draggable",
                 update: function (event, ui) {
                    var data = $(this).sortable('serialize');

                    // POST to server using $.post or $.ajax
                    $.ajax({
                        data: data,
                        method: 'POST',
                        url: adminUrl+'subject/saveChaptercurriculumOrder/'+subjectId+'/'+chapterId,
                         beforeSend: function() {
                            //Display loader
                            $("#curriculum_loader").removeClass('d-none');
                         },
                         success:function(responseData){
                            var data = JSON.parse(responseData);
                            //console.log(data);
                            if(data.check == "success"){
                                //Load curriculum data 
                                $("#curriculum_loader").addClass('d-none');
                                loadCurriculumMedia(subjectId,chapterId);
                                //alert_func([data.msg, "success", "#A5DC86"]);
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
                             url:adminUrl+'subject/deleteCurriculumContent',
                             method:'POST',
                             data: formData,
                              beforeSend: function() {
                                 //Display loader
                                $("#curriculum_loader").removeClass('d-none');
                              },
                              success:function(responseData){
                                 var data = JSON.parse(responseData);
                                 //console.log(data);
                                 if(data.check == "success"){
                                    //Load curriculum data 
                                    $("#curriculum_loader").addClass('d-none');
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