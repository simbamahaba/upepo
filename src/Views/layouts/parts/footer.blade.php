@if( config('shop.active') === true )
@include('vendor.upepo.layouts.scripts.cart')
@endif
@yield('footer-assets')
</body>
</html>