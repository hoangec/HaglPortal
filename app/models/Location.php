<?php
class Location extends Eloquent{
	public $table = 'locations';
	protected $fillable = array('name','real_quantity','import_quantity','export_quantity','transfer_quantity','nationalID');
	
	public function farms(){
		return $this->hasMany("Farms","locationID");
	}

	public function national(){
		return $this->belongsTo("National","nationalID");
	}

}	