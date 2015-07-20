<?php namespace Controllers\Domain\Dashboard\Report;
use \National as National;
use \Company as Company;
use \Farm as Farm;
use \Location as Location;
use \Partner as Partner;
use \Contract as Contract;
use \Abattoir as Abattoir;
use \CattleForSale as CattleForSale;
use \CowDeath as CowDeath;
use \Exporter as Exporter;
use \FeedLot as FeedLot;
use \CattleReceive as CattleReceive;
use \CattleReceipt as CattleReceipt;
use \CompanyFeedlot as CompanyFeedlot;
use \Country as Country;
class LiveStockController extends \BaseController{


	// Xu ly hien thi bang dieu khien bao cao
	public function getIndex(){
		$data = array();		
		$feedlots = FeedLot::all()->toArray();			
		$totalRealQty = 0;
		$totalReceivedQty = 0;
		$totalSaleQty = 0;
		$totalMortalityQty = 0;
		foreach($feedlots as $feedlot){
			$realQty =  $this->quantityJson2Array($feedlot['real_quantity']);
			$totalRealQty += $realQty['sumQty'];
			$receivedQty =  $this->quantityJson2Array($feedlot['received_quantity']);
			$totalReceivedQty += $receivedQty['sumQty'];
			$saleQuantity =  $this->quantityJson2Array($feedlot['sale_quantity']);
			$totalSaleQty += $saleQuantity['sumQty'];
			$mortalityQty =  $this->quantityJson2Array($feedlot['mortality_quantity']);
			$totalMortalityQty += $mortalityQty['sumQty'];
		}
		$data['totalRealQtyCountries'] = $totalRealQty;
		$data['totalImportQtyCountries'] = $totalReceivedQty;
		$data['totalExportQtyCountries'] = $totalSaleQty;
		$data['totalDeathQtyCountries'] = $totalMortalityQty;
		$data['feedlots'] = $feedlots;	
		/*echo "<pre>";
		print_r($data);
		echo "<pre>";*/
		return \View::make('dashboard.report.livestock.index')
					->with('title',"Báo cáo chăn nuôi bò thịt")
					->with('data',$data);
	}

	public function getRealQuantity($country = null){
		if($country != null){
			$data = $this->countriesQuantityById('real',$country);

		/*	echo "<pre>";
			print_r($data);
			echo "</pre>";	*/		
			return \View::make('dashboard.report.livestock.real-quantity-by-country')
						->with('title',"Báo cáo số lượng bò thực tế")
						->with('data',$data);		
			
		}else{
			// Truong hop khong co tham so hien thi tat ca cac quoc gia
			$data = array();
			$data['countries'] = $this->countriesQuantity('real');
			$data['feedlots'] = $this->feedlotQuantity('real');
			$data['exporters'] = $this->exporterQuantity('real');
/*			echo "<pre>";
			print_r($data);
			echo "</pre>";*/
			return \View::make('dashboard.report.livestock.real-quantity')
						->with('title',"Báo cáo số lượng bò thực tế")
						->with('data',$data);
		}	
	}

	public function getReceivedQuantity($exporter = null){
		if($exporter != null){
			$data = $this->getImportByPartner($partner);
		/*	echo "<pre>";
			print_r($data);
			echo "</pre>";*/
			return \View::make('dashboard.report.livestock.import-by-partner')
						->with('title',"Báo cáo số lượng bò nhập")
						->with('data',$data);
		}else{
			$data = array();
			$data['exporters'] = $this->exporterQuantity('received');
			$data['companies'] = $this->companyQuantity('received');
			$data['feedlots'] = $this->feedlotQuantity('received');
			$data['feedlotsPerCompanies'] = $this->feedlotsByCompanyQuantity();
		/*	echo "<pre>";
			print_r($data['feedlotsPerCompanies']);
			echo "</pre>";*/
			return \View::make('dashboard.report.livestock.import')
						 ->with('title',"Báo cáo số lượng bò nhập")
						 ->with('data',$data);
		}
	}
	
