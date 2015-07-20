<?php
class CattleForTransfer extends Eloquent{
	public $table = 'cattle_for_transfer';
	
	protected $fillable = array('name','date_left_feedlot','company_feedlot_src_id','company_feedlot_des_id','feeder_steer_quantity','feeder_heifer-quantity','breeder_bull_quantity','breeder_heifer_quantity','user_id');
	
	public function user(){
		return $this->belongsTo('User','userID');
	}

	public function companyFeedlotSrc(){
		return $this->belongsTo('CompanyFeedlot','company_feedlot_src_id');
	}


	public function companyFeedlotDes(){
		return $this->belongsTo('CompanyFeedlot','company_feedlot_des_id');
	}

}