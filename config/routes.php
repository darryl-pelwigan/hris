<?php
defined('BASEPATH') OR exit('No direct script access allowed');




$route['default_controller'] = 'admin/index';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['login'] = 'admin/rlogin';
$route['(:any)/login'] = 'admin/rlogin';
$route['(:any)/(:any)/login'] = 'admin/rlogin';
$route['(:any)/(:any)/(:any)/login'] = 'admin/rlogin';
$route['(?i)StudentList'] = "student/student_record/student_recordx";
/*Teacher*/
$route['(?i)admin'] 	= 'admin/index';
$route['(?i)GetStaffFromDepartment'] 	= 'admin/get_all_staff_dept';
$route['(?i)GetStudentAccts'] 	= 'admin/get_all_student_acct';

$route['(?i)TeacherScheduleList'] 	= "admin/teach_sched";
$route['(?i)Schedule/Records/(:num)'] = 'sched_record2/get_sched_students/$1';
$route['(?i)Schedule/Records2'] = 'sched_record2/get_sched_students';

/* NEW GRADING SYSTEM*/
$route['(?i)Schedule/SCHED_GRADESX'] = 'sched_grades/enter_student_gradesx';
$route['(?i)Schedule/SCHED_GRADES'] = 'sched_grades/enter_student_grades';
$route['(?i)Schedule/DOWNLOAD_EXCEL'] = 'sched_grades/download_excel';
/*class standing*/


/* ViewSubmittedGrades*/


$route['(?i)ViewSubmittedGrades'] = 'check_submitted/get_all_subjects';

$route['(?i)FacultyViewStudentdGrades'] = 'student_grades/student_faculty_grades/student_list';
/* ViewSubmittedGrades*/


$route['(?i)ViewSubmittedGradesRegistrar'] = 'check_submitted/check_submitted_registrar/get_all_subjects';

$route['(?i)ViewSubmittedGradesSAGSO'] = 'check_submitted/check_submitted_sagso/get_all_subjects';

/* whole computation start */
$route['(?i)UpdateStudentCS_WC'] = 'sched_record2/sched_cs_record_wc/update_student_cs';
$route['(?i)importDataCSV_WC'] = 'sched_record2/sched_cs_record_wc/import_data_csv';
$route['(?i)importDataEXAMCSV_WC'] = 'sched_record2/import_data_examcsv';
/* whole computation end */


/* nsub computation start */
$route['(?i)UpdateStudentCS_NSUB'] = 'sched_record2/sched_cs_record_nsub/update_student_cs';

/* nsub computation end  */

/* grade only computation start */
$route['(?i)UpdateStudentCS_GRADE'] = 'sched_record2/sched_record_list_gradeonly/update_student_grade';
/* grade only computation end */

/* grade only lec+lab computation start */
$route['(?i)UpdateStudentCS_GRADELCLB'] = 'sched_record2/sched_record_list_gradeonlyleclab/update_student_grade';
/* grade only computation end */


/* grade only computation start */
$route['(?i)UpdateStudentCS_FGRADE'] = 'sched_record2/sched_record_list_fgradeonly/update_student_fgrade';
/* grade only computation end */


/* whole computation start */
$route['(?i)UpdateStudentCS_Wsub'] = 'sched_record2/sched_cs_record_wsub/update_student_cs';

/* whole computation end */

/* contg computation start */
$route['(?i)UpdateStudentCS_CONTG'] = 'sched_record2/sched_cs_record_contg/update_student_cs';

/* contg computation end */




$route['(?i)UpdateStudentExam2'] = 'sched_record2/update_student_exam';

$route['(?i)UpdateStudentCS'] = 'sched_record2/sched_cs_record/update_student_cs';
$route['(?i)UpdateStudentExam'] = 'sched_record2/update_student_exam';
$route['(?i)UpdateStudentIntern'] = 'sched_record2/update_student_interngrades';
$route['(?i)importDataCSV'] = 'sched_record2/import_data_csv';
/*Admin*/
$route['(?i)Registration'] 	= 'registration/register';
$route['(?i)RegistrationAF'] 	= 'registration/registeraf';
$route['(?i)Early_Enrollment'] 	= 'registration/early_enroll/register';
$route['(?i)Submit_Early_Enrollment'] 	= 'registration/submit_test';
$route['(?i)Submit_Registration'] 	= 'registration/submit_test';


/* Students */
$route['(?i)GetSubjectEnrollees'] 	= 'subject/subject_enrollees/subject_enrolleesx';

$route['(?i)StudentGrades'] 	= 'student_grades/student_grades/student_gradesx';

/* Admin REGISTRAR*/
$route['(?i)Subject-Enrollees'] 	= 'subject/subject_enrollees/get_subject_enrollees/';

/**Transcript Of Records*/
$route['(?i)Transcript-of-Records'] 	= 'tor/get_student_grades';
$route['(?i)Transcript-of-Records-List'] 	= 'tor/get_student_list';


/**
 * Grades Submission
 */

$route['(?i)grade_submission'] = 'admin_registrar/student_grades_submission/index/';
$route['(?i)update_grade_submission'] = 'admin_registrar/student_grades_submission/update/';


$route['(?i)student_gradeview_date'] = 'admin_registrar/student_grades_submission/st_update/';

$route['(?i)check_grades_submitting'] = 'sched_record2/grades_submission/check_grades_submitting/';

