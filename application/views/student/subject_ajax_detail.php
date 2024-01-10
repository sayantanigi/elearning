
 <?php 
        $subjectDetail = strip_tags(htmlspecialchars_decode($subjectDetails->summary));
        $subjectSummary = '';

        if(strlen($subjectDetail) <= 124){
           $subjectSummary = $subjectDetail;  
        }else{
           $subjectSummary .= substr($subjectDetail,0,115).'<span id="dots">...</span>';
           $subjectSummary .= '<span id="more" style="display: none;">'.substr($subjectDetail,116).'</span>';
           $subjectSummary .= '&nbsp;<a href="javascript:void(0);" id="myBtn" class="text-primary" onclick="showMoreLess()">Read more</a>';
        }   
 ?>    
        <h4 class="h6"><?=$subjectDetails->subjectName?></h4>
        <hr>
        <p><?=$subjectSummary?></p>
         
