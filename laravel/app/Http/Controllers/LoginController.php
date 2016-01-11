<?php
namespace App\Http\Controllers;

use App\Models\Member as Member;
use App\Models\validateuser as validateuser;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Request;

Class LoginController extends Controller{
    
    public function register(Request $request){
        
        $validate = validateuser::validate(Request::all());
        
        if($validate->passes()){
            $user = new Member();
            $user->email = $request::input('email');
            $user->password = \Hash::make($request::input('password'));
            $user->name = $request::input('name');
            $user->surname = $request::input('surname');
            $user->nickname = $request::input('nickname');
            $user->phone = $request::input('phone');
            $user->id_card = $request::input('id_card');
            $user->bank = $request::input('bank');
            $user->account_no = $request::input('account');
            $user->education = $request::input('education');
            $user->institute = $request::input('institute');
            $user->reference = $request::input('reference');
            
            $link = '';
            
            if($user->save()) {
                $userinfo = $request::only('email','password');

                if(Auth::attempt($userinfo)){
                    $link = '/';
                }
                
                //ส่ง email
                
                //จบส่ง email
                
            } else {
                $link = 'register';
            }
            
            return Redirect::to($link);
            
        }else{
            return redirect::to('register')
                    ->withInput(Request::except('password'))
                    ->withErrors($validate->messages());
        }
        
    }
    
    public function login(Request $request){
        $userinfo = $request::only('email','password');
        if(Auth::attempt($userinfo)){
            return Redirect::to('/');
        }else{
            return redirect()->back()
                    ->with('message',"Error!! Username or Password Incorrect. \nPlease try again.")
                    ->withInput(Request::except('password'));
        }
    }
    
    public function logout(){
        
        Auth::logout();
        return Redirect::to('login');
    }
    
    public function checklogin(){
        if(Auth::check()){
            return Redirect::to('/');
        }else{
            return View('Member.Login');
        }
    }
    
}