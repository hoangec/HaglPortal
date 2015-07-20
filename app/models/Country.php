<?php
Class Country extends Eloquent{
	public $table = 'countries';
	protected $fillable = array('name','real_quantity','recevied_quantity','sale_quantity','mortality_quantity');
	
	public function companies(){
		return $this->hasMany('Company','country_id');
	}

}