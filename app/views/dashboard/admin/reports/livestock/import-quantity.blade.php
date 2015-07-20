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
						{{Form::open(array('route'=>array('admin_report_import_quantity_add_post'),'id'=>'add_form'))}}	
						<div class="box-body">											
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">								
										{{Form::label('lblContract','Tên lô')}}
										{{Form::text('batch_name','',array('class'=>'form-control'))}}								
									</div><!--./form-group -->
								</div>
								<div class="col-md-3">
									<div class="form-group">								
										{{Form::label('lblContract','Tên hợp đồng')}}
										{{Form::select('contract_id',$contracts,'',array('class'=>'form-control','id'=>'select_contract'))}}					
									</div><!--./form-group -->
								</div>
								
								<div class="col-md-3">
									<div class="form-group">								
										{{Form::label('lblContract','Nhà cung cấp')}}
										<input type="hidden" name="partner_id" id="txt_partner_id"></input>
										{{Form::text('partner_name','',array('class'=>'form-control','id'=>'txt_partner','disabled'))}}					
									</div><!--./form-group -->
								</div>

								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('lbldate','Ngày nhập bò về cảng')}}
										<div class="input-group">
											<div class ="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>	
											{{Form::text('import_date','',array('class'=>'form-control','id'=>'txt_imp_date','data-provide'=> 'datepicker','required'=>'true'))}}
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
										{{Form::label('lblFarms','Nông trường dự kiến nhận')}}
										<select name= "farm_id" id="select_farm" class="form-control"></select>
									</div><!--./form-group -->								
								</div>	
								<div class="col-md-3">
									<div class="form-group">
											{{Form::label('lblheifer','Tổng số cân thực tế (Kg)')}}
											<input type="hidden" id="hide_total_weight" name="old_total_weight">
											{{Form::text('real_total_weight','0',array('class'=>'form-control','id'=>'txt_total_weight','data-parsley-required'=>'true'))}}
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
						<h3 class="box-title">Danh sách các lô bò nhập</h3>										
					</div><!--./box-header -->
					<div class="box-body table-responsive">			
						<table id="import_table" class="display" cellspacing="0" width="100%">
							<thead>
								<tr >
			                        <th>#</th>
			                        <th>Hợp đồng</th>
			                        <th>Nông Trường</th>
			                        <th>Lô</th>
			                        <th>Nhập khẩu</th>
			                        <th>Ngày nhập</th>
			                        <th>Bò đực thịt</th>
			                        <th>Bò cái thịt</th>
			                        <th>Bò đực giống</th>
			                        <th>Bò cái giống</th>
			                        <th>Tổng cân (Kg)</th>
			                        <th>Sửa</th>
			                        <th>Xóa</th>
		                      </tr>
							</thead>
							<tbody>
								@foreach($importTable as $item)
									<tr id="{{'rows_'.$item->id}}">
										<td>{{$item->id}}</td>
										<td>{{$item->contract->name}}</td>
										<td>{{$farms[$item->farm_id]}}</td>
										<td>{{$item->batch_name}}</td>
										<td>{{$partners[$item->partner_id]}}</td>
										<td>{{date('m/d/Y',strtotime($item->import_date))}}</td>
										<td>{{number_format($item->feedersteer,0,',','.')}}</td>
										<td>{{number_format($item->feederheifer,0,',','.')}}</td>
										<td>{{number_format($item->breederbull,0,',','.')}}</td>
										<td>{{number_format($item->breederheifer,0,',','.')}}</td>	
										<td>{{number_format($item->real_total_weight,0,',','.')}}</td>										
										<td style="text-align:center" class="details-control"></td>
										<td style="text-align:center" class="delete-control"><a href="javascript:void(0)"><i class="fa fa-times"></i></a></td>
									</tr>
								@endforeach
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

		var table = $('#import_table').DataTable({			
          "language" : {
          	"zeroRecords": "Không tìm thấy giá trị",
          }
        });

        $('#import_table tbody').on('click','td.details-control',function(){
        	var tr = $(this).closest('tr');
        	var row = table.row(tr);        	     	      
        	if(row.child.isShown()){
        		row.child.hide();
		        tr.removeClass('shown');
        	}else{
        		row.child(format(row.data())).show();
        		$('#update_form').parsley();
		        tr.addClass('shown');
        	}
        })
        $('#import_table tbody').on('click','td.delete-control',function(){
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
        $('#select_contract').on('change',function(){
        	var contractID = $(this).val();
        	showDetailContractBy(contractID);
        })
        var _companyID = $("#select_company option:selected").val();
        showFarmsByCompany(_companyID);
        var _contractID = $("#select_contract option:selected").val();       
        showDetailContractBy(_contractID);
	});
	function showDetailContractBy(id){
		var partners = {{json_encode($partners)}}
		var contracts = {{json_encode($contractDetail)}}
		var companies = {{json_encode($companies)}}
		var partnerName = partners[contracts[id]['partner_id']];
		var importDate = new Date(contracts[id]['import_date']);
		var companyRecevied = contracts[id]['company_id'];
		var feedersteerQty = contracts[id]['feedersteer_quantity'];
		var feederheiferQty = contracts[id]['feederheifer_quantity'];
		var breederbullQty = contracts[id]['breederbull_quantity'];
		var breederheiferQty = contracts[id]['breederheifer_quantity'];
		var totalWeight = contracts[id]['feedersteer_quantity'] * contracts[id]['feedersteer_weight'] + contracts[id]['feederheifer_quantity'] * contracts[id]['feederheifer_weight'] + contracts[id]['breederbull_quantity'] * contracts[id]['breederbull_weight'] + contracts[id]['breederheifer_quantity'] * contracts[id]['breederheifer_weight'];

		
		$('#txt_partner').val(partnerName);
		$('#txt_imp_date').val(importDate.toLocaleDateString());

		$('#select_company').val(companyRecevied);
		$('#txt_partner_id').val(contracts[id]['partner_id']);

		$('#txt_feedersteer_qty').val(feedersteerQty);
		$('#hide_feedersteer_qty').val(feedersteerQty);

		$('#txt_feederheifer_qty').val(feederheiferQty);
		$('#hide_feederheifer_qty').val(feederheiferQty);
		
		$('#txt_breederbull_qty').val(breederbullQty);
		$('#hide_breederbull_qty').val(breederbullQty);
		
		$('#txt_breederheifer_qty').val(breederheiferQty);
		$('#hide_breederheifer_qty').val(breederheiferQty);
		
		$('#txt_total_weight').val(totalWeight);
		$('#hide_total_weight').val(totalWeight);
		
		

		showFarmsByCompany(companyRecevied);
	}
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
						'<input type="text" name="import_date" class="form-control" data-provide = "datepicker" value ="'+ data[4]+'" required></input>' +	
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