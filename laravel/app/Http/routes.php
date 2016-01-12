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

//Function
//Logout
Route::get('logout','LoginController@logout');

//Post Register
Route::post('register','LoginController@register');
//Post Login
Route::post('login','LoginController@login');
//Post Forgot password
Route::post('forgot','Sendmail@sendEmailForgot');
//Post Forgot password
Route::post('updateuser','GetUser@updateuser');
