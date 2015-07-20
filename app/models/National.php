<?php
Class national extends Eloquent{
	public $table = 'nationals';
	protected $fillable = array('name','real_quantity','import_quantity','export_quantity','transfer_quantity');
	
	public function companies(){
		return $this->hasMany('Company','nationalID');
	}

	public function locations(){
		return $this->hasMany('Location','nationalID');
	}
}