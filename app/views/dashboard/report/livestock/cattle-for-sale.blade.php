@extends('layout.master')
@section('stylehead')
	<!-- Datatable-->
	{{HTML::style('public/plugins/datatables/css/jquery.dataTables.css')}}
    <!-- cus hoangec style -->
    {{HTML::style("public/css/adminlte/cushoangec.css")}}
@stop
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
	    Báo cáo tổng đàn bò thịt xuất bán đến các lò mổ
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
	    <li><a href="#">Báo cáo ngành</a></li>
	    <li><a href="{{URL::route('front_report_livestock_index_get')}}">Chăn nuôi bò thịt</a></li>
	    <li class="active">Tổng đàn bò xuất bán</li>
	  </ol>
	</section>
	<!-- Main content -->
	<section class="content">
		<div class="row">
			
			
			@if(Session::has('error'))
			<!-- Message Feedback -->
			<div class="col-md-12">
				<div class="callout callout-danger">
	              <h4>Lỗi</h4>
	              <p>{{Session::get('error')}}.</p>
	            </div>
            </div>
			@elseif(Session::has('success'))
			<!-- Message Feedback -->
			<div class="col-md-12">
				<div class="callout callout-success">
	              <h4>{{Session::get('success')}}</h4>
	              <p>{{Session::get('success')}}.</p>
	            </div>
	         </div>
			@endif	
			<div class="col-md-12">
				<!-- list cow import box -->
				<div class="box" >
					<div class="box-header">
						<h3 class="box-title">Số lượng bò xuất bán đến các lò mỗ phân theo khu vực</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="abattoir_sale_location_quantity_table" class="table table-bordered table-striped table-hover">
							<thead>
								<tr >		
									<th>#</th>                
			                        <th>Miền</th>	
			                        <th>Số lượng xuất bán</th>	                        
			                        <th>Ngày cập nhật</th>		                        
		                      </tr>
							</thead>
							<tbody>
								@if(!empty($data['abattoirsByLocation']))
									@foreach($data['abattoirsByLocation'] as $key => $value)
									<tr id = "{{$key}}" data-child-value="{{$key}}">
										<td class="details-control"></td>
										<td>{{$value['name']}}</td>			
										<td>{{number_format($value['quantity'],0,'.',',')}}</td>
										<td>{{date('d/m/Y',strtotime($value['updateDate']))}}</td>
									</tr>
									@endforeach
								@endif
							</tbody>
							<tfoot>
							</tfoot>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div>
			<div class="col-md-12">
				<!-- list cow import box -->
				<div class="box" >
					<div class="box-header">
						<h3 class="box-title">Số lượng bò xuất bán đến các lò mỗ</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="abattoir_export_quantity_table" class="table table-bordered table-striped table-hover">
							<thead>
								<tr >		
									<th>#</th>
									<th>ID</th>                      
			                        <th>Lò mổ</th>	
			                        <th>Số lượng xuất bán</th>	                        
			
			                        <th>Ngày cập nhật</th>		                        
		                      </tr>
							</thead>
							<tbody>
								@if(!empty($data['abattoirs']))
									@foreach($data['abattoirs'] as $key => $abattoir)
									<tr id = "{{$key}}" data-child-value="{{$key}}">
										<td class="details-control"></td>
										<td>{{$key}}</td>
										<td>{{$abattoir['name']}}</td>	
										<td>{{number_format($abattoir['sumQuantity'],0,'.',',')}}</td>
										<td>{{date('d/m/Y',strtotime($abattoir['updateDate']))}}</td>
									</tr>
									@endforeach
								@endif
							</tbody>
							<tfoot>
							</tfoot>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div>
			<div class="col-md-12">
				<!-- list cow import box -->
				<div class="box" >
					<div class="box-header">
						<h3 class="box-title">Số lượng bò xuất bán theo từng công ty (xuất nội bộ / xuất bên ngoài)</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="company_sale_quantity_table" class="table table-bordered table-striped table-hover">
							<thead>
								<tr >	
									<th>#</th>		                        
			                        <th>Công ty</th>				                        
			                        <th>Tổng xuất</th>
			                        <th>Bò đực vỗ béo</th>
			                        <th>Bò cái vỗ béo</th>
			                        <th>Bò đực giống</th>
			                        <th>Bò cái giống</th>
			                        <th>Ngày cập nhật</th>			                        
		                      </tr>
							</thead>
							<tbody>
								@if(!empty($data['companies']))
									@foreach($data['companies'] as $company)
									<tr id="{{$company['id']}}" data-child-value="{{$company['id']}}">
										<td class="details-control"></td>	
										<td class="data">{{$company['name']}}</td>
										<td class="total-column data">{{number_format($company['internal_sale']['sumQty'],0,'.',',')}} / {{number_format($company['external_sale']['sumQty'],0,'.',',')}}</td>
										<td class="data">{{number_format($company['internal_sale']['feedersteerQty'],0,'.',',')}} / {{number_format($company['external_sale']['feedersteerQty'],0,'.',',')}}</td>
										<td class="data">{{number_format($company['internal_sale']['feederheiferQty'],0,'.',',')}} / {{number_format($company['external_sale']['feederheiferQty'],0,'.',',')}}</td>
										<td class="data">{{number_format($company['internal_sale']['breederbullQty'],0,'.',',')}} / {{number_format($company['external_sale']['breederbullQty'],0,'.',',')}}</td>
										<td class="data">{{number_format($company['internal_sale']['breederheiferQty'],0,'.',',')}} / {{number_format($company['external_sale']['breederheiferQty'],0,'.',',')}}</td>
										<td class="data">{{date('d/m/Y',strtotime($company['updated_at']))}}</td>
									</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div>
			<div class="col-md-12">
				<!-- list cow import box -->
				<div class="box" >
					<div class="box-header">
						<h3 class="box-title">Số lượng bò xuất bán theo từng khu vực (Xuất nội bộ / Xuất lò mỗ)</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="feedlot_sale_quantity_table" class="display nowrap" cellspacing="0">
							<thead>
								<tr >	
									                        
			                        <th>Trang trại</th>				                        
			                        <th>Tổng xuất</th>
			                        <th>Bò đực vỗ béo</th>
			                        <th>Bò cái vỗ béo</th>
			                        <th>Bò đực giống</th>
			                        <th>Bò cái giống</th>
			                        <th>Ngày cập nhật</th>			                        
		                      </tr>
							</thead>
							<tbody>
								@if(!empty($data['feedlots']))
									@foreach($data['feedlots'] as $feedlot)
									<tr id="{{$feedlot['id']}}" data-child-value="{{$feedlot['id']}}">
								
										<td class="data">{{$feedlot['name']}}</td>
										<td class="total-column">{{number_format($feedlot['internal_sale']['sumQty'],0,'.',',')}} / {{number_format($feedlot['external_sale']['sumQty'],0,'.',',')}}</td>
										<td>{{number_format($feedlot['internal_sale']['feedersteerQty'],0,'.',',')}} / {{number_format($feedlot['external_sale']['feedersteerQty'],0,'.',',')}}</td>
										<td>{{number_format($feedlot['internal_sale']['feederheiferQty'],0,'.',',')}} / {{number_format($feedlot['external_sale']['feederheiferQty'],0,'.',',')}}</td>
										<td>{{number_format($feedlot['internal_sale']['breederbullQty'],0,'.',',')}} / {{number_format($feedlot['external_sale']['breederbullQty'],0,'.',',')}}</td>
										<td>{{number_format($feedlot['internal_sale']['breederheiferQty'],0,'.',',')}} / {{number_format($feedlot['external_sale']['breederheiferQty'],0,'.',',')}}</td>
										<td>{{date('d/m/Y',strtotime($feedlot['updated_at']))}}</td>
									</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div>
			<div class = col-md-12>
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh tỷ lệ tổng đàn bò xuất bán giữa các lò mổ</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="pie-export-quantity" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<div class = col-md-6>
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh tỷ lệ xuất bán ra ngoài giữa các công ty</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="pie-sale-company-quantity" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<div class = col-md-6>
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh tỷ lệ xuất bán giữa các nông trường</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="pie-sale-feedlot-quantity" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>		
			<div class = col-md-12>
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ cơ cấu số lương xuất bán đến lò mổ theo từng nhà cung cấp bò</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="column-export-from-partner" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
		</div>
	</section>
