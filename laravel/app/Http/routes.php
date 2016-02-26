<?php
use App\Http\Controllers\LoginController as LoginController;
use App\Models\Database\user as user;

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::filter('Admincheck',function(){
	$permission = LoginController::checkadmin();

	if($permission == 0){
			return View('Member.Login');
	}
	else if($permission != 3){
			return Redirect::to('/');
	}

});

Route::filter('Staffcheck',function(){
	$permission = LoginController::checkadmin();

	if($permission == 0){
			return View('Member.Login');
	}
	else if($permission == 1){
			return Redirect::to('/');
	}
	
});


//check login
Route::group(['middleware' => 'auth'], function()
{
    Route::get('/', 'LoginController@index');

		Route::get('poatregister', function(){
				return View::make('Member.post_register');
		});

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
		Route::get('editjob/{id}', function($id){
				return View::make('Request_Job.editjob');
		});
		//detail
		Route::get('detail_request/{id}', function($id){
				return View::make('Request_Job.detail');
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
					return View::make('Admin.admin');
			});
			//view user profile admin
			Route::get('profile_admin/{id}',function($id){
					return View::make('Admin.profile_user');
			});
			//edit user profile admin
			Route::get('useredit_admin/{id}',function($id){
					return View::make('Admin.edit_user');
			});
			//Assignment
			Route::get('assigment/{id}',function($id){
					return View::make('Assign.assign');
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

			//report request job
			Route::get('reportrequestjob/{id}', function($id){
					return View::make('Request_Job.report');
			});

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
//Upload pic & id new
Route::post('uploaduser','Member\uploadfunction@main');



//Admin Function
Route::post('admin_get_user_filter','AdminController@get_filter_jquery');
//Admin update user
Route::post('adminupdateuser','AdminController@update_user');



//Calendar change
Route::post('nextcalendar','Calendar@getformjquery');
Route::post('changeassingcalendar','Assignment\AssignCalendar@getformjquery');


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
//add room
Route::post('add_room','venue\VenueManage@main');
//end function venue



//function event
//add
Route::post('add_event','EventControl@add');
//edit
Route::post('edit_event','EventControl@edit');
//jquery get data form
Route::post('geteventform','EventControl@getformjquery');
//get event report from jquery
Route::post('get_event_filter','EventControl@get_filter_jquery');
//Update event task status
Route::post('update_task_event','event_task\event_task_manage@update_event_task');
//Update inventory
Route::post('update_inventory','Inventory\inventoryManage@main');
//get auto complete venue room
Route::any('get_room_autocomplete','venue\AutoCompleteVenue@main');
//Update payment
Route::post('update_payment','Payment\paymentManage@main');
//end function event



//function request job
Route::post('add_request_job','RequestJob@add');
//delete
Route::post('delete_jobrequest','RequestJob@delete');
//edit
Route::post('edit_request_job','RequestJob@edit');
//report
Route::post('get_report_filter','RequestJob@get_report_jquery');
//request event
Route::post('request_event','RequestJob@request_event');
//end function request job

//function assignment
Route::post('update_assignment','Assignment\AssignManage@main');
Route::post('request_assign_jquery','Assignment\Assign@jquery_data');


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

Route::get('test_upload', function(){
		return View::make('Venue.test_upload');
});
Route::any('uploadplan','venue\uploadplan@main');

Route::get('test_query',function(){
	//$query = user::find(31)->event->toArray();

	/*$query = user::where('id', '=', '31')->whereHas('event', function ($q) {
    $q->where('event_date', '=', '2016-02-17');
})->get();*/


//$query = user::find(31)->assign('2016-02-17')->get()->toArray();
//$query = user::find(31)->assign('2016-02-17')->count();
//$query = App\Models\Database\venue_room::find(1);

//echo $query->venue->name.",".$query->room_name.",".$query->venue->address;





	//echo $query;
	//dd($query);
});
