<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// login
$route['default_controller'] = 'auth';
// logout
$route['logout']='auth/logout';
$route['pass-recover']='auth/pass_recover';
$route['pass-reset']='auth/pass_reset_form';
$route['pass-reset-set']='auth/pass_reset_set';
/*
*
* Administrative part
*
*/
// dashboard
$route['dashboard']='welcome';
$route['mail-service']='welcome/mail_method';

// daily update report commet
$route['u_report_comment']='welcome/u_report_comment';

// Job or Requirement form
$route['job-create'] = 'jobs/create';
$route['job-insert'] = 'jobs/insert';
$route['job-update'] = 'jobs/update';
$route['ajax-product-search'] = 'jobs/pro_search';
$route['ajax-get-product-form'] = 'jobs/get_product_form';
$route['ajax-save-in-session-job-product'] = 'jobs/job_product_save_in_session';
$route['modify-ajax-save-in-session-job-product'] = 'jobs/job_product_save_in_session_modify';
$route['ajax-job-product-cart-update'] = 'jobs/cart_update';
$route['ajax-job-product-modify-cart-update'] = 'jobs/modify_cart_update';
$route['ajax-remove-from-cart'] = 'jobs/remove_from_cart';
$route['ajax-remove-from-modify-cart'] = 'jobs/remove_from_modify_cart';
$route['job-list'] = 'jobs/job_list';
$route['job-edit/(:num)'] = 'jobs/job_edit/$1';
$route['job-trash/(:num)'] = 'jobs/job_trash/$1';
$route['job-trash-to-main/(:num)'] = 'jobs/job_trash_to_move/$1';
$route['job-trash-list'] = 'jobs/job_trash_list';
$route['job-handler/(:num)'] = 'jobs/job_handler_setup';
$route['job-handler-save'] = 'jobs/job_handler_save';
$route['job-close/(:num)'] = 'jobs/job_close/$1';
$route['job-close'] = 'jobs/job_close_update';
$route['job-close-list'] = 'jobs/c_job_list';
$route['job-close-move/(:num)'] = 'jobs/c_job_move/$1';
$route['job-principle-setup/(:num)'] = 'jobs/job_requirement_send_to_principle/$1';
$route['job-requirement-send'] = 'jobs/job_requirement_send';
$route['job-requirement-remove'] = 'jobs/job_requirement_delete';
$route['job-details/(:num)']='jobs/details/$1';
// job for design
$route["design-board"]='jobs/de_list';
$route["update-desing-work"]='jobs/update_design_work';


// Job Event Register

$route['job-event/(:num)'] = 'job_event/job_event_register/$1';
$route['job-event-save/(:num)'] = 'job_event/job_event_register_save/$1';




// Service

$route['service-create']='services/create';
$route['ajax-save-in-session-service-product']='services/service_product_save_in_session';
$route['ajax-remove-from-service-cart']='services/remove_from_cart';
$route['ajax-service-product-cart-update']='services/cart_update';
$route['service-insert']='services/insert';
$route['service-list']='services/service_list';
$route['service-handler/(:num)'] = 'services/service_handler_setup';
$route['service-handler-save']='services/service_handler_save';
$route['service-close/(:num)'] = 'services/service_close/$1';
$route['service-close'] = 'services/service_close_update';
$route['service-close-list'] = 'services/c_service_list';
$route['service-close-move/(:num)'] = 'services/c_service_move/$1';
$route['service-edit/(:num)'] = 'services/service_edit/$1';
$route['modify-ajax-save-in-session-service-product'] = 'services/service_product_save_in_session_modify';
$route['ajax-service-product-modify-cart-update'] = 'services/modify_cart_update';
$route['ajax-remove-from-modify-service-cart'] = 'services/remove_from_modify_cart';
$route['service-update'] = 'services/update';
$route['service-trash/(:num)'] = 'services/service_trash/$1';
$route['service-trash-list'] = 'services/service_trash_list';
$route['service-trash-to-main/(:num)'] = 'services/service_trash_to_move/$1';
$route['service-details/(:num)']='services/details/$1';
// service event
$route['service-event/(:num)'] = 'service_event/service_event_register/$1';
$route['service-event-save/(:num)'] = 'service_event/service_event_register_save/$1';




