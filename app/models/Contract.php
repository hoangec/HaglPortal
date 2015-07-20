<?php
Class Contract extends Eloquent{
	public $table = 'import_contract';
	protected $fillable = array('name','imp_status','imp_status_text','import_date','lc_open_last_date','partner_id','company_id','farm_id','port_id','feedersteer_quantity','feederheifer_quantity','breederbull_quantity','breederheifer_quantity','feedersteer_weight','feederheifer_weight','breederbull_weight','breederheifer_weight','feedersteer_price','feederheifer_price','breederbull_price','breederheifer_price','diff_total_quantity','diff_total_weight','farm_id','userID');
	
	public function cattleImport(){
		return $this->hasMany('CattleImport');
	}

	public function port(){
		return $this->belongsTo("Port","port_id");
	}
	public function farm(){
		return $this->belongsTo("Farm","farm_id");
	}
}