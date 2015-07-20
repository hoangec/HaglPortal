<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	if(!Sentry::Check()){
		return View::make("login.index");
	}else{
		return Redirect::route("front_report_livestock_index_get");
	}

});
/* ---*/
Route::get('login',array("as"=>"login_get",function(){
	if(!Sentry::check())
	{
		return View::make('login.index');
	}
	else
	{
		return Redirect::route('front_report_livestock_index_get');
	}
}));
/*Route xu ly duogn dan kg tim thay */
Route::get("error.html",array("as"=>"error_page",function(){
	return View::make('errors.somethingwentwrong');	
}));
Route::get('logout',array("as"=>"logout_get","before"=>"check_user","uses"=>"AuthController@getLogout"));
/* Cac route xu ly chung thuc nguoi dung */
Route::post("auth/login",array("as"=>"login_post","before"=>"is_login","uses"=>"AuthController@postLogin"));

Route::group(array('prefix'=>'dashboard',"before"=>"check_user"),function(){
	/*Route::get("/",function(){
		return View::make("dashboard.index")->with("title","Dashboard");
	});*/
	
	Route::get('reports/livestock',array("as"=>"front_report_livestock_index_get","uses"=>"Controllers\Domain\Dashboard\Report\LiveStockController@getIndex"));

	Route::get('reports/livestock/real-quantity/{country?}',array("as"=>"front_report_livestock_real_quantity_get","uses"=>"Controllers\Domain\Dashboard\Report\LiveStockController@getRealQuantity"));

	Route::get('reports/livestock/received-quantity/{exporter?}',array("as"=>"front_report_livestock_received_quantity_get","uses"=>"Controllers\Domain\Dashboard\Report\LiveStockController@getReceivedQuantity"));

	Route::get('reports/livestock/received-quantity/company/{companyid?}',array("as"=>"front_report_livestock_received_quantity_company_get","uses"=>"Controllers\Domain\Dashboard\Report\LiveStockController@getReceivedQuantityByCompany"));

	Route::get('reports/livestock/cattle-for-sale/{abattoir?}',array("as"=>"front_report_livestock_cattle_for_sale_get","uses"=>"Controllers\Domain\Dashboard\Report\LiveStockController@getCattleForSale"));

	Route::get('reports/livestock/death-quantity/{country?}',array("as"=>"front_report_livestock_death_quantity_get","uses"=>"Controllers\Domain\Dashboard\Report\LiveStockController@getDeathQuantity"));

	/*Xử lý Ajax lấy số lượng thực tế */
	Route::get('reports/beef/ajaxquantity/real',array("as"=>"report_real_quantity_ajax_get","uses"=>"Controllers\Domain\Dashboard\Report\LiveStockController@getRealQuantity"));
	
	Route::get('reports/beef/ajaxquantity/realByCompany',array("as"=>"report_company_real_quantity_ajax_get","uses"=>"Controllers\Domain\Dashboard\Report\LiveStockController@getRealQuantityByCompany"));

	Route::get('reports/beef/ajaxquantity/realChartByCompany',array("as"=>"report_chart_company_real_quantity_ajax_get","uses"=>"Controllers\Domain\Dashboard\Report\LiveStockController@getCompaniesRealQuantityByCountry"));
	
	// Chuc nang hien thi profile
	Route::get("/me",array("as"=>"my_profile_get","uses"=>"Controllers\Domain\Dashboard\UserController@getMyProfile"));
	/*------ Admin Route -----------*/
	Route::group(array('prefix' =>'admin'),function(){
		Route::get('reports/livestock',array('as'=>'admin_report_livestock_index_get','uses'=>"Controllers\Domain\Admin\LiveStockController@getIndex"));

		Route::get('reports/livestock/import-contract',array('as'=>'admin_report_import_contract_get','uses'=>'Controllers\Domain\Admin\LiveStockController@getImportContract'));

		Route::post('reports/livestock/import-contract',array('as'=>'admin_report_import_contract_add_post','uses'=>'Controllers\Domain\Admin\LiveStockController@postImportContractAdd'));

		Route::get('reports/livestock/import-real-quantity',array('as'=>'admin_report_import_quantity_get','uses'=>'Controllers\Domain\Admin\LiveStockController@getImportQuantity'));
		Route::post('reports/livestock/import-real-quantity/add',array('as'=>'admin_report_import_quantity_add_post','uses'=>'Controllers\Domain\Admin\LiveStockController@postImportQuantityAdd'));
		Route::post('reports/livestock/importquantity/update',array('as'=>'admin_report_import_quantity_update_post','uses'=>'Controllers\Domain\Admin\LiveStockController@postImportQuantityUpdate'));

		Route::get('reports/livestock/importquantity/delete/{id}',array('as'=>'admin_report_import_quantity_delete_get','uses'=>'Controllers\Domain\Admin\LiveStockController@getImportQuantityDelete'));
	});
});