	public function getReceivedQuantityByCompany($id){
		$data = array();
		return \View::make('dashboard.report.livestock.import-by-company')
						->with('title',"Báo cáo số lượng bò nhập")
						->with('data',$data);
	}

	public function getCattleForSale($abattoir = null){
		if($abattoir != null){
			$data = $this->getCattleForSaleByAbattoir($abattoir);
			/*echo "<pre>";
			print_r($data);
			echo "</pre>";*/
			return \View::make('dashboard.report.livestock.cattle-for-sale-by-abattoir')
						->with('title',"Báo cáo số lượng bò xuất bán")
						->with('data',$data);
		}else{
			$data = array();
			$data['abattoirs'] = $this->abattoirQuantity('sale');
			$data['companies'] = $this->companyQuantity('sale');
			$data['feedlots'] = $this->feedlotQuantity('sale');
			$data['cattleForSalesPerMonth'] = array();
			$data['saleFeedlotByCompanies'] = $this->feedlotsByCompanyQuantity();
			$data['abattoirsByLocation'] = $this->abattoirQuantityByLocation();
		/*	echo "<pre>";
			print_r($data['companies']);
			echo "</pre>";*/
			return \View::make('dashboard.report.livestock.cattle-for-sale')
						 ->with('title',"Báo cáo số lượng bò xuất bán")
						 ->with('data',$data);
		}
	}

	public function getMortalityQuantity($country = null){
		if($country != null){
			$data = $this->countriesQuantityById('mortality',$country);
			return \View::make('dashboard.report.livestock.mortality-quantity-by-country')
						->with('title',"Báo cáo số lượng bò thực tế")
						->with('data',$data);		
		}else{
			$data = array();
			$data['countries'] = $this->countriesQuantity('mortality');
			$data['feedlots'] = $this->feedlotQuantity('mortality');
			$data['exporters'] = $this->exporterQuantity('mortality');
		/*	echo "<pre>";
			print_r($data['feedlots']);
			echo "</pre>";*/
			return \View::make('dashboard.report.livestock.mortality-quantity')
						->with('title',"Báo cáo số lượng bò chết")
						->with('data',$data);
		}	
	}
	


	/*
		--- Cac ham chuc nang  --- 
	*/

	private function exporterQuantity($type,$exporterID = null){
		$data = array();
		$varTypeName = $type . "_quantity" ;
		if(!$exporterID){
			$exporters = Exporter::all();
			if(count($exporters) > 0){				
				foreach($exporters as $key => $exporter){								
					$data[$exporter->id] = $this->quantityJson2Array($exporter->$varTypeName);
					$data[$exporter->id]['id'] = $exporter->id;
					$data[$exporter->id]['name'] = $exporter->exporter_name;
					$data[$exporter->id]['received_counts'] = $exporter->received_counts;
					$data[$exporter->id]['updated_at'] = $exporter->updated_at;
					$data[$exporter->id]['avg_price'] =$this->priceJson2Array($exporter->import_avg_prices);
				}
					
			}
		}
		return $data;
	}
	
