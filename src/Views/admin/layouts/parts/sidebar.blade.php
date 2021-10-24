<!-- sidebar menu -->
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

    {!! $tabele !!}
    @if( config('shop.active') === true )
    <div class="menu_section">
        <h3>{{ __('upepo::admin.shop') }}</h3>
        <ul class="nav side-menu">
            <li><a href="{{ url('/admin/shop/orders') }}"><i class="fa fa-shopping-cart"></i> {{__('upepo::admin.orders')}}</a></li>
            <li><a href="{{ url('/admin/shop/statuses') }}"><i class="fa fa-bar-chart"></i> {{__('upepo::admin.status')}}</a></li>
            <li><a href="{{ url('/admin/shop/invoice') }}"><i class="fa fa-file-text-o"></i> {{__('upepo::admin.invoices')}}</a></li>
            <li><a href="{{ url('/admin/shop/transport') }}"><i class="fa fa-truck"></i> {{__('upepo::admin.shipping')}}</a></li>
            <li><a href="{{ url('/admin/shop/customers') }}"><i class="fa fa-users"></i> {{__('upepo::admin.customers')}}</a></li>
        </ul>
    </div>
    @endif
    <div class="menu_section">
        <h3>{{__('upepo::admin.settings')}}</h3>
        <ul class="nav side-menu">
            <li><a href="{{ url('admin/maps') }}"><i class="fa fa-map-marker"></i> {{__('upepo::admin.map')}}</a></li>
            <li><a href="{{ url('admin/settings/social') }}"><i class="fa fa-info-circle"></i> {{__('upepo::admin.social')}}</a></li>
            <li><a href="{{ url('admin/settings') }}"><i class="fa fa-cogs"></i> {{__('upepo::admin.site_settings')}}</a></li>
            <li><a href="{{ url('admin/sitemap') }}"><i class="fa fa-sitemap"></i> Sitemap</a></li>
        </ul>
    </div>
    @if( config('app.debug') === true )
    <div class="menu_section">
        <h3>{{__('upepo::admin.tables')}}</h3>
        <ul class="nav side-menu">
            <li><a href="{{ url('admin/table-settings') }}"><i class="fa fa-laptop"></i> {{__('upepo::admin.tables_settings')}}</a></li>
        </ul>
    </div>
    @endif
</div>
<!-- /sidebar menu -->
