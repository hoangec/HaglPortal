@extends("layout.master")
@section("content")
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
    </section>
    <!-- Main content -->
    <section class="content">
    	<div class="row">
    		<div class="col-lg-3 col-xs-6">
    			<pre>
    				{{print_r($data)}}
    			</pre>
    		</div>
    	</div>
    </section>

</div>
@stop