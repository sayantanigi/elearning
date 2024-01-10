<table class="table table-bordered">
	<thead>
	<tr>
	  <th scope="col">#</th>
	  <th scope="col">Day</th>
	  <th scope="col">Coruse Name</th>
	  <th scope="col">Student Name</th>
	  <th scope="col">Coruse Level</th>
	  <th scope="col">Date</th>
	  <th scope="col">Time</th>
	</tr>
	</thead>
	<tbody>
		<tr>
			<td colspan="7" style="text-align:center;">
				<span style="color:#000;">Following dates are booked by some students. Please cancel all the classes by clicking the cancel class button.</span>
			</td>
		</tr>	
	<?php foreach($colidedDateArr as $index => $date){ ?>	
		<tr>
		  <td scope="row"><?=$index+1?></td>
		  <td><?=$date['day']?></td>
		  <td><?=$date['courseName']?></td>
		  <td><?=$date['studentName']?></td>
		  <td><?=$date['courseLvl']?></td>
		  <td><?=date('jS F, Y',strtotime($date['date']))?></td>
		  <td>
		  	 <strong>From</strong>&nbsp;
		  	    <?=date('g:i A',strtotime($date['fromTime']))?>&nbsp;
		  	 <strong>To</strong>&nbsp;
		  	    <?=date('g:i A',strtotime($date['toTime']))?>
		  </td>
		</tr>
	<?php } ?>
	<tr>
		<td colspan="7" style="text-align:center;">
			<button class="btn btn-danger" id="cancelBulkClasses">Cancel Classes</button>
		</td>
	</tr>
	<tr>
		<td colspan="7" style="text-align:center;">
			<span style="color:#000;">Else you can cancel your desried classes manually from your schedule calendar.</span>
		</td>
	</tr>	
	</tbody>
</table>