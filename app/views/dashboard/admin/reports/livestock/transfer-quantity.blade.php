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
	    Quản lý báo cáo chăn nuôi bò thịt
	    <small>Quản lý lô nhập bò</small>
	  </h1>
	  <ol class="breadcrumb">
	    <li><a href="#"><i class="fa fa-dashboard"></i>Quản trị</a></li>
	    <li class="active">Báo cáo ngành</li>
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
				<!-- Add new cow import box -->				
				<div class="box box-primary" >
					<div class="box-header with-border">
						<h3 class="box-title">Chức năng</h3>										
						<br />
						<div class="box-application" style="margin-top:10px">
						 	<a class="btn btn-app" href="javascript:void(0)" onclick="showBoxFunc('box-contract-add')">
	                    		<i class="fa fa-edit"></i> Tạo lô nhập bò
	                 		</a>
						</div><!-- ./box-application -->
					</div><!--./box-header -->	
					<!--box-outer contract add function -->
					<div class="box-outer" id="box-contract-add" style="display:none">
						<!--Form start -->					
						{{Form::open(array('route'=>array('admin_report_livestock_transfer_quantity_add_post'),'id'=>'add_form'))}}	
						<div class="box-body">											
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">								
										{{Form::label('lblContract','Tên lô chuyển')}}
										{{Form::text('transfer_no','',array('class'=>'form-control'))}}								
									</div><!--./form-group -->
								</div>						
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lbldate','Ngày chuyển')}}
										<div class="input-group">
											<div class ="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>	
											{{Form::text('transfer_date','',array('class'=>'form-control','id'=>'txt_imp_date','data-provide'=> 'datepicker','required'=>'true'))}}
										</div><!--./input-group -->			
									</div><!--./form-group -->
								</div>
							</div>
							<hr />
							<div class="row">
								<div class="col-md-3" >
									<div class="form-group">	
										{{Form::label('lblCompanies','Công ty')}}
										{{Form::select('company_id',$companies,'1',array('class'=>'form-control','id'=>'select_company'))}}					
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">	
										{{Form::label('lblFarms','Nông trường chuyển')}}
										<select name= "feedlot_transfer_id" id="select_feedlot_transfer" class="form-control" data-parsley-checkdiff='#select_feedlot_received'></select>
									</div><!--./form-group -->								
								</div>	
								<div class="col-md-3">
									<div class="form-group">	
										{{Form::label('lblFarms','Nông trường nhận')}}
										<select name= "feedlot_recevied_id" id="select_feedlot_received" class="form-control" data-parsley-checkdiff='#select_feedlot_transfer'></select>
									</div><!--./form-group -->								
								</div>	
							</div><!--./end-rows -->
							<hr />
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblmalebeef','Số lượng bò đực thịt')}}
										<input type="hidden" id="hide_feedersteer_qty" name="old_feedersteer_quantity">
										{{Form::text('feedersteer_quantity','0',array('class'=>'form-control','id'=>'txt_feedersteer_qty','data-parsley-required'=>'true'))}}
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblfemalebeef','Số lượng bò cái thịt')}}
										<input type="hidden" id="hide_feederheifer_qty" name="old_feederheifer_quantity">
										{{Form::text('feederheifer_quantity','0',array('class'=>'form-control','id'=>'txt_feederheifer_qty','data-parsley-required'=>'true'))}}
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblsteer','Số lượng bò đực giống')}}
										<input type="hidden" id="hide_breederbull_qty" name="old_breederbull_quantity">
										{{Form::text('breederbull_quantity','0',array('class'=>'form-control','id'=>'txt_breederbull_qty','data-parsley-required'=>'true'))}}
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblheifer','Số lượng bò cái giống')}}
										<input type="hidden" id="hide_breederheifer_qty" name="old_breederheifer_quantity">
										{{Form::text('breederheifer_quantity','0',array('class'=>'form-control','id'=>'txt_breederheifer_qty','data-parsley-required'=>'true'))}}
									</div><!--./form-group -->	
								</div>
								
							</div><!--./end-rows -->																	
						</div><!--./box-body -->
						<div class="box-footer">
							{{Form::submit('Xác nhận',array('class'=>'btn btn-primary'))}}
							{{Form::close()}}
						</div>
					</div><!-- ./outer-box -->	
					
				</div>
			</div>
			<div class="col-md-12">
				<!-- list cow import box -->
				<div class="box" >
					<div class="box-header">
						<h3 class="box-title">Danh sách luân chuyển lô</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="import_table" class="display" cellspacing="0" width="100%">
							<thead>
								<tr >
			                        <th>#</th>
			                        <th>Lô chuyển</th>
			                        <th>Công ty</th>
			                        <th>Nông trường chuyển</th>
			                        <th>Nông trường nhận</th>
			                        <th>Ngày luân chuyển</th>
			                        <th>Bò đực thịt</th>
			                        <th>Bò cái thịt</th>
			                        <th>Bò đực giống</th>
			                        <th>Bò cái giống</th>
			                        <th>Sửa</th>
			                        <th>Xóa</th>
		                      </tr>
							</thead>
							<tbody>
								@if($feedlotTransfer)
									@foreach($feedlotTransfer as $transfer)
										<tr>
											<td>{{$transfer->id}}</td>
											<td>{{$transfer->name}}</td>
											<td>{{$transfer->companyFeedlotSrc->company->name}}</td>
											<td>{{$transfer->companyFeedlotSrc->feedlot->name}}</td>
											<td>{{$transfer->companyFeedlotDes->feedlot->name}}</td>
											<td>{{date('m/d/Y',strtotime($transfer->date_left_feedlot))}}</td>
											<td>{{$transfer->feeder_steer_quantity}}</td>
											<td>{{$transfer->feeder_heifer_quantity}}</td>
											<td>{{$transfer->breeder_bull_quantity}}</td>
											<td>{{$transfer->breeder_heifer_quantity}}</td>
											<td>--</td>
											<td>--</td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div>
		</div>

	</section>
