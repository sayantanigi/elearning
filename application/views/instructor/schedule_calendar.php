<style>
    .fc-list-event-time {
      display:none;
    }
</style>    
<div class="dashboard-content">
    <div class="container">
        <h4 class="dashboard-title"><?=$title?></h4>
            <h5 style="text-align: center; margin: 20px 0;font-family:'Mada',sans-serif;font-weight:500;" >All timings are accoding to the Eastern Time Zone. U.S.A.</h5>

            <div class="row">

                <!-- Profile Sidebar -->
                
                <!-- / Profile Sidebar -->

                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        
                        <div class="overlayer" style="display: none;">
                           <div class="spinner"></div>
                        </div>

                        <div class="card-header">
                            <h4>Scheldule Calender</h4>
                        </div>
                        <div class="card-body pt-0">
                            <div class="fc-overflow">
                                <div id="calendar" class="mt-4 mb-4"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div> 
       
        </div>
        <a id="back-to-top" href="#" class="btn btn-secondary btn-sm back-to-top" role="button"><i class="fa fa-chevron-up"></i></a>
        </div>
        <!-- Page Header -->
        <!-- /Page Header -->
    </div>
</div>


<script>
  
  var eventUrl = baseUrl+'instructor/fetchschedule/current';

  document.addEventListener('DOMContentLoaded', function() {
      var TodayDate = new Date();
      renderCalendar(TodayDate,false);
  });

</script>