	private function abattoirQuantityByLocation(){
		$abattoirsNorth = Abattoir::where('location_name','BAC')->get();
		$abattoirsSounth = Abattoir::where('location_name','NAM')->get();
		$abattoirsMid = Abattoir::where('location_name','TRUNG')->get();
		$abattoirsTransfer = Abattoir::where('location_name','TRUNGCHUYEN')->get();
		$data = array(
			'abattoirsNorth' => array(),
			'abattoirsSounth' =>array(),
			'abattoirsMid' =>array(),
			'abattoirsTransfer' =>array()
		);
		if(!empty($abattoirsNorth)){
			$data['abattoirsNorth']['name'] = "Miền Bắc";
			$sumNorthQty= 0;
			foreach($abattoirsNorth as $abattoir){
				$data['abattoirsNorth']['abattoirs'][$abattoir->id]['name']  = $abattoir->name;
				$data['abattoirsNorth']['updateDate'] = $abattoirsNorth[0]->updated_at;
				$saleQuantity = json_decode($abattoir->sale_quantity,true);
				$sumAbattoirQty = 0;
				foreach ($saleQuantity as $key => $value) {
					$sumNorthQty += $value['quantity'];
					$sumAbattoirQty += $value['quantity'];
				}
				$data['abattoirsNorth']['abattoirs'][$abattoir->id]['quantity'] = $sumAbattoirQty;
			}
			$data['abattoirsNorth']['quantity'] = $sumNorthQty;
		}
		//
		if(!empty($abattoirsSounth)){
			$data['abattoirsSounth']['name'] = "Miền Nam";
			$sumNorthQty= 0;
			foreach($abattoirsSounth as $abattoir){
				$data['abattoirsSounth']['abattoirs'][$abattoir->id]['name']  = $abattoir->name;
				$data['abattoirsSounth']['updateDate'] = $abattoirsSounth[0]->updated_at;
				$saleQuantity = json_decode($abattoir->sale_quantity,true);
				$sumAbattoirQty = 0;
				foreach ($saleQuantity as $key => $value) {
					$sumNorthQty += $value['quantity'];
					$sumAbattoirQty += $value['quantity'];
				}
				$data['abattoirsSounth']['abattoirs'][$abattoir->id]['quantity'] = $sumAbattoirQty;
			}
			$data['abattoirsSounth']['quantity'] = $sumNorthQty;
		}
		//
		if(!empty($abattoirsMid)){
			$data['abattoirsMid']['name'] = "Miền Trung";
			$sumNorthQty= 0;
			foreach($abattoirsMid as $abattoir){
				$data['abattoirsMid']['abattoirs'][$abattoir->id]['name']  = $abattoir->name;
				$data['abattoirsMid']['updateDate'] = $abattoirsMid[0]->updated_at;
				$saleQuantity = json_decode($abattoir->sale_quantity,true);
				$sumAbattoirQty = 0;
				foreach ($saleQuantity as $key => $value) {
					$sumNorthQty += $value['quantity'];
					$sumAbattoirQty += $value['quantity'];
				}
				$data['abattoirsMid']['abattoirs'][$abattoir->id]['quantity'] = $sumAbattoirQty;
			}
			$data['abattoirsMid']['quantity'] = $sumNorthQty;
		}
		//
		if(!empty($abattoirsTransfer)){
			$data['abattoirsTransfer']['name'] = "Trung Chuyển";
			$sumNorthQty= 0;
			foreach($abattoirsTransfer as $abattoir){
				$data['abattoirsTransfer']['abattoirs'][$abattoir->id]['name']  = $abattoir->name;
				$data['abattoirsTransfer']['updateDate'] = $abattoirsTransfer[0]->updated_at;
				$saleQuantity = json_decode($abattoir->sale_quantity,true);
				$sumAbattoirQty = 0;
				foreach ($saleQuantity as $key => $value) {
					$sumNorthQty += $value['quantity'];
					$sumAbattoirQty += $value['quantity'];
				}
				$data['abattoirsTransfer']['abattoirs'][$abattoir->id]['quantity'] = $sumAbattoirQty;
			}
			$data['abattoirsTransfer']['quantity'] = $sumNorthQty;
		}
		return $data;
	}
	private function abattoirQuantity($type,$abattoirID = null){
		$data = array();
		$varTypeName = $type . "_quantity" ;
		if(!$abattoirID){
			$abattoirs = Abattoir::all();		
			if(count($abattoirs) > 0){
				foreach($abattoirs as $key => $abattoir){
					$data[$abattoir->id]['name'] = $abattoir->name;
					$exportQtyData = json_decode($abattoir->$varTypeName,true);
					$sumQty = 0;
					$numOfFromPartner = 0;
					foreach ($exportQtyData as $key => $value) {
						$data[$abattoir->id]['from_partner'][$key] = array(
							"name" => $value['name'],
							"quantity" => $value['quantity']
						);
						$numOfFromPartner ++;
						$sumQty += $value['quantity'];
					}
					$data[$abattoir->id]['numOfFromPartner'] = $numOfFromPartner;
					$data[$abattoir->id]['sumQuantity']= $sumQty;
					$data[$abattoir->id]['exportCounts'] = $abattoir->export_counts;
					$data[$abattoir->id]['totalPrice'] = $abattoir->export_total_prices;
					$data[$abattoir->id]['updateDate'] = $abattoir->updated_at;
				}
			}
		}		
		return $data;
	}
	private function countriesQuantity($type){
		$data = array();
		$varTypeName = $type . "_quantity" ;
		$countries = Country::all();
		foreach ($countries as $country) {
			$qty = $this->quantityJson2Array($country->$varTypeName);	
			$data[$country->id] = $qty;
			$data[$country->id]['id'] = $country['id'];
			$data[$country->id]['name'] = $country['name'];
			$data[$country->id]['updated_at'] = $country['updated_at'];
		}

		return $data;
	}
	private function countriesQuantityById($type,$id){
		$data = array();
		$country = Country::find($id);
		$farmsByCompany = array();
		$companyData = array();
		if($country){
			$companies = $country->companies;
			$varTypename = $type .'_quantity';
			foreach ($companies as $key => $company) {
				$qty = $this->quantityJson2Array($company->$varTypename);
				$companyData[$company->id] = $qty;
				$companyData[$company->id]['id'] = $company->id;
				$companyData[$company->id]['name'] = $company->name;
				$companyData[$company->id]['updated_at'] = $company->updated_at;
				$companyData[$company->id]['feedlots'] = $company->feedlots->toArray();
			}
		}
		$data['companies'] = $companyData;
		$data['country']['name'] = $country->name;
		$data['country']['id'] = $country->id;
		$data['locations'] = array();
		$data['farms'] = array();
		/*$companies = Company::where("nationalID",$countryID)->get();
		$farmsByCompany = array();
		$companyData = array();
		foreach ($companies as $company) {
			$realQty = $this->quantityJson2Array($company->real_quantity);
			$companyData[$company->id] = $realQty;
			$companyData[$company->id]['id'] = $company->id;
			$companyData[$company->id]['name'] = $company->name;
			$companyData[$company->id]['updated_at'] = $company->updated_at;
			// Data cua farms lien quan den company
			$farmsByCompany[$company->id] = Farm::where('companyID',$company->id)->get()->toArray();
		}
		$data = array();
		$data['country']['name'] = $country->name;
		$data['country']['id'] = $country->id;
		$data['companies'] = $companyData;		
		// Thuc hien dinh dang lai cot real_quantity cua farm thanh mang
		foreach($farmsByCompany as $key1 => $farms){
			$qtyConverted = array()	;
			foreach($farms as $key2 => $farm){
				$qtyConverted = $this->quantityJson2Array($farm['real_quantity']);
				$farmsByCompany[$key1][$key2]['real_quantity'] = $qtyConverted;
			}
		}
		$data['farms'] = $farmsByCompany;
		//
		$locations = Location::where('nationalID',$countryID)->get();
		$lcoationData = array();
		foreach($locations as $key => $location){
			$realQty = $this->quantityJson2Array($location->real_quantity);
			$lcoationData[$location->id] = $realQty;
			$lcoationData[$location->id]['name'] = $location->name;
			$lcoationData[$location->id]['updated_at'] = $location->updated_at;
		}
		$data['locations'] = $lcoationData;*/
		// /return $companies->toArray();	
		return $data;
	}
	private function companyQuantity($type,$companyID = null){
		$data = array();
		if($type == 'sale'){
			$externalVarName = $type . "_quantity" ;
			$internalVarName = 'internal_' .$type . '_quantity';
			if(!$companyID){
				$companies = Company::all();
				if(count($companies)){
					foreach($companies as $company){
						$externalSaleQty = $this->quantityJson2Array($company->$externalVarName);
						$internalSaleQty = $this->quantityJson2Array($company->$internalVarName);
						$data[$company->id]['external_sale'] = $externalSaleQty;
						$data[$company->id]['internal_sale'] = $internalSaleQty;
						$data[$company->id]['id'] = $company->id;
						$data[$company->id]['name'] = $company->name;
						$data[$company->id]['updated_at'] = $company->updated_at;
					}
				}
			}
		}elseif($type == 'received'){
			$externalVarName = $type . "_quantity" ;
			$internalVarName = 'internal_' .$type . '_quantity';
			if(!$companyID){
				$companies = Company::all();
				if(count($companies)){
					foreach($companies as $company){
						$externalReceivedQty = $this->quantityJson2Array($company->$externalVarName);
						$internalReceivedQty = $this->quantityJson2Array($company->$internalVarName);
						$data[$company->id]['external_received'] = $externalReceivedQty;
						$data[$company->id]['internal_received'] = $internalReceivedQty;
						$data[$company->id]['id'] = $company->id;
						$data[$company->id]['name'] = $company->name;
						$data[$company->id]['updated_at'] = $company->updated_at;
					}
				}
			}
		}else{
			$varTypename = $type . '_quantity';
			if(!$companyID){
				$companies = Company::all();
				if(count($companies)){
					foreach($companies as $company){
						$qty = $this->quantityJson2Array($company->$varTypename);
						$data[$company->id] = $qty;
						$data[$company->id]['id'] = $company->id;
						$data[$company->id]['name'] = $company->name;
						$data[$company->id]['updated_at'] = $company->updated_at;
					}
				}
			}
		}
		
		return $data;		
	}

