@extends('layout.master')
@section('stylehead')
	<!-- Datepicker -->
	{{HTML::style('public/plugins/bootstrap-datetimepicker/bootstrap-datepicker.min.css')}}
	<!-- Datatable-->
	{{HTML::style('public/plugins/datatables/css/dataTables.bootstrap.css')}}
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
	    Báo cáo tổng đàn bò thịt chết các quốc gia
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
	    <li><a href="#">Báo cáo ngành</a></li>
	    <li><a href="{{URL::route('front_report_beef_index_get')}}">Chăn nuôi bò thịt</a></li>
	    <li class="active">Tổng đàn bò chết</li>
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
						<h3 class="box-title">Số lượng bò chết</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="real-quantity-table" class="table table-bordered table-striped table-hover">
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
								<?php 
									$sumTotal = 0;
									$sumFeederSteer = 0;
									$sumFeederheifer = 0;
									$sumBreederBull = 0;
									$sumBreederheifer = 0;
								?>
								@foreach($data as $country)
								<?php 
									$sumTotal +=  $country['sumQty'];
									$sumFeederSteer += $country['feederSteerQty'];
									$sumFeederheifer += $country['feederheiferQty'];
									$sumBreederBull += $country['breederBullQty'];
									$sumBreederheifer += $country['breederheiferQty'];
								?>
								<tr id = "{{$country['id']}}">
									<td>{{$country['name']}}</td>
									<td class="total-column">{{number_format($country['sumQty'],0,',','.')}}</td>
									<td>{{number_format($country['feederSteerQty'],0,',','.')}}</td>
									<td>{{number_format($country['feederheiferQty'],0,',','.')}}</td>
									<td>{{number_format($country['breederBullQty'],0,',','.')}}</td>
									<td>{{number_format($country['breederheiferQty'],0,',','.')}}</td>
									<td>{{date('d/m/Y',strtotime($country['updated_at']))}}</td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>
									<td >Tổng</td>
									<td>{{number_format($sumTotal,0,',','.')}}</td>
									<td>{{number_format($sumFeederSteer,0,',','.')}}</td>
									<td>{{number_format($sumFeederheifer,0,',','.')}}</td>
									<td>{{number_format($sumBreederBull,0,',','.')}}</td>
									<td>{{number_format($sumBreederheifer,0,',','.')}}</td>
									<td></td>
								</tr>
							</tfoot>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div>
			<div class = col-md-12>
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh tỷ lệ tổng đàn bò chết giữa các quốc gia</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="pie-total" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<div class = col-md-12>
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ phân bổ chi tiết đàn bò chết giữa các quốc gia</h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="column-real-country" style="height:300px;"></div>
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
			var myTable = $('#real-quantity-table');
			myTable.dataTable({
	          "bPaginate": false,
	          "bLengthChange": true,
	          "bFilter": false,
	          "bSort": false,
	          "bInfo": false,
	          "bAutoWidth": true
	        });
	        $('#real-quantity-table tbody tr').on("click",function(event){
	        	id = this.id;
	        	url = "{{URL::route('front_report_beef_death_quantity_get')}}";
	        	url += "/" + id;
     			$(location).attr("href", url);
	        });
		})

		/*Xu ly tao bieu do bang google chart */
		// Bieu do pie ty le so bo thuc te giua cac quoc gia
		google.load("visualization", "1", {packages:["corechart"]});
		google.setOnLoadCallback(sumQuantityCountryPieChart);
		// Bieu do column ty mat do chi tiet cac loai bo giua cac quoc gia
		google.load("visualization", "1", {packages:["corechart","bar"]});
		google.setOnLoadCallback(detailCountryColumnChart);
		// Ham xu ly de chart responsive
		$(window).resize(function () {
    		sumQuantityCountryPieChart();
    		detailCountryColumnChart();
		});

		function sumQuantityCountryPieChart(){
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
    		var countries = {{json_encode($data)}};
    		var data = new google.visualization.DataTable();
    		data.addColumn('string','countryName');
    		data.addColumn('number','sumQuantity');
    		$.each(countries,function(key,country){
    			console.log(country);
    			data.addRows([
    				[country.name,{v:country.sumQty,f:numberWithCommans(country.sumQty)}],
    			]);
    		});
    		var chart = new google.visualization.PieChart(document.getElementById('pie-total'));
    		chart.draw(data,options);
		}
		function detailCountryColumnChart(){
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
			var countries = {{json_encode($data)}}
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
						{v:country.feederSteerQty,f:numberWithCommans(country.feederSteerQty)},
						{v:country.feederheiferQty,f:numberWithCommans(country.feederheiferQty)},
						{v:country.breederBullQty,f:numberWithCommans(country.breederBullQty)},
						{v:country.breederheiferQty,f:numberWithCommans(country.breederheiferQty)}
					],
				]);
			});
			var chart = new google.visualization.ColumnChart(document.getElementById('column-real-country'));
			chart.draw(data, options);
			//console.log(countries);
		}

		
	</script>
@stop