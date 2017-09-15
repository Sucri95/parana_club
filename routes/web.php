<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('activities', 'ActivitiesController');

Route::resource('categories', 'CategoriesController');

Route::resource('classes', 'ClassesController');

Route::resource('classrooms', 'ClassroomsController');

Route::resource('products', 'ProductsController');

Route::resource('tutors', 'TutorsController');

Route::resource('inscriptions', 'InscriptionsController');

Route::resource('sales', 'SalesController');

Route::get('activities_by_tutor', 'TutorsController@activitiesByTutor');

Route::get('activities_by_tutor/autocomplete', 'TutorsController@autocomplete');

Route::get('user_inscriptions/autocomplete', 'InscriptionsController@autocomplete');

Route::get('product/autocomplete', 'ProductsController@autocomplete');

Route::get('user_inscriptions', 'InscriptionsController@userInscriptions');

Route::get('classes_days_schedules', 'ClassesController@classesDaysSchedules');

Route::get('classrooms_days_schedules', 'ClassesController@classroomsDaysSchedules');

Route::get('tutor_days_schedules', 'ClassesController@tutorDaysSchedules');

Route::get('classes_days_schedules_by_id', 'ClassesController@classesDaysSchedulesById');

Route::get('statistics', 'StatisticsController@index');

Route::get('all_users', 'UsersController@showAllUsers');

Route::get('inactive_users', 'UsersController@showInactiveUser');

Route::get('new_user', 'UsersController@create');

Route::get('new_user_roles', 'UsersController@createRoles');

Route::get('get_by_dni', 'UsersController@getByDni');

Route::resource('users', 'UsersController');

Route::resource('assists', 'AssistsController');

Route::resource('tasks', 'TasksController');

Route::resource('news', 'NewsController');

Route::resource('notifications', 'NotificationsController');

Route::resource('quizzes', 'QuizzesController');

Route::resource('wods', 'WodsController');

Route::resource('cash_deposits', 'CashDepositsController');

Route::resource('type_cash_transactions', 'TypeCashTransactionsController');

Route::resource('cash_transactions', 'CashTransactionsController');

Route::resource('cashier_closing', 'CashierClosingController');

Route::resource('benchmarks', 'BenchmarksController');

Route::get('notifications_user/{id}', 'NotificationsController@notificationsUsers');

Route::post('transactions/close_day', 'CashTransactionsController@closeDay');


// SERVICIOS PARA SITE RECEPCIÓN

Route::get('site/get_tasks/user', 'ReceptionController@showView');

Route::get('site/get_tasks_by_user', 'ReceptionController@getTasksByUser');

Route::get('site/store_task/user', 'ReceptionController@showCreateBlade');

Route::get('site/get_employees', 'ReceptionController@getEmployees');

Route::get('site/get_clients', 'ReceptionController@getClients');

Route::get('site/get_clients_with_debt', 'ReceptionController@getClientsWithDebt');

Route::get('site/find_user_by_id', 'ReceptionController@findUserById');

Route::get('site/list_products_available', 'ReceptionController@listProductsAvailable');

Route::get('site/list_all_fields', 'ReceptionController@listAllFields');

Route::get('site/show_field', 'ReceptionController@showFields');

Route::get('site/view_all_reservations', 'ReceptionController@viewAllReservations');

Route::get('site/view_reservations_by_id_field', 'ReceptionController@viewReservationsByIdField');

Route::get('site/list_plans', 'ReceptionController@listPlan');

Route::post('site/store_tasks_by_user', 'ReceptionController@storeTasksByUser');

Route::post('site/remove_tasks_by_user', 'ReceptionController@removeTasksByUser');

Route::post('site/store_user', 'ReceptionController@storeUsers');

Route::post('site/update_products_stock', 'ReceptionController@updateProductStock');

Route::post('site/store_deposit', 'ReceptionController@storeDeposit');

Route::post('site/store_sales_receptions', 'ReceptionController@storeSalesReceptions');

Route::post('site/store_field', 'ReceptionController@storeField');

Route::post('site/reserve_fields', 'ReceptionController@reserveFields');

Route::post('site/cancel_reservation', 'ReceptionController@cancelReservation');

Route::post('site/create_plan', 'ReceptionController@createPlan');

Route::post('site/buy_plans', 'ReceptionController@buyPlans');

Route::post('site/tutor_payments_by_classes', 'ReceptionController@tutorPaymentsByClasses');

// SERVICIOS PARA APP

Route::get('mobile/get_notifications_by_user', 'MobileController@getNotificationsByUser');

Route::get('mobile/login_service', 'MobileController@loginService');

Route::get('mobile/show_work_outs', 'MobileController@showWorkOuts');

Route::get('mobile/show_benchmarks', 'MobileController@showBenchmarks');

Route::get('mobile/show_activity_historial', 'MobileController@showActivityHistorial');