</div>
@stop
@section('data_code')
	<!-- parsley -->
    {{HTML::script("public/plugins/parsley/parsley.min.js")}}
    <!-- parsley language-->
    {{HTML::script("public/plugins/parsley/i18n/vi.js")}}	
    <!-- Jquery Input mask version 3.0-->
    {{HTML::script("public/plugins/input-mask/jquery.inputmask.js")}}	    
    {{HTML::script("public/plugins/input-mask/jquery.inputmask.numeric.extensions.js")}}	

    {{HTML::script("public/plugins/input-mask/jquery.inputmask.date.extensions.js")}}	
<script type="text/javascript">
	$('document').ready(function(){
		$("#add_form").parsley();

		$.extend($.inputmask.defaults, {
		    'removeMaskOnSubmit' : true
		});
		$("#txt_total_weight").inputmask(
			"integer",
			{ autoGroup: true, groupSeparator: ",", groupSize: 3 }
		);
		$("#txt_feedersteer_qty").inputmask(
			"integer",
			{ autoGroup: true, groupSeparator: ",", groupSize: 3 }
		);
		$("#txt_feederheifer_qty").inputmask(
			"integer",
			{ autoGroup: true, groupSeparator: ",", groupSize: 3 }
		);
		$("#txt_breederbull_qty").inputmask(
			"integer",
			{ autoGroup: true, groupSeparator: ",", groupSize: 3 }
		);
		$("#txt_breederheifer_qty").inputmask(
			"integer",
			{ autoGroup: true, groupSeparator: ",", groupSize: 3 }
		);
		window.ParsleyValidator.addValidator('checkdiff',function(value,requirement){
			
			var idCheck = requirement + " option:selected";
			var transferFeedlotId = $(idCheck).val();
			if(value == transferFeedlotId){
				return false;
			}
			return true;
		},32)
		.addMessage('en', 'checkdiff', 'Nông trường không được giống nhau !')
		.addMessage('fr', 'checkdiff', 'Cette valeur doit être un multiple de %s');

		var table = $('#import_table').DataTable({			
          "language" : {
          	"zeroRecords": "Không tìm thấy giá trị",
          }
        });

        var companyId = $("#select_company option:selected").val();
        
        showFeedlotsByCompany(companyId);
        var feedlotTransferId = $("#select_feedlot_transfer").val(); 

        showFeedlotByCompanyQuantity(companyId,feedlotTransferId);
        
        $("#select_company").on('change',function(){
        	var companyId = $(this).val();        	
        	showFeedlotsByCompany(companyId);
        	var feedlotId = $('#select_feedlot_transfer').val();
        	showFeedlotByCompanyQuantity(companyId,feedlotId);
        	/*console.log(companyId);
        	console.log(feedlotId);*/
        })
        $('#select_feedlot_transfer').on('change',function(){
        	var feedlotId = $(this).val();
        	var companyId = $("#select_company").val();        	
        	/*console.log(companyId);
        	console.log(feedlotId);*/
        	showFeedlotByCompanyQuantity(companyId,feedlotId);
        })


	});
	
	function showFeedlotsByCompany(id){
		var feedlotsByCompany = {{json_encode($feedlotByCompanyLists)}}
		$("#select_feedlot_received").html("");
		$("#select_feedlot_transfer").html("");
		var optionHtml = "";
		$.each(feedlotsByCompany[id],function(key,value){
			optionHtml = "<option value='" + key + "'>" + value + "</option>";
    		$("#select_feedlot_transfer").append(optionHtml);
    		$("#select_feedlot_received").append(optionHtml);
    	});  
	}

	function showFeedlotByCompanyQuantity(companyId,feedlotId){
		var feedlotCompanyQuantity = {{json_encode($feedlotCompanyQuantity)}};
		var result = feedlotCompanyQuantity[companyId][feedlotId];
	/*	console.log(result);*/
		$('#txt_feedersteer_qty').val(result.feedersteer);
		$('#txt_feederheifer_qty').val(result.feederheifer);
		$('#txt_breederbull_qty').val(result.breederbull);
		$('#txt_breederheifer_qty').val(result.breederheifer);
	}

	// Ham hien thi box function tung chuc nang
	function showBoxFunc(boxFuncId){
		$idBoxFunc = $("#"+ boxFuncId);
		if($idBoxFunc.is(":hidden")){
			$idBoxFunc.fadeIn("fast");
		}else{
			$idBoxFunc.fadeOut("fast");
		}
	}

</script>
@stop