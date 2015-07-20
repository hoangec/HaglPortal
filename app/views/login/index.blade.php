<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>HAGL Portal Login</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
     {{HTML::style("public/css/bootstrap/bootstrap.min.css")}}
    <!-- Font Awesome Icons -->
    {{HTML::style("public/css/font-awesome/font-awesome.min.css")}}
    <!-- Theme style -->
    {{HTML::style("public/css/adminlte/AdminLTE.min.css")}}
    <!-- iCheck -->
    {{HTML::style("public/plugins/icheck/square/blue.css")}}
    <!-- Parsley -->
    {{HTML::style("public/plugins/parsley/parsley.css")}}
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="javascript:void(0)"><b style="color:green">HAGL</b><span style="color:orange">Portal<span></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Đăng nhập vào hệ thống</p>
        {{Form::open(array("route"=>"login_post","data-parsley-validate"))}}
          <div class="form-group has-feedback">
            {{Form::text("emailLogin","",array("class"=>"form-control","placeholder"=>"Email","data-parsley-required"=>"True","data-parsley-type"=>"email"))}}
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            {{Form::password("passLogin",array("class"=>"form-control","placeholder"=>"Password","data-parsley-required"=>"True"))}}
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
                <label>
                  {{Form::checkbox("rememCheck")}} Ghi nhớ
                </label>
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              {{Form::submit("Đăng nhập",array("class"=>"btn btn-primary btn-block btn-flat"))}}   
            </div><!-- /.col -->
          </div>
        {{Form::close()}}
        <a href="#">Quên mật khẩu</a><br>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.3 -->
    {{HTML::script("public/plugins/jQuery/jQuery-2.1.3.min.js")}}
    <!-- Bootstrap 3.3.2 JS -->
    {{HTML::script("public/js/bootstrap/bootstrap.min.js")}}
    <!-- iCheck -->
    {{HTML::script("public/plugins/iCheck/icheck.min.js")}}
    <!-- parsley -->
    {{HTML::script("public/plugins/parsley/parsley.min.js")}}
    <!-- Ngon ngu viet cho parsley-->
    {{HTML::script("public/plugins/parsley/i18n/vi.js")}}
    <!-- Notify-->
    {{HTML::script("public/plugins/bootstrap-notify/bootstrap-notify.min.js")}}
    <script type="text/javascript">
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
      // Xuat thong báo trả về
    </script>
    @if(Session::get("message") == "error101")
      {{Session::flush();}}
      <script type="text/javascript">
        $.notify({
          message:"Mật khẩu đăng nhập không đúng"
        },{
          type:"error",
          placement: {
            from: "top",
            align: "center"
          },
        })
      </script>
    @elseif(Session::get("message") == "error102")
      {{Session::flush();}}
      <script type="text/javascript">
        $.notify({
          message:"Tài khoản đăng nhập không tồn tại"
        },{
          type:"error",
          placement: {
            from: "top",
            align: "center"
          },
        })
      </script>
    @elseif(Session::get("message") == "error103")
    {{Session::flush();}}
    <script type="text/javascript">
      $.notify({
        message:"Tài khoản đăng nhập chưa được kích hoạt, xin liên hệ quản trị hệ thống"
      },{
        type:"error",
        placement: {
            from: "top",
            align: "center"
        },
      })
    </script>
    @elseif(Session::get("message") == "error104")
    {{Session::flush();}}
    <script type="text/javascript">
      $.notify({
        message:"Tài khoản bị tạm khóa, xin liên hệ quản trị hệ thống"
      },{
        type:"error",
        placement: {
            from: "top",
            align: "center"
        },
      })
    </script>
    @elseif(Session::get("message") == "error105")
    {{Session::flush();}}
    <script type="text/javascript">
      $.notify({
        message:"Tài khoản bị chặn, xin liên hệ quản trị hệ thống"
      },{
        type:"error",
        placement: {
            from: "top",
            align: "center"
        },
      })
    </script>
    @endif
  </body>
</html>