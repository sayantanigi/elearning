<?php
  $currentPaymentInfoArr = unserialize($userDetails->payment_info);
  $updatedPaymentInfoArr = unserialize($userUpdationDetails->payment_info);
?>
	<div class="content-body">
		<div class="container-fluid">
			<div class="page-titles">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="<?= admin_url('dashboard')?>">Home</a></li>
					<li class="breadcrumb-item active"><a href="javascript:void(0)"><?= $title ?></a></li>
				</ol>
			</div>
			<div class="d-flex flex-wrap mb-4 row">
				<div class="col-xl-6 col-lg-6 mb-2 titleListing">
					<span class="ttiletop">
						<h6 class="text-black fs-20 font-w600 mb-1">List of Instructors</h6>
					</span>
				
				</div>
				<div class="col-xl-6 col-lg-6 mb-2 text-right">
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div id="tab-1" class="tab-view active">
					 	<h4>General Info</h4>
					 	<input type="hidden" name="userId" value="<?=$userId?>">
						<div class="memberlistTable">
							<div class="table-responsive">
								<table id="examples" class="display table-responsive-md table"> 
									<thead class="text-center">
										<tr>
											<th>#</th>
											<th>Column Name</th>
											<th>Current Data</th>
											<th>Updated Data</th>
										</tr>
									</thead>
									
									<tbody class="text-center">
										<tr>
											<td>1</td>
											<td>Profile Picture</td>											
											<td>
												<?php if(!empty($userDetails->profilePic)){ ?>
                            <img src="<?= base_url('uploads/users/'.$userDetails->profilePic) ?>" alt="user-img" class="listusericon">
                        <?php }else{ ?>
												    <td>N/A</td>
												<?php } ?>    
											</td>

											<?php if($userDetails->profilePic != $userUpdationDetails->profilePic){ ?>	
												<td>
													<?php if(!empty($userUpdationDetails->profilePic)){ ?>
                              <img src="<?= base_url('uploads/users/'.$userUpdationDetails->profilePic) ?>" alt="user-img" class="listusericon">
                          <?php } ?>     
												</td>
											<?php }else{ ?>	
												<td>N/A</td>
											<?php } ?>	
										</tr>

										<tr>
											<td>2</td>
											<td>Introduction Video</td>											
											<td>
												<?php 
													if(!empty($userDetails->intro_video)){ 
														 if(strpos($userDetails->intro_video, 'youtu')){
												?>
                            <a href="<?=$userDetails->intro_video?>" target="_blank" style="color:blue;">Watch Video</a>
                        <?php }else{ ?>
												    <a href="<?= base_url('uploads/users/'.$userDetails->intro_video) ?>" target="_blank" style="color:blue;">Watch Video</a>
												<?php } }else{ ?> 
												    N/A
												<?php } ?>     
											</td>
                      
                      <?php if($userDetails->intro_video != $userUpdationDetails->intro_video){ ?>	 
													<td>
														<?php 
															if(!empty($userUpdationDetails->intro_video)){ 
																 if(strpos($userUpdationDetails->intro_video, 'youtu')){
														?>
		                            <a href="<?=$userUpdationDetails->intro_video?>" target="_blank" style="color:blue;">Watch Video</a>
		                        <?php }else{ ?>
														    <a href="<?= base_url('uploads/users/'.$userUpdationDetails->intro_video) ?>" target="_blank" style="color:blue;">Watch Video</a>
														<?php } }else{ ?> 
														    <td>N/A</td>
														<?php } ?>     
													</td>	
											<?php }else{ ?>		
												  <td>N/A</td>
										  <?php } ?>		  
										</tr>

										<tr>
											<td>3</td>
											<td>First Name</td>											
											<td><?=$userDetails->firstName?></td>
											<?php if($userDetails->firstName != $userUpdationDetails->firstName){ ?>	
												<td><?=$userUpdationDetails->firstName?></td>
											<?php }else{ ?>
											    <td>N/A</td>
											<?php } ?>    	
										</tr>
										  
										<tr>
											<td>4</td>
											<td>Last Name</td>											
											<td><?=$userDetails->lastName?></td>
											<?php if($userDetails->lastName != $userUpdationDetails->lastName){ ?>	
												<td><?=$userUpdationDetails->lastName?></td>
											<?php }else{ ?>
											    <td>N/A</td>
											<?php } ?>  		
										</tr>

										<tr>
											<td>5</td>
											<td>Country Code</td>											
											<td><?=(!empty($userDetails->ccCode)?$userDetails->ccCode:'N/A')?></td>
											<?php if($userDetails->ccCode != $userUpdationDetails->ccCode){ ?>	
												<td><?=$userUpdationDetails->ccCode?></td>
											<?php }else{ ?>
											    <td>N/A</td>
											<?php } ?>  		
										</tr>

										<tr>
											<td>6</td>
											<td>Mobile</td>											
											<td><?=$userDetails->mobile?></td>
											<?php if($userDetails->mobile != $userUpdationDetails->mobile){ ?>	
												<td><?=$userUpdationDetails->mobile?></td>
											<?php }else{ ?>
											    <td>N/A</td>
											<?php } ?>  		
										</tr>
										 
										<tr>
											<td>7</td>
											<td>CV</td>											
											<td>
												<?php if(!empty($userDetails->cv)){ ?>
                            <a href="<?=base_url('./uploads/cv/'.$userDetails->cv)?>" style="color:blue;" download><i class="fa fa-eye"></i>&nbsp;Display Current CV</a>
                        <?php }else{ ?>
												    <td>N/A</td>
												<?php } ?>    
											</td>

											<?php if($userDetails->cv != $userUpdationDetails->cv){ ?>	
												<td>
													<?php if(!empty($userUpdationDetails->cv)){ ?>
                              <a href="<?=base_url('./uploads/cv/'.$userUpdationDetails->cv)?>" style="color:blue;" download><i class="fa fa-eye"></i>&nbsp;Display Updated CV</a>
                          <?php } ?>     
												</td>
											<?php }else{ ?>	
												<td>N/A</td>
											<?php } ?>	
										</tr>

											<tr>
											<td>8</td>
											<td>Country of Origin</td>											
											<td>
												<?=(!empty($userDetails->origin_country)?$userDetails->origin_country:'N/A')?>
											</td>
											<?php if($userDetails->origin_country != $userUpdationDetails->origin_country){ ?>	
												<td><?=$userUpdationDetails->origin_country?></td>
											<?php }else{ ?>
											    <td>N/A</td>
											<?php } ?>    	
										</tr>

										<tr>
											<td>9</td>
											<td>Timezone</td>											
											<td>
												<?=(!empty($userDetails->timezone)?$userDetails->timezone:'N/A')?>
											</td>
											<?php if($userDetails->timezone != $userUpdationDetails->timezone){ ?>	
												<td><?=$userUpdationDetails->timezone?></td>
											<?php }else{ ?>
											    <td>N/A</td>
											<?php } ?>    	
										</tr>

										<tr>
											<td>10</td>
											<td>Bio</td>											
											<td>
												   <a href="javascript:void(0);" style="color:blue;" data-toggle="tooltip" title="View Current Bio" onclick="showBio('current_bio')">
														 <i class="fa fa-eye"></i>&nbsp;Current User Bio
													</a>
													<input type="hidden" id="current_bio" value="<?=html_entity_decode($userDetails->descriptions)?>">
											</td>
											<?php if(strlen($userDetails->descriptions) != strlen($userUpdationDetails->descriptions)){ ?>	
												<td>
													<a href="javascript:void(0);" style="color:blue;" data-toggle="tooltip" title="View Updated Bio" onclick="showBio('updated_bio')">
														<i class="fa fa-eye"></i>&nbsp;Updated User Bio
													</a>
													<input type="hidden" id="updated_bio" value="<?=html_entity_decode($userUpdationDetails->descriptions)?>">
												</td>
											<?php }else{ ?>
											    <td>N/A</td>
											<?php } ?>  		
										</tr>

									</tbody>
								</table>
							</div>
						</div>
					</div>
          <h4>Payment Info</h4>
          <div class="memberlistTable">
						<div class="table-responsive">
							<table id="examples" class="display table-responsive-md table"> 
								<thead class="text-center">
									<tr>
										<th>#</th>
										<th>Column Name</th>
										<th>Current Data</th>
										<th>Updated Data</th>
									</tr>
								</thead>
								
								<tbody class="text-center">
									
									<tr>
										<td>1</td>
										<td>Bank Name</td>											
										<td><?=$currentPaymentInfoArr['bank_name']?></td>
										<?php if($currentPaymentInfoArr['bank_name'] != $updatedPaymentInfoArr['bank_name']){ ?>	
											<td><?=$updatedPaymentInfoArr['bank_name']?></td>
										<?php }else{ ?>
										    <td>N/A</td>
										<?php } ?>    	
									</tr>

									<tr>
										<td>2</td>
										<td>Bank Branch Address</td>											
										<td><?=$currentPaymentInfoArr['bank_address']?></td>
										<?php if($currentPaymentInfoArr['bank_address'] != $updatedPaymentInfoArr['bank_address']){ ?>	
											<td><?=$updatedPaymentInfoArr['bank_address']?></td>
										<?php }else{ ?>
										    <td>N/A</td>
										<?php } ?>    	
									</tr>

									<tr>
										<td>3</td>
										<td>User Name on Bank Records</td>											
										<td><?=$currentPaymentInfoArr['ins_bank_name']?></td>
										<?php if($currentPaymentInfoArr['ins_bank_name'] != $updatedPaymentInfoArr['ins_bank_name']){ ?>	
											<td><?=$updatedPaymentInfoArr['ins_bank_name']?></td>
										<?php }else{ ?>
										    <td>N/A</td>
										<?php } ?>    	
									</tr>

									<tr>
										<td>4</td>
										<td>Account No</td>											
										<td><?=$currentPaymentInfoArr['bank_acunt_no']?></td>
										<?php if($currentPaymentInfoArr['bank_acunt_no'] != $updatedPaymentInfoArr['bank_acunt_no']){ ?>	
											<td><?=$updatedPaymentInfoArr['bank_acunt_no']?></td>
										<?php }else{ ?>
										    <td>N/A</td>
										<?php } ?>    	
									</tr>

									<tr>
										<td>5</td>
										<td>Routing No</td>											
										<td><?=$currentPaymentInfoArr['routing_no']?></td>
										<?php if($currentPaymentInfoArr['routing_no'] != $updatedPaymentInfoArr['routing_no']){ ?>	
											<td><?=$updatedPaymentInfoArr['routing_no']?></td>
										<?php }else{ ?>
										    <td>N/A</td>
										<?php } ?>    	
									</tr>

									<tr>
										<td>6</td>
										<td>Swift Code</td>											
										<td><?=$currentPaymentInfoArr['swift_code']?></td>
										<?php if($currentPaymentInfoArr['swift_code'] != $updatedPaymentInfoArr['swift_code']){ ?>	
											<td><?=$updatedPaymentInfoArr['swift_code']?></td>
										<?php }else{ ?>
										    <td>N/A</td>
										<?php } ?>    	
									</tr>

								</tbody>
							</table>
						</div>
              
             <div class="row">
	              <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
	              <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
								  <div class="form-group">
											<button type="submit" class="btn btn-rounded btn-info" onclick="profileUpdationAction(<?=$userId?>,'approve')">Approve </button>&nbsp;
										  <button type="submit" class="btn btn-rounded btn-danger" onclick="profileUpdationAction(<?=$userId?>,'reject')">Reject </button>
								  </div>	
	               </div>
	           </div>   
						</div>
			  	</div>
			</div>
		</div>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="showUserBioModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="updateBioType">User Bio</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	        <div class="row">
			    <div class="col-lg-12 col-md-12 col-sm-12">
			      <div class="description"></div>
			    </div>  
			</div>

	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </div>
	</div>

	<script>

		function showBio(updateType){
			 var userBio = $("#"+updateType).val();

			 if(updateType == "current_bio"){
          $('#updateBioType').text('Current User Bio');
			 }else{
          $('#updateBioType').text('Updated User Bio');
			 }

			 $(".description").text(userBio);
       $("#showUserBioModal").modal('show');
		}
	
		//Course status change function
		function profileUpdationAction(userId,action) {    
      
      if(action == 'approve'){
        var warningText = "Are You sure want to approve this request?";  
      }else{
      	var warningText = "Are You sure want to reject this request?";
      }
		  swal({
				title: warningText,
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
							url: adminUrl+'instructors/profileUpdationAction',       
							type: 'POST',       
							dataType: 'json',       
							data: {         
								userId: String(userId),        
								action: String(action)        
							},
						})
						.done(function(data) {   

							  if(data.check == 'success'){
							  	 var responseArr = [data.msg,'success','#A5DC86'];
							  	 var redirectURL = adminUrl+"instructors/profile-updation-request";   

							  	 setTimeout(function(){
                      alert_response(responseArr,redirectURL);
							  	 },100);
							  }

							  else if(data.check == 'warning'){
							  	 var responseArr = [data.msg,'warning','#A5DC86'];
							  	 var redirectURL = adminUrl+"instructors/profile-updation-request";   
							  	 setTimeout(function(){
                      alert_response(responseArr,redirectURL);
							  	 },100);
							  }else{
							  	 var responseArr = [data.msg,'error','#DD6B55'];
							  	 var redirectURL = adminUrl+"instructors/profile-updation-request";   
							  	 setTimeout(function(){
                      alert_response(responseArr,redirectURL);
							  	 },100);
							  }
						     
						})
						.fail(function(data) {      
							console.log(data);       
						}); 
				}

		 });	 				 
	}

	</script>
