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
	    Báo cáo tổng đàn bò thịt chết từng quốc gia
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
	    <li><a href="#">Báo cáo ngành</a></li>
	    <li><a href="{{URL::route('front_report_beef_index_get')}}">Chăn nuôi bò thịt</a></li>
	    <li><a href="{{URL::route('front_report_beef_death_quantity_get')}}">Tổng đàn bò chết</a></li>
	    <li class="active">Quốc gia</li>
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
						<h3 class="box-title">Số lượng bò chết tại {{$data['country']['name']}}</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="real-quantity-table" class="display nowrap" cellspacing="0">
							<thead>
								<tr>	
									<th></th>		                        
			                        <th>Công ty</th>	
			                        <th >Tổng</th>	                        
			                        <th>Bò đực vỗ béo</th>
			                        <th>Bò cái vỗ béo</th>
			                        <th>Bò đực giống</th>
			                        <th>Bò cái giống</th>
			                        <th>Ngày cập nhật</th>			                        
		                      </tr>
							</thead>
							<tbody>
								@foreach($data['companies'] as $company)
								<tr data-child-value="{{$company['id']}}">		
									<td class="details-control"></td>					
									<td>{{$company['name']}}</td>
									<td class="total-column">{{number_format($company['sumQty'],0,',','.')}}</td>
									<td>{{number_format($company['feederSteerQty'],0,'.','.')}}</td>
									<td>{{number_format($company['feederheiferQty'],0,',','.')}}</td>
									<td>{{number_format($company['breederBullQty'],0,',','.')}}</td>
									<td>{{number_format($company['breederheiferQty'],0,'.','.')}}</td>
									<td>{{date('d/m/Y',strtotime($company['updated_at']))}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div>
			<div class = col-md-12>
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh mật độ phân bổ đàn bò chết giữa các công ty tại <b>{{$data['country']['name']}}</b></h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="column-real-company-total" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			@foreach($data['companies'] as $company)
			<div class = col-md-12>
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh mật độ phân bổ đàn bò chết giữa các nông trường tại công ty <b>{{$company['name']}}</b></h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="column-real-company-{{$company['id']}}" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			@endforeach
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
		// Thu vien dinh dang so
		function format(value){
			var jObject;
			var dataJson = {{json_encode($data['farms'])}}
			var companyData = dataJson[value]
			var str = '';
			$.each(companyData,function(key,value){
				str +=  '<tr>'+
	                    '<td>--</td>'+
	                    '<td>'+ value.name+'</td>'+
	                    '<td>' + numberWithCommans(value.death_quantity.sumQty) + '</td>'+
	                    '<td>' + numberWithCommans(value.death_quantity.feederSteerQty) + '</td>'+
	                    '<td>' + numberWithCommans(value.death_quantity.feederheiferQty) + '</td>'+
	                    '<td>' + numberWithCommans(value.death_quantity.breederBullQty) + '</td>'+
	                    '<td>' + numberWithCommans(value.death_quantity.breederheiferQty) + '</td>'+
	                    '<td>--</td>'+
	                '</tr>'
	        });
			jObject = $(str);
			return jObject;
    	}
		$(document).ready(function(){
			var table = $('#real-quantity-table').DataTable({
				"bPaginate": false,
	            "bLengthChange": true,
	            "bFilter": false,
	            "bSort": false,
	            "bInfo": false,
	            "bAutoWidth": true
			});
	        $('#real-quantity-table tbody').on("click",'td.details-control',function(){
		        
	        	var tr = $(this).closest('tr');
	        	var row = table.row(tr);

		         if (row.child.isShown()) {
		              // This row is already open - close it
		              row.child.hide();
		              tr.removeClass('shown');
		          } else {
		              // Open this row
		              row.child(format(tr.data('child-value'))).show();
		              tr.addClass('shown');
		          }
	        })

		})
		
		// script cho cac bieu do dung google chart
		google.load("visualization", "1", {packages:["corechart",'bar']});
		google.setOnLoadCallback(companyColumnChart);

		google.load("visualization", "1", {packages:["corechart","bar"]});
		google.setOnLoadCallback(farmByCompanyColumnChart);
		
		
		$(window).resize(function () {
    		//companyColumnChart();
    		//farmByCompanyColumnChart();
		});

		function companyColumnChart(){
			var companies = {{json_encode($data['companies'])}}
			var data = new google.visualization.DataTable();
			data.addColumn('string',"Công ty");
			data.addColumn('number',"Bò thịt đực");
			data.addColumn('number',"Bò thịt cái");
			data.addColumn('number',"Bò giống đực");
			data.addColumn('number',"Bò giống cái");
			$.each(companies,function(key,company){
				data.addRows([
					[company.name,company.feederSteerQty,company.feederheiferQty,company.breederBullQty,company.breederheiferQty],
				]);
			});
			var options = {
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
			var chart = new google.visualization.ColumnChart(document.getElementById('column-real-company-total'));
			chart.draw(data,options);
			//console.log(companies);
		}
		
		function farmByCompanyColumnChart(){
			var companyFarms = {{json_encode($data['farms'])}};
			//console.log(farms);
			
			$.each(companyFarms,function(key,company){	
				var data = new google.visualization.DataTable();			
				data.addColumn('string',"Nông trường");
				data.addColumn('number',"Bò thịt đực");
				data.addColumn('number',"Bò thịt cái");
				data.addColumn('number',"Bò giống đực");
				data.addColumn('number',"Bò giống cái");
				$.each(company,function(key,farm){
					//console.log(farm.real_quantity.feederSteerQty);
					data.addRows([
						[farm.name,farm.real_quantity.feederSteerQty,farm.real_quantity.feederheiferQty,farm.real_quantity.breederBullQty,farm.real_quantity.breederheiferQty],
					]);
				})
				var options = {
					isStacked : true,
					width: '100%',
					height: '100%',
					legend: {position: 'top', maxLines: 3},
					hAxis : {
						title: 'Nông trường',
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
				var chart = new google.visualization.ColumnChart(document.getElementById('column-real-company-'+key));
				chart.draw(data, options);
			})
		}		
	</script>
@stop