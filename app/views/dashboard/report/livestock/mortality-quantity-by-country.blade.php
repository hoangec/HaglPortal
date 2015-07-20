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
	    Báo cáo số lượng bò chết
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
	    <li><a href="#"?Báo cáo ngành</a></li>
	    <li><a href="{{URL::route('front_report_livestock_index_get')}}">Chăn nuôi bò thịt</a></li>
	    <li><a href="{{URL::route('front_report_livestock_real_quantity_get')}}">Tổng đàn bò thực tế</a></li>
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
						<h3 class="box-title">Số lượng bò chết tại {{$data['country']['name'] }} theo công ty</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="real-quantity-company-table" class="display nowrap" cellspacing="0">
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
									<td>{{number_format($company['feedersteerQty'],0,'.','.')}}</td>
									<td>{{number_format($company['feederheiferQty'],0,',','.')}}</td>
									<td>{{number_format($company['breederbullQty'],0,',','.')}}</td>
									<td>{{number_format($company['breederheiferQty'],0,'.','.')}}</td>
									<td>{{date('d/m/Y',strtotime($company['updated_at']))}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div><!--./ real quantity table by company -->
			<div class = col-md-12>
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh mật độ phân bổ đàn bò chết giữa các công ty tại <b>{{$data['country']['name']}}</b></h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="company_pie_chart" style="height:300px;"></div>
	                </div><!-- /.box-body -->
	            </div><!-- /.box -->
			</div>
			<div class = col-md-12>
				<!-- AREA CHART 1-->
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh mật độ phân bổ đàn bò chết giữa các công ty tại <b>{{$data['country']['name']}}</b></h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="company_column_chart" style="height:300px;"></div>
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
		function format(value){
			var jObject;
			var dataJson = {{json_encode($data['companies'])}}
			var companyData = dataJson[value]
			var str = '';
			$.each(companyData.feedlots,function(key,feedlot){
				var quantity = JSON.parse(feedlot.pivot.mortality_quantity);
				
				str +=  '<tr>'+
	                    '<td>--</td>'+
	                    '<td>'+ feedlot.name+'</td>'+
	                    '<td>' + numberWithCommans(quantity.feedersteer + quantity.feederheifer + quantity.breederbull + quantity.breederheifer) + '</td>'+
	                    '<td>' + numberWithCommans(quantity.feedersteer) + '</td>'+
	                    '<td>' + numberWithCommans(quantity.feederheifer) + '</td>'+
	                    '<td>' + numberWithCommans(quantity.breederbull) + '</td>'+
	                    '<td>' + numberWithCommans(quantity.breederheifer) + '</td>'+
	                    '<td>--</td>'+
	                '</tr>'
	        });
			jObject = $(str);
			return jObject;
    	}
		$(document).ready(function(){
			var table = $('#real-quantity-company-table').DataTable({
				"bPaginate": false,
	            "bLengthChange": true,
	            "bFilter": false,
	            "bSort": false,
	            "bInfo": false,
	            "bAutoWidth": true
			});
	        $('#real-quantity-company-table tbody').on("click",'td.details-control',function(){
		        
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
		google.setOnLoadCallback(companyQuantityChart);
		
		$(window).resize(function () {
    		//companyColumnChart();
    		//farmByCompanyColumnChart();
		});

		function companyQuantityChart(){
			var columnChartOptions = {
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
      			title: 'Số lượng thực tế'
    			}
			};
			var pieChartOptions = {
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
    		var divShowCompanyPieChart = $('#company_pie_chart');
    		var divShowCompanyColumnChart = $('#company_column_chart');
			var companies = {{json_encode($data['companies'])}}
			if(!jQuery.isEmptyObject(companies)){
				var dataColumnChart = new google.visualization.DataTable();
				var dataPieChart = new google.visualization.DataTable();
				dataColumnChart.addColumn('string',"Công ty");
				dataColumnChart.addColumn('number',"Bò thịt đực");
				dataColumnChart.addColumn('number',"Bò thịt cái");
				dataColumnChart.addColumn('number',"Bò giống đực");
				dataColumnChart.addColumn('number',"Bò giống cái");
				//
				dataPieChart.addColumn('string',"companyName");
				dataPieChart.addColumn('number',"quantity");
				$.each(companies,function(key,company){
					dataColumnChart.addRows([
						[company.name,company.feedersteerQty,company.feederheiferQty,company.breederbullQty,company.breederheiferQty],
					]);
					dataPieChart.addRows([
	    				[company.name,{v:company.sumQty,f:numberWithCommans(company.sumQty)}],
	    			]);
				});
				
				var columnChart = new google.visualization.ColumnChart(document.getElementById('company_column_chart'));
				columnChart.draw(dataColumnChart,columnChartOptions);

				var pieChart = new google.visualization.PieChart(document.getElementById('company_pie_chart'));
				pieChart.draw(dataPieChart,pieChartOptions);

			}else{
				ShowNoDataToDrawnChartMessages(divShowCompanyPieChart);
				ShowNoDataToDrawnChartMessages(divShowCompanyColumnChart);
			}
			
		}
		

	</script>
@stop