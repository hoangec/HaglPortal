<?php
use Illuminate\Database\Eloquent\Relations\Pivot;
class CompanyFeedlot extends Eloquent {
	public $table = 'company_feedlot';
	public function CattleReceipts(){
		return $this->hasMany('CattleReceipt','company_feedlot_id');
	}
}