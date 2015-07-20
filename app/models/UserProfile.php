<?php 
Class UserProfile extends Eloquent{
	public $table="user_profile";
	// Chi ra thuoc tinh soft delete
	protected $softDelete = true;
	// Khai bao relationship 
	// 1:1 on Users
	public function Users(){
		return $this->belongsTo("User","id");
	}
}