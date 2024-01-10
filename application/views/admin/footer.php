	<input type="hidden" id="baseUrl" value="<?= base_url() ?>">
	<input type="hidden" id="adminUrl" value="<?= admin_url() ?>">
        <div class="footer">
            <div class="copyright">
                <p>Copyright &copy; Designed &amp; Developed by <a href="http://goigi.com/" target="_blank">GOIGI</a></p>
            </div>
        </div>
    </div>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script src="<?= base_url('backend/vendor/global/global.min.js') ?>"></script>
<script src="<?= base_url('backend/vendor/chart/chart.bundle.min.js') ?>"></script>
<script src="<?= base_url('backend/js/custom.min.js') ?>"></script>
<script src="<?= base_url('backend/js/deznav-init.js') ?>"></script>
<script src="<?= base_url('backend/vendor/owl-carousel/owl.carousel.js') ?>"></script>
<script src="<?= base_url('backend/js/sweetalert/sweetalert.min.js') ?>"></script>
<script src="<?= base_url('backend/js/sweetalert/jquery.sweet-alert.custom.js') ?>"></script>
<script src="<?= base_url('backend/vendor/peity/jquery.peity.min.js') ?>"></script>
<script src="<?= base_url('backend/js/dashboard/dashboard-1.js') ?>"></script>
<script src="<?= base_url('backend/vendor/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('backend/js/plugins-init/datatables.init.js') ?>"></script>   
<script src="<?= base_url('backend/vendor/summernote/js/summernote.min.js') ?>"></script>
<script src="<?= base_url('backend/js/plugins-init/summernote-init.js') ?>"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/4.0.0/js/jasny-bootstrap.min.js"></script>

<script src="<?= base_url('backend/js/jquery.validate.min.js') ?>"></script>

<script src="<?= base_url('backend/js/form-validation.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script src="<?= base_url('plugins/switchery/dist/switchery.min.js')?>"></script>

<?php if(in_array($subpage, array('instructoradd','instructoredit'))){ ?>
    <script src="<?= base_url('plugins/intelInput/intlTelInput.js');?>"></script>
<?php } ?>    

<?php if($page == "chaptercurriculum"){ ?>

    <!-----JQUERY UI JS------>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--End Here-->

    <!-- Jquery File Uploader JS -->
    <script src="<?= base_url('backend/vendor/bootstrap-uploader/js/plugins/buffer.min.js') ?>"></script>
    <script src="<?= base_url('backend/vendor/bootstrap-uploader/js/plugins/filetype.min.js') ?>"></script>
    <script src="<?= base_url('backend/vendor/bootstrap-uploader/js/plugins/piexif.min.js') ?>"></script>
    <script src="<?= base_url('backend/vendor/bootstrap-uploader/js/plugins/sortable.min.js') ?>"></script>

    <script src="<?= base_url('backend/vendor/bootstrap-uploader/js/fileinput.js') ?>"></script>
    <script src="<?= base_url('backend/vendor/bootstrap-uploader/js/locales/fr.js') ?>"></script>
    <script src="<?= base_url('backend/vendor/bootstrap-uploader/js/locales/es.js') ?>"></script>

    <script src="<?= base_url('backend/vendor/bootstrap-uploader/themes/fa5/theme.js') ?>"></script>
    <script src="<?= base_url('backend/vendor/bootstrap-uploader/themes/explorer-fa5/theme.js') ?>"></script>
    <!--End Here-->

    <!-- Jquery File Uploader JS -->
    <script src="<?= base_url('backend/vendor/jquery-lightbox/js/jquery.fancybox.js') ?>"></script>
    <!--End Here-->

<?php } ?>        

<!-----SCHEDULE JS------>
  
  <script src="<?=base_url('frontend/js/plugins/jquery-ui.js')?>"></script>
  <script src="<?=base_url('frontend/js/plugins/timepicker.min.js')?>"></script> 

  <script src="<?= base_url('frontend/js/plugins/fullcalendar.js');?>"></script>

  <script src="<?= base_url('dist/js/script.js?v=').time() ?>"></script>

<!----END HERE--->  

