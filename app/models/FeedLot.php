<?php
class FeedLot extends Eloquent{
	public $table = 'feedlots';
	protected $fillable = array('name','real_quantity','internal_received_quantity','received_quantity','sale_quantity','mortality_quantity');

	public function companies(){
		return $this->belongsToMany("Company","company_feedlot",'company_id','feedlot_id')->withPivot('real_quantity','internal_received_quantity','received_quantity','internal_sale_quantity','sale_quantity','mortality_quantity');
	}
}