	private function feedlotQuantity($type,$feedlotID = null){
		$data = array();
		if($type == 'received'){
			$externalVarName = $type . "_quantity" ;
			$internalVarName = 'internal_' .$type . '_quantity';
			if(!$feedlotID){
				$feedlots = Feedlot::all();
				if(count($feedlots)){
					foreach($feedlots as $feedlot){
						$qty = $this->quantityJson2Array($feedlot->$externalVarName);
						$internalQty = $this->quantityJson2Array($feedlot->$internalVarName);
						$data[$feedlot->id]['internal_received'] = $internalQty;
						$data[$feedlot->id]['external_received'] = $qty;
						$data[$feedlot->id]['id'] = $feedlot->id;
						$data[$feedlot->id]['name'] = $feedlot->name;
						$data[$feedlot->id]['updated_at'] = $feedlot->updated_at;
					}
				}
			}
		}elseif($type == 'sale'){
			$externalVarName = $type . "_quantity" ;
			$internalVarName = 'internal_' .$type . '_quantity';
			if(!$feedlotID){
				$feedlots = Feedlot::all();
				if(count($feedlots)){
					foreach($feedlots as $feedlot){
						$qty = $this->quantityJson2Array($feedlot->$externalVarName);
						$internalQty = $this->quantityJson2Array($feedlot->$internalVarName);
						$data[$feedlot->id]['internal_sale'] = $internalQty;
						$data[$feedlot->id]['external_sale'] = $qty;
						$data[$feedlot->id]['id'] = $feedlot->id;
						$data[$feedlot->id]['name'] = $feedlot->name;
						$data[$feedlot->id]['updated_at'] = $feedlot->updated_at;
					}
				}
			}
		}else{
			$varTypeName = $type . "_quantity" ;
			if(!$feedlotID){
				$feedlots = Feedlot::all();
				if(count($feedlots)){
					foreach($feedlots as $feedlot){
						$qty = $this->quantityJson2Array($feedlot->$varTypeName);
						$data[$feedlot->id] = $qty;
						$data[$feedlot->id]['id'] = $feedlot->id;
						$data[$feedlot->id]['name'] = $feedlot->name;
						$data[$feedlot->id]['updated_at'] = $feedlot->updated_at;
					}
				}
			}
		}		
		return $data;
	}


