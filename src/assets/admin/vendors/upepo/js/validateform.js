$().ready(function() {
    $("#myForm").validate({
        rules : {
            'name': {
                required: true,
                alphadashspaces: true,
                minlength : 3,
                maxlength: 50
            },
            'email': {
                required: true,
                email: true,
                maxlength: 100
            },
            'phone': {
                required: true,
                digits: true,
                minlength : 10,
                maxlength: 50
            },
            'subject': {
                required: true,
                minlength : 4,
                maxlength: 50
            },
            'message': {
                required: true,
                minlength : 20,
                maxlength: 1000,
                bodymessage: true
            }
        }
    });
    $.validator.addMethod( "alphadashspaces", function( value, element ) {
        return this.optional( element ) || /^([A-Za-zĂÎÂŞŢăîâşţ]+[\s|\-]?[A-Za-zĂÎÂŞŢăîâşţ]+){1,}$/.test( value );
    }, "Te rugăm sa folosesti doar litere, spatii si cratima." );
    $.validator.addMethod( "bodymessage", function( value, element ) {
        return this.optional( element ) || /^[^'"<>*^]+$/.test( value );
    }, "Mesajul contine caractere nepermise (',\",*,^,<,>)." );
});