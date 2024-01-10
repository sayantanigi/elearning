   
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
