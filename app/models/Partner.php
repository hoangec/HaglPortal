<?php
class Partner extends Eloquent{
	public $table = 'partners';
	protected $fillable = array('name','import_quantity','export_quantity','death_qauntity','transfer_quantity','import_avg_prices','import_counts');	
	
	public function cowimport(){
		return $this->hasMany('CowImport','partnerID');
	}
}