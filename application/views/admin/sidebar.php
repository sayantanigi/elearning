<div class="deznav">
	<div class="deznav-scroll">
		<ul class="metismenu" id="menu">
		
		<li class="<?= (!empty($page) && $page == 'dashboard')? 'mm-active' : ''; ?>"><a href="<?= admin_url('dashboard')?>" class="ai-icon" aria-expanded="false">
				<i class="fa fa-tachometer" aria-hidden="true"></i>
				<span class="nav-text">Dashboard</span>
			</a>
		</li>
		
		<li class="<?= (!empty($page) && $page == 'reports')? 'mm-active' : ''; ?>" ><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
				<i class="fa fa-shopping-cart"></i>
				<span class="nav-text">Reports</span>
			</a>
			<ul aria-expanded="false">
				<li class="<?= (!empty($subpage) && $subpage == 'purchasehistory')? 'mm-active' : ''; ?>">
					<a href="<?= admin_url('reports/purchasehistory') ?>">Purchase History</a>
				</li>
				<li class="<?= (!empty($subpage) && ( $subpage == 'changeinstructordata' || $subpage == 'changeinshsitory') )? 'mm-active' : ''; ?>">
					<a href="<?= admin_url('reports/changeinstructordata') ?>" class="<?= (!empty($subpage) && ( $subpage == 'changeinstructordata' || $subpage == 'changeinshsitory') )? 'mm-active' : ''; ?>">Change Instructor Report</a>
				</li>
				<li class="<?= (!empty($subpage) && ( $subpage == 'cancelstudentdata' || $subpage == 'cancelstudenthistory') )? 'mm-active' : ''; ?>">
					<a href="<?= admin_url('reports/cancelstudentdata') ?>" class="<?= (!empty($subpage) && ( $subpage == 'cancelstudentdata' || $subpage == 'cancelstudenthistory') )? 'mm-active' : ''; ?>">Course/Student Cancel Report</a>
				</li>
				<li class="<?= (!empty($subpage) && ( $subpage == 'cancelcoursedata' || $subpage == 'cancelcoursehistory') )? 'mm-active' : ''; ?>">
					<a href="<?= admin_url('reports/cancelcoursedata') ?>" class="<?= (!empty($subpage) && ( $subpage == 'cancelcoursedata' || $subpage == 'cancelcoursehistory') )? 'mm-active' : ''; ?>">Complete Course Cancellation Report</a>
				</li>
			</ul>
		</li>

		<li class="<?= (!empty($page) && $page == 'course')? 'mm-active' : ''; ?>">
			<a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
				<i class="flaticon-381-controls-3"></i>
				<span class="nav-text">Courses Mgmt</span>
			</a>
			<ul aria-expanded="false">
				<li class="<?= (!empty($subpage) && $subpage == 'addcourse')? 'mm-active' : ''; ?>"><a href="<?= admin_url('course/add') ?>">Add New Course</a></li>
				<li class="<?= (!empty($subpage) && $subpage == 'courselist')? 'mm-active' : ''; ?>"><a href="<?= admin_url('course/lists') ?>">List of Courses</a></li>
			</ul>
		</li>
		<li class="<?= (!empty($page) && $page == 'subjects')? 'mm-active' : ''; ?>">
			<a href="<?= admin_url('subject/lists') ?>" class="ai-icon" aria-expanded="false">
				<i class="flaticon-381-notepad"></i>
				<span class="nav-text">Subjects</span>
			</a>
		</li>		
		<!--<li class="<?= (!empty($page) && $page == 'package')? 'mm-active' : ''; ?>">
			<a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
				<i class="flaticon-381-controls-3"></i>
				<span class="nav-text">Packages</span>
			</a>
			<ul aria-expanded="false">
				<li class="<?= (!empty($subpage) && $subpage == 'addpackage')? 'mm-active' : ''; ?>"><a href="<?= admin_url('package/add') ?>">Add New Package</a></li>
				<li class="<?= (!empty($subpage) && $subpage == 'packagelist')? 'mm-active' : ''; ?>"><a href="<?= admin_url('package/lists') ?>">List of Packages</a></li>
			</ul>
		</li>-->

		<li class="<?= (!empty($page) && $page == 'students')? 'mm-active' : ''; ?>">
			<a href="javascript:void()" class="has-arrow ai-icon" aria-expanded="false">
				<i class="flaticon-381-user"></i>
				<span class="nav-text">Students</span>
			</a>
			<ul aria-expanded="false">
				<li class="<?= (!empty($subpage) && $subpage == 'studentadd')? 'mm-active' : ''; ?>">
					<a href="<?= admin_url('students/add') ?>">Add New Student</a>
				</li>
				<li class="<?= (!empty($subpage) && $subpage == 'studentlist')? 'mm-active' : ''; ?>">
					<a href="<?= admin_url('students/lists') ?>">List of Students</a>
				</li>
			</ul>

		 </li>	
	
		<li class="<?= (!empty($page) && $page == 'instructors')? 'mm-active' : ''; ?>">
			<a href="javascript:void()" class="has-arrow ai-icon" aria-expanded="false">
				<i class="flaticon-381-user"></i>
				<span class="nav-text">Instructors</span>
			</a>
			<ul aria-expanded="false">
				<li class="<?= (!empty($subpage) && $subpage == 'instructoradd')? 'mm-active' : ''; ?>">
					<a href="<?= admin_url('instructors/add') ?>">Add New Instructor</a>
				</li>

				<li class="<?= (!empty($subpage) && $subpage == 'instructorlist')? 'mm-active' : ''; ?>">
				    <a href="<?= admin_url('instructors/lists') ?>">List of Instructors</a>
			    </li>

				<li class="<?= (!empty($subpage) && $subpage == 'profileupdationrequest')? 'mm-active' : ''; ?>">
					<a href="<?= admin_url('instructors/profile-updation-request') ?>">Profile Updation Request</a>
				</li>

					<li class="<?= (!empty($subpage) && $subpage == 'reasonlist')? 'mm-active' : ''; ?>">
					<a href="<?= admin_url('instructors/instructor-change-reason') ?>">Change Instructor Reason</a>
				</li>
			</ul>

		 </li>

		 <li class="<?= (!empty($page) && $page == 'reviewlist')? 'mm-active' : ''; ?>"><a href="<?= admin_url('reviews/list')?>" class="ai-icon" aria-expanded="false">
				<i class="fa fa-star"></i>
				<span class="nav-text">Review</span>
			</a>
		</li>

		 <li class="<?= (!empty($page) && $page == 'bloglist')? 'mm-active' : ''; ?>" ><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
				<i class='fab fa-blogger-b'></i>
				<span class="nav-text">Blog</span>
			</a>
			<ul aria-expanded="false">
				<li class="<?= (!empty($subpage) && $subpage == 'blogadd')? 'mm-active' : ''; ?>"><a href="<?= admin_url('blog/add') ?>">Add New Blog</a></li>
				<li class="<?= (!empty($subpage) && $subpage == 'bloglist')? 'mm-active' : ''; ?>"><a href="<?= admin_url('blog/lists') ?>">List of Blog</a></li>
			</ul>
		</li>
	
		 <li class="<?= (!empty($page) && $page == 'faq')? 'mm-active' : ''; ?>" ><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
				<i class="flaticon-381-controls-3"></i>
				<span class="nav-text">FAQ</span>
			</a>
			<ul aria-expanded="false">
				<li class="<?= (!empty($subpage) && $subpage == 'add_new_faq')? 'mm-active' : ''; ?>"><a href="<?= admin_url('faq/add') ?>">Add New FAQ</a></li>
				<li class="<?= (!empty($subpage) && $subpage == 'faq_list')? 'mm-active' : ''; ?>"><a href="<?= admin_url('faq/lists') ?>">List of FAQ</a></li>
				<li class="<?= (!empty($subpage) && $subpage == 'faq_import')? 'mm-active' : ''; ?>"><a href="<?= admin_url('faq/import') ?>">Import of FAQ</a></li>
			</ul>
		</li>

		<!-- CMS MANAGEMENT -->
		<li class="<?= (!empty($page) && $page == 'cms')? 'mm-active' : ''; ?>"><a href="<?= admin_url('cms/pages')?>" class="ai-icon" aria-expanded="false">
				<i class="fa fa-edit"></i>
				<span class="nav-text">C.M.S.</span>
			</a>
		</li>

		<li class="<?= (!empty($page) && $page == 'settings')? 'mm-active' : ''; ?>" ><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
			<i class="flaticon-381-settings-2"></i>
			<span class="nav-text">Settings</span>
		</a>
		<ul aria-expanded="false">
			<li class="<?= (!empty($subpage) && $subpage == 'site_settings')? 'mm-active' : ''; ?>"><a href="<?= admin_url('settings/site_settings') ?>">Site Settings</a></li>
			<li class="<?= (!empty($subpage) && $subpage == 'logo_settings')? 'mm-active' : ''; ?>"><a href="<?= admin_url('settings/logo') ?>">Logo Settings</a></li>
		</ul>
	</li>

		</ul>
	</div>
</div>