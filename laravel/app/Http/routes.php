<?php

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


Route::group(['middleware' => 'auth'], function()
{
    Route::get('/', 'LoginController@index');
});

//Link to page
Route::get('login','LoginController@checklogin');

Route::get('register',function(){
    return View::make('Member.register');
});

Route::get('forgot',function(){
    return View::make('Member.forgotpass');
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
