<?php 
Class Company extends Eloquent{
	public $table = 'companies';
	protected $fillable = array('name','real_quantity','received_quantity','export_quantity','transfer_quantity','nationalID');
	public function national(){
		return $this->belongsTo('National','nationalID');
	}
	public function farms(){
		return $this->hasMany('Farm','companyID');
	}

	public function feedlots(){
		return $this->belongsToMany("FeedLot","company_feedlot",'company_id','feedlot_id')->withPivot('real_quantity','internal_received_quantity','received_quantity','internal_sale_quantity','sale_quantity','mortality_quantity');
	}

/*	public function newPivot(Eloquent $parent, array $attributes, $table, $exists) {
        if ($parent instanceof CompanyFeedlot) {
            return new CompanyFeedlot($parent, $attributes, $table, $exists);
        }
        return parent::newPivot($parent, $attributes, $table, $exists);
    }*/
}