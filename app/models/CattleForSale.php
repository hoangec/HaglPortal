<?php
class CattleForSale extends Eloquent{
	public $table = 'cattle_for_sales';
	protected $fillable = array('name','date_left_feedlot','feedersteer','feederheifer','breederbull','breederheifer','prices','cattle_import_id','abattoir_id','user_id');
	public function cattleImport(){
		return $this->belongsTo('CattleImport','cattle_import_id');
	}
	public function abattoir(){
		return $this->belongsTo('Abattoir','abattoir_id');
	}
	public function user(){
		return $this->belongsTo('User','userID');
	}
}