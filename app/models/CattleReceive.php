<?php
class CattleReceive extends Eloquent{
	public $table = 'cattle_receive';
	protected $fillable = array('batch_name','date_arrive','description','feeder_steer_quantity','feeder_heifer_quantity','breeder_bull_quantity','breeder_heifer_quantity');

	public function cattlereceipts(){
		return $this->hasMany("CattleReceipt","cattle_receive_id");
	}
}