<?php if(in_array($subpage, array('instructoradd','instructoredit'))){ ?>
   <script>
      var input = document.querySelector("#mobile");

      var iti = window.intlTelInput(input, {
         initialCountry: "us",
         preferredCountries: ['us', 'tr'],
         separateDialCode: false,
         utilsScript: baseUrl+"plugins/intelInput/utils.js",
      });
      
      //Getting initial selected country data
      var countryData = iti.getSelectedCountryData();
      
      $("#ccName").val(countryData.iso2);
      $("#ccCode").val(countryData.dialCode);

      input.addEventListener("countrychange", function() {
         // do something with iti.getSelectedCountryData()
         var countryData = iti.getSelectedCountryData();
        
         $("#ccName").val(countryData.iso2);
         $("#ccCode").val(countryData.dialCode);
      });
  </script>
<?php } ?>
    
  <script type="text/javascript">
   
   var validator;
    
   $(".js-select2").select2({
      closeOnSelect : false,
      placeholder : "Placeholder",
      // allowHtml: true,
      allowClear: true,
      tags: true // создает новые опции на лету
    });

  //Defining and Initializing course level default value
  //var courseLvlCount = 1;

  //Defining and Initializing course level
  //var previous_course_lvl;
  //var  courseLvl= [];

  $(function () {
      $('[data-toggle="tooltip2"]').tooltip();
  });

  $('#add-more-image').on('click', function(event) 
    {
      event.preventDefault();
      $('#image-group').append('<div class="fileinput fileinput-new" data-provides="fileinput"><div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"><img src="'+baseUrl+'uploads/noimg.png" alt=""></div><div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"></div><div><span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="images[]" accept="images/*" required=""></span><a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a><span class="btn btn-danger delete-image-input">&times;</span></div></div>');
    });

    function alert_func(data) 
    {
     swal({title: data[0], type: data[1], confirmButtonColor: data[2]});
     
    }
    function confirm_yes(msg, ptype, okclose, btn, colors) 
    {
      if (typeof btn === "undefined" || btn === null) { 
        btn = ['Yes','No']; 
      }
      if (typeof colors === "undefined" || colors === null) { 
        colors = ['#A5DC86','#DD6B55']; 
      }
      if (typeof okclose === "undefined" || okclose === null) { 
        okclose = false; 
      } else {
        okclose = true; 
      }
      swal({
        title: msg,
        type: ptype,
        showCancelButton: true,
        confirmButtonColor: colors[0],
        cancelButtonColor: colors[1],
        confirmButtonText: btn[0],
        cancelButtonText: btn[1],
        closeOnConfirm: okclose,
        closeOnCancel: true
      }, function(isConfirm){
        if (isConfirm) {
          return true;
        } else {
          return false
        }
      });
    }
  </script>
  <?php if (!empty($this->session->flashdata('msg'))): ?>
    <?php if ($this->session->flashdata('msg') == 'error') { ?>
      <script>
        alert_func(["Some error occured, Please try again!", "error", "#DD6B55"]);  
      </script>
    <?php } else { ?>
      <script>
        alert_func(<?= $this->session->flashdata('msg') ?>);
      </script>
    <?php } ?>
  <?php endif ?>

  <script type="text/javascript">   

    function changeUserStatus(userId, thisSwitch) 
    {
      var newStatus;

      if (thisSwitch.val() == 1) 
      {
        thisSwitch.val('0');
        newStatus = '0';
      } else {
        thisSwitch.val('1');
        newStatus = '1';

      }

      $.ajax({
        url: adminUrl+'users/changeStatus',
        type: 'POST',
        dataType: 'json',
        data: {
          userId: String(userId),
          status: String(newStatus)
        },

      })
      .done(function(data) {
        alert_func(data);
      })

      .fail(function(data) {
        console.log(data);
      }); 

    }

    function changePackageStatus(package_id, thisSwitch) 
    {
      var newStatus;

      if (thisSwitch.val() == 1) 
      {
        thisSwitch.val('0');
        newStatus = '0';
      } else {
        thisSwitch.val('1');
        newStatus = '1';

      }

      $.ajax({
        url: adminUrl+'package/changeStatus',
        type: 'POST',
        dataType: 'json',
        data: {
          packageId: String(package_id),
          status: String(newStatus)
        },

      })
      .done(function(data) {
        alert_func(data);
      })

      .fail(function(data) {
        console.log(data);
      }); 

    }  

    function changeSubjectStatus(subjectId, thisSwitch) 
    {
      var newStatus;

      if (thisSwitch == '1') 
      {       
        newStatus = '0';
      } else {        
        newStatus = '1';

      }
      $.ajax({
        url: adminUrl+'subject/changeStatus',
        type: 'POST',
        dataType: 'json',
        data: {
          subjectId: String(subjectId),
          status: String(newStatus)
        },

      })
      .done(function(data) {
        alert_func(data);
        window.location.reload();
      })

      .fail(function(data) {
        console.log(data);
      }); 

    }

    function changeChapterStatus(cId, thisSwitch) 
    {
      var newStatus;

      if (thisSwitch == '1') 
      {       
        newStatus = '0';
      } else {        
        newStatus = '1';

      }

      $.ajax({
        url: adminUrl+'subject/changeChapterStatus',
        type: 'POST',
        dataType: 'json',
        data: {
          chapterId: String(cId),
          status: String(newStatus)
        },

      })
      .done(function(data) {
        alert_func(data);
        window.location.reload();
      })

      .fail(function(data) {
        console.log(data);
      }); 

    }

     function changeLessonStatus(cId, thisSwitch) 
    {
      var newStatus;

      if (thisSwitch == '1') 
      {       
        newStatus = '0';
      } else {        
        newStatus = '1';

      }

      $.ajax({
        url: adminUrl+'subject/changeLessonStatus',
        type: 'POST',
        dataType: 'json',
        data: {
          chapterId: String(cId),
          status: String(newStatus)
        },

      })
      .done(function(data) {
        alert_func(data);
        window.location.reload();
      })

      .fail(function(data) {
        console.log(data);
      }); 

    }

    function changeTestStatus(cId, thisSwitch) 
    {
      var newStatus;

      if (thisSwitch == '1') 
      {       
        newStatus = '0';
      } else {        
        newStatus = '1';

      }

      $.ajax({
        url: adminUrl+'subject/changeTestStatus',
        type: 'POST',
        dataType: 'json',
        data: {
          testId: String(cId),
          status: String(newStatus)
        },

      })
      .done(function(data) {
        alert_func(data);
        window.location.reload();
      })

      .fail(function(data) {
        console.log(data);
      }); 

    }

    function changeQuizStatus(cId, thisSwitch) 
    {
      var newStatus;

      if (thisSwitch == '1') 
      {       
        newStatus = '0';
      } else {        
        newStatus = '1';

      }

      $.ajax({
        url: adminUrl+'subject/changeQuizStatus',
        type: 'POST',
        dataType: 'json',
        data: {
          quizId: String(cId),
          status: String(newStatus)
        },

      })
      .done(function(data) {
        alert_func(data);
        window.location.reload();
      })

      .fail(function(data) {
        console.log(data);
      }); 

    }



    function cloneSubject(subjectId)
    {
      $.ajax({
        url: adminUrl+'subject/cloneSubject',
        type: 'POST',
        dataType: 'json',
        data: {
          subjectId: String(subjectId),
        },

      })
      .done(function(data) {
        alert_func(data);
        window.location.reload();
      })

      .fail(function(data) {
        console.log(data);
      });

    }

    function cloneChapter(chapterId)
    {
      $.ajax({
        url: adminUrl+'subject/cloneChapter',
        type: 'POST',
        dataType: 'json',
        data: {
          chapterId: String(chapterId),
        },

      })
      .done(function(data) {
        alert_func(data);
        window.location.reload();
      })

      .fail(function(data) {
        console.log(data);
      });

    }

    function cloneLesson(LessonId)
    {
      $.ajax({
        url: adminUrl+'subject/cloneLesson',
        type: 'POST',
        dataType: 'json',
        data: {
          LessonId: String(LessonId),
        },

      })
      .done(function(data) {
        alert_func(data);
        window.location.reload();
      })

      .fail(function(data) {
        console.log(data);
      });

    }

     function cloneTest(testId)
    {
      $.ajax({
        url: adminUrl+'subject/cloneTest',
        type: 'POST',
        dataType: 'json',
        data: {
          testId: String(testId),
        },

      })
      .done(function(data) {
        alert_func(data);
        window.location.reload();
      })

      .fail(function(data) {
        console.log(data);
      });

    }

     function cloneQuiz(quizId)
    {
      $.ajax({
        url: adminUrl+'subject/cloneQuiz',
        type: 'POST',
        dataType: 'json',
        data: {
          quizId: String(quizId),
        },

      })
      .done(function(data) {
        alert_func(data);
        window.location.reload();
      })

      .fail(function(data) {
        console.log(data);
      });

    }

   

    $(document).ready(function(){
      $('.slectview li a').click(function(){
        var tab_id = $(this).attr('data-tab');

        $('.slectview li a').removeClass('active');
        $('.tab-view').removeClass('active');

        $(this).addClass('active');
        $("#"+tab_id).addClass('active');
      })

    });
  </script> 

