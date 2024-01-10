<style>
    .fc-list-event-time {
      display:none;
    }
</style>    
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?=admin_url('dashboard')?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('faq/lists') ?>"><?=ucwords(@$page)?></a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?= ucwords(@$title) ?></a></li>
            </ol>
        </div>
        <div class="row">   

                <!-- Profile Sidebar -->
                
                <!-- / Profile Sidebar -->

                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
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

            <div class="row mt-3 mb-4">
                <div class="col-md-12">
                    <a class="btn btn-rounded btn-secondary" href="<?= admin_url('instructors/lists') ?>">
                        Back
                    </a>

                </div>    
            </div>
       
        </div>
        <a id="back-to-top" href="#" class="btn btn-secondary btn-sm back-to-top" role="button"><i class="fa fa-chevron-up"></i></a>
        </div>
       

<script>
  
  var eventUrl = adminUrl+'instructors/fetchschedule/'+'<?=$instructorId?>';

  console.log(eventUrl);

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
      },

      customButtons: {
          prev: {
            text: 'Prev',
            click: function() {
               calendar.prev();
            }
          },
          next: {
            text: 'Next',
            click: function() {
               calendar.next();
            }
          }
       },    
      //initialDate: '2022-08-12',
      initialDate: new Date(),
      navLinks: true, // can click day/week names to navigate views
      businessHours: true, // display business hours
      editable: true,
      selectable: true,
      allDay: false,
      height: 600,
      displayEventTime : true,
      events: eventUrl,
      eventRender: function (eventInfo, element, view) {       
        element.append("<td>" + eventInfo.title + "</td>");     
      },
      dateClick: function(info) {
        //console.log('clicked on ' + info.dateStr);
      },
      eventClick: function (calEvent, jsEvent, view) {
        //alert('event clicked!');
      }
    });

    calendar.render();
  });

</script>



