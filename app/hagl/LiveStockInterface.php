<?php
interface LiveStockInterface{
	// Get total Real Cattle
	function getAllRealCattle();
	// Get total  imported cattle form partners
	function getAllImportCattle();
	// Get total exported cattle to abattoir
	function getAllExportCattle();
	// get total death cattle
	function getAllDeathCattle();
}
