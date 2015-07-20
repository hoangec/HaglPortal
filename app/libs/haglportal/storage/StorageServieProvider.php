<?php namespace Haglportal\Storage;
use Illuminate\Support\ServiceProvider;
class StorageServiceProvider extends ServiceProvider{
	public function register(){
		$this->app->bind("Haglportal\Storage\User\IUserRepository","Haglportal\Storage\User\EloquentUserRepository");
	}

}