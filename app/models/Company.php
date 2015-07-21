<?php 
Class Company extends Eloquent{
	public $table = 'companies';
	protected $fillable = array('name','real_quantity','internal_received_quantity','received_quantity','internal_sale_quantity','sale_quantity','mortality_quantity','country_id');

	public function country(){
		return $this->belongsTo('Country','country_id');
	}

	public function feedlots(){
		return $this->belongsToMany("FeedLot","company_feedlot",'company_id','feedlot_id')->withPivot('real_quantity','internal_received_quantity','received_quantity','internal_sale_quantity','sale_quantity','mortality_quantity');
	}
}