</div>
@stop
@section('data_code')
	<!-- parsley -->
    {{HTML::script("public/plugins/parsley/parsley.min.js")}}
    <!-- Ngon ngu viet cho parsley-->
    {{HTML::script("public/plugins/parsley/i18n/vi.js")}}
    <!--Load script google chart -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">

		/* ------------------ */
		// Script cho datatable
		$("document").ready(function(){
			$('#feedlot_sale_quantity_table').DataTable({
				"bPaginate": false,
	          	"bLengthChange": true,
	          	"bFilter": false,
	          	"bSort": false,
	          	"bInfo": false,
	          	"bAutoWidth": true
			});
			var abattoirLocationTable = $('#abattoir_sale_location_quantity_table').DataTable({
				"bPaginate": false,
	         	"bLengthChange": true,
	         	"bFilter": false,
	         	"bSort": false,
	         	"bInfo": false,
	         	"bAutoWidth": true
			});
			var abattoirTable = $('#abattoir_export_quantity_table').DataTable({
				"bPaginate": false,
	         	"bLengthChange": true,
	         	"bFilter": false,
	         	"bSort": false,
	         	"bInfo": false,
	         	"bAutoWidth": true
			});
			var companyTable = $('#company_sale_quantity_table').DataTable({
				"bPaginate": false,
	         	"bLengthChange": true,
	         	"bFilter": false,
	         	"bSort": false,
	         	"bInfo": false,
	         	"bAutoWidth": true
			});
	      /*  $('#abattoir_export-quantity-table tbody tr').on("click",function(event){
	        	id = this.id;
	        	url = "{{URL::route('front_report_livestock_cattle_for_sale_get')}}";
	        	url += "/" + id;
     			$(location).attr("href", url);
	        });*/
		  $('#abattoir_export_quantity_table tbody tr').on("click",'td.details-control',function(event){
	        	var tr = $(this).closest('tr');
	        	var row = abattoirTable.row(tr);

		         if (row.child.isShown()) {
		              // This row is already open - close it
		              row.child.hide();
		              tr.removeClass('shown');
		          } else {
		              // Open this row
		              row.child(abattoirDetailFormat(tr.data('child-value'))).show();
		              tr.addClass('shown');
		          }
	        });
			$('#abattoir_sale_location_quantity_table tbody tr').on("click",'td.details-control',function(event){
	        	var tr = $(this).closest('tr');
	        	console.log(tr);
	        	var row = abattoirLocationTable.row(tr);

		         if (row.child.isShown()) {
		              // This row is already open - close it
		              row.child.hide();
		              tr.removeClass('shown');
		          } else {
		              // Open this row		         
		              row.child(abattoirLocationDetailFormat(tr.data('child-value'))).show();
		              tr.addClass('shown');
		          }
	        });
		  	$('#company_sale_quantity_table tbody tr').on("click",'td.details-control',function(event){
	        	var tr = $(this).closest('tr');
	        	var row = companyTable.row(tr);

		         if (row.child.isShown()) {
		              // This row is already open - close it
		              row.child.hide();
		              tr.removeClass('shown');
		          } else {
		              // Open this row
		              row.child(companyDetailFormat(tr.data('child-value'))).show();
		              tr.addClass('shown');
		          }
	        });
	        //SalePerMonth();
		})
		function abattoirLocationDetailFormat(locationName){
			var jObject;
			var dataJson = {{json_encode($data['abattoirsByLocation'])}}
			var abattoirData = dataJson[locationName];
			var str = '';
			if(!jQuery.isEmptyObject(abattoirData)){
				$.each(abattoirData['abattoirs'],function(key,value){
					str +=  '<tr>'+
	                    '<td>--</td>'+
	                    '<td>'+ value.name+'</td>'+
	                    '<td>' + numberWithCommans(value.quantity) + '</td>' + 
	                    '<td>'+ '--' + '</td>'
	                '</tr>'
				});
				
			}
			jObject = $(str);
			return jObject;
		}
		function abattoirDetailFormat(id){
			var jObject;
			var dataJson = {{json_encode($data['abattoirs'])}}		
			var abattoirData = dataJson[id]
			var str = '';
			var sumQty = 0;
			if(!jQuery.isEmptyObject(abattoirData)){
				str += '<table class="table">' +
							'<thead>' +
								'<tr>' + 
									'<th>Nhà xuất khẩu</th>' + 
									'<th>Số lượng xuất bán</th>' +
								'</tr>' +
							'</thead>';
				$.each(abattoirData.from_partner,function(key,value){
					str += '<tr>' + 
								'<td>' + value.name + '</td>' +
								'<td>' + value.quantity + '</td>' +
							'</tr>';
				});
				str +=  '</table>';
			}else{
				str ='';
			}
			
			jObject = $(str);
			return jObject;
    	}
    	function companyDetailFormat(id){
			var jObject;
			var dataJson = {{json_encode($data['saleFeedlotByCompanies'])}}		
			var companyData = dataJson[id]

			var str = '';
			var sumQty = 0;
			var internalSaleQty = 0;
			if(!jQuery.isEmptyObject(companyData)){
				$.each(companyData,function(key,value){
					var quantity = JSON.parse(value.pivot.sale_quantity);
					var internalSaleQty = JSON.parse(value.pivot.internal_sale_quantity);
					sumQty = quantity.feedersteer + quantity.feederheifer + quantity.breederbull + quantity.breederheifer;
					sumInternalSaleQty =  internalSaleQty.feedersteer + internalSaleQty.feederheifer + internalSaleQty.breederbull + internalSaleQty.breederheifer;
					str +=  '<tr>'+
	                    '<td>--</td>'+
	                    '<td>'+ value.name+'</td>'+
	                    '<td>' + numberWithCommans(sumInternalSaleQty) + ' / '+ numberWithCommans(sumQty) + '</td>'+
	                    '<td>' + numberWithCommans(internalSaleQty.feedersteer) + ' / '+ numberWithCommans(quantity.feedersteer) + '</td>'+
	                    '<td>' + numberWithCommans(internalSaleQty.feederheifer) + ' / ' + numberWithCommans(quantity.feederheifer)  + '</td>'+
	                    '<td>' + numberWithCommans(internalSaleQty.breederbull) + ' / ' + numberWithCommans(quantity.breederbull) + '</td>'+
	                    '<td>' + numberWithCommans(internalSaleQty.breederheifer) + ' / ' + numberWithCommans(quantity.breederheifer) + '</td>'+
	                    '<td>--</td>'+
	                '</tr>'
	                sumQty =0;
	                internalSaleQty =0;
	        	});
			}else{
				str +=  '<tr>'+
	                    '<td>--</td>'+
	                    '<td>0</td>'+
	                    '<td>0</td>'+
	                    '<td>0</td>'+
	                    '<td>0</td>'+
	                    '<td>0</td>'+
	                    '<td>0</td>'+
	                    '<td>--</td>'+
	                '</tr>'
			}
			
			jObject = $(str);
			return jObject;
    	}


		/*Xu ly tao bieu do bang google chart */
		// Bieu do pie ty le so bo thuc te giua cac quoc gia
		google.load("visualization", "1", {packages:["corechart","Bar"]});
		google.setOnLoadCallback(abattoirChart);
		google.setOnLoadCallback(companyChart);
		google.setOnLoadCallback(feedlotChart);
		
		// Ham xu ly de chart responsive
		$(window).resize(function () {
    		abattoirChart();
    		companyChart();
    		feedlotChart();
		});

		function abattoirChart(){
			var optionsPieChart = {
	        	width: '100%',
	      		height: '100%',
	            pieSliceText: 'percentage',	        
	            chartArea: {
		            left: "3%",
		            top: "3%",
		            height: "94%",
		            width: "94%"
	        	}
    		};
    		var optionsColumnChart = {
					isStacked : true,
					width: '100%',
					height: '100%',
					legend: {position: 'top', maxLines: 3},
					hAxis : {
						title: 'Lò mỗ',
						format : 'long',
						viewWindowMode : 'pretty',
						viewWindow: {
				            min: [7, 30, 0],
				            max: [17, 30, 0]
				        }
					},
					vAxis: {
	          			title: 'Số lượng'
	        		}
			};
			var divToShowQuantity = $('#pie-export-quantity');
			//var divToShowprice = $('#pie-export-price');
			var divToShowFromPartner = $('#column-export-from-partner');
			var divToShowSalePerMonth = $('#column-sale-per-month');
    		var abattoirs = {{json_encode($data['abattoirs'])}};
    		if(!jQuery.isEmptyObject(abattoirs)){
    			var dataQuantity = new google.visualization.DataTable();
    			dataQuantity.addColumn('string','abattoirName');
    			dataQuantity.addColumn('number','sumQuantity');
    			//
    			var dataFromImportPartner = new google.visualization.DataTable();
    			dataFromImportPartner.addColumn('string',"");
    			//
				var runFirstOne = true;
				var countCheck = 1;	 
				var rowValues  = new Array();
	    		$.each(abattoirs,function(key,abattoir){
	    			dataQuantity.addRows([
	    				[abattoir.name,{v:abattoir.sumQuantity,f:numberWithCommans(abattoir.sumQuantity)}]
	    			]);
	    			//	   
	    			if(runFirstOne){
	    				numFromPartner = Object.keys(abattoir.from_partner).length;
	    			}
	    			
	    			rowValues = [abattoir.name]; 			
    				$.each(abattoirs[key].from_partner,function(partnerid,value){
    					if(runFirstOne && countCheck <= numFromPartner){    						
    						dataFromImportPartner.addColumn('number',value.name);    						
    						countCheck ++;
    					}else{
    						runFirstOne = false;
    					}
    					//
    					rowValues.push({v:value.quantity});
    				});    
	    			dataFromImportPartner.addRow(rowValues);
	    			//
	    			
	    		});
	    		var sumQuantitychart = new google.visualization.PieChart(document.getElementById('pie-export-quantity'));
	    		sumQuantitychart.draw(dataQuantity,optionsPieChart);

	    		var fromPartnerchart = new google.visualization.ColumnChart(document.getElementById('column-export-from-partner'));
				fromPartnerchart.draw(dataFromImportPartner, optionsColumnChart);
	    		
			
    		}else{
    			ShowNoDataToDrawnChartMessages(divToShowQuantity);
    			ShowNoDataToDrawnChartMessages(divToShowFromPartner);
    		}    	
		}

		function companyChart(){
			
			var optionsPieChart = {
	        	width: '100%',
	      		height: '100%',
	            pieSliceText: 'percentage',	        
	            chartArea: {
		            left: "3%",
		            top: "3%",
		            height: "94%",
		            width: "94%"
	        	}
    		};
			var divToShowCompanyQuantity = $('#pie-sale-company-quantity');
    		var companies = {{json_encode($data['companies'])}}
    		if(!jQuery.isEmptyObject(companies)){
    			var dataCompanyQuantity = new google.visualization.DataTable();
	    		dataCompanyQuantity.addColumn('string','ExporterName');
	    		dataCompanyQuantity.addColumn('number','sumQuantity');
	    		$.each(companies,function(key,company){
	    			dataCompanyQuantity.addRows([
	    				[company.name,{v:company.external_sale.sumQty,f:numberWithCommans(company.external_sale.sumQty)}],
	    			]);	
	    		});
	    		var chartSumCompanyQuantity = new google.visualization.PieChart(document.getElementById('pie-sale-company-quantity'));
	    		chartSumCompanyQuantity.draw(dataCompanyQuantity,optionsPieChart)
    		}else{
    			ShowNoDataToDrawnChartMessages(divToShowComapnyQuantity);
    		} 	
		}

		function feedlotChart(){
			var optionsPieChart = {
	        	width: '100%',
	      		height: '100%',
	            pieSliceText: 'percentage',	        
	            chartArea: {
		            left: "3%",
		            top: "3%",
		            height: "94%",
		            width: "94%"
	        	}
    		};
    		var divToShowFeedlotQuantity = $('#pie-sale-feedlot-quantity');
    		var feedlots = {{json_encode($data['feedlots'])}}
    		if(!jQuery.isEmptyObject(feedlots)){
    			var dataFeedlotQuantity = new google.visualization.DataTable();
	    		dataFeedlotQuantity.addColumn('string','feedlotName');
	    		dataFeedlotQuantity.addColumn('number','sumQuantity');
	    		$.each(feedlots,function(key,feedlot){
	    			dataFeedlotQuantity.addRows([
	    				[feedlot.name,{v:feedlot.sumQty,f:numberWithCommans(feedlot.sumQty)}],
	    			]);	
	    		});
	    		var chartSumFeedlotQuantity = new google.visualization.PieChart(document.getElementById('pie-sale-feedlot-quantity'));
	    		chartSumFeedlotQuantity.draw(dataFeedlotQuantity,optionsPieChart)
    		}else{
    			ShowNoDataToDrawnChartMessages(divToShowFeedlotQuantity);
    		}
		}
	</script>
@stop