@extends('layout.master')
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
          <h1>
            Quản lý báo cáo chăn nuôi bò thịt
            <small>Bảng điều khiển</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Quản trị</a></li>
            <li class="active">Báo cáo ngành</li>
          </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-md-12">
    			 <!-- Application buttons -->
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Chức năng</h3>
                </div>
                <div class="box-body">
                  
                  <p>Chọn chức năng dưới đây để thực hiện:</p>
                  <a href="{{route('admin_report_import_contract_get')}}" class="btn btn-app">
                    <i class="fa fa-edit"></i> Quản lý hợp đồng nhập bò
                  </a>
                  <a href="{{route('admin_report_import_quantity_get')}}" class="btn btn-app">
                    <i class="fa fa-play"></i> Quản lý lô nhập bò
                  </a>
                  <a class="btn btn-app">
                    <i class="fa fa-repeat"></i> Quản lý chi tiết nhập
                  </a>
                  <a class="btn btn-app">
                    <i class="fa fa-pause"></i> Quản lý luân chuyển bò
                  </a>
                  
                </div><!-- /.box-body -->
              </div><!-- /.box -->
    		</div>
    	</div>
    </section>

</div>
@stop