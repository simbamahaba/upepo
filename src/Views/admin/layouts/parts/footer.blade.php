<!-- footer content -->
<footer>
    <div class="pull-right">
         Site realizat de <a href="https://www.decoweb.ro">Decoweb Designs SRL</a> Constanta
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>--}}
<script src="{{ asset('assets/admin/vendors/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/moment/locale/'.app()->getLocale().'.js') }}"></script>
<script src="{{ asset('assets/admin/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
@yield('footer-assets')
<script src="{{ asset('assets/admin/build/js/custom.min.js') }}"></script>
@if(defined('EDITOR'))
<script src="https://cdn.ckeditor.com/4.15.1/full/ckeditor.js"></script>
<script>
  CKEDITOR.replace( 'my-editor', {
      filebrowserImageBrowseUrl: '{!! url('/laravel-filemanager?type=Images') !!}',
      filebrowserImageUploadUrl: '{!! url('/laravel-filemanager/upload?type=Images&_token='.csrf_token()) !!}',
      filebrowserBrowseUrl: '{!! url('/laravel-filemanager?type=Files') !!}',
      filebrowserUploadUrl: '{!! url("/laravel-filemanager/upload?type=Files&_token=".csrf_token()) !!}'
  });
</script>
@endif

</body>
</html>
