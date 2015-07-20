<?php
class Abattoir extends Eloquent{
	public $table = 'abattoirs';
	protected $fillable = array('name','export_quantity','export_counts','export_total_prices');	

	public function cattlesForSales(){
		return $this->hasMany('CattleForSale','abattoir_id');
	}
}