	private function feedlotsByCompanyQuantity(){
		$data = array();
		$companies = Company::all();
		foreach($companies as $company){
			$feedlotsByCompany = $company->feedlots->toArray();
			$data[$company->id] = $feedlotsByCompany;			
		}
		return $data;

	}


	/*------------------------------------------------------------*/
	private function quantityJson2Array($qtyJson){
		$result = array();
		$qtyJsonFormated = strtolower($qtyJson);
		$farmRealQty = json_decode($qtyJsonFormated,true);
	
		$feederSteer = $farmRealQty['feedersteer'];	
		$feederheifer = $farmRealQty['feederheifer'];
		$breederBull =  $farmRealQty['breederbull'];
		$breederheifer = $farmRealQty['breederheifer'];

		$result['sumQty'] = $feederSteer + $feederheifer + $breederBull + $breederheifer;
		$result['feedersteerQty'] = $feederSteer;
		$result['feederheiferQty'] = $feederheifer;
		$result['breederbullQty'] = $breederBull;
		$result['breederheiferQty'] = $breederheifer;
		return $result;
	}
	private function priceJson2Array($qtyJson){
		$result = array();
		$qtyJsonFormated = strtolower($qtyJson);
		$farmRealQty = json_decode($qtyJsonFormated,true);
	
		$feederSteer = $farmRealQty['feedersteer'];	
		$feederheifer = $farmRealQty['feederheifer'];
		$breederBull =  $farmRealQty['breederbull'];
		$breederheifer = $farmRealQty['breederheifer'];

		/*$result['feederSteerPrice'] = round($feederSteer,3);
		$result['feederHeiferPrice'] = round($feederheifer,3);
		$result['breederBullPrice'] = round($breederBull,3);
		$result['breederHeiferPrice'] = round($breederheifer,3);*/

		$result['feederSteerPrice'] = 0;
		$result['feederHeiferPrice'] = 0;
		$result['breederBullPrice'] = 0;
		$result['breederHeiferPrice'] = 0;
		return $result;
	}

