<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>{{$title}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    {{HTML::style("public/css/bootstrap/bootstrap.min.css")}}
    <!-- FontAwesome 4.3.0 -->
    {{HTML::style("public/css/font-awesome/font-awesome.min.css")}}
    <!-- Ionicons 2.0.3 -->
    <!-- {{HTML::style("public/plugins/ionicons/css/ionicons.min.css")}}  -->  
    <link href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />   
    <!-- Theme style -->
    {{HTML::style("public/css/adminlte/AdminLTE.min.css")}}
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    {{HTML::style("public/css/adminlte/skins/_all-skins.min.css")}}
    <!-- iCheck -->
    {{HTML::style("public/plugins/icheck/square/blue.css")}}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    @yield("stylehead")
  </head>
  <body class="skin-blue">
    <div class="wrapper">
      <!-- Main Header-->
      @include("layout.header")
      <!-- Left side column. contains the logo and sidebar -->
      @include("layout.sliderbar")
      <!-- Content Wrapper. Contains page content -->
      @yield("content")
      <!-- Footer content -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2014-2015 <a href="http://hagl.com.vn">HAGL IT Departement</a>.</strong> All rights reserved.
      </footer>
    </div><!-- ./wrapper -->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-63934470-1', 'auto');
	  ga('send', 'pageview');

	</script>
    <!-- jQuery 2.1.3 -->
    {{HTML::script("public/plugins/jQuery/jQuery-2.1.3.min.js")}}
    <!-- jQuery UI 1.11.4 -->
    {{HTML::script("public/plugins/jQueryUI/jquery-ui.min.js")}}
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.2 JS -->
    {{HTML::script("public/js/bootstrap/bootstrap.min.js")}}
    <!-- iCheck -->
    {{HTML::script("public/plugins/iCheck/icheck.min.js")}}
    <!-- Slimscroll -->
    {{HTML::script("public/plugins/slimScroll/jquery.slimscroll.min.js")}}
    <!-- FastClick -->
    {{HTML::script("public/plugins/fastclick/fastclick.min.js")}}
    
    {{HTML::script('public/plugins/bootstrap-datetimepicker/bootstrap-datepicker.min.js')}}
    {{HTML::script('public/plugins/bootstrap-datetimepicker/bootstrap-datepicker.vi.min.js')}}
    {{HTML::script('public/plugins/datatables/js/jquery.dataTables.min.js')}}
    {{HTML::script('public/plugins/datatables/js/dataTables.bootstrap.js')}}
    <!-- AdminLTE App -->
     {{HTML::script("public/js/adminlte/app.min.js")}}
    <!-- My java script -->
    {{HTML::script("public/js/adminlte/hoangec.js")}}
     <!--Cus js -->
    @yield("data_code")
  </body>
</html>