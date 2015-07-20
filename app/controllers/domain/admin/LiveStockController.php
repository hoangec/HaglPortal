<?php namespace Controllers\Domain\Admin;
use \Farm as Farm;
use \Company as Company;
use \National as National;
use \CattleImport as CattleImport;
use \Partner as Partner;
use \Location as Location;
use \Contract as Contract;
use \Port as Port;
Class LiveStockController extends \BaseController{

	public function getIndex(){
		return \View::make('dashboard.admin.reports.livestock.index')->with('title',"Quản lý báo cáo bò thịt");
	}

	public function getImportContract(){
		$farms= Farm::lists('name','id');
		$companies = Company::lists('name','id');
		$farmsByCompany = array();
		$temp = array();
		foreach ($companies as $key => $values) {
			$temp[$key] = Farm::Where('companyID',$key)->get(array('name','id'))->toArray();
			foreach($temp[$key] as $value){
				$farmsByCompany[$key][$value['id']] = $value['name'];
			}
		}
		$ports = Port::lists("name","id");
		$partners = Partner::lists('name','id');		
		$contracts = array();
		$contractNotFinished = Contract::where('imp_status',0)->get();
		$contractHasFinished = Contract::where('imp_status',1)->get();
		foreach($contractNotFinished as $contract){
			$contracts['contractNotFinished'][$contract->id] = $contract;
			$sumContract = $this->sumTotal($contract);
		    $contracts['contractNotFinished'][$contract->id]['sumQty'] = $sumContract['sumQty'];
		    $contracts['contractNotFinished'][$contract->id]['sumWeight'] =$sumContract['sumWeight'];
		    $contracts['contractNotFinished'][$contract->id]['sumPrice'] = $sumContract['sumPrice'];
		}

		foreach($contractHasFinished as $contract){
			$contracts['contractHasFinished'][$contract->id] = $contract;
			$sumContract = $this->sumTotal($contract);
		    $contracts['contractHasFinished'][$contract->id]['sumQty'] = $sumContract['sumQty'];
		    $contracts['contractHasFinished'][$contract->id]['sumWeight'] = $sumContract['sumWeight'];
		    $contracts['contractHasFinished'][$contract->id]['sumPrice'] = $sumContract['sumPrice'];
		}
		/*$contractNotFinished = $contracts->filter(function($item){
			return $item->imp_status == 0;
		});*/
		return \View::make('dashboard.admin.reports.livestock.import-contract')
						->with('title',"Quản lý hợp đồng nhập bò")
						->with('farms',$farms)
						->with('companies',$companies)
						->with('partners',$partners)						
						->with('farmsByCompany',$farmsByCompany)
						->with('ports',$ports)
						->with('contracts',$contracts);
	}


	public function getImportQuantity(){
		$contracts = Contract::where('imp_status',0)->get();
		$contractDetail = array();
		foreach($contracts as $contract){
			$contractDetail[$contract->id] = $contract;
		}
			
		$farms= Farm::lists('name','id');
		$companies = Company::lists('name','id');
		$farmsByCompany = array();
		$temp = array();

		foreach ($companies as $key => $values) {
			$temp[$key] = Farm::Where('companyID',$key)->get(array('name','id'))->toArray();
			foreach($temp[$key] as $value){
				$farmsByCompany[$key][$value['id']] = $value['name'];
			}
		}

		$partners = Partner::lists('name','id');		
		$importTable = CattleImport::with('Contract')->get();
		return \View::make('dashboard.admin.reports.livestock.import-quantity')
						->with('title',"Quản lý nhập bò")
						->with('farms',$farms)
						->with('companies',$companies)
						->with('farmsByCompany',$farmsByCompany)
						->with('contractDetail',$contractDetail)
						->with('contracts',$contracts->lists('name','id'))
						->with('partners',$partners)
						->with('importTable',$importTable);
	}
	/* -- ---------------------------------------------------------------------------*/
	/* Ham xu ly them, sua, xoa moi lo bo nhap 												*/
	/*  -------------------------------------------------------------------------------*/
	public function postImportContractAdd(){
		$inputs = \Input::all();
		$val = true; /*Validator::make($input,Contract::$contractRule);*/
		if($val){
			$feederSteerQty = \Input::get('feedersteer_quantity');
			$feederHeiferQty = \Input::get('feederheifer_quantity');
			$breederBullQty = \Input::get('breederbull_quantity');
			$breederHeiferQty = \Input::get('breederheifer_quantity');
			$feederSteerWeight = \Input::get('feedersteer_weight');
			$feederHeiferWeight = \Input::get('feederheifer_weight');
			$breederBullWeight = \Input::get('breederbull_weight');
			$breederHeiferWeight = \Input::get('breederheifer_weight');
			$feederSteerPrice = \Input::get('feedersteer_price');
			$feederHeiferPrice = \Input::get('feederheifer_price');
			$breederBullPrice = \Input::get('breederbull_price');
			$breederHeiferPrice = \Input::get('breederheifer_price');
			//
			$importDate = date("Y-m-d",strtotime(\Input::get('import_date')));
			$openLcDate = date("Y-m-d",strtotime(\Input::get('lc_open_last_date')));
			$contractInsert = array(
				'feedersteer_quantity' => $feederSteerQty,
				'feederheifer_quantity' => $feederHeiferQty,
				'breederbull_quantity' => $breederBullQty,
				'breederheifer_quantity' => $breederHeiferQty,
				'feedersteer_weight'	=> $feederSteerWeight,
				'feederheifer_weight'	=> $feederHeiferWeight,
				'breederbull_weight'	=> $breederBullWeight,
				'breederheifer_weight'	=> $breederHeiferWeight,
				'feedersteer_price'	=>$feederSteerPrice,
				'feederheifer_price'	=> $feederHeiferPrice,
				'breederbull_price'		=>$breederBullPrice,
				'breederheifer_price'	=> $breederHeiferPrice,
				'name'	=> $inputs['imp_contract_name'],
				'import_date'=>$importDate,
				'lc_open_last_date' => $openLcDate,
				'imp_status_text' => \input::get('imp_status_text'),
				'partner_id' => $inputs['partner_id'],
				'farm_id'	=>$inputs['farm_id'],
				'company_id' => $inputs['company_id'],
				'port_id' => $inputs['port_id']
			);

			// Tinh so lan nhap cua doi tac			
			$importCounts = Contract::where('partner_id',$inputs['partner_id'])->count() + 1;
			//Tinh don gia trung binh nhap
			$partner = Partner::find($inputs['partner_id']);			
			$newAvgPrice = array();
			if($partner){
				$currentAvgPrices = json_decode($partner->import_avg_prices,true);
				foreach ($currentAvgPrices as $key => $price) {
					$varName = $key.'Price';
					$newAvgPrice[$key] = (($importCounts - 1) * $price + $$varName) / ($importCounts);
				}
			}
			try{
				Contract::create($contractInsert);
				$partner->update(array(
					'import_counts'=>$importCounts,
					'import_avg_prices' => json_encode($newAvgPrice)
				));
				return \Redirect::route('admin_report_import_contract_get')->with('success',"Thêm thành hợp đồng nhập bò");
			}catch(exp $e ){
				return \Redirect::route('admin_report_import_contract_get')->with('error',"Lỗi hệ thống, vui lòng liên hệ quản trị");
			}				
		}else{
			return $val->errors();
		}
	}

	public function postImportQuantityAdd(){
	
		$inputs = \Input::all();
		$bien = array_keys($inputs);
		$value = array_values($inputs);

		$val = \Validator::make($inputs,CattleImport::$CattleImportRule);
		if($val->passes()){
			// Du lieu de tao lo nhap bo
			$feederSteer = \Input::get('feedersteer_quantity');
			$feederHeifer = \Input::get('feederheifer_quantity');
			$breederBull = \Input::get('breederbull_quantity');
			$breederHeifer = \Input::get('breederheifer_quantity');
			$totalWeight = \Input::get('real_total_weight');
			//
			$contractFeederSteerQty = \Input::get('old_feedersteer_quantity');
			$contractFeederHeiferQty = \Input::get('old_feederheifer_quantity');
			$contractBreederBullQty = \Input::get('old_breederbull_quantity');
			$contractBreederHeiferQty = \Input::get('old_breederheifer_quantity');
			$contractTotalWeight = \Input::get('old_total_weight');
			//
			$partnerID	= \Input::get('partner_id');
			$farmID = \Input::get('farm_id');
			$contractID = \Input::get('contract_id');
			// dinh dang lai ngay theo chuan mysql yyy-mm-dd
			$importDate = date("Y-m-d",strtotime(\Input::get('import_date')));
			//
			$CattleImportInsert = array(
				'import_date'		=> $importDate,
				'feedersteer'		=> $feederSteer,
				'feederheifer'		=> $feederHeifer,
				'breederbull'		=> $breederBull,
				'breederheifer'		=> $breederHeifer,
				'real_total_weight'			=> $totalWeight,
				'batch_name'				=> \Input::get('batch_name'),		
				'user_id'					=> \Sentry::getUser()->id,
				'farm_id'					=>  $farmID,
				'contract_id'				=> $contractID,
				'partner_id'				=>$partnerID
			);
			//Tinh chenh lech so luong va can nang giua hop dong voi nhap thuc te
			$diffTotalQuantity = ($feederSteer +  $feederHeifer + $breederBull + $breederHeifer) - ($contractFeederSteerQty + $contractFeederHeiferQty + $contractBreederBullQty + $contractBreederHeiferQty);
			$diffTotalWeight = $totalWeight - $contractTotalWeight;
			$diffData = array(
				'diff_total_quantity' => $diffTotalQuantity,
				'diff_total_weight'	=> $diffTotalWeight
			);
			
			$result = $this->updateContractStatus($contractID,$diffData) and $this->updateQuantity("import",$CattleImportInsert) and CattleImport::create($CattleImportInsert);
			
			if($result){
				return \Redirect::route('admin_report_import_quantity_get')->with('success',"Thêm thành công lô bò nhập");
			}else{
				return \Redirect::route('admin_report_import_quantity_get')->with('error',"Lỗi hệ thống, vui lòng liên hệ quản trị");
			}
		}else{
			return $val->errors();
		}
	}

	public function postImportQuantityUpdate(){
		$val = \Validator::make(\Input::all(),CattleImport::$CattleImportRule);
		if($val->passes()){
			$feederSteer = \Input::get('feedersteer_quantity');
			$feederHeifer = \Input::get('feederheifer_quantity');
			$breederBull = \Input::get('breederbull_quantity');
			$breederHeifer = \Input::get('breederheifer_quantity');
			//
			$feederSteerHide = \Input::get('feedersteer_quantity_hide');
			$feederHeiferHide = \Input::get('feederheifer_quantity_hide');
			$breederBullHide = \Input::get('breederbull_quantity_hide');
			$breederHeiferHide = \Input::get('breederheifer_quantity_hide');
			//
			$diffFeederSteer = $feederSteer - $feederSteerHide;
			$diffFeederHeifer = $feederHeifer - $feederHeiferHide;
			$diffBreederBull = $breederBull - $breederBullHide;
			$diffBreederHeifer = $breederHeifer - $breederHeiferHide;
			//
			$farmID = \Input::get('selected_farm');
			$importDate = date("Y-m-d",strtotime(\Input::get('import_date')));
			$batchId = \Input::get('batch_id');
			//
			$CattleImportUpdated = array(
				'import_date'		=> $importDate,
				'feedersteer'		=> $feederSteer,
				'feederheifer'		=> $feederHeifer,
				'breederbull'		=> $breederBull,
				'breederheifer'		=> $breederHeifer,
				'batch_name'			=> \Input::get('batch_name'),
				'import_partner'		=> \Input::get('import_partner'),
			);
			$data = array(
				'feedersteer'		=> $diffFeederSteer,
				'feederheifer'		=> $diffFeederHeifer,
				'breederbull'		=> $diffBreederBull,
				'breederheifer'		=> $diffBreederHeifer,
				'farmID'				=>  $farmID
			);
			$importBatch = CattleImport::find($batchId);
				if($importBatch){
					$result = $this->updateQuantity('import',$data);
					$importBatch->update(array(
						'import_data' => $importDate,
						'feedersteer' => $feederSteer,
						'feederheifer' => $feederHeifer,
						'breederbull' => $breederBull,
						'breederheifer' => $breederHeifer
					));
					if($result){
						return \Redirect::route('admin_report_import_quantity_get')->with('success',"Cập nhập thành công lô bò nhập");
					}else{
						return \Redirect::route('admin_report_import_quantity_get')->with('error',"Lỗi hệ thống, vui lòng liên hệ quản trị");
					}
				}else{
					return \Redirect::route('admin_report_import_quantity_get')->with('error',"Lô nhập không tồn tại");
				}			
			}else{
				return "fail";
			}
	}

	public function getImportQuantityDelete($id){
		$import = CattleImport::find($id);
		$data = array(
			'feedersteer'		=> 0 - $import->feedersteer,
			'feederheifer'		=> 0 - $import->feederheifer,
			'breederbull'		=> 0 - $import->breederbull,
			'breederheifer'		=> 0 - $import->breederheifer,
			'farmID'			=>  $import->farmID
		);
		if($import){
			$import->delete();
			$updateResult = $this->updateQuantity("import",$data);;
			return \Response::json($updateResult);
		}else{
		  	return \Response::json(array("status"=>"error","mess"=>"Lô nhập không tồn tại"));
		}
	}


	private function updateQuantity($type,$data){
		$columnName = $type . '_quantity';
		//
		$mPartner = Partner::find($data['partner_id']);
		$currentPartnerQty = json_decode($mPartner->$columnName,true);
		foreach($currentPartnerQty as $key => $value){
			$currentPartnerQty[$key] += $data[$key];
		}
		//
		$mFarm = Farm::find($data['farm_id']);
		$currentFarmQty = json_decode($mFarm->$columnName,true);
		foreach($currentFarmQty as $key => $value){
			$currentFarmQty[$key] += $data[$key];
		}
		$mLocation = Location::find($mFarm->locationID);
		$currentLocationQty = json_decode($mLocation->$columnName,true);
		foreach($currentLocationQty as $key => $value){
			$currentLocationQty[$key] += $data[$key];
		}

		$mCompany = Company::find($mFarm->companyID);
		$currentCompanyQty = json_decode($mCompany->$columnName,true);
		foreach($currentCompanyQty as $key => $value){
			$currentCompanyQty[$key] += $data[$key];
		}
		//
		$mCountry = National::find($mCompany->nationalID);
		$currentCountryQty = json_decode($mCountry->$columnName,true);
		foreach($currentCountryQty as $key => $value){
			$currentCountryQty[$key] += $data[$key];
		}
		
		$resultFunction = array(); 
		$resultFunction['farm']= $currentFarmQty;
		$resultFunction['company'] = $currentCompanyQty;
		$resultFunction['country'] = $currentCountryQty;
		$resultFunction['location'] = $currentLocationQty;
		$resultFunction['partner'] = $currentPartnerQty;
		//
		try{			
			$mFarm->update(array($columnName =>json_encode($resultFunction['farm'])));
			$mCompany->update(array($columnName =>json_encode($resultFunction['company'])));
			$mCountry->update(array($columnName =>json_encode($resultFunction['country'])));
			$mLocation->update(array($columnName=>json_encode($resultFunction['location'])));
			$mPartner->update(array($columnName=>json_encode($resultFunction['partner'])));
			$resultReal = $this->updateRealQuantity($data['farm_id']);
			return true;
		}catch(exp $e){
			return false;
		}
	}

	private function updateContractStatus($id,$data){
		try{
			$contract = Contract::find($id);
			$contract->update(array(
				'diff_total_quantity' => $data['diff_total_quantity'],
				'diff_total_weight' => $data['diff_total_weight'],
				'imp_status'		=> 1
			));
			return true;
		}catch(exp  $msg){
			return false;
		}
		
	}
	/* -- ---------------------------------------------------------------------------*/
	/* Ham xu ly cap nhap so luong thuc te tuong ung voi cap farm,comapany,national,location*/
	/*  -------------------------------------------------------------------------------*/
	private function updateRealQuantity($farmID){
		$mFarm = Farm::find($farmID);
		$farmRealQty = $this->updateFarmRealQty($mFarm);

		$mLocation = Location::find($mFarm->locationID);
		$locationRealQty = $this->updateLocationRealQty($mLocation);
		//
		$mCompany  = Company::find($mFarm->companyID);
		$companyRealQty = $this->updateCompanyRealQty($mCompany);
		//
		$mNational = National::find($mCompany->nationalID);
		$nationalRealQty = $this->updateNationalRealQty($mNational);
		//
		try{
			$mFarm->update(array('real_quantity'=>json_encode($farmRealQty)));
			$mCompany->update(array('real_quantity'=>json_encode($companyRealQty)));
			$mNational->update(array('real_quantity'=>json_encode($nationalRealQty)));
			$mLocation->update(array('real_quantity'=>json_encode($locationRealQty)));
			return true;
		}catch(exp $e){
			return false;
		}		
	}
	private function updateFarmRealQty($farm){

		$importQty = json_decode($farm->import_quantity,true);
		$exportQty = json_decode($farm->export_quantity,true);
		$deathQty = json_decode($farm->death_quantity,true);
		/*$realQty['qtyMaleBeef'] = $importQty['qtyMaleBeef'] - $exportQty['qtyMaleBeef'] - $deathQty['qtyMaleBeef'];
		$realQty['qtyFemaleBeef'] = $importQty['qtyFemaleBeef'] - $exportQty['qtyFemaleBeef'] - $deathQty['qtyFemaleBeef'];
		$realQty['qtySteer'] = $importQty['qtySteer'] - $exportQty['qtySteer'] - $deathQty['qtySteer'];
		$realQty['qtyHeifer'] = $importQty['qtyHeifer'] - $exportQty['qtyHeifer'] - $deathQty['qtyHeifer'];	*/

		$realQty['feedersteer'] = $importQty['feedersteer'] - $exportQty['feedersteer'] - $deathQty['feedersteer'];
		$realQty['feederheifer'] = $importQty['feederheifer'] - $exportQty['feederheifer'] - $deathQty['feederheifer'];
		$realQty['breederbull'] = $importQty['breederbull'] - $exportQty['breederbull'] - $deathQty['breederbull'];
		$realQty['breederheifer'] = $importQty['breederheifer'] - $exportQty['breederheifer'] - $deathQty['breederheifer'];	
		return $realQty;
	}
	private function updateCompanyRealQty($company){

		$importQty = json_decode($company->import_quantity,true);
		$exportQty = json_decode($company->export_quantity,true);
		$deathQty = json_decode($company->death_quantity,true);
		$realQty['feedersteer'] = $importQty['feedersteer'] - $exportQty['feedersteer'] - $deathQty['feedersteer'];
		$realQty['feederheifer'] = $importQty['feederheifer'] - $exportQty['feederheifer'] - $deathQty['feederheifer'];
		$realQty['breederbull'] = $importQty['breederbull'] - $exportQty['breederbull'] - $deathQty['breederbull'];
		$realQty['breederheifer'] = $importQty['breederheifer'] - $exportQty['breederheifer'] - $deathQty['breederheifer'];	
		return $realQty;
	}
	private function updateNationalRealQty($national){

		$importQty = json_decode($national->import_quantity,true);
		$exportQty = json_decode($national->export_quantity,true);
		$deathQty = json_decode($national->death_quantity,true);
		$realQty['feedersteer'] = $importQty['feedersteer'] - $exportQty['feedersteer'] - $deathQty['feedersteer'];
		$realQty['feederheifer'] = $importQty['feederheifer'] - $exportQty['feederheifer'] - $deathQty['feederheifer'];
		$realQty['breederbull'] = $importQty['breederbull'] - $exportQty['breederbull'] - $deathQty['breederbull'];
		$realQty['breederheifer'] = $importQty['breederheifer'] - $exportQty['breederheifer'] - $deathQty['breederheifer'];	
		return $realQty;
	}
	private function updateLocationRealQty($location){
		$importQty = json_decode($location->import_quantity,true);
		$exportQty = json_decode($location->export_quantity,true);
		$deathQty = json_decode($location->death_quantity,true);
		$realQty['feedersteer'] = $importQty['feedersteer'] - $exportQty['feedersteer'] - $deathQty['feedersteer'];
		$realQty['feederheifer'] = $importQty['feederheifer'] - $exportQty['feederheifer'] - $deathQty['feederheifer'];
		$realQty['breederbull'] = $importQty['breederbull'] - $exportQty['breederbull'] - $deathQty['breederbull'];
		$realQty['breederheifer'] = $importQty['breederheifer'] - $exportQty['breederheifer'] - $deathQty['breederheifer'];	
		return $realQty;
	}

	private function sumTotal($data){
		$result = array();

		$sumQty = $data->feedersteer_quantity + $data->feederheifer_quantity + $data->breederbull_quantity + $data->breederheifer_quantity;
		$sumWeight = $data->feedersteer_quantity * $data->feedersteer_weight + $data->feederheifer_quantity * $data->feederheifer_weight + $data->breederbull_quantity * $data->breederbull_weight + $data->breederheifer_quantity * $data->breederheifer_weight;
		$sumPrice = $data->feedersteer_quantity * $data->feedersteer_weight * $data->feedersteer_price + $data->feederheifer_quantity * $data->feederheifer_weight * $data->feederheifer_price + $data->breederbull_quantity * $data->breederbull_weight * $data->breederbull_price + $data->breederheifer_quantity * $data->breederheifer_weight * $data->breederheifer_price;
		$result['sumQty'] = $sumQty;
		$result['sumWeight'] = $sumWeight;
		$result['sumPrice'] = $sumPrice;
		return $result;
	}
}