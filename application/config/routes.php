<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['terms-and-conditions'] ='home/terms';
$route['privacy-policy'] ='home/policy';
$route['forgot-password']='login/forgot';
$route['process-forgot-password']='login/postForgetPassword';
$route['user-reset-password/(:any)']='login/resetUserPassword/$1';
$route['process-reset-password']='login/postResetPassword';
$route['courselist'] ='home/courselist';
$route['about-us'] ='home/about';
$route['become-a-instructor'] ='home/becomeInstructor';
$route['blogs'] ='home/bloglist';
$route['blog/(:any)'] ='home/blogdetail/$1';
$route['faqs'] ='home/faqlist';

//ADMIN URL
$route['admin'] = 'admin/login/index';
$route['admin/logout'] = 'admin/login/logout';

//ADMIN REPORTS ROUTE
$route['admin/reports/purchasehistory'] = 'admin/Reports/purchase_history';
$route['admin/reports/changeinstructordata'] = 'admin/Reports/change_instructor_data';
$route['admin/reports/cancelstudentdata'] = 'admin/Reports/cancel_student_data';
$route['admin/reports/view-unapproved-change-instructor-data/(:any)'] = 'admin/Reports/changeInsHistory/$1';
$route['admin/reports/view-approved-change-instructor-data/(:any)'] = 'admin/Reports/changeInsHistory/$1';

$route['admin/reports/view-unapproved-student-cancel-data/(:any)'] = 'admin/Reports/cancelStudentHistory/$1';
$route['admin/reports/view-approved-student-cancel-data/(:any)'] = 'admin/Reports/cancelStudentHistory/$1';

$route['admin/reports/view-unapproved-course-cancel-data/(:any)'] = 'admin/Reports/cancel_course_history/$1';
$route['admin/reports/view-approved-course-cancel-data/(:any)'] = 'admin/Reports/cancel_course_history/$1';

$route['admin/reports/cancelcoursedata'] = 'admin/Reports/cancel_course_data';
$route['admin/reports/cancel-course/details/(:num)'] = 'admin/Reports/cancelCourseDetails/$1';

$route['admin/reports/cancel-course-history'] = 'admin/Reports/cancel_course_history';
$route['admin/reports/cancel-course-history/details/(:num)'] = 'admin/Reports/cancelCourseHistoryDetails/$1';

//ADMIN CMS
$route['admin/cms/pages'] = 'admin/CMS/pages';
$route['admin/cms/lists/(:any)'] = 'admin/CMS/lists/$1';
$route['admin/cms/edit/(:any)/(:num)'] = 'admin/CMS/edit/$1/$2';
$route['admin/cms/update'] = 'admin/CMS/update';

//ADMIN CHAPTER CARRICULUM
$route['admin/subject/curriculum/(:num)/(:num)'] = 'admin/Subject/chapter_curriculum/$1/$2';
$route['admin/subject/loadAjaxChapterCurriculum/(:num)/(:num)'] = 'admin/Subject/load_Ajax_Chapter_Curriculum/$1/$2';

//ADMIN INSTRUCTOR
$route['admin/instructors/profile-updation-request'] = 'admin/Instructors/profileUpdationRequestList';
$route['admin/instructors/profile-updation-detail/(:num)'] = 'admin/Instructors/profileUpdationRequestDetail/$1';

$route['admin/instructors/instructor-change-reason'] = 'admin/Reason/lists';
$route['admin/instructors/add-reason'] = 'admin/Reason/add';
$route['admin/instructors/edit-reason/(:num)'] = 'admin/Reason/edit/$1';
$route['admin/instructors/reason/publish/(:num)'] = 'admin/Reason/publish/$1';
$route['admin/instructors/reason/unpublish/(:num)'] = 'admin/Reason/unpublish/$1';

//Admin Instructor Module Route
$route['admin/instructors/manageschedule/(:num)'] = 'admin/instructors/manageSchedule/$1';
$route['admin/instructors/scheduleclasses/(:num)'] = 'admin/instructors/scheduleClasses/$1';
$route['admin/instructors/fetchschedule/(:num)'] = 'admin/instructors/fetchSchedule/$1';

//INSTRUCTOR ROUTE
$route['instructor'] = 'Instructor/dashboard';
$route['instructor/assigned-course-list'] = 'Instructor/assignedCourseList';
$route['instructor/my-created-course'] = 'Instructor/myCreatedCourselist';
$route['instructor/course/add'] = 'Instructor/addCourseView';
$route['instructor/course/create'] = 'Instructor/createCourse';
$route['instructor/course/edit/(:num)'] = 'Instructor/editCourse/$1';
$route['instructor/course/update'] = 'Instructor/updateCourse';
$route['instructor/course/view/(:num)'] = 'Instructor/viewCourse/$1';
$route['instructor/course/cancel/(:num)'] = 'Instructor/cancelCourse/$1';

$route['instructor/subjects'] = 'Instructor/subject_list';
$route['instructor/subject/add'] = 'Instructor/addSubjectView';
$route['instructor/subject/create'] = 'Instructor/createSubject';
$route['instructor/subject/edit/(:num)'] = 'Instructor/editSubject/$1';
$route['instructor/subject/update'] = 'Instructor/updateSubject';
$route['instructor/subject/view/(:num)'] = 'Instructor/viewSubject/$1';

$route['instructor/chapters/(:num)'] = 'Instructor/chapter_list/$1';
$route['instructor/chapter/add/(:num)'] = 'Instructor/addChapterView/$1';
$route['instructor/chapter/create'] = 'Instructor/createChapter';
$route['instructor/chapter/edit/(:num)/(:num)'] = 'Instructor/editChapter/$1/$2';
$route['instructor/chapter/update'] = 'Instructor/updateChapter';
$route['instructor/chapter/view/(:num)/(:num)'] = 'Instructor/viewChapter/$1/$2';
$route['instructor/chapter-curriculum/(:num)/(:num)'] = 'Instructor/view_Chapter_Curriculum/$1/$2';

$route['instructor/fetchschedule/(:any)'] = 'Instructor/fetchSchedule/$1';
$route['instructor/viewclasses'] = 'Instructor/viewClasses';
$route['instructor/view'] = 'Instructor/viewBookedClasses';
$route['instructor/showstudentschedule/(:num)/(:any)/(:num)'] = 'Instructor/showStudentSchedule/$1/$2/$3';

//STUDENT ROUTE
$route['student'] = 'Student/dashboard';
$route['student/enrolledcourselist'] = 'Student/enrolled_course_Lists';
$route['student/runningcourselist'] = 'Student/running_course_Lists';
$route['student/copmpletedcourselist'] = 'Student/completed_course_Lists';
$route['student/courses'] = 'Student/course_Lists';
$route['student/subjects/(:num)/(:any)'] = 'Student/courseDetails/$1/$2';
$route['student/subject-detail/(:num)/(:any)/(:num)'] = 'Student/getSubjectDetails/$1/$2/$3';

$route['student/chapters/(:num)/(:any)'] = 'Student/courseDetails/$1/$2';
$route['student/chapters/(:num)/(:any)/(:num)'] = 'Student/courseListUnderSubject/$1/$2/$3';
$route['student/chapter-curriculum/(:num)/(:any)/(:num)/(:num)'] = 'Student/chapter_curriculum/$1/$2/$3/$4';

$route['student/instructor/(:num)/(:any)'] = 'Student/instructorLists/$1/$2';
$route['student/scheduleclass/(:num)/(:any)/(:num)'] = 'Student/scheduleClass/$1/$2/$3';
$route['student/fetchschedule/(:num)/(:any)/(:num)'] = 'Student/fetchSchedule/$1/$2/$3';
$route['student/bookclass/'] = 'Student/bookClass';

$route['student/viewbookedsession/(:num)/(:any)/(:num)'] = 'Student/viewBookedSession/$1/$2/$3';
$route['student/viewbookedschedule/(:num)/(:any)/(:num)'] = 'Student/viewBookedSchedule/$1/$2/$3';

//ADMIN COURSE ROUTE
$route['admin/course/load-new-level-html']='admin/Course/load_new_level_html';

//API ROUTE
$route['restapi/api/fetchsubjectlist'] = 'restapi/api/fetchSubjects';
$route['restapi/api/fetchcourselist'] = 'restapi/api/fetchCourses';
$route['restapi/api/fetchrecentcourselist'] = 'restapi/api/fetchRecentCourses';
$route['restapi/api/fetchtrendingcourse'] = 'restapi/api/fetchTrendingCourse';
$route['restapi/api/fetchtrendingsubject'] = 'restapi/api/fetchTrendingSubject';
$route['restapi/api/fetchcoursesubjectwise'] = 'restapi/api/fetchCourseSubjectWise';
$route['restapi/api/fetchcoursedetails'] = 'restapi/api/fetchCourseDetails';
$route['restapi/api/fetchcourselvlsubjectlist'] = 'restapi/api/fetchCourseLevelSubjects';
$route['restapi/api/fetchcoursechapterlist'] = 'restapi/api/fetchCourseChapterData';
$route['restapi/api/fetchchapterdetails'] = 'restapi/api/fetchChapterDetails';






