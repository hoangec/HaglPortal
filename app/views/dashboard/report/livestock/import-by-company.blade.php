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
	     Báo cáo tổng đàn bò thịt nhập theo từng công ty
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
	    <li><a href="#"Báo cáo ngành</a></li>
	    <li><a href="{{URL::route('front_report_livestock_index_get')}}">Chăn nuôi bò thịt</a></li>
	    <li><a href="{{URL::route('front_report_livestock_received_quantity_get')}}">Tổng đàn bò nhập</a></li>
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
						<h3 class="box-title">Các trang trại nhập</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="partner-contract-table" class="display nowrap" cellspacing="0">
							<thead>
								<tr>	
									<th></th>
									<th>Trang trại</th>		                        
			                        <th></th>	                        
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

							</tbody>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div>

	</section>
</div>
@stop
@section('data_code')

    <!--Load script google chart -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			var table = $('#partner-contract-table').DataTable({

			});

		})
	</script>
@stop