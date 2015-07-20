<?php
class FeedLot extends Eloquent{
	public $table = 'feedlots';
	protected $fillable = array('name','real_quantity','received_quantity','sale_quantity','mortality_quantity');

	public function comapnies(){
		return $this->belongsToMany("Company","company_feedlot_receive","feedlot_id","company_id");
	}

	public function companies(){
		return $this->belongsToMany("Company","company_feedlot",'company_id','feedlot_id')->withPivot('real_quantity','internal_received_quantity','received_quantity','internal_sale_quantity','sale_quantity','mortality_quantity');
	}

/*	public function newPivot(Eloquent $parent, array $attributes, $table, $exists) {
        if ($parent instanceof CompanyFeedlot) {
            return new CompanyFeedlot($parent, $attributes, $table, $exists);
        }
        return parent::newPivot($parent, $attributes, $table, $exists);
    }*/
}