	private function getCattleForSalePerMonth($abattoirs){
		$data = array();
		$dataPricePerMonth = array();
		$numberOfAbattoir = count($abattoirs);
		$cattleForSales = \DB::table('cattle_for_sales');
		$currentYear = date('Y');
		$pricePerMonthFormated = array();
		for($i = 1; $i <= 12; $i++){
			$pricePerMonth = \DB::table('cattle_for_sales')
							->select(\DB::raw('abattoir_id, sum(prices) as sumPrices'))
							->whereRaw("month(date_left_feedlot) = $i and year(date_left_feedlot) = $currentYear")
							->groupBy('abattoir_id')
							->get();

			if(!empty($pricePerMonth)){
				foreach ($pricePerMonth as $key => $value) {
					$pricePerMonthFormated[$value->abattoir_id] = $value;
				}
				$dataPricePerMonth[$i] = $pricePerMonthFormated;
				$pricePerMonthFormated  = array();
			}else{
				$dataPricePerMonth[$i] = $pricePerMonth;
			}
		}
		foreach($dataPricePerMonth as $month => $abattoirPrices){
			$data[$month] = array();
			if(empty($abattoirPrices)){
				for($i=0;$i < $numberOfAbattoir; $i++) {
					array_push($data[$month],0);
				}
			}else{
				foreach ($abattoirs as $abattoir) {
					if(!array_key_exists($abattoir->id,$abattoirPrices)){
						array_push($data[$month],0);
					}else{
						array_push($data[$month],$abattoirPrices[$abattoir->id]->sumPrices);
					}
				}
			}

		}
		//return $abattoirs->toArray();
		//return $dataPricePerMonth;
		return $data;
	}

}