<script>

  $('#answer0').attr('required', 'required');
  $('#correctans0').attr('required', 'required');

    $('#add-answer-field').on('click', function(event) 
    {
      event.preventDefault();

      var totalAns = $('#answer-group .form-group:last-child').attr('id');
      totalAns = parseInt(parseInt(totalAns)+1);
      $('#answer-group').append('<div class="form-group row" id="'+totalAns+'"><label class="col-sm-3">Option '+(totalAns+1)+' : <span>*</span></label><div class="col-sm-6"><input type="text" class="form-control" name="answer[]" id="answer'+totalAns+'" onkeyup="setValue($(this))" data-row-id="'+totalAns+'"></div><div class="col-sm-3"><div class="form-inline mt-2"> <input type="radio" name="correctans" class="mr-2" id="correctans'+totalAns+'" value="1" > Correct Answer <button type="button" class="btn btn-danger btn-xs ml-2 m-t-10 remove-answer btn-rounded"><i class="fa fa-times"></i> </button></div></div></div></div>');
        console.log(totalAns);
    });

    $(document).on('click', '.remove-answer', function(event) 
    {
      event.preventDefault();
      $(this).closest('div.form-group').remove();
      console.log('');
    });

    function setValue(thisInput) {

      var id = String(thisInput.data('row-id'));
      var thisVal = thisInput.val().trim();
      $('#correctans'+id).val(thisVal);
    }

    function validate()
    {
      var marks = $("#marks").val().trim();
      if (isNaN(marks)){
        alert("Marks is not valid");
        return false;
      } else {
        return true;
      }
    }
