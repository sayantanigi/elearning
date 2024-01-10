<div class="dashboard-content">
	<div class="container">
		<h4 class="dashboard-title">Add Schedule Date</h4>
		<div class="card">
			<div class="card-body">
				<form action="<?= base_url('instructor/add_sch_date') ?>" class="form-horizontal" method="post">
					<div>
						<div class="row">
							<div class="col-lg-12">
								<div class="form-group mb-3">
									<label>Select Schedule</label>
									<select class="form-control form-select" name="schedule" required>
									<option value="">Select</option>
										<?php
										foreach($sch as $v){
											echo "<option value='$v[id]'>$v[name]</option>";
										}
										?>
								</select>
								</div>
							</div>
						</div>
						<div class="selectdays mb-3">
							<label>Select Days</label>
							<ul>
								<li><label><input type="checkbox" name="day[1]"> 1</label></li>
								<li><label><input type="checkbox" name="day[2]"> 2</label></li>
								<li><label><input type="checkbox" name="day[3]"> 3</label></li>
								<li><label><input type="checkbox" name="day[4]"> 4</label></li>
								<li><label><input type="checkbox" name="day[5]"> 5</label></li>
								<li><label><input type="checkbox" name="day[6]"> 6</label></li>
								<li><label><input type="checkbox" name="day[7]"> 7</label></li>
								<li><label><input type="checkbox" name="day[8]"> 8</label></li>
								<li><label><input type="checkbox" name="day[9]"> 9</label></li>
								<li><label><input type="checkbox" name="day[10]"> 10</label></li>
								<li><label><input type="checkbox" name="day[11]"> 11</label></li>
								<li><label><input type="checkbox" name="day[12]"> 12</label></li>
								<li><label><input type="checkbox" name="day[13]"> 13</label></li>
								<li><label><input type="checkbox" name="day[14]"> 14</label></li>
								<li><label><input type="checkbox" name="day[15]"> 15</label></li>
								<li><label><input type="checkbox" name="day[16]"> 16</label></li>
								<li><label><input type="checkbox" name="day[17]"> 17</label></li>
								<li><label><input type="checkbox" name="day[18]"> 18</label></li>
								<li><label><input type="checkbox" name="day[19]"> 19</label></li>
								<li><label><input type="checkbox" name="day[20]"> 20</label></li>
								<li><label><input type="checkbox" name="day[21]"> 21</label></li>
								<li><label><input type="checkbox" name="day[22]"> 22</label></li>
								<li><label><input type="checkbox" name="day[23]"> 23</label></li>
								<li><label><input type="checkbox" name="day[24]"> 24</label></li>
								<li><label><input type="checkbox" name="day[25]"> 25</label></li>
								<li><label><input type="checkbox" name="day[26]"> 26</label></li>
								<li><label><input type="checkbox" name="day[27]"> 27</label></li>
								<li><label><input type="checkbox" name="day[28]"> 28</label></li>
								<li><label><input type="checkbox" name="day[29]"> 29</label></li>
								<li><label><input type="checkbox" name="day[30]"> 30</label></li>
								<li><label><input type="checkbox" name="day[31]"> 31</label></li>
							</ul>
						</div>
						<div class="selectdays weekdays mb-3">
							<label>Select Week Days</label>
							<ul>
								<li><label><input type="checkbox" name="week[Sunday]"> Sunday</label></li>
								<li><label><input type="checkbox" name="week[Monday]"> Monday</label></li>
								<li><label><input type="checkbox" name="week[Tuesday]"> Tuesday</label></li>
								<li><label><input type="checkbox" name="week[Wednesday]"> Wednesday</label></li>
								<li><label><input type="checkbox" name="week[Thursday]"> Thursday</label></li>
								<li><label><input type="checkbox" name="week[Friday]"> Friday</label></li>
								<li><label><input type="checkbox" name="week[Saturday]"> Saturday</label></li>
							</ul>
						</div>
						<div class="selectdays monthlist mb-3">
							<label>Select Months</label>
							<ul>
								<li><label><input type="checkbox" name="month[January]"> </label></li>
								<li><label><input type="checkbox" name="month[February]"> February</label></li>
								<li><label><input type="checkbox" name="month[March]"> March</label></li>
								<li><label><input type="checkbox" name="month[April]"> April</label></li>
								<li><label><input type="checkbox" name="month[May]"> May</label></li>
								<li><label><input type="checkbox" name="month[June]"> June</label></li>
								<li><label><input type="checkbox" name="month[July]"> July</label></li>
								<li><label><input type="checkbox" name="month[August]"> August</label></li>
								<li><label><input type="checkbox" name="month[September]"> September</label></li>
								<li><label><input type="checkbox" name="month[October]"> October</label></li>
								<li><label><input type="checkbox" name="month[November]"> November</label></li>
								<li><label><input type="checkbox" name="month[December]"> December</label></li>
							</ul>
						</div>
						<div class="mb-3">
							<div class="form-group">
								<label>Select Year</label>
								<select class="form-control form-select" name="year">
									<option>Select</option>
									<option>2022</option>
									<option>2023</option>
									<option>2024</option>
									<option>2025</option>
									<option>2026</option>
									<option>2027</option>
									<option>2028</option>
								</select>
							</div>
						</div>
						<div><button class="btn btn-primary">Submit</button></div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>