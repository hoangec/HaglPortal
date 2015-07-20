<?php
class Exporter extends Eloquent{
	public $table = 'exporters';
	protected $fillable = array('exporter_name','real_quantity','sale_quantity','mortality_quantity');	

}