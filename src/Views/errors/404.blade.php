@extends('vendor.upepo.layouts.app')
@section('content')

    <div class="tm_pb_section  tm_pb_section_0 tm_section_regular tm_section_transparent">
        <div class="container">
            <div class=" row tm_pb_row tm_pb_row_1">

                <div class="tm_pb_column tm_pb_column_4_4  tm_pb_column_1 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 tm_pb_vertical_alligment_start">

                    <div class="tm_pb_text tm_pb_module tm_pb_bg_layout_light tm_pb_text_align_center  tm_pb_text_1">

                        <h1 style="font-size: 3em;">Pagina indisponibila (404)</h1>

                    </div> <!-- .tm_pb_text --><hr class="tm_pb_module tm_pb_space tm_pb_divider_0">
                    <div style="text-align: center;">
                        @if( isset($tell) )
                            <div><strong>{{ $tell }}</strong></div>
                        @endif
                        Ne cerem scuze, pagina cautata este indisponibila.<br>
                        Va rugam sa navigati catre o alta sectiune din site.
                    </div>
                </div> <!-- .tm_pb_column -->

            </div> <!-- .tm_pb_row -->
        </div>



    </div>
@endsection