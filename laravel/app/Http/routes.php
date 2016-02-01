<?php
use App\Http\Controllers\LoginController as LoginController;

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::filter('Admincheck',function(){
	$permission = LoginController::checkadmin();

	if($permission != 3){
			return Redirect::to('/');
	}
});

Route::filter('Staffcheck',function(){
	$permission = LoginController::checkadmin();

	if($permission == 1){
			return Redirect::to('/');
	}
});


//check login
Route::group(['middleware' => 'auth'], function()
{
    Route::get('/', 'LoginController@index');

		Route::get('useredit/{id}', function($id){
		    return View::make('Member.useredit');
		});

		Route::get('user_profile', function(){
				return View::make('Member.profile');
		});

		//Request job
		Route::get('add_request/{date}', function($date){
				return View::make('Request_Job.newjob');
		});
		//edit
		Route::get('editjob', function(){
				return View::make('Request_Job.editjob');
		});
		//End request job

		//event
		Route::get('event', function(){
				return View::make('event.event');
		});

		//View event
		Route::get('event_detail/{id}', function($id){
				return View::make('event.detail');
		});

		//View event
		Route::get('send_email_verify', 'LoginController@send_email_verify');


		//Check admin
		Route::group(['before' => 'Admincheck'], function(){

			Route::get('admin',function(){
					return View::make('Member.admin');
			});

		});

		//Check staff
		Route::group(['before' => 'Staffcheck'], function(){

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

			//add_contact
			Route::get('add_contact/{id}', function($id){
					return View::make('Customer.addcontact');
			});
			//edit contact
			Route::get('edit_contact/{id}', function($id){
					return View::make('Customer.editcontact');
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

			//add event
			Route::get('add_event', function(){
					return View::make('event.add');
			});
			//edit event
			Route::get('edit_event/{id}', function($id){
					return View::make('event.edit');
			});
			//End event


		});

});


Route::get('login','LoginController@checklogin');

Route::get('register',function(){
    return View::make('Member.register');
});

Route::get('forgot',function(){
    return View::make('Member.forgotpass');
});

Route::get('reset/{id}/token/{token}', function($id,$token){
		return View::make('Member.reset');
});

//Activate page
Route::get('activate/{activatecode}', function($activatecode){
    return View::make('Member.activate');
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
//Post Update user
Route::post('updateuser','GetUser@updateuser');
//Post Reset Password
Route::post('resetpassword','Resetpassword@reset');
//Post Activate account
Route::post('activateaccount','LoginController@activate');
//upload profile picture
Route::post('uploaduser','UploadController@profilepicture');
//upload id card
Route::post('uploadidcard','UploadController@uploadidcard');

//Calendar change
Route::post('nextcalendar','Calendar@getformjquery');


//function customer
//add
Route::post('add_customer','Customercontrol@add');
//edit
Route::post('edit_customer','Customercontrol@edit');
//add Contact
Route::post('add_contact','Customer\Contact@add_contact');
//edit Contact
Route::post('edit_contact','Customer\Contact@edit_contact');
//delete COntact
Route::post('delete_contact','Customer\Contact@delete_contact');
//end function customer


//function venue
//add
Route::post('add_venue','VenueControl@add');
//edit
Route::post('edit_venue','VenueControl@edit');
//end function venue



//function event
//add
Route::post('add_event','EventControl@add');
//edit
Route::post('edit_event','EventControl@edit');
//jquery get data form
Route::post('geteventform','EventControl@getformjquery');
//end function event



//function request job
Route::post('add_request_job','RequestJob@add');
//end function request job


//upload
Route::get('upload','UploadController@getIndex');
Route::post('postupload','UploadController@postAction');



//test package
Route::get('imagepackage', function()
{
    $img = Image::make('images/picture.jpg');

		if($img->height() > $img->width()){
			$imgresult = $img->resize(null, 206, function ($constraint) {
			$constraint->aspectRatio();
			});
		}else{
			$imgresult = $img->resize(206, null, function ($constraint) {
			$constraint->aspectRatio();
			});
		}
    //return $imgresult->response('jpg');
		$imgresult->save('images/new.jpg');
});

//test calendar
Route::get('calendar', function(){
		return View::make('Calendar.test');
});
Route::get('calendar2', function(){
		return View::make('Calendar.test3');
});
