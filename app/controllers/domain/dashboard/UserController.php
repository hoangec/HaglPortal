<?php namespace Controllers\Domain\Dashboard;
use Haglportal\Storage\User\IUserRepository as User;
use Cartalyst\Sentry\Facades\Laravel\Sentry as Sentry;

class UserController extends \BaseController{
	protected $user;
	public function __construct(User $user){
		$this->user = $user;
	}

	public function getMyProfile(){
		// lay ID hien tai cua nguoi dang dang nhap
		$userID = Sentry::getUser()->id;
		// Lay profile
		$userProfile = $this->user->getUserProfile($userID);
		return \View::make("dashboard.users.userprofile")->with("title","Profile")->with("data",$userProfile);
	}
}