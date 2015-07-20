<?php namespace Haglportal\Storage\User;
use \User as User;
use \UserProfile as UserProfile;

Class EloquentUserRepository implements IUserRepository{
	public function getUserProfile($userID){
		try{
			// lay user, cac thong tin chinh luua vao main data
			$user['mainData'] = User::find($userID)->toArray();
			// lay profile tuong ung cua user luu vao bien profile
			$temProfile = UserProfile::find($userID);
			if($temProfile == null){
				$user['Profile']["image_url"] = null;
				$user['Profile']["email"] = null;
				$user['Profile']["address"] = null;
				$user['Profile']["phone"] = null;
				$user['Profile']["about"] = null;
			}else{
				$user['profile'] = $temProfile->toArray();
			}
			return $user;
		}catch(Expection $e){
			Log::error("error in User Respository - getUserProfile:" . $e.getMesseage());
			throw new SomethingWentWrongExpection;
		}
	}
	//
}