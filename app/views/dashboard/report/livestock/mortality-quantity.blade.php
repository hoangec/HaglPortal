@extends('layout.master')
@section('stylehead')
	<!-- Datepicker -->
	{{HTML::style('public/plugins/bootstrap-datetimepicker/bootstrap-datepicker.min.css')}}
	<!-- Datatable-->
	{{HTML::style('public/plugins/datatables/css/jquery.dataTables.css')}}
	<!-- Parsley -->
    {{HTML::style("public/plugins/parsley/parsley.css")}}
    <!-- cus hoangec style -->
    {{HTML::style("public/css/adminlte/cushoangec.css")}}
@stop
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
	    Báo cáo bò thịt chết	
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
	    <li><a href="#">Báo cáo ngành</a></li>
	    <li><a href="{{URL::route('front_report_livestock_index_get')}}">Chăn nuôi bò thịt</a></li>
	    <li class="active">Bò chết</li>
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
						<h3 class="box-title">Số lượng bò chết giữa các quốc gia</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="real-quantity-country-table" class="table table-bordered table-striped table-hover">
							<thead>
								<tr >			                        
			                        <th>Quốc gia</th>	
			                        <th>Tổng</th>	                        
			                        <th>Bò đực vỗ béo</th>
			                        <th>Bò cái vỗ béo</th>
			                        <th>Bò đực giống</th>
			                        <th>Bò cái giống</th>
			                        <th>Ngày cập nhật</th>			                        
		                      </tr>
							</thead>
							<tbody>
								@if(!empty($data['countries']) )
									@foreach($data['countries'] as $country)
									<tr id = "{{$country['id']}}">
										<td>{{$country['name']}}</td>
										<td class="total-column">{{number_format($country['sumQty'],0,'.',',')}}</td>
										<td>{{number_format($country['feedersteerQty'],0,'.',',')}}</td>
										<td>{{number_format($country['feederheiferQty'],0,'.',',')}}</td>
										<td>{{number_format($country['breederbullQty'],0,'.',',')}}</td>
										<td>{{number_format($country['breederheiferQty'],0,'.',',')}}</td>
										<td>{{date('d/m/Y',strtotime($country['updated_at']))}}</td>
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
						<h3 class="box-title">Số lượng bò chết theo khu vực</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="real-quantity-feedlot-table" class="display nowrap" cellspacing="0">
							<thead>
								<tr >			                        
			                        <th>Khu vực</th>	
			                        <th>Tổng</th>	                        
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
										<td>{{$feedlot['name']}}</td>
										<td class="total-column">{{number_format($feedlot['sumQty'],0,'.',',')}}</td>
										<td>{{number_format($feedlot['feedersteerQty'],0,'.',',')}}</td>
										<td>{{number_format($feedlot['feederheiferQty'],0,'.',',')}}</td>
										<td>{{number_format($feedlot['breederbullQty'],0,'.',',')}}</td>
										<td>{{number_format($feedlot['breederheiferQty'],0,'.',',')}}</td>
										<td>{{date('d/m/Y',strtotime($feedlot['updated_at']))}}</td>
									</tr>
									@endforeach
								@endif()
							</tbody>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div>
			<div class="col-md-12">
				<!-- list cow import box -->
				<div class="box" >
					<div class="box-header">
						<h3 class="box-title">Số lượng bò chết theo các đối tác xuất khẩu</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="real-quantity-exporter-table" class="display nowrap" cellspacing="0">
							<thead>
								<tr >			                        
			                        <th>Nhà xuất khẩu</th>	
			                        <th>Tổng</th>	                        
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
										<td>{{$exporter['name']}}</td>
										<td class="total-column">{{number_format($exporter['sumQty'],0,'.',',')}}</td>
										<td>{{number_format($exporter['feedersteerQty'],0,'.',',')}}</td>
										<td>{{number_format($exporter['feederheiferQty'],0,'.',',')}}</td>
										<td>{{number_format($exporter['breederbullQty'],0,'.',',')}}</td>
										<td>{{number_format($exporter['breederheiferQty'],0,'.',',')}}</td>
										<td>{{date('d/m/Y',strtotime($exporter['updated_at']))}}</td>
									</tr>
									@endforeach
								@endif()
							</tbody>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div>
			<div class = "col-md-12">
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh tỷ lệ tổng đàn bò chết giữa các quốc gia</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="country_pie_chart" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<div class = "col-md-6">
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh tỷ lệ tổng đàn bò chết giữa các khu vực</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="feedlot_pie_chart" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<div class = "col-md-6">
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh tỷ lệ tổng đàn bò chết giữa các đối tác xuất khẩu</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="exporter_pie_chart" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<div class = "col-md-12">
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ phân bổ chi tiết đàn bò chết giữa các quốc gia</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="detail_country_quantity_chart" style="height:300px;"></div>
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
			$('#real-quantity-country-table, #real-quantity-feedlot-table, #real-quantity-exporter-table').DataTable({
	          "bPaginate": false,
	          "bLengthChange": true,
	          "bFilter": false,
	          "bSort": false,
	          "bInfo": false,
	          "bAutoWidth": true
	        });
	       /* $('#real-quantity-country-table tbody tr').on("click",function(event){
	        	id = this.id;
	        	url = "{{URL::route('front_report_livestock_mortality_quantity_get')}}";
	        	url += "/" + id;
     			$(location).attr("href", url);
	        }); */
		})

		/*Xu ly tao bieu do bang google chart */
		// Bieu do pie ty le so bo thuc te giua cac quoc gia
		/*google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(sumQuantityCountryPieChart);*/
		// Bieu do column ty mat do chi tiet cac loai bo giua cac quoc gia
		google.load("visualization", "1", {packages:["corechart","bar"]});
		google.setOnLoadCallback(detailCountryChart);
		google.setOnLoadCallback(countryQuantityChart);
		google.setOnLoadCallback(feedlotQuantityChart);
		google.setOnLoadCallback(exporterQuantityChart);
		// Ham xu ly de chart responsive
		$(window).resize(function () {
    		detailCountryChart();
    		countryQuantityChart();
    		feedlotQuantityChart();
    		exporterQuantityChart();
		});

		function countryQuantityChart(){
			var options = {
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
    		divToShowcountryChart = $('#country_pie_chart');
    		var countries = {{json_encode($data['countries'])}};
    		if(!jQuery.isEmptyObject(countries)){
    			var data = new google.visualization.DataTable();
	    		data.addColumn('string','countryName');
	    		data.addColumn('number','sumQuantity');
	    		$.each(countries,function(key,country){
	    			data.addRows([
	    				[country.name,{v:country.sumQty,f:numberWithCommans(country.sumQty)}],
	    			]);
	    		});
	    		var chart = new google.visualization.PieChart(document.getElementById('country_pie_chart'));
	    		chart.draw(data,options);
    		}else{
    			ShowNoDataToDrawnChartMessages(divToShowcountryChart);
    		}
    		
		}
		function detailCountryChart(){
			var options = {
					isStacked : true,
					width: '100%',
					height: '100%',
					legend: {position: 'top', maxLines: 3},
					hAxis : {
						title: 'Quốc gia',
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
			var divToShowChart = $('#detail_country_quantity_chart');
			var countries = {{json_encode($data['countries'])}}
			if(!jQuery.isEmptyObject(countries)){
				var data = new google.visualization.DataTable();
				data.addColumn('string',"Quốc gia");
				data.addColumn('number',"Bò thịt đực");
				data.addColumn('number',"Bò thịt cái");
				data.addColumn('number',"Bò giống đực");
				data.addColumn('number',"Bò giống cái");
				$.each(countries,function(key,country){
					data.addRows([
						[
							country.name,
							{v:country.feedersteerQty,f:numberWithCommans(country.feedersteerQty)},
							{v:country.feederheiferQty,f:numberWithCommans(country.feederheiferQty)},
							{v:country.breederbullQty,f:numberWithCommans(country.breederbullQty)},
							{v:country.breederheiferQty,f:numberWithCommans(country.breederheiferQty)}
						],
					]);
				});
				var chart = new google.visualization.ColumnChart(document.getElementById('detail_country_quantity_chart'));
				chart.draw(data, options);
			}else{
				ShowNoDataToDrawnChartMessages(divToShowChart);
			}		
		}

		function feedlotQuantityChart(){
			var options = {
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
    		divToShowfeedlotChart = $('#feedlot_pie_chart');
    		var feedlots = {{json_encode($data['feedlots'])}};
    		if(!jQuery.isEmptyObject(feedlots)){
    			var data = new google.visualization.DataTable();
	    		data.addColumn('string','feedlotName');
	    		data.addColumn('number','sumQuantity');
	    		$.each(feedlots,function(key,feedlot){
	    			data.addRows([
	    				[feedlot.name,{v:feedlot.sumQty,f:numberWithCommans(feedlot.sumQty)}],
	    			]);
	    		});
	    		var chart = new google.visualization.PieChart(document.getElementById('feedlot_pie_chart'));
	    		chart.draw(data,options);
    		}else{
    			ShowNoDataToDrawnChartMessages(divToShowfeedlotChart);
    		}
		}
		function exporterQuantityChart(){
			var options = {
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
    		divToShowExporterChart = $('#exporter_pie_chart');
    		var exporters = {{json_encode($data['exporters'])}};
    		if(!jQuery.isEmptyObject(exporters)){
    			var data = new google.visualization.DataTable();
	    		data.addColumn('string','exporterName');
	    		data.addColumn('number','sumQuantity');
	    		$.each(exporters,function(key,exporter){
	    			data.addRows([
	    				[exporter.name,{v:exporter.sumQty,f:numberWithCommans(exporter.sumQty)}],
	    			]);
	    		});
	    		var chart = new google.visualization.PieChart(document.getElementById('exporter_pie_chart'));
	    		chart.draw(data,options);
    		}else{
    			ShowNoDataToDrawnChartMessages(divToShowfeedlotChart);
    		}
		}
	</script>
@stop