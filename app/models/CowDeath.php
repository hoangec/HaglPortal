<?php
class CowDeath extends Eloquent{
	public $table = 'cowdeath';
	public function farm(){
		return $this->belongsTo('Farm','farmID');
	}
	public function user(){
		return $this->belongsTo('User','userID');
	}
}