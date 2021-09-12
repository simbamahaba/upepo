<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

    {!! $tabele !!}
    @if( config('shop.active') === true )
    <div class="menu_section">
        <h3>Magazin</h3>
        <ul class="nav side-menu">
            <li><a href="{{ url('/admin/shop/orders') }}"><i class="fa fa-shopping-cart"></i> Comenzi</a></li>
            <li><a href="{{ url('/admin/shop/statuses') }}"><i class="fa fa-bar-chart"></i> Status comenzi</a></li>
            <li><a href="{{ url('/admin/shop/invoice') }}"><i class="fa fa-file-text-o"></i> Setari facturi</a></li>
            <li><a href="{{ url('/admin/shop/transport') }}"><i class="fa fa-truck"></i> Setari transport</a></li>
            <li><a href="{{ url('/admin/shop/customers') }}"><i class="fa fa-users"></i> Utilizatori</a></li>
        </ul>
    </div>
    @endif
    <div class="menu_section">
        <h3>Setari</h3>
        <ul class="nav side-menu">
            <li><a href="{{ url('admin/maps') }}"><i class="fa fa-map-marker"></i> Google map</a></li>
            <li><a href="{{ url('admin/settings/social') }}"><i class="fa fa-info-circle"></i> Retele sociale</a></li>
            <li><a href="{{ url('admin/settings') }}"><i class="fa fa-cogs"></i> Setari generale</a></li>
            <li><a href="{{ url('admin/sitemap') }}"><i class="fa fa-sitemap"></i> Sitemap</a></li>
        </ul>
    </div>
    @if( config('app.debug') === true )
    <div class="menu_section">
        <h3>Tabele</h3>
        <ul class="nav side-menu">
            <li><a href="{{ url('admin/table-settings') }}"><i class="fa fa-laptop"></i> Setari tabele</a></li>
        </ul>
    </div>
    @endif
</div>
<!-- /sidebar menu -->