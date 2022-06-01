<script>
$(document).ready(function(){
    $('.add_to_cart').click(function(event){
        event.preventDefault();
        const product_id = $(this).attr('id');
        const cant = $("#qty_" + product_id).val();
        const price = $('#price_' + product_id).html();
        //Ajax setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            method: "POST",
            url: "{{ url('addCart') }}",
            data: {
                product_id: product_id,
                qty: cant,
                price: price,
                _token: "{{ Session::token() }}",
                _method: "post"
            },
            dataType:'json',
            success: function(data) {
                $("#cart").text('Aveti ' + data + ' produse in cos');
            }
        }).done(function(data) {
            console.log(data);
        }).fail(function(e) {
            console.log(e);
        });
    });
});
</script>
