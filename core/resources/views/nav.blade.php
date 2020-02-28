<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      @if(auth()->guard('admin')->check())
        <div class="pull-left image">
          <img src="{{ asset( auth()->guard('admin')->user()->photo != '' ? 'assets/img/uploads/'.auth()->guard('admin')->user()->photo : 'assets/img/uploads/defaultavatar.png') }}" class="img-circle" alt="User Image" />
        </div>
        <div class="pull-left info">
          <p> {{ auth()->guard('admin')->user()->name }} </p>
          <a href="#"><i class="fa fa-circle text-success"></i> {{trans('application.online')}}</a>
        </div>
        @endif
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">{{trans('application.main_menu')}}</li>
      <li class="{{ HTML::menu_active('/') }}"><a href="{{ url('/') }}"><i class="fa fa-home"></i><span>{{trans('application.dashboard')}}</span></a></li>
      <li class="{{ HTML::menu_active('inventory') }}"><a href="{{ url('inventory') }}"><i class="fa fa-columns"></i><span>Inventory</span></a></li>
      <li class="{{ HTML::menu_active('clients') }}"><a href="{{ url('clients') }}"><i class="fa fa-users"></i><span>{{trans('application.clients')}}</span></a></li>
      <li class="{{ HTML::menu_active('vendors') }}"><a href="{{ url('vendors') }}"><i class="fa fa-file" aria-hidden="true"></i><span>Vendors</span></a></li>
      <!--
        <li class="{{ HTML::menu_active('invoices') }}"><a href="{{ url('invoices') }}"><i class="fa fa-file-pdf-o"></i><span>{{trans('application.invoices')}}</span></a></li>
        <li class="{{ HTML::menu_active('estimates') }}"><a href="{{ url('estimates') }}"><i class="fa fa-list-alt"></i><span>{{trans('application.estimates')}}</span> </a></li>
        <li class="{{ HTML::menu_active('payments') }}"><a href="{{ url('payments') }}"><i class="fa fa-money"></i><span>{{trans('application.payments')}}</span></a></li>
        <li class="{{ HTML::menu_active('expenses') }} {{ HTML::menu_active('expense_category') }}"><a href="{{ url('expenses') }}"><i class="fa fa-credit-card "></i><span>{{trans('application.expenses')}}</span></a></li>
      -->
      <li class="{{ HTML::menu_active('products') }} {{ HTML::menu_active('product_category') }}"><a href="{{ url('products') }}"><i class="fa fa-puzzle-piece"></i> <span>{{trans('application.products')}}</span></a></li>
      <li class="{{ HTML::menu_active('couriers') }}"><a href="{{ url('couriers') }}"><i class="fa fa-truck"></i> <span>{{trans('application.couriers')}}</span></a></li>

      <!--
        <li class="{{ HTML::menu_active('reports') }}"><a href="{{ url('reports') }}"><i class="fa fa-line-chart"></i> <span>{{trans('application.reports')}}</span></a></li>
        @if(auth()->guard('admin')->check() && (auth()->guard('admin')->user()->can('edit_setting') || auth()->guard('admin')->user()->HasRole('admin')))
          <li class="{{ HTML::menu_active('settings') }}"><a href="{{ url('settings/company') }}"><i class="fa fa-cogs"></i> <span>{{trans('application.settings')}}</span></a></li>
        @endif
        <li class="{{ HTML::menu_active('profile') }}"><a href="{{ url('profile') }}"><i class="fa fa-user-md "></i> <span>{{trans('application.profile')}}</span></a></li>
      -->

      <li class="{{ HTML::menu_active('users') }}"><a href="{{ route('users.index') }}"><i class="fa fa-user "></i> <span>{{trans('application.users')}}</span></a></li>
      <li class="{{ HTML::menu_active('logout') }}"><a href="{{ route('admin_logout') }}"><i class="fa fa-power-off"></i> <span>{{trans('application.logout')}}</span></a></li>
      <li class="header">Credits</li>
      <li class=""><a href="http://gerzahim.com/" target="blank">Gerzahim.com</a></li>      
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
