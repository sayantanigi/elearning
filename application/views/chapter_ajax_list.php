
 <?php 
    foreach($lvlChapterList as $index => $chapter){ 
        $chapterDes = strip_tags(htmlspecialchars_decode($chapter->summary));

        $chapterDescription = '';

        if(strlen($chapterDes) <= 124){
           $chapterDescription = $chapterDes;  
        }else{
           $chapterDescription .= substr($chapterDes,0,115).'<span id="dots_'.$index.'">...</span>';
           $chapterDescription .= '<span id="more_'.$index.'" style="display: none;">'.substr($chapterDes,116).'</span>';
           $chapterDescription .= '&nbsp;<a href="javascript:void(0);" class="text-primary showMoreLess" data-state="less" data-index="'.$index.'">Read more</a>';
        }
 ?>    
    <div class="courserlistBlock">
        <h4 class="h6"><?=$chapter->chapterName?></h4>
        <p class="mb-2"><small><span class="fw-bold text-primary"><i class="far fa-clock"></i> Duration:</span> <?=$chapter->totalHours?> Hour<?=($chapter->totalHours>1?'s':'')?></small></p>
        <p class="fw-bold mb-1">About the Chapter</p>
        <p><?=$chapterDescription?></p>
    </div>
 <?php } ?>    