/* tao du lieu mau */
Route::get("create_user",function(){
	$user = Sentry::createUser(array(
			"email"=>"vohoangec@gmail.com",
			"password"=>"12345",
			"first_name" => "Hoàng",
			"last_name" => "Võ Trọng",
			"activated" => 1,
			"permissions" =>array(
					"admin" => 1
				)
		));
	return "Done";
});

Route::get('posts',function(){
	return "all posts";
});

Route::get('posts2',function(){
	return View::make("posts",array('post'=>'abc'));
});

Route::get('posts3',function(){
	//$user = User::all();
	$user = array('1'=>2);
	return View::make("posts",array('posts'=>$user));
});

Route::get('imfarm_create',function(){

	$farmImportInsert = array(
		'qtyMaleBeef'	=> 0,
		'qtyFemaleBeef' => 0,
		'qtySteer'		=> 0,
		'qtyHeifer'		=> 0
	);
	$str = "";
	for($i = 1; $i <= 3 ; $i++){
		$mFarm = National::find($i);
		$mFarm->real_quantity = json_encode($farmImportInsert);
		$mFarm->save();
		$mFarm = National::find($i);
		$mFarm->import_quantity = json_encode($farmImportInsert);
		$mFarm->save();
		$mFarm = National::find($i);
		$mFarm->export_quantity = json_encode($farmImportInsert);
		$mFarm->save();
		$mFarm = National::find($i);
		$mFarm->transfer_quantity = json_encode($farmImportInsert);
		$mFarm->save();
		$mFarm = National::find($i);
		$mFarm->death_quantity = json_encode($farmImportInsert);
		$mFarm->save();
		$str .= $i . 'Xong <br />';
	}
	
	return $str;
});
Route::get('imfarm_get',function(){
	$mFarm = Farm::find(1);
	$arrImFarm = json_decode($mFarm->import_quantity,true);
	echo '<pre>';
	print_r($arrImFarm);
	echo '</pre>';
});


Route::get('refactory',function(){
	$farms = Farm::All();
	$data = array(
			'feedersteer' => 0,
			'feederheifer' => 0,
			'breederbull' => 0,
			'breederheifer' =>0
	);
	foreach($farms as $farm){
		
		$farm->update(array('real_quantity' => json_encode($data)));
		$farm->update(array('import_quantity'=>json_encode($data)));
	}
	$companies = Company::All();
	foreach($companies as $company){
		$company->update(array('real_quantity'=> json_encode($data)));
		$company->update(array('import_quantity'=>json_encode($data)));
	}
	$countries = National::All();
	foreach($countries as $country){
		$country->update(array('real_quantity' =>json_encode($data)));
		$country->update(array('import_quantity'=>json_encode($data)));
	}
	$locations = Location::All();
	foreach($locations as $location){
		$location->update(array('real_quantity' =>json_encode($data)));
		$location->update(array('import_quantity'=>json_encode($data)));
	}
	$partners = Partner::All();
	foreach($partners as $partner){
		
		$partner->update(array('import_quantity'=>json_encode($data)));
	}
	return "done";
});

Route::get('reset-partner',function(){
	$partners = Partner::all();
	$data = array(
		"feederSteer" =>0,
		"feederHeifer" =>0,
		"breederBull" => 0,
		"breederHeifer" =>0
	);
	foreach($partners as $partner){
		$partner->update(array('import_avg_prices' => json_encode($data),'import_counts'=>0));
	}
	return "done";
});