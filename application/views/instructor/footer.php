<?php $settings = $this->mymodel->get('settings', true, 'settingId', '1'); ?>
<div class="footer-section footer-bg-1">
    <div class="footer-widget-area section-padding-01">
        <div class="container">
            <div class="row gy-6">                
                <div class="col-lg-12">
                    <div class="footer-widget text-center">                      
                        <p class="footer-widget__copyright">&copy;  <?=date('Y')?> <span> <?=$settings->title?> </span> Made by <a href="https://www.goigi.com" target="_blank">GOIGI</a></p>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?=base_url('frontend/js/vendor/modernizr-3.11.7.min.js')?>"></script>

<script src="<?=base_url('frontend/js/vendor/jquery-migrate-3.3.2.min.js')?>"></script>
<script src="<?=base_url('frontend/js/vendor/bootstrap.bundle.min.js')?>"></script>

<script src="<?=base_url('frontend/js/plugins/aos.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/parallax.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/swiper-bundle.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/perfect-scrollbar.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/jquery.powertip.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/nice-select.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/glightbox.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/jquery.sticky-kit.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/imagesloaded.pkgd.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/masonry.pkgd.min.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/flatpickr.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/range-slider.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/select2.min.js')?>"></script>
<script src="<?= base_url('plugins/sweetalert/sweetalert.min.js');?>"></script>

<script src="<?= base_url('frontend/js/plugins/toastr.min.js');?>"></script>

<!-----JQUERY UI JS------>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!--End Here-->

<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" type="text/javascript"></script>

<script type="text/javascript">
   function googleTranslateElementInit() {
        new google.translate.TranslateElement(
            {pageLanguage: 'en'},
            'google_translate_element'
        );
    }
</script>

<?php if($page == "profilesetting"){ ?>
    <script src="<?= base_url('plugins/intelInput/intlTelInput.js');?>"></script>
<?php } ?>    

<script src="<?= base_url('backend/js/jquery.validate.min.js') ?>"></script>

<script src="<?=base_url('frontend/js/plugins/jquery-ui.js')?>"></script>
<script src="<?=base_url('frontend/js/plugins/timepicker.min.js')?>"></script>

<script async src="https://static.addtoany.com/menu/page.js"></script> 

<script src="<?= base_url('frontend/js/plugins/fullcalendar.js');?>"></script>

<!-- Additional Admin JS -->

<script src="<?= base_url('backend/vendor/datatables/js/jquery.dataTables.min.js') ?>"></script>
<script src="https://cdn.tiny.cloud/1/qidech0ze58locstwrtmqsrw9oaou4afpejvulmcdr91ahnf/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<!--End Here-->

<!-- Jquery Lightbox Gallery JS -->
<script src="<?= base_url('backend/vendor/jquery-lightbox/js/jquery.fancybox.js') ?>"></script>
<!--End Here-->

<!-- DROPZONE JS -->
<script src="<?= base_url('plugins/dropzone/dropzone.min.js');?>"></script>
<!--End Here-->

<script src="<?=base_url('frontend/js/main.js')?>"></script>

<script src="<?=base_url('frontend/js/instructor_script.js')?>"></script>
</body>
</html>

<div class="modal fade" id="rewquestModal">
    <div class="modal-dialog modal-dialog-centered modal-login">
        <div class="modal-wrapper">
            <button type="button" class="modal-close btn-close" data-bs-dismiss="modal"><i class="fal fa-times"></i></button>               
            <div class="modal-content model_req">
                <div class="modal-header">
                    <h5 class="modal-title">Request for Approval</h5>
                    <p class="modal-description">Without approval not able to Add New Course</p>
                </div>
                <div class="modal-body">
                    <form action="#">
                        <div id="alert-msg"></div>
                        <div class="modal-form">
                            <label class="form-label">Subject</label>
                            <input type="text"  name="subject"  class="form-control" placeholder="Your email">
                        </div>
                        <div class="modal-form">
                            <label class="form-label">Request Details</label>
                            <textarea name="" class="form-control"></textarea>
                        </div>
                        
                        <div class="modal-form">
                            <button type="button" id="reqSent" class="btn btn-primary btn-hover-secondary w-100">Send  Request</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

<script>
    var pageName = $("#pageName").val();

    if(pageName == "profilesetting"){
        var input = document.querySelector("#phone");

        var iti = window.intlTelInput(input, {
          // allowDropdown: false,
          // autoHideDialCode: false,
          // autoPlaceholder: "off",
          // dropdownContainer: document.body,
          // excludeCountries: ["us"],
          // formatOnDisplay: false,
          // geoIpLookup: function(callback) {
          //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
          //     var countryCode = (resp && resp.country) ? resp.country : "";
          //     callback(countryCode);
          //   });
          // },
          // hiddenInput: "full_number",
           initialCountry: "us",
          // localizedCountries: { 'de': 'Deutschland' },
          // nationalMode: false,
          // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
          // placeholderNumberType: "MOBILE",
           preferredCountries: ['us', 'tr'],
           separateDialCode: false,
           //hiddenInput: "full_phone",
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
