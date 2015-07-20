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
	    <small>Hợp đồng nhập bò</small>
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
				<div class="box box-danger" >
					<div class="box-header with-border">
						<h3 class="box-title">Chức năng</h3>										
						<br />
						<div class="box-application" style="margin-top:10px">
						 	<a class="btn btn-app" href="javascript:void(0)" onclick="showBoxFunc('box-contract-add')">
	                    		<i class="fa fa-edit"></i> Tạo hơp đồng nhập bò
	                 		</a>
						</div><!-- ./box-application -->
					</div><!--./box-header -->	
					<!--box-outer contract add function -->
					<div class="box-outer" id="box-contract-add" style="display:none">
						<!--Form start -->					
						{{Form::open(array('route'=>array('admin_report_import_contract_add_post'),'data-parsley-validate'))}}	
						<div class="box-body">											
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">								
										{{Form::label('lblContract','Tên hợp đồng')}}
										{{Form::text('imp_contract_name','',array('class'=>'form-control','required'=>'true'))}}					
									</div><!--./form-group -->
								</div>
								<div class="col-md-3" >
									<div class="form-group">								
											{{Form::label('lblImporter','Tên nhà nhập khẩu')}}
											{{Form::select('partner_id',$partners,'',array('class'=>'form-control'))}}													
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lbldate','Ngày nhập bò về cảng')}}
										<div class="input-group">
											<div class ="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>	
											{{Form::text('import_date','',array('class'=>'form-control','data-provide'=> 'datepicker','required'=>'true'))}}
										</div><!--./input-group -->			
									</div><!--./form-group -->
								</div>
								<div class="col-md-3" >
									<div class="form-group">	
										{{Form::label('lblPorts','Cảng nhập')}}
										{{Form::select('port_id',$ports,'',array('class'=>'form-control'))}}					
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
										{{Form::label('lblFarms','Nông trường dự kiến nhận')}}
										<select name= "farm_id" id="select_farm" class="form-control"></select>	
									</div><!--./form-group -->								
								</div>	
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblStatus','Ngày mở LC')}}
										<div class="input-group">
											<div class ="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>	
											{{Form::text('lc_open_last_date','',array('class'=>'form-control','data-provide'=> 'datepicker','required'=>'true'))}}
										</div><!--./input-group -->	
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblStatusText','Tình trạng hợp đồng')}}
										{{Form::text('imp_status_text','',array('class'=>'form-control','data-parsley-required'=>'true'))}}
									</div><!--./form-group -->
								</div>	
								
							</div><!--./end-rows -->
							<hr />
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblmalebeef','Số lượng bò đực thịt')}}
										{{Form::text('feedersteer_quantity','0',array('class'=>'form-control','id'=>'txt_feedersteer_qty','data-parsley-required'=>'true'))}}
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblfemalebeef','Số lượng bò cái thịt')}}
										{{Form::text('feederheifer_quantity','0',array('class'=>'form-control','id'=>'txt_feederheifer_qty','data-parsley-required'=>'true'))}}
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblsteer','Số lượng bò đực giống')}}
										{{Form::text('breederbull_quantity','0',array('class'=>'form-control','id'=>'txt_breederbull_qty','data-parsley-required'=>'true'))}}
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
											{{Form::label('lblheifer','Số lượng bò cái giống')}}
											{{Form::text('breederheifer_quantity','0',array('class'=>'form-control','id'=>'txt_breederheifer_qty','required'=>'true'))}}
									</div><!--./form-group -->	
								</div>
							</div><!--./end-rows -->
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblmalebeef','Trọng lượng bò đực thịt')}}
										{{Form::text('feedersteer_weight','0',array('class'=>'form-control','id'=>'txt_feedersteer_weight','data-parsley-required'=>'true'))}}
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblfemalebeef','Trọng lượng bò cái thịt')}}
										{{Form::text('feederheifer_weight','0',array('class'=>'form-control','data-parsley-required'=>'true','id'=>'txt_feederheifer_weight'))}}
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblsteer','Trọng lượng bò đực giống')}}
										{{Form::text('breederbull_weight','0',array('class'=>'form-control','data-parsley-required'=>'true','id'=>'txt_breederbull_weight'))}}
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
											{{Form::label('lblheifer','Trọng lượng bò cái giống')}}
											{{Form::text('breederheifer_weight','0',array('class'=>'form-control','required'=>'true','id'=>'txt_breederheifer_weight'))}}
									</div><!--./form-group -->	
								</div>								
							</div><!--./end-rows -->
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblmalebeef','Đơn giá bò đực thịt (Kg/con)')}}
										{{Form::text('feedersteer_price','0',array('class'=>'form-control','data-parsley-required'=>'true','id'=>'txt_feedersteer_price'))}}
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblfemalebeef','Đơn giá bò cái thịt (Kg/con)')}}
										{{Form::text('feederheifer_price','0',array('class'=>'form-control','data-parsley-required'=>'true','id'=>'txt_feederheifer_price'))}}
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lblsteer','Đơn giá bò đực giống (Kg/con)')}}
										{{Form::text('breederbull_price','0',array('class'=>'form-control','data-parsley-required'=>'true','id'=>'txt_breederbull_price'))}}
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">
											{{Form::label('lblheifer','Đơn giá bò cái giống (Kg/con)')}}
											{{Form::text('breederheifer_price','0',array('class'=>'form-control','required'=>'true','id'=> 'txt_breederheifer_price'))}}
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
			</div><!--./ Function Form-->
			<div class="col-md-12">
				<!-- list cow import box -->
				<div class="box box-primary" >
					<div class="box-header">
						<h3 class="box-title">Danh sách các hợp đồng đang chờ nhập</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="contract_table_not_finished" class="display" cellspacing="0" width="100%">
							<thead>
								<tr >			
									<th>#</th>                 
			                        <th>Tên</th>			                        
			                        <th>Công ty</th>
			                        <th>Đối tác</th>
			                        <th>Ngày đến</th>
			                        <th>Ngày mở LC</th>                        			                        
			                        <th>Cảng nhập</th>
			                       	<th>Số lượng </th>
			                        <th>Trọng lượng (Kg)</th>
			                        <th>Giá trị (USD)</th>
			                        <th>Tình trạng</th>
			                        <th>Sửa</th>
			                        <th>Xóa</th>
		                      </tr>
							</thead>
							<tbody>
								@if(!empty($contracts['contractNotFinished']))
									@foreach($contracts['contractNotFinished'] as $contract)
										<tr id="{{'rows_'.$contract->id}}">		
											<td>{{$contract->id}}</td>							
											<td>{{$contract->name}}</td>
											<td>{{$companies[$contract->company_id]}}</td>
											<td>{{$partners[$contract->partner_id]}}</td>
											<td>{{date('m/d/Y',strtotime($contract->import_date))}}</td>
											<td>{{date('m/d/Y',strtotime($contract->lc_open_last_date))}}</td>						
											<td>{{$ports[$contract->port_id]}}</td>
											<td>{{number_format($contract['sumQty'],0,'.',',')}}</td>
											<td>{{number_format($contract['sumWeight'],0,'.',',')}}</td>								
											<td>{{number_format($contract['sumPrice'],2,'.',',')}}</td>								
											<td>{{$contract->imp_status_text}}</td>					
											<td style="text-align:center" class="details-control"></td>
											<td style="text-align:center" class="delete-control"><a href="javascript:void(0)"><i class="fa fa-times"></i></a></td>
										</tr>
									@endforeach
								@endif
							</tbody>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div><!-- ./contract table  not yet finished -->
			<div class="col-md-12">
				<!-- list cow import box -->
				<div class="box box-success" >
					<div class="box-header">
						<h3 class="box-title">Danh sách các hợp đồng đã hoàn thành</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="contract_table_has_finished" class="display" cellspacing="0" width="100%">
							<thead>
								<tr >
			                 
			                        <th>Tên</th>
			                        <th>Công ty</th>
			                        <th>Đối tác</th>
			                        <th>Ngày đến</th>
			                        <th>Hạn chót mở LC</th>                        			                        
			                        <th>Cảng nhập</th>
			                       	<th>Số lượng </th>
			                        <th>Trọng lượng (Kg)</th>
			                        <th>Giá trị (USD)</th>
			                        <th>Ghi chú</th>
		                      </tr>
							</thead>
							<tbody>
								@if(!empty($contracts['contractHasFinished']))
									@foreach($contracts['contractHasFinished'] as $contract)
										<tr id="{{'rows_'.$contract->id}}">									
											<td>{{$contract->name}}</td>
											<td>{{$companies[$contract->company_id]}}</td>
											<td>{{$partners[$contract->partner_id]}}</td>
											<td>{{date('m/d/Y',strtotime($contract->import_date))}}</td>
											<td>{{date('m/d/Y',strtotime($contract->lc_open_last_date))}}</td>																
											<td>{{$ports[$contract->port_id]}}</td>
											<td>{{number_format($contract['sumQty'],0,'.',',')}}</td>
											<td>{{number_format($contract['sumWeight'],0,'.',',')}}</td>								
											<td>{{number_format($contract['sumPrice'],2,'.',',')}}</td>									
											<td>{{$contract->imp_status_text}}</td>					
										</tr>
									@endforeach
								@endif								
							</tbody>
						</table>
					</div><!--./box-body -->
				</div><!--./box -->
			</div><!-- ./contract table has finished -->
		</div>

	</section>
