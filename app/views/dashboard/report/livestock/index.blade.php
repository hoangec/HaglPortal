@extends('layout.master')
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
          <h1>
            Báo cáo chăn nuôi bò thịt
            <small>Bảng điều khiển</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
            <li><a href="#">Báo cáo ngành</a></li>
            <li class="active">Chăn nuôi bò thịt</li>
          </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    	<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{number_format($data['totalRealQtyCountries'],0,',','.')}}</h3>
              <p>Đàn bò thực tế</p>
            </div>
            <div class="icon">
              <i class="ion-pie-graph"></i>
            </div>
            <a href="{{route('front_report_livestock_real_quantity_get')}}" class="small-box-footer"> Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{number_format($data['totalImportQtyCountries'],0,',','.')}}</h3>
              <p>Bò nhập nhà xuất khẩu</p>
            </div>
            <div class="icon">
              <i class="ion-arrow-down-a"></i>
            </div>
            <a href="{{URL::route('front_report_livestock_received_quantity_get')}}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{number_format($data['totalExportQtyCountries'],0,',','.')}}</h3>
              <p>Bò xuất lò mỗ</p>
            </div>
            <div class="icon">
              <i class="ion-arrow-up-a"></i>
            </div>
            <a href="{{route('front_report_livestock_cattle_for_sale_get')}}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{number_format($data['totalDeathQtyCountries'],0,',','.')}}</h3>
              <p>Bò chết</p>
            </div>
            <div class="icon">
              <i class="ion-arrow-graph-up-right"></i>
            </div>
            <a href="{{route('front_report_livestock_mortality_quantity_get')}}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div><!-- ./col -->
      	<div class = "col-xs-6 col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                      <h3 class="box-title">Sơ đồ phân bổ quốc gia</h3>
                    </div>
                    <div class="box-body chart-responsive" id="country_geo_chart" style="height:600px;" >
                     
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
        </div>
        <div class = "col-xs-6 col-md-6">
          <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Số liệu từng trang trại</h3>
              </div>
              <div class="box-body chart-responsive" id="country_geo_table" style="height:600px;">              
                </div>
          </div><!-- /.box-body -->country_geo_table
        </div><!-- /.box -->
        </div>
    	</div>
    </section>

</div>
@stop
@section('data_code')
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', { 'packages': ['map','table'] });
      google.setOnLoadCallback(drawMap);
	  
	  $(window).resize(function(){
		drawMap();
	  }); 
    function drawMap() {
          var data1 = google.visualization.arrayToDataTable([
            ['Lat','Lon','Name','Hiện tại','Bán','Chết'],
            [14.033148,108.279598,'Đắk Ya','1000','1000','1000'],
            [14.024199,108.699073,'An Khê','2000','1000','1000'],
            [13.865643,108.265457,'Kon Thụp','3000','1000','1000'],
            [13.887401, 108.015978,'Hàm Rồng','3000','1000','1000'],
            [14.821295, 106.820884,'Attapeu','3000','1000','1000']
           
          ]);

          var feedlots = {{json_encode($data['feedlots'])}}
          console.log(feedlots);
          if(!jQuery.isEmptyObject(feedlots)){
            var geoData = new google.visualization.DataTable();
            geoData.addColumn('number','Lat');
            geoData.addColumn('number','Lon');
            geoData.addColumn('string','Khu vực');
            geoData.addColumn('number','Thực tế');
            geoData.addColumn('number','Nhập nhà xuất khẩu');
            geoData.addColumn('number','Xuất lò mỗ');
            geoData.addColumn('number','Chết');
            $.each(feedlots,function(key,feedlot){
              var realQtyJson = JSON.parse(feedlot.real_quantity);
              var realQty = realQtyJson.feedersteer + realQtyJson.feederheifer + realQtyJson.breederbull + realQtyJson.breederheifer;
              //
              var receivedQtyJson = JSON.parse(feedlot.received_quantity);
              var receviedQty = receivedQtyJson.feedersteer + receivedQtyJson.feederheifer + receivedQtyJson.breederbull + receivedQtyJson.breederheifer;
              //          
              var saleQtyJson = JSON.parse(feedlot.sale_quantity);
              var saleQty = saleQtyJson.feedersteer + saleQtyJson.feederheifer + saleQtyJson.breederbull + saleQtyJson.breederheifer;
              //
              var mortalityQtyJson = JSON.parse(feedlot.mortality_quantity);
              var mortalityQty = mortalityQtyJson.feedersteer + mortalityQtyJson.feederheifer + mortalityQtyJson.breederbull + mortalityQtyJson.breederheifer;
              //
              geoData.addRows([
                [
                  {v:feedlot.lat},
                  {v:feedlot.lon},
                  feedlot.name,
                  {v:realQty,f:numberWithCommans(realQty)},
                  {v:receviedQty,f:numberWithCommans(receviedQty)},
                  {v:saleQty,f:numberWithCommans(saleQty)},
                  {v:mortalityQty,f:numberWithCommans(mortalityQty)},
                ],
              ]);
            });

          }

          var geoViewMap = new google.visualization.DataView(geoData);
          geoViewMap.setColumns([0,1,2]);

          var geoViewTable = new google.visualization.DataView(geoData);
          geoViewTable.setColumns([2,3,4,5,6]);

          var table = new google.visualization.Table(document.getElementById('country_geo_table'));
          table.draw(geoViewTable, {showRowNumber: false});

          var map = new google.visualization.Map(document.getElementById('country_geo_chart'));
          map.draw(geoViewMap, {showTip: true});

          // Set a 'select' event listener for the table.
          // When the table is selected, we set the selection on the map.
          google.visualization.events.addListener(table, 'select',
              function() {
                map.setSelection(table.getSelection());
              });

          // Set a 'select' event listener for the map.
          // When the map is selected, we set the selection on the table.
          google.visualization.events.addListener(map, 'select',
              function() {
                table.setSelection(map.getSelection());
          });
      };
    </script>
@stop