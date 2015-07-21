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
	    Báo cáo bò thịt nhập
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
	    <li><a href="#">Báo cáo ngành</a></li>
	    <li><a href="{{URL::route('front_report_livestock_index_get')}}">Chăn nuôi bò thịt</a></li>
	    <li class="active">Bò nhập</li>
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
						<h3 class="box-title">Số lượng bò đã nhập thực tế giữa các nhà xuất khẩu bò</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="import-quantity-table" class="table table-bordered table-striped table-hover">
							<thead>
								<tr >	
									<th>#</th>		                        
			                        <th>Nhà xuất khẩu</th>				                        
			                        <th>Tổng nhập</th>	    
			                        <th>Số lần nhập</th>                    
			                        <th>Bò đực vỗ béo</th>
			                        <th>Bò cái vỗ béo</th>
			                        <th>Bò đực giống</th>
			                        <th>Bò cái giống</th>
			                        <th>Ngày cập nhật</th>			                        
		                      </tr>
							</thead>
							<tbody>
								@if(!empty($data['exporters']))
									@foreach($data['exporters'] as $exporter)
									<tr id = "{{$exporter['id']}}">
										<td>{{$exporter['id']}}</td>
										<td>{{$exporter['name']}}</td>
										<td class="total-column">{{number_format($exporter['sumQty'],0,'.',',')}}</td>
										<td>{{$exporter['received_counts']}}</td>
										<td>{{number_format($exporter['feedersteerQty'],0,'.',',')}}</td>
										<td>{{number_format($exporter['feederheiferQty'],0,'.',',')}}</td>
										<td>{{number_format($exporter['breederbullQty'],0,'.',',')}}</td>
										<td>{{number_format($exporter['breederheiferQty'],0,'.',',')}}</td>
										<td>{{date('d/m/Y',strtotime($exporter['updated_at']))}}</td>
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
						<h3 class="box-title">Số lượng bò đã nhập theo từng công ty (Nhập nội bộ / Nhập nhà cung cấp)</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="company-received-quantity-table" class="table table-bordered table-striped table-hover">
							<thead>
								<tr >	
									<th>#</th>		                        
			                        <th>Công ty</th>				                        
			                        <th>Tổng nhập</th>
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
										<td class="total-column data">{{number_format($company['internal_received']['sumQty'],0,'.',',')}} / {{number_format($company['external_received']['sumQty'],0,'.',',')}}</td>
										<td class="data">{{number_format($company['internal_received']['feedersteerQty'],0,'.',',')}} / {{number_format($company['external_received']['feedersteerQty'],0,'.',',')}}</td>
										<td class="data">{{number_format($company['internal_received']['feederheiferQty'],0,'.',',')}} / {{number_format($company['external_received']['feederheiferQty'],0,'.',',')}}</td>
										<td class="data">{{number_format($company['internal_received']['breederbullQty'],0,'.',',')}} / {{number_format($company['external_received']['breederbullQty'],0,'.',',')}}</td>
										<td class="data">{{number_format($company['internal_received']['breederheiferQty'],0,'.',',')}} / {{number_format($company['external_received']['breederheiferQty'],0,'.',',')}}</td>
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
						<h3 class="box-title">Số lượng bò đã nhập theo từng trang trại (Nhập nội bộ / nhập nhà cung cấp)</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="import-quantity-table" class="table table-bordered table-striped table-hover">
							<thead>
								<tr >	
									<th>#</th>		                        
			                        <th>Khu vực</th>				                        
			                        <th>Tổng nhập</th>
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
									<tr id = "{{$feedlot['id']}}">
										<td>{{$feedlot['id']}}</td>	
										<td>{{$feedlot['name']}}</td>
										<td class="total-column">{{number_format($feedlot['internal_received']['sumQty'],0,'.',',')}} / {{number_format($feedlot['external_received']['sumQty'],0,'.',',')}}</td>
										<td>{{number_format($feedlot['internal_received']['feedersteerQty'],0,'.',',')}} / {{number_format($feedlot['external_received']['feedersteerQty'],0,'.',',')}}</td>
										<td>{{number_format($feedlot['internal_received']['feederheiferQty'],0,'.',',')}} / {{number_format($feedlot['external_received']['feederheiferQty'],0,'.',',')}}</td>
										<td>{{number_format($feedlot['internal_received']['breederbullQty'],0,'.',',')}} / {{number_format($feedlot['external_received']['breederbullQty'],0,'.',',')}}</td>
										<td>{{number_format($feedlot['internal_received']['breederheiferQty'],0,'.',',')}} / {{number_format($feedlot['external_received']['breederheiferQty'],0,'.',',')}}</td>
										<td>{{date('d/m/Y',strtotime($feedlot['updated_at']))}}</td>
									</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div>
			<div class = "col-md-12">
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh tỷ lệ tổng đàn bò nhập giữa các đối tác</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="pie-total-quantity" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<div class = "col-md-12">
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh tỷ lệ tổng đàn bò nhập từ giữa các công ty</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="column-total-company-quantity" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<div class = "col-md-12">
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh tỷ lệ tổng đàn bò nhập giữa các trang trại</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="column-total-feedlot-quantity" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<div class = "col-md-6">
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ đàn bò nhập từ <b>nhà xuất khẩu</b> giữa các công ty</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="pie-total-company-quantity" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<div class = "col-md-6">
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ đàn bò nhập từ <b>nhà xuất khẩu</b> giữa các trang trại</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="pie-total-feedlot-quantity" style="height:300px;"></div>
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
		Array.prototype.reduce = undefined;
		/* ------------------ */	
		// Script cho datatable
		$("document").ready(function(){
			var table = $('#company-received-quantity-table').DataTable({
				"bPaginate": false,
	            "bLengthChange": true,
	            "bFilter": false,
	            "bSort": false,
	            "bInfo": false,
	            "bAutoWidth": true
			});
			 $('#company-received-quantity-table tbody tr').on("click",'td.data',function(event){
	        	parentTr = $(this).parent().get(0);
	        	id = parentTr.id;
	        	url = "{{URL::route('front_report_livestock_received_quantity_company_get')}}";
	        	url += '/' +id;
     			$(location).attr("href", url);
	        });
	        $('#company-received-quantity-table tbody').on("click",'td.details-control',function(event){
	        	//console.log(event);
	        	var tr = $(this).closest('tr');
	        	var row = table.row(tr);

		         if (row.child.isShown()) {
		              // This row is already open - close it
		              row.child.hide();
		              tr.removeClass('shown');
		          } else {
		              // Open this row
		              row.child(CompanyDetailFormat(tr.data('child-value'))).show();
		              tr.addClass('shown');
		          }
	        })
		})

		/*Xu ly tao bieu do bang google chart */
		// Bieu do pie ty le so bo thuc te giua cac quoc gia
		google.load("visualization", "1", {packages:["corechart","timeline"],'language': 'vi'});
		google.setOnLoadCallback(sumQuantityExporterhart);
		google.setOnLoadCallback(sumQuantityCompanyColumnChart);
		google.setOnLoadCallback(sumQuantityFeedlotColumnChart);
		google.setOnLoadCallback(sumQuantityCompanyPieChart);
		google.setOnLoadCallback(sumQuantityFeedlotPieChart);	
		// Ham xu ly de chart responsive
		$(window).resize(function () {
    		//sumQuantityAndPricePartnerChart();
    		//importPlaningTimeChart();
		});

		function sumQuantityExporterhart(){
			var optionsSumQuantity = {
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
    		var divToShowSumQuantity = $('#pie-total-quantity');
    		var exporters = {{json_encode($data['exporters'])}};
    		if(!jQuery.isEmptyObject(exporters)){
    			var dataSumQuantity = new google.visualization.DataTable();
	    		dataSumQuantity.addColumn('string','ExporterName');
	    		dataSumQuantity.addColumn('number','sumQuantity');
				
				$.each(exporters,function(key,exporter){	
					dataSumQuantity.addRows([
	    				[exporter.name,{v:exporter.sumQty,f:numberWithCommans(exporter.sumQty)}],
	    			]);		
				});
	    		
	    		var chartSumQuantity = new google.visualization.PieChart(document.getElementById('pie-total-quantity'));
	    		chartSumQuantity.draw(dataSumQuantity,optionsSumQuantity);

    		}else{
    			ShowNoDataToDrawnChartMessages(divToShowSumQuantity);
    		}
		}
		function sumQuantityCompanyPieChart(){
			var optionsCompanySumQuantity = {
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
    		var divToShowComapnyQuantity = $('#pie-total-company-quantity');
    		var divToShowFeedlotQuantity = $('#pie-total-feedlot-quantity');
    		var companies = {{json_encode($data['companies'])}}
    		if(!jQuery.isEmptyObject(companies)){
    			var dataCompanyQuantity = new google.visualization.DataTable();
	    		dataCompanyQuantity.addColumn('string','ExporterName');
	    		dataCompanyQuantity.addColumn('number','sumQuantity');
	    		$.each(companies,function(key,company){
	    			dataCompanyQuantity.addRows([
	    				[company.name,{v:company.external_received.sumQty,f:numberWithCommans(company.external_received.sumQty)}],
	    			]);	
	    		});
	    		var chartSumCompanyQuantity = new google.visualization.PieChart(document.getElementById('pie-total-company-quantity'));
	    		chartSumCompanyQuantity.draw(dataCompanyQuantity,optionsCompanySumQuantity)
    		}else{
    			ShowNoDataToDrawnChartMessages(divToShowComapnyQuantity);
    		}
		}
		function sumQuantityFeedlotPieChart(){
			var optionsCompanySumQuantity = {
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
    		var divToShowFeedlotQuantity = $('#pie-total-feedlot-quantity');
    		var feedlots = {{json_encode($data['feedlots'])}}
    		if(!jQuery.isEmptyObject(feedlots)){
    			var dataFeedlotQuantity = new google.visualization.DataTable();
	    		dataFeedlotQuantity.addColumn('string','feedlotName');
	    		dataFeedlotQuantity.addColumn('number','sumQuantity');
	    		$.each(feedlots,function(key,feedlot){
	    			dataFeedlotQuantity.addRows([
	    				[feedlot.name,{v:feedlot.external_received.sumQty,f:numberWithCommans(feedlot.external_received.sumQty)}],
	    			]);	
	    		});
	    		var chartSumFeedlotQuantity = new google.visualization.PieChart(document.getElementById('pie-total-feedlot-quantity'));
	    		chartSumFeedlotQuantity.draw(dataFeedlotQuantity,optionsCompanySumQuantity)
    		}else{
    			ShowNoDataToDrawnChartMessages(divToShowFeedlotQuantity);
    		}
		}
		function sumQuantityCompanyColumnChart(){
			var optionsColumnChart = {
					isStacked : true,
					width: '100%',
					height: '100%',
					legend: {position: 'top', maxLines: 3},
					hAxis : {
						title: 'Công ty',
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
			var divToShowComapnyQuantity = 'column-total-company-quantity';
			var companies = {{json_encode($data['companies'])}}
			if(!jQuery.isEmptyObject(companies)){
				var dataCompanyQuantity = new google.visualization.DataTable();
	    		dataCompanyQuantity.addColumn('string','companyName');
	    		dataCompanyQuantity.addColumn('number','Nhập nội bộ');
	    		dataCompanyQuantity.addColumn('number','Nhập nhà xuất khẩu');
	    		$.each(companies,function(key,company){
	    			dataCompanyQuantity.addRows([
	    				[company.name,{v:company.internal_received.sumQty,f:numberWithCommans(company.internal_received.sumQty)},{v:company.external_received.sumQty,f:numberWithCommans(company.external_received.sumQty)}],
	    			]);	
	    		});
	    		var chartSumCompanyQuantity = new google.visualization.ColumnChart(document.getElementById(divToShowComapnyQuantity));
	    		chartSumCompanyQuantity.draw(dataCompanyQuantity,optionsColumnChart)
			}else{
				ShowNoDataToDrawnChartMessages(divToShowComapnyQuantity);
			}
		}
		function sumQuantityFeedlotColumnChart(){
			var optionsColumnChart = {
					isStacked : true,
					width: '100%',
					height: '100%',
					legend: {position: 'top', maxLines: 3},
					hAxis : {
						title: 'Trang trại',
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
			var divToShowFeedlotQuantity = 'column-total-feedlot-quantity';
			var feedlots = {{json_encode($data['feedlots'])}}
			if(!jQuery.isEmptyObject(feedlots)){
				var dataFeedlotQuantity = new google.visualization.DataTable();
	    		dataFeedlotQuantity.addColumn('string','feedlotName');
	    		dataFeedlotQuantity.addColumn('number','Nhập nội bộ');
	    		dataFeedlotQuantity.addColumn('number','Nhập nhà xuất khẩu');
	    		$.each(feedlots,function(key,feedlot){
	    			dataFeedlotQuantity.addRows([
	    				[feedlot.name,{v:feedlot.internal_received.sumQty,f:numberWithCommans(feedlot.internal_received.sumQty)},{v:feedlot.external_received.sumQty,f:numberWithCommans(feedlot.external_received.sumQty)}],
	    			]);	
	    		});
	    		var chartSumFeedlotQuantity = new google.visualization.ColumnChart(document.getElementById(divToShowFeedlotQuantity));
	    		chartSumFeedlotQuantity.draw(dataFeedlotQuantity,optionsColumnChart)
			}else{
				ShowNoDataToDrawnChartMessages(divToShowFeedlotQuantity);
			}
		}
		function CompanyDetailFormat(value){
			var jObject;
			var dataJson = {{json_encode($data['feedlotsPerCompanies'])}}		
			var companyData = dataJson[value]

			var str = '';
			var sumInternalReceivedQty = 0; 
			var sumQty = 0;
			if(!jQuery.isEmptyObject(companyData)){
				$.each(companyData,function(key,value){
					var quantity = JSON.parse(value.pivot.received_quantity);
					var internalReceivedQty = JSON.parse(value.pivot.internal_received_quantity);
					sumQty = quantity.feedersteer + quantity.feederheifer + quantity.breederbull + quantity.breederheifer;
					sumInternalReceivedQty = internalReceivedQty.feedersteer + internalReceivedQty.feederheifer + internalReceivedQty.breederbull + internalReceivedQty.breederheifer;
					str +=  '<tr>'+
	                    '<td>--</td>'+
	                    '<td>'+ value.name+'</td>'+
	                    '<td>' + numberWithCommans(sumInternalReceivedQty) + ' / ' + numberWithCommans(sumQty) + '</td>'+
	                    '<td>' + numberWithCommans(internalReceivedQty.feedersteer)  + ' / ' +  numberWithCommans(quantity.feedersteer) + '</td>'+
	                    '<td>' + numberWithCommans(internalReceivedQty.feederheifer) + ' / ' +  numberWithCommans(quantity.feederheifer) + '</td>'+
	                    '<td>' + numberWithCommans(internalReceivedQty.breederbull) + ' / ' + numberWithCommans(quantity.breederbull) + '</td>'+
	                    '<td>' + numberWithCommans(internalReceivedQty.breederheifer) + ' / ' + numberWithCommans(quantity.breederheifer) + '</td>'+
	                    '<td>--</td>'+
	                '</tr>'
	                sumQty =0;
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

	</script>
@stop