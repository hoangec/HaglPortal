<?php
class CattleImport extends Eloquent{
	public $table = 'cattle_imports';
	protected $fillable = array('import_date','batch_name','feedersteer','feederheifer','breederbull','breederheifer','real_total_weight','contract_id','farm_id','user_id','partner_id');
	
	public function contract(){
		return $this->belongsTo('Contract');
	}
	public function farm(){
		return $this->belongsTo('Farm','farmID');
	}
	public function user(){
		return $this->belongsTo('User','userID');
	}

	public function partner(){
		return $this->belongsTo('Partner','partnerID');
	}

	public function cattleForSales(){
		return $this->hasManys('CattleForSale','cattle_import_id');
	}
	public static $CattleImportRule = array(
			'batch_name'			=> 'required',
			'import_date'			=> 'required|date',
			'feedersteer_quantity'		=> 'required',
			'feederheifer_quantity'	=> 'required',
			'breederbull_quantity'		=> 'required',
			'breederheifer_quantity'		=> 'required',
		);
	public static $CattleImportLangs = array(
			'batch_name.required'			=>'Xin vui lòng nhập tên lô',
			'import_partner.required'		=>'Xin vui lòng nhập tên nhà nhập khẩu',
			'import_date.required'			=>'Xin vui lòng nhập định dạng ngày',
			'feedersteer_quantity.required'	=> "Xin vui lòng nhập số lượng bò thịt đực",
			'feederheifer_quantity.required'	=> "Xin vui lòng nhập số lượng bò thịt cái",
			'breederbull_quantity.required'		=> "Xin vui lòng nhập số lượng bò giống đực",
			'breederheifer_quantity.required'		=> "Xin vui lòng nhập số lượng bò giống cái",
		);
}