</div>
@stop
@section('data_code')
	<!-- parsley -->
    {{HTML::script("public/plugins/parsley/parsley.min.js")}}
    <!-- Ngon ngu viet cho parsley-->
    {{HTML::script("public/plugins/parsley/i18n/vi.js")}}
     <!-- Jquery Input mask version 3.0-->
    {{HTML::script("public/plugins/input-mask/jquery.inputmask.js")}}	    
    {{HTML::script("public/plugins/input-mask/jquery.inputmask.numeric.extensions.js")}}	
<script type="text/javascript">
	$('document').ready(function(){
		/*Input mask setup*/
		$.extend($.inputmask.defaults, {
		    'removeMaskOnSubmit' : true
		});
		$("#txt_feedersteer_qty, #txt_feedersteer_weight").inputmask(
			"integer",
			{ autoGroup: true, groupSeparator: ",", groupSize: 3 }
		);
		$("#txt_feederheifer_qty, #txt_feederheifer_weight").inputmask(
			"integer",
			{ autoGroup: true, groupSeparator: ",", groupSize: 3 }
		);
		$("#txt_breederbull_qty, #txt_breederbull_weight").inputmask(
			"integer",
			{ autoGroup: true, groupSeparator: ",", groupSize: 3 }
		);
		$("#txt_breederheifer_qty, #txt_breederheifer_weight").inputmask(
			"integer",
			{ autoGroup: true, groupSeparator: ",", groupSize: 3 }
		);
		//
		$("#txt_feedersteer_price").inputmask(
			"decimal",
			{ autoGroup: true, groupSeparator: ",", groupSize: 3 }
		);
		$("#txt_feederheifer_price").inputmask(
			"decimal",
			{ autoGroup: true, groupSeparator: ",", groupSize: 3 }
		);
		$("#txt_breederbull_price").inputmask(
			"decimal",
			{ autoGroup: true, groupSeparator: ",", groupSize: 3 }
		);
		$("#txt_breederheifer_price").inputmask(
			"decimal",
			{ autoGroup: true, groupSeparator: ",", groupSize: 3 }
		);
		/*dataTables config for 2 contract table ( notFinished & hasFinished) */
		var contractTableNotFinished = $('#contract_table_not_finished').DataTable({});
		var contractTableHasFinished = $('#contract_table_has_finished').DataTable({});
       /* Update action on notFinished contract tables*/
        $('#contract_table_not_finished tbody').on('click','td.details-control',function(){
        	var tr = $(this).closest('tr');
        	var row = contractTableNotFinished.row(tr);        	     	      
        	if(row.child.isShown()){
        		row.child.hide();
		        tr.removeClass('shown');
        	}else{
        		row.child(format(row.data())).show();
        		$('#update_form').parsley();
		        tr.addClass('shown');
        	}
        })
        /* Delete action on notFinished contract tables*/
        $('#contract_table_not_finished tbody').on('click','td.delete-control',function(){
        	var tr = $(this).closest('tr');
        	var row = table.row(tr);        	
        	$.get("{{URL::to("dashboard/admin/reports/beef/importquantity/delete")}}/"+ row.data()[0],function(data){
        		if(data = true){
        			row.remove().draw();	
        			alert("Đã xóa thành công");
        		}				
			}).fail(function(data){
				console.log(data.responseText);
			});        	
        })
        //

        var farmsByCompany = {{json_encode($farmsByCompany)}}

        $("#select_company").on('change',function(){
        	var companyID = $(this).val();
        	showFarmsByCompany(companyID);
        })
        var _companyID = $("#select_company option:selected").val()
        showFarmsByCompany(_companyID);
	});

	function showFarmsByCompany(id){
		var farmsByCompany = {{json_encode($farmsByCompany)}}
		$("#select_farm").html("");
		$.each(farmsByCompany[id],function(key,value){
    		var optionHtml = "<option value='" + key + "'>" + value + "</option>";
    		$("#select_farm").append(optionHtml);
    	});        

	}
	function deleteImport(id){
		$.get("{{URL::to("dashboard/admin/reports/beef/importquantity/delete")}}/"+id,function(data){			
			console.log("#rows_"+id);
			$("#rows_"+id).remove();			
		}).fail(function(data){
			console.log(data.responseText);
		});
	}
	function format(data){
		var farmsJson = {{json_encode($farms)}};
		var str = '';
		str = '{{Form::open(array("route"=>array("admin_report_import_quantity_update_post"),"id"=>"update_form"))}}'+
		'<div class="row">' + 		
			'<div class="col-xs-4 col-md-4">'+
				'<div class="form-group">'+
					'{{Form::label("lbldate","Ngày nhập")}} '+
					'<div class="input-group">'+
						'<div class ="input-group-addon">'+
							'<i class="fa fa-calendar"></i>'+
						'</div>'+
						'<input type="text" name="lc_open_last_date" class="form-control" data-provide = "datepicker" value ="'+ data[4]+'" required></input>' +	
					'</div>' +
				'</div>'+
			'</div>'+
		'</div>' +
		'<hr />' + 
		'<div class="row">'+
			'<div class="col-xs-3 col-md-3">'+
				'<div class="form-group">'+
					'{{Form::label("lblmalebeef","Số lượng bò đực thịt")}}' +
					'<input type="hidden" name="feedersteer_quantity_hide" value="' + data[5] + '"></input>' + 
					'<input type="text" name="feedersteer_quantity"value="' + data[5] + '"class="form-control" required data-parsley-type="digits"	min="1"></input>' + 					
				'</div>'+
			'</div>'+
			'<div class="col-xs-3 col-md-3">' + 
				'<div class="form-group">'+
					'{{Form::label("lblfemalebeef","Số lượng bò cái thịt")}}'+
					'<input type="hidden" name="feederheifer_quantity_hide" value="' + data[6] + '"></input>' + 
					'<input type="text" name="feederheifer_quantity" value="' + data[6] + '"class="form-control" required data-parsley-type="digits"	min="1"></input>' + 
				'</div>'+
			'</div>'+
			'<div class=" col-xs-3 col-md-3">'+
				'<div class="form-group">'+
					'{{Form::label("lblsteer","Số lượng bò đực giống")}}'+
					'<input type="hidden" name="breederbull_quantity_hide" value="' + data[7] + '"></input>' + 
					'<input type="text" name= "breederbull_quantity" value="' + data[7] + '" class="form-control" required data-parsley-type="digits"	min="1"></input>' + 
				'</div>'+
			'</div>'+
			'<div class="col-xs-3 col-md-3">'+
				'<div class="form-group">'+
					'{{Form::label("lblheifer","Số lượng bò cái giống")}}'+
					'<input type="hidden" name="breederheifer_quantity_hide" value="' + data[8] + '"></input>' + 
					'<input type="text" name="breederheifer_quantity" value="' + data[8] + '"class="form-control" required data-parsley-type="digits"	min="1"></input>' + 
				'</div>'+
			'</div>'+
			'<div class="col-xs-3 col-md-3">'+
				'<div class="form-group">'+
					'{{Form::label("lblmalebeef","Trọng lượng bò đực thịt")}}' +
					'<input type="hidden" name="feedersteer_quantity_hide" value="' + data[5] + '"></input>' + 
					'<input type="text" name="feedersteer_quantity"value="' + data[5] + '"class="form-control" required data-parsley-type="digits"	min="1"></input>' + 					
				'</div>'+
			'</div>'+
			'<div class="col-xs-3 col-md-3">' + 
				'<div class="form-group">'+
					'{{Form::label("lblfemalebeef","Trọng lượng bò cái thịt")}}'+
					'<input type="hidden" name="feederheifer_quantity_hide" value="' + data[6] + '"></input>' + 
					'<input type="text" name="feederheifer_quantity" value="' + data[6] + '"class="form-control" required data-parsley-type="digits"	min="1"></input>' + 
				'</div>'+
			'</div>'+
			'<div class=" col-xs-3 col-md-3">'+
				'<div class="form-group">'+
					'{{Form::label("lblsteer","Trọng lượng bò đực giống")}}'+
					'<input type="hidden" name="breederbull_quantity_hide" value="' + data[7] + '"></input>' + 
					'<input type="text" name= "breederbull_quantity" value="' + data[7] + '" class="form-control" required data-parsley-type="digits"	min="1"></input>' + 
				'</div>'+
			'</div>'+
			'<div class="col-xs-3 col-md-3">'+
				'<div class="form-group">'+
					'{{Form::label("lblheifer","Trọng lượng bò cái giống")}}'+
					'<input type="hidden" name="breederheifer_quantity_hide" value="' + data[8] + '"></input>' + 
					'<input type="text" name="breederheifer_quantity" value="' + data[8] + '"class="form-control" required data-parsley-type="digits"	min="1"></input>' + 
				'</div>'+
			'</div>'+
			'<div class="col-xs-3 col-md-3">'+
				'<div class="form-group">'+
					'{{Form::label("lblmalebeef","Đơn giá bò đực thịt (Kg/con)")}}' +
					'<input type="hidden" name="feedersteer_quantity_hide" value="' + data[5] + '"></input>' + 
					'<input type="text" name="feedersteer_quantity"value="' + data[5] + '"class="form-control" required data-parsley-type="digits"	min="1"></input>' + 					
				'</div>'+
			'</div>'+
			'<div class="col-xs-3 col-md-3">' + 
				'<div class="form-group">'+
					'{{Form::label("lblfemalebeef","Đơn giá bò cái thịt (Kg/con)")}}'+
					'<input type="hidden" name="feederheifer_quantity_hide" value="' + data[6] + '"></input>' + 
					'<input type="text" name="feederheifer_quantity" value="' + data[6] + '"class="form-control" required data-parsley-type="digits"	min="1"></input>' + 
				'</div>'+
			'</div>'+
			'<div class=" col-xs-3 col-md-3">'+
				'<div class="form-group">'+
					'{{Form::label("lblsteer","Đơn giá bò đực giống (Kg/con)")}}'+
					'<input type="hidden" name="breederbull_quantity_hide" value="' + data[7] + '"></input>' + 
					'<input type="text" name= "breederbull_quantity" value="' + data[7] + '" class="form-control" required data-parsley-type="digits"	min="1"></input>' + 
				'</div>'+
			'</div>'+
			'<div class="col-xs-3 col-md-3">'+
				'<div class="form-group">'+
					'{{Form::label("lblheifer","Đơn giá bò cái giống (Kg/con)")}}'+
					'<input type="hidden" name="breederheifer_quantity_hide" value="' + data[8] + '"></input>' + 
					'<input type="text" name="breederheifer_quantity" value="' + data[8] + '"class="form-control" required data-parsley-type="digits"	min="1"></input>' + 
				'</div>'+
			'</div>'+
		'</div>'+
		'<hr />' +
		'{{Form::submit("Xác nhận",array("class"=>"btn btn-primary"))}}' +
		'{{Form::close()}}';

		return str;
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