<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              
              <img src="{{asset("public/img/user-default-profile-160x160.png")}}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p>{{Sentry::getUser()->first_name . ' ' . Sentry::getUser()->last_name}}</p>

              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">Chức năng</li>
            <li class="treeview {{Request::is('dashboard/reports/*') ? 'active' : ''}}">
              <a href="#">
                <i class="fa fa-dashboard"></i> <span>Báo cáo ngành</span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class="{{Request::is('dashboard/reports/livestock/*') ? 'active' : ' '}}">
                  <a href="#">
                    <i class="fa fa-circle-o"></i> Chăn nuôi bò thịt<i class="fa fa-angle-left pull-right"></i>
                  </a>
                 <ul class="treeview-menu">
                  <li
                    @if(Request::is('dashboard/reports/livestock/index') || Request::is('dashboard/reports/livestock/index/*'))
                      class="active"                  
                    @endif
                  >
                    <a href="{{route('front_report_livestock_index_get')}}"><i class="fa fa-circle-o"></i> Tổng quan</a>
                  </li>
                  <li
                    @if(Request::is('dashboard/reports/livestock/real-quantity') || Request::is('dashboard/reports/livestock/real-quantity/*'))
                      class="active"                  
                    @endif
                  > 
                    <a href="{{route('front_report_livestock_real_quantity_get')}}"><i class="fa fa-circle-o"></i> Bò thực tế</a>
                  </li>
                  <li
                    @if(Request::is('dashboard/reports/livestock/received-quantity') || Request::is('dashboard/reports/livestock/received-quantity/*'))
                      class="active"                  
                    @endif
                  > 
                    <a href="{{route('front_report_livestock_received_quantity_get')}}"><i class="fa fa-circle-o"></i> Bò Nhập</a>
                  </li>
                  <li
                    @if(Request::is('dashboard/reports/livestock/cattle-for-sale') || Request::is('dashboard/reports/livestock/cattle-for-sale/*'))
                      class="active"                  
                    @endif
                  > 
                    <a href="{{route('front_report_livestock_cattle_for_sale_get')}}"><i class="fa fa-circle-o"></i> Bò xuất</a>
                  </li>
                  <li
                    @if(Request::is('dashboard/reports/livestock/mortality-quantity') || Request::is('dashboard/reports/livestock/mortality-quantity/*'))
                      class="active"                  
                    @endif
                  > 
                    <a href="{{route('front_report_livestock_mortality_quantity_get')}}"><i class="fa fa-circle-o"></i> Bò chết</a>
                  </li>
                </ul> 
                            
                </li>                
              </ul>
            </li>
            <li class="header">Quản trị</li>
             <li class="treeview {{Request::is('dashboard/admin/reports/*') ? 'active' : ''}} ">
              <a href="#">
                <i class="fa fa-files-o"></i>
                <span>Báo cáo ngành</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li class = "{{Request::is('dashboard/admin/reports/livestock/*') ? 'active' : ''}}">                                
                  <a href="{{route('admin_report_livestock_index_get')}}"><i class="fa fa-circle-o"></i> Chăn nuôi bò thịt</a>               
                </li>
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Hệ thống</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Người dùng</a></li>
                <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Hệ thống</a></li>
              </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>