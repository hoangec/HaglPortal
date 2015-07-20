<?php
class Port extends Eloquent{
	public $table = "ports";
	protected $fillable = array('name');

	public function contracts(){
		return $this->hasMany("Contract");
	}
}