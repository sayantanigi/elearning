<div class="dashboard-content">
    <div class="container">
        <h4 class="dashboard-title"><?=$title?></h4>
        <div class="card">
            <div class="card-body">
                <form>
                    <div>
                        <div class="row justify-content-bottom row1 mb-3">
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label>Time From</label>
                                    <input type="time" class="form-control" name="scheduleTime[0][fromTime]">
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="form-group">
                                    <label>Time To</label>
                                    <input type="time" class="form-control" name="scheduleTime[0][toTime]">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                        	<div class="col-md-12">
                                <div class="form-group text-right" style="margin-bottom:0px;">
                                    <button class="btn btn-primary btn-sm px-4" type="button" onclick="addRow()"><i class="fas fa-plus" style="font-size:16px;"></i>&nbsp;&nbsp;ADD ROW</button>
                                </div>
                            </div> 
                        </div>	
                        
                        <hr> 
                        <div class="row mb-3 mt-3 text-center">
                        	<div class="col-md-12">
                                <div><button class="btn btn-success">Submit</button></div>
                            </div> 
                        </div>	

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
           

<script>
    var k = 1;

    function addRow()
    {

        var id = 'id_' + k;
        var row = '';
        row += '';

        row += '<div class="row '+id+'"><div class="col-md-12 mb-2"><div class="form-group text-right" style="margin-bottom:0px;"><a style="color:red" ><i class="fas fa-times-circle" style="font-size:25px;" onclick="deleterow(\'' + id + '\')"></i></a></div></div></div>';

        row += '<div class="row justify-content-bottom row1 mb-3 mt-1 '+id+'"><div class="col-lg-5"><div class="form-group"><label>Time From</label>'+
               '<input type="time" class="form-control" name="scheduleTime['+k+'][fromTime]"></div></div>';

        row += '<div class="col-lg-5"><div class="form-group"><label>Time To</label>'+
               '<input type="time" class="form-control" name="scheduleTime['+k+'][toTime]"></div></div></div>';    

        //row += '<div class="row row1 '+id+'"><div class="col-md-6"><div class="form-group"><label>Time From</label><input class="form-control" id="TimeFrom1" name="TimeFrom1" placeholder="TimeFrom" required="required" type="Time" value="" /></div></div><div class="col-md-6"><div class="form-group"><label>Time To</label><input class="form-control" id="TimeTo1" name="TimeTo1" placeholder="TimeTo" required="required" type="Time" value="" /></div></div></div>';          
        
        console.log(row);
        $(".row1:last").after(row);

        k++;
    }
   
    function deleterow(id)
    {
        //$("a").next().remove(".row");

        $("." + id).remove();
        //$(this).closest("a").remove();
    }
</script>