<?php
Class Farm extends Eloquent{
	public $table = 'farms';
	protected $fillable = array('name','real_quantity','import_quantity','export_quantity','transfer_quantity','companyID','locationID');
	public function company(){
		return $this->belongsTo('Company','companyID');
	}
	public function location(){
		return $this->belongsTo('Location','locationID');
	}
	public function cattleImports(){
		return $this->hasMany("cattleImport","farmID");
	}

	public function cowExports(){
		return $this->hasMany("CowExport","farmID");
	}

	public function cowDeaths(){
		return $this->hasMany("CowDeath","farmID");
	}

	public function cowFromTransfers(){
		return $this->hasMany("CowTransFer","from_farmID");
	}
	public function cowToTransfers(){
		return $this->hasMany("CowTransFer","to_farmID");
	}
	public function contracts(){
		return $this->hasMany("Contract","farm_id");
	}
}