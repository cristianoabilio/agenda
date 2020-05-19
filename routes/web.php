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

Route::group(['middleware' => 'auth'], function() {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::group(['middleware' => 'gym-mate-web'], function() {
        Route::get('/company', 'CompanyController@index')->name('company');
        Route::post('/company', 'CompanyController@store')->name('company');
        Route::post('/company/list', 'CompanyController@filter');
        Route::post('/company/destroy', 'CompanyController@destroy');


        
    });
    
    Route::get('/email', function() {
        Mail::send('emails.test', ['name' => 'Silveira', 'email' => 'emaildosilveira@gmail.com', 'password' => '12341234'], function($m) {
            $m->subject('GymMate - Boas vindas');
            $m->from('cristianocafr@gmail.com');
            $m->to('ext.cristiano@havea.com.br');
        });
    });
    Route::get('/plan', 'PlanController@index')->name('plan');
    Route::post('/plan', 'PlanController@store')->name('plan');
    Route::post('/plan/list', 'PlanController@filter');
    Route::post('/plan/destroy', 'PlanController@delete');

    Route::get('/stats', 'ReportController@index')->name('stats');
    Route::post('/stats/bar', 'ReportController@bar');
    Route::post('/stats/bubble', 'ReportController@bubble');
    Route::post('/stats/line', 'ReportController@line');

    
    Route::get('/modality', 'ModalityController@index')->name('modality');
    Route::post('/modality', 'ModalityController@store')->name('modality');


    Route::get('/checkin', 'CheckinController@index')->name('checkin');
    Route::get('/checkin/history', 'CheckinController@history');
    Route::post('/checkin/company', 'CheckinController@company');
    Route::post('/checkin', 'CheckinController@store')->name('checkin');
    Route::post('/checkin/list', 'CheckinController@filter');    
    Route::post('/checkin/destroy', 'CheckinController@delete');

    Route::get('/classes', 'ClassesController@index')->name('classes');
    Route::post('/classes', 'ClassesController@store')->name('classes');
    Route::post('/classes/list', 'ClassesController@filter');
    Route::post('/classes/destroy', 'ClassesController@delete');


    Route::get('/user-plan', 'UserPlanController@index')->name('user-plan');
    Route::post('/user-plan', 'UserPlanController@store')->name('user-plan');
    Route::post('/user-plan/list', 'UserPlanController@filter');
    Route::post('/user-plan/destroy', 'UserPlanController@delete');
    Route::post('/user-plan/expiration', 'UserPlanController@expiration');


    Route::get('/users', 'UserController@index')->name('users');
    Route::post('/users', 'UserController@store')->name('users');
    Route::post('/users/list', 'UserController@filter');
    Route::post('/users/destroy', 'UserController@destroy');
});




