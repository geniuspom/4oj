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
//Route::get('reset/{id}/token/{token}', 'Resetpassword@reset');

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
