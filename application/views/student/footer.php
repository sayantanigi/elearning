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

<script src="<?= base_url('plugins/intelInput/intlTelInput.js');?>"></script>

<script src="<?= base_url('frontend/js/plugins/toastr.min.js');?>"></script>

<script src="<?= base_url('frontend/js/plugins/fullcalendar.js');?>"></script>

<!-- Jquery Lightbox Gallery JS -->
<script src="<?= base_url('backend/vendor/jquery-lightbox/js/jquery.fancybox.js') ?>"></script>
<!--End Here-->

<script src="<?=base_url('frontend/js/main.js')?>"></script>
<script src="<?=base_url('frontend/js/student_script.js')?>"></script>

<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" type="text/javascript"></script>

<script type="text/javascript">
   function googleTranslateElementInit() {
        new google.translate.TranslateElement(
            {pageLanguage: 'en'},
            'google_translate_element'
        );
    }
</script>

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

</body>
</html>