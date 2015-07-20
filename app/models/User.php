<?php
use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;
class User extends SentryUserModel {

	public function cowImports(){
		return $this->hasMany('CowImport','userID');
	}
	public function cattleForSales(){
		return $this->hasMany('CattleForSale','user_id');
	}
	public function cowDeaths(){
		return $this->hasMany('CowDeath','userID');
	}
	public function cowTransfers(){
		return $this->hasMany('CowTransfer','userID');
	}

}
