<?php
Class CowTransfer extends Eloquent{
	public function fromFarm(){
		return $this->belongsTo('Farm','from_farmID');
	}
	public function toFarm(){
		return $this->belongsTo('Farm','to_farmID');
	}
	public function user(){
		return $this->belongsTo('User','userID');
	}
}