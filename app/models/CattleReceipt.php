<?php 
Class CattleReceipt extends Eloquent{
	public $table = 'cattle_receipt';
	protected $fillable = array('name','feeder_steer_quantity','feeder_heifer_quantity','breeder_bull_quantity','breeder_heifer_quantity','company_feedlot_id','cattle_receive_id');
	
	public function companyFeedlot(){
		return $this->belongsTo('CompanyFeedlot','company_feedlot_id');
	}
	public function feedlot(){
		return $this->belongsTo("FeedLot","company_feedlot_receive","feedlot_id","company_id");
	}
	public function cattleReceive(){
		return $this->belongsTo('CattleReceive','cattle_receive_id');
	}
}