</script>

<script>
  $('#changeProfilePic').change(function()
  {
    startUpload();
  });


//logo upload
 function startUpload() 
 {   
    var file_name = $("#changeProfilePic").val();
    var index_dot=file_name.lastIndexOf(".")+1;
   
    var ext=file_name.substr(index_dot);

        if(file_name=='') {
            alert('Please upload image');
        }
        else if(!(ext=='png' || ext=='jpg' || ext=='jpeg')) 
        {
            alert('Please upload jpg or png image only');
        }   //Image validation end
        else {
            var formData = new FormData();
            formData.append('fileupload',$('#changeProfilePic')[0].files[0], file_name);
            $.ajax({
                url: '<?php echo admin_url('settings/companyImage')?>',
                data: formData,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data)
                {
                    $('.msgAlert').html(data);
                    location.reload();
                }
            });
 }       
}

//remove logo
$(".remBtn").click(function(){
  window.location = "<?=admin_url();?>settings/removeLogo";
});

var m_sub= '';
var m_active ='';
const memberSub = $('.member');
memberSub.on('change', function() {
var member = $(this).attr('member');
let m_sub = $(this).is(':checked') ? 1 : 0;
  $.ajax({
    url: "<?php echo admin_url('settings/notificationsStatus');?>",
    method: "POST",
    data: {
      member:member,
      mem_val: m_sub,
    },
    success: function(data) 
    {
      ///console.log(data);
    }
  });

});

</script>

</body>

</html>