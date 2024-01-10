<div class="dashboard-content">
	<div class="container">
		<h4 class="dashboard-title"><?=$title?></h4>
		<div class="card">
			<div class="card-body">
               <table class="table table-bordered table-responsive-md coursetable">
				  <thead class="text-center">
					<tr>
						<th>Sl No. </th>
						<th>Course Name </th>
						<th>Course Level </th>
						<!--<th>Number of Lessons </th>-->
						<th>Course Image</th>
						<th>Created On</th>	
					</tr>
				  </thead>
				  <tbody class="text-center">
					 <?php 
					   if(count($courseList)>0){
						   foreach (@$courseList as $key => $v){ 
						   	 $courseLvlStr = join(',', array_map('ucfirst', explode(',', $v->course_level)));
					 ?>
						<tr>
							<td><?= $key+1 ?></td>
							<td><?= $v->courseName ?></td>
							<td><?= $courseLvlStr ?></td>		
							<!--<td><?= $totalLesson ?></td>-->										    	
							<td class="courseBnr">
								<?php if (@$v->image && file_exists('./uploads/courses/'.@$v->image)) { ?>
									<img src="<?= base_url('uploads/courses/'.@$v->image) ?>" alt="img">
								<?php } else { ?>
									<img src="<?= base_url('dist/images/noimage.jpg') ?>" alt="img">
								<?php } ?>
							</td>																		
							<td class="fs-13"><?= date('d-M-Y', strtotime(@$v->created)) ?></td>
						</tr>
					 <?php } }else{ ?>
					 	 <td colspan="6">No course is found at this moment!</td>
					 <?php } ?> 
			       </tbody>
			    </table>
			</div>
		</div>
	</div>
</div>