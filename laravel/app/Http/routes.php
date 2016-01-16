<?php

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::group(['middleware' => 'auth'], function()
{
    Route::get('/', 'LoginController@index');
		Route::get('admin',function(){
		    return View::make('Member.admin');
		});
});

//Link to page
Route::get('login','LoginController@checklogin');

Route::get('register',function(){
    return View::make('Member.register');
});

Route::get('forgot',function(){
    return View::make('Member.forgotpass');
});

Route::get('useredit/{id}', function($id){
    return View::make('Member.useredit');
});

Route::get('user_profile', function(){
		return View::make('Member.profile');
});

Route::get('reset/{id}/token/{token}', function($id,$token){
		return View::make('Member.reset');
});

//Activate page
Route::get('activate/{activatecode}', function($activatecode){
    return View::make('Member.activate');
});



//Customer
Route::get('customer', function(){
		return View::make('Customer.customer');
});
//add
Route::get('add_customer', function(){
		return View::make('Customer.add');
});
//View
Route::get('customer_detail/{id}', function($id){
		return View::make('Customer.detail');
});
//edit
Route::get('edit_customer/{id}', function($id){
		return View::make('Customer.edit');
});
//End customer



//Venue
Route::get('venue', function(){
		return View::make('Venue.venue');
});
//add
Route::get('add_venue', function(){
		return View::make('Venue.add');
});
//View
Route::get('venue_detail/{id}', function($id){
		return View::make('Venue.detail');
});
//edit
Route::get('edit_venue/{id}', function($id){
		return View::make('Venue.edit');
});
//End Venue



//Function
//Logout
Route::get('logout','LoginController@logout');

//Post Register
Route::post('register','LoginController@register');
//Post Login
Route::post('login','LoginController@login');
//Post Forgot password
Route::post('forgot','Sendmail@sendEmailForgot');
//Post Update user
Route::post('updateuser','GetUser@updateuser');
//Post Reset Password
Route::post('resetpassword','Resetpassword@reset');
//Post Activate account
Route::post('activateaccount','LoginController@activate');


//function customer
//add
Route::post('add_customer','Customercontrol@add');
//edit
Route::post('edit_customer','Customercontrol@edit');
//end function customer


//function venue
//add
Route::post('add_venue','VenueControl@add');
//edit
Route::post('edit_venue','VenueControl@edit');
//end function venue
