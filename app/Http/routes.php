<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/home', 'FlightController@index');

Route::get('/', 'FlightController@index');

Route::get('/profile', 'UserController@profile');

Route::get('/flight-list', 'FlightController@searchFlightList');

Route::get('/flight-list-return', 'FlightController@searchFlightList_Return');

Route::get('/flight-detail', 'FlightController@flightDetail');

Route::get('/flight-detail-return', 'FlightController@flightDetail_Return');

Route::get('/index', 'FlightController@index');

Route::get('/airport-by-city-from', 'FlightController@airport_city_from');

Route::get('/airport-by-city-to', 'FlightController@airport_city_to');

Route::post('/flight-book', 'FlightBookController@getFlightBook');

Route::post('/postBooking', 'FlightBookController@postBooking');

Route::post('/detail-book-profile', 'UserController@postDetail_book_profile');

Route::get('/cancel-ticket', 'UserController@cancel_ticket');

Route::post('/update_user', 'UserController@update_user');

Route::post('/update-customer', 'UserController@update_customer');


Route::get('/auth/login', 'Auth\LoginController@getLogin');

Route::post('/checkLogin', 'Auth\LoginController@checkLogin');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

//Manage flight
Route::get('/admin/index', 'ManageFlightController@index');

Route::get('/admin/load-city', 'ManageFlightController@get_city_by_id_country');

Route::get('/admin/load-airline', 'ManageFlightController@get_airline_by_country_code');

Route::get('/admin/load-airport', 'ManageFlightController@get_aiport_by_id_city');

Route::get('/admin/detail-ticket-flight', 'ManageFlightController@get_detail_ticket');

Route::get('/admin/create-transnational-flight', 'ManageFlightController@get_create_transnational_flight');

Route::get('/admin/create-domestic-flight', 'ManageFlightController@get_create_domestic_flight');

Route::get('/admin/manage-tickets', 'ManageFlightController@get_ticket_list');

Route::get('/admin/update-customer', 'ManageFlightController@update_customer');

Route::get('/admin/cancel-ticket', 'ManageFlightController@cancel_ticket');

Route::get('/admin/revenue-airlines', 'ManageFlightController@get_revenue_airlines');

Route::get('/admin/airport-manager', 'ManageFlightController@get_aiport_paginate');

Route::post('/admin/post-domestic-flight', 'ManageFlightController@post_domestic_flight');

Route::post('/admin/post-transnational-flight', 'ManageFlightController@post_transnational_flight');