// user or employee work plan 
$route['monthly-work-plan'] = 'work_plan/index';
$route['ajax-get-work-plan'] = 'work_plan/get_work_plan';
$route['ajax-customer-search'] = 'work_plan/cust_search';
$route['ajax-principle-search'] = 'work_plan/princ_search';
$route['work-plan-event-ajax-add'] = 'work_plan/plan_event_insert';
$route['get-working-plan-detail-by-id/(:num)'] = 'work_plan/plan_detail_by_plan_details_id/$1';
$route['get-working-plan-detail-by-id-for-table/(:num)'] = 'work_plan/plan_detail_by_plan_details_id_for_table/$1';
$route['remove-event-plan/(:num)'] = 'work_plan/remove_event_plan/$1';
$route['daily-work-update'] = 'work_plan/daily_update';
$route['update-work-plan-status'] = 'work_plan/update_work_plan_status';
$route['update-work-plan-details'] = 'work_plan/update_work_plan_details';
// user profile
$route['profile']='user/profile';
// customer
$route['customer-add']='customer/save';
$route['customer-insert']='customer/insert';
$route['customer-list']='customer/clist';
$route['customer-edit/(:num)']='customer/edit/$1';
$route['customer-update']='customer/update';
$route['customer-trash/(:num)']='customer/delete/$1';
$route['customer-trash-list']='customer/trash';
$route['customer-trash-to-main/(:num)']='customer/move/$1';
// customer type
$route['customer-type-add']='customer_type/save';
$route['customer-type-insert']='customer_type/insert';
$route['customer-type-list']='customer_type/clist';
$route['customer-type-edit/(:num)']='customer_type/edit/$1';
$route['customer-type-update']='customer_type/update';
$route['customer-type-trash/(:num)']='customer_type/delete/$1';
$route['customer-type-trash-list']='customer_type/trash';
$route['customer-type-trash-to-main/(:num)']='customer_type/move/$1';
$route['customer-details/(:num)']='customer/details/$1';
// customer contacts
$route['contact-ajax-add']='contact/ajax_add';
$route['contact-ajax-update']='contact/ajax_update';
$route['customer-contact-list/(:num)']='contact/list_by_customer/$1';
$route['customer-contact-trash/(:num)/(:num)']='contact/contact_trash/$1/$2';
$route['customer-contact-trash-list/(:num)']='contact/trash_list_by_customer/$1';
$route['customer-contact-trash-to-main/(:num)/(:num)']='contact/move/$1/$2';
$route['ajax-get-cust-contact']='contact/contact_option_list';
// principles
$route['principle-add']='principles/add';
$route['principle-insert']='principles/insert';
$route['principle-list']='principles/plist';
$route['principle-edit/(:num)']='principles/edit/$1';
$route['principle-update']='principles/update';
$route['principle-trash/(:num)']='principles/delete/$1';
$route['principle-trash-list']='principles/trash';
$route['principle-trash-to-main/(:num)']='principles/move/$1';


$route['principle-contact-list/(:num)']='principles/contacts/$1';
$route['principle-contact-ajax-add']='principles/contact_ajax_add';
$route['principle-contact-ajax-update']='principles/contact_ajax_update';
$route['principle-contact-trash/(:num)/(:num)']='principles/contact_trash/$1/$2';
$route['principle-contact-trash-list/(:num)']='principles/trash_list_by_priciple/$1';
$route['principle-contact-trash-to-main/(:num)/(:num)']='principles/c_move/$1/$2';
$route['principle-details/(:num)']='principles/details/$1';
// products
$route['product-add'] = 'products/add';
$route['product-list'] = 'products/plist';
$route['product-image-upload'] = 'products/img_upload';
$route['product-image-delete'] = 'products/img_delete';
$route['product-insert'] = 'products/insert';
$route['product-edit/(:num)'] = 'products/edit/$1';
$route['product-update'] = 'products/update';
$route['product-trash/(:num)']='products/delete/$1';
$route['product-trash-list']='products/trash';
$route['product-trash-to-main/(:num)']='products/move/$1';


// department
$route['department-add']='departments/save';
$route['department-insert']='departments/insert';
$route['department-list']='departments/dlist';
$route['department-edit/(:num)']='departments/edit/$1';
$route['department-update']='departments/update';
$route['department-trash/(:num)']='departments/delete/$1';
$route['department-trash-list']='departments/trash';
$route['department-trash-to-main/(:num)']='departments/move/$1';

// designation
$route['designation-add']='designations/save';
$route['designation-insert']='designations/insert';
$route['designation-list']='designations/dlist';
$route['designation-edit/(:num)']='designations/edit/$1';
$route['designation-update']='designations/update';
$route['designation-trash/(:num)']='designations/delete/$1';
$route['designation-trash-list']='designations/trash';
$route['designation-trash-to-main/(:num)']='designations/move/$1';


// settings - form
$route['form-add'] = 'form_builder/create';
$route['form-create'] = 'form_builder/insert';
$route['form-list'] = 'form_builder/flist';
$route['get_form_by_id_ajax'] = 'form_builder/ajax_preview';
$route['form-delete/(:num)'] = 'form_builder/delete/$1';
// user
$route['user-add']='user/save';
$route['user-insert']='user/insert';
$route['user-list']='user/ulist';
$route['user-edit/(:num)']='user/edit/$1';
$route['user-update']='user/update';
$route['user-trash/(:num)']='user/delete/$1';
$route['user-trash-list']='user/trash';
$route['user-trash-to-main/(:num)']='user/move/$1';

// user privileges
$route['privilege-setup/(:num)']='user_privilege/index';
$route['privilege-update']='user_privilege/update';

// dashboard 
$route['daily-update-report-refresh']='welcome/daily_update_report_refresh';


// reports
$route['daily-update-report']='daily_update_report/index';
$route['daily-update-report-show']='daily_update_report/show_report';

// upcoming tender register
$route['upcoming-tender']='upcoming_tender/tlist';
$route['upcoming-tender-create']='upcoming_tender/create';
$route['upcoming-tender-save']='upcoming_tender/save';
$route['upcoming-tender-remove/(:num)']='upcoming_tender/remove/$1';
$route['upcoming-tender-edit/(:num)']='upcoming_tender/edit/$1';
$route['upcoming-tender-update']='upcoming_tender/update';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
