<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
<title>HAGL Portal - Trang không tồn tại</title>
{{ HTML::style('public/css/errorpages/style.css') }}
{{ HTML::style('public/css/errorpages/custom.css') }}

</head>
<body>
<!-- Section -->
<section>

<div class="error_main">
    <div class="error_detail_1"><img src="{{asset('public/img/errorpages/hagl-group-logo.png')}}" alt=""/></div>
	<div class="error_detail_1">Oops !</div>
    <div class="error_detail_1">Trang yêu cầu không tồn tại. </div>
    <div class="error_detail_3">
    	<div class="error_detail_3_inner">
        	<p>Không tìm thấy đường dẫn này.</p>            
        </div>
        
    </div>
    <div class="error_detail_4"><a href="{{URL::route('front_report_livestock_index_get')}}">Truy cập vào trang chủ ?</a></div>
</div>

</section>
  
</body>
</html>