$route['(?i)sent_grades_registrar'] = 'sched_record2/grades_submission/sent_grades_registrar/';
$route['(?i)sent_update_grades_registrar'] = 'sched_record2/grades_submission/sent_update_grades_registrar/';
$route['(?i)check_update_grades_registrar'] = 'sched_record2/grades_submission/check_update_grades_registrar/';
$route['(?i)registrar_check_request'] = 'admin_registrar/student_grades_submission/registrar_check_request/';
$route['(?i)validate_update_grades_registrar'] = 'admin_registrar/student_grades_submission/validate_update_grades_registrar/';


/**
 * remarks
 */
$route['(?i)add_remarks_grade'] = 'sched_record2/grades_submission/add_remarks_grade/';


/**
 * Admin Registrar View Grades
 */
$route['(?i)GetSubjectStudentGrades']   = 'admin_registrar/student_grades/grades';
$route['(?i)get_all_by']   = 'subject/subject_enrollees/get_all_by';
$route['(?i)get_allteacher_by']   = 'subject/subject_enrollees/get_allteacher_by';

$route['(?i)college_deans']   = 'college_deans/college_deans/view_college_deans';
############################################################
/**
* HRIS MODULE
* 	-Employee Profile
*  	-leave requests
*   -overtime requets
*/
############################################################\

#############################################################################
#############################################################################
##HR ACCOUNT
$route['employee_lists'] = 'hr/employees/index';
$route['employee_lists_inactive'] = 'hr/employees/inactive';
$route['employee_leave_records'] = 'hr/leave_ot_records/index';
$route['employee_position_record'] = 'hr/employees/employee_postions';
$route['employee_years_service'] = 'hr/employees/employee_years_service';
$route['employee_leave_credits'] = 'hr/employees/employee_leave_credits';
$route['employee_job_position_record'] = 'profile/employee_job_position_record';
$route['employee_appointment_record'] = 'profile/employee_appointment_record';
$route['update_employee_active_status'] = 'profile/update_employee_active_status';

$route['employee_overtime_requests_approval'] = 'hr/leave_ot_records/employee_pending_overtime_requests';
$route['employee_leave_requests'] = 'hr/leave_ot_records/employee_pending_leave_requests';
$route['employee_passslip_requests_approval'] = 'hr/leave_ot_records/employee_pending_passslip_requests';
$route['employee_travelform_requests_approval'] = 'hr/leave_ot_records/employee_pending_travelform_requests';
$route['employee_timekeeping'] = 'hr/attendance/index';
$route['employee_attendance'] = 'hr/attendance/attendance';
$route['upload_attendance'] = 'hr/attendance/upload_attendance';
$route['employee_add_leave_credit'] = 'hr/leave_ot_records/add_leave_credit';

$route['employee_leave_application'] = 'hr/leave_ot_records/add_leave_application';
$route['employees_overtime_application'] = 'hr/leave_ot_records/add_overtime_application';
$route['employees_pass_slip_application'] = 'hr/leave_ot_records/add_pass_slip_application';
$route['employees_travel_order_application'] = 'hr/leave_ot_records/add_travel_order_application';

##EMPLOYEE SERVICE ADDED LEAVE CREDITS
$route['employee_service_credit_log'] = 'hr/employees/service_credits';



###EMPLOYEE ACCOUNT
$route['employees/(:num)'] = 'profile/employee_profile/$1';
$route['history_log'] = 'profile/history_view';

###SETTINGS
$route['list_holidays'] = 'hr/holidays/index';
$route['setting_approving_position_ids'] = 'hr/approval/index';
$route['settings_leave_types'] = 'hr/leave_ot_records/settings';
$route['update_leave_type_days'] = 'hr/leave_ot_records/update_lt_days';


##PAYROLL
$route['payroll'] = 'payroll/payroll/index';

$route['salary_matrix'] = 'payroll/salary/index';
$route['salary_computation/(:num)'] = 'payroll/salary/view_salary_computaion/$1';

$route['deductions_allowances'] = 'payroll/deductions/index';
$route['payroll/add_deductions'] = 'payroll/deductions/add_deductions';
$route['payroll/delete_deductions/(:num)'] = 'payroll/deductions/delete_deductions/$1';
$route['payroll/update_deductions/(:num)'] = 'payroll/deductions/update_deductions/$1';

$route['loans'] = 'payroll/loans/index';
$route['loans/add_loans'] = 'payroll/loans/add_loans';

$route['cut_off/add_cutoff_period'] = 'payroll/cut_off/add_cutoff_period';

##REPORTS
$route['hr_report'] = 'hr/reports/index';
$route['hr_report_charts'] = 'hr/reports/charts';


#############################################################################
#############################################################################
##STAFF ACCOUNT
$route['myprofile/(:num)'] = 'profile/employee_profile/$1';
$route['employee_leave_form'] = 'staff/leave_request/leave_request';
$route['add_leave_application_employee'] = 'staff/leave_request/add_leave_application_employee';
$route['employee_requests_approval'] = 'staff/requests_approval';
$route['employee_overtime_requests'] = 'staff/leave_request/overtime_requests';
$route['employee_passslip_requests'] = 'staff/leave_request/passslip_request';
$route['employee_travelform_requests'] = 'staff/leave_request/travel_order_request';
$route['update_leave_request_approval'] = 'staff/leave_approval';
$route['update_overtime_approval'] = 'staff/overtime_approval';
$route['update_pass_slip_approval'] = 'staff/pass_slip_approval';
$route['update_travel_order_request_approval'] = 'staff/travel_order_request_approval';


##Attendance
$route['employee_scheduling'] = 'hr/scheduling/index';

