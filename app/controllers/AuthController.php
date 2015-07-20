<?php
use Cartalyst\Sentry\Users\WrongPasswordException as  WrongPasswordException;
use Cartalyst\Sentry\Users\UserNotFoundException as UserNotFoundException;
use Cartalyst\Sentry\Users\UserNotActivatedException as UserNotActivatedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException as UserSuspendedException;
use Cartalyst\Sentry\Throttling\UserBannedException as UserBannedException;

class AuthController extends BaseController{
	public function postLogin(){
		$email = Input::get("emailLogin");
		$pass  = Input::get("passLogin");
		$remmber = Input::get("rememCheck");
		try{
			$credentials = array(
				"email" 	=> $email,
				"password"	 	=> $pass
			);
			if($remmber){
				Sentry::Authenticate($credentials,true);
			}else{
				Sentry::Authenticate($credentials,false);
			}
			//return Redirect::to("dashboard");
			return Redirect::route("front_report_livestock_index_get");
		}catch(WrongPasswordException $e){

			return Redirect::route("login_get")->with("message","error101");
		}catch(UserNotFoundException $e){
		
			return Redirect::route("login_get")->with("message","error102");
		}catch(UserNotActivatedException $e){
			
			return Redirect::route("login_get")->with("message","error103");
		}catch(UserSuspendedException $e){
			
			return Redirect::route("login_get")->with("message","error104");
		}catch(UserBannedException $e){
			
			return Redirect::route("login_get")->with("message","error105");
		}
	}
	// Xu ly logout
	Public function getLogout(){
		Sentry::logout();
		return Redirect::route("login_get");
	}
}