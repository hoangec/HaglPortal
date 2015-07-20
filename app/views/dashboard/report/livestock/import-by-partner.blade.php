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
	     Báo cáo tổng đàn bò thịt nhập từng quốc gia
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
	    <li><a href="#"Báo cáo ngành</a></li>
	    <li><a href="{{URL::route('front_report_livestock_index_get')}}">Chăn nuôi bò thịt</a></li>
	    <li><a href="{{URL::route('front_report_livestock_import_quantity_get')}}">Tổng đàn bò nhập</a></li>
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
						<h3 class="box-title">Các hợp đồng thuộc đối tác {{$data['partner']}} </h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="partner-contract-table" class="display nowrap" cellspacing="0">
							<thead>
								<tr>	
									<th></th>
									<th>Hợp đồng</th>		                        
			                        <th>Số lượng</th>	                        
			                        <th>Cân nặng</th>
			                        <th>Giá trị</th>
			                        <th>Ngày cập cảng</th>
			                        <th>Cảng nhập</th>
			                        <th>Thời hạn LC</th>
			                        <th>Nông trương nhận </th>
			                        <th>Trạng thái hợp đồng</th>			                        
		                      </tr>
							</thead>
							<tbody>
								@if(!empty($data['contracts']))
									@foreach($data['contracts'] as $contract)							
									@if($contract->diff_total_quantity != 0 || $contract->diff_total_weight != 0)
									<tr data-child-value ="{{$contract['id']}}" class="contract-diff-real">
									@else
									<tr data-child-value ="{{$contract['id']}}">
									@endif
										<td class="details-control"></td>
										<td>{{$contract->name}}</td>
										<td>{{number_format($contract['sumQty'],0,'.',',')}}</td>
										<td>{{number_format($contract['sumWeight'],0,'.',',')}} Kg</td>
										<td>{{number_format($contract['sumPrice'],2,'.',',')}} $</td>
										<td>{{date('d/m/Y',strtotime($contract['import_date']))}}</td>
										<td>{{$contract->port->name}}</td>
										<td>{{date('d/m/Y',strtotime($contract['lc_open_last_date']))}}</td>
										<td>{{$contract->farm->name}}</td>
										<td>{{$contract->imp_status_text}}</td>
									
									</tr>
									@endforeach
								@endif()
							</tbody>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div>
			<!-- <div class = col-md-12>
	            <div class="box box-primary">
	                <div class="box-header">
	                  <h3 class="box-title">Biểu đồ so sánh mật độ phân bổ đàn bò nhập giữa các công ty tại <b>---</b></h3>
	                </div>
	                <div class="box-body chart-responsive">
	                  <div class="chart" id="column-real-company-total" style="height:300px;"></div>
	                </div>
	            </div>
			</div> -->
		</div>

	</section>
</div>
@stop
@section('data_code')

    <!--Load script google chart -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		// Thu vien dinh dang so
		function format(value){
			var jObject;
			var dataJson = {{json_encode($data['contracts'])}}
			var contractData = dataJson[value]
			console.log(dataJson);
			var str1 = '';
			var str2 = '';
			str1 += "<p><b>Đơn giá nhập khẩu bò tương ứng hợp đồng</b></p>" +
					"<table>" +
						"<tr>" +
							"<th>Bò thịt đực</th>" +
							"<th>Bò thịt cái</th>" + 
							"<th>Bò giống đực</th>" +
							"<th>Bò giống cái</th>" +
						"</tr>" +
						"<tr>" +
							"<td>" + contractData.feedersteer_price + "</td>" +
							"<td>" + contractData.feederheifer_price + "</td>" + 
							"<td>" + contractData.breederbull_price + "</td>" +
							"<td>" + contractData.breederheifer_price + "</td>" +
						"</tr>" +
					"</table>";
			str2 += "<p><b>Chênh lệch giữa hợp đồng và thực tế nhập</b></p>" +
					"<table>" +
						"<tr>" +
							"<th></th>" +
							"<th>Kế hoạch</th>" + 
							"<th>Thực tế</th>" +
							"<th>Chênh lệch</th>" +
						"</tr>" +
						"<tr>" +
							"<td>Tổng Số lượng</td>" +
							"<td>" + numberWithCommans(contractData.sumQty) + "</td>" + 
							"<td>" + numberWithCommans((contractData.sumQty + contractData.diff_total_quantity)) + "</td>" +
							"<td>" + numberWithCommans((contractData.sumQty + contractData.diff_total_quantity - contractData.sumQty))  + "</td>" +
						"</tr>" +
						"<tr>" +
							"<td>Tổng trọng lượng</td>" +
							"<td>" + numberWithCommans(contractData.sumWeight) + "</td>" + 
							"<td>" + numberWithCommans((contractData.sumWeight+ contractData.diff_total_weight)) + "</td>" +
							"<td>" + numberWithCommans((contractData.sumWeight + contractData.diff_total_weight) - contractData.sumWeight)  + "</td>" +
						"</tr>" +
					"</table>";
			
			if(contractData.diff_total_quantity != 0 || contractData.diff_total_weight != 0  ){
				return str1 + "<br>" + str2;					
			}else{
				return str1;
			}
			
    	}
		$(document).ready(function(){
			var table = $('#partner-contract-table').DataTable({

			});
	        $('#partner-contract-table tbody').on("click",'td.details-control',function(){
		        
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
	</script>
@stop