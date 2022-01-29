$().ready(function() {
    $("#myForm").validate({
        debug: false,
        errorElement: "p",
        rules : {
            'name': {
                required: true,
                alphadashspaces: true,
                minlength : 3,
                maxlength: 50
            },
            'email': {
                required: true,
                mail: true,
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
            },
            'privacy':{
                required: true
            }
        }
    });
    $.validator.addMethod( "alphadashspaces", function( value, element ) {
        return this.optional( element ) || /^([A-Za-zĂÂÎŞŢăâîşţ]+[\s\-]?[A-Za-zĂÂÎŞŢăâîşţ]+)+$/.test( value );
    }, "Te rugăm să foloseşti doar litere, spaţii şi cratimă." );
    $.validator.addMethod( "mail", function( value, element ) {
        return this.optional( element ) || /^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/.test( value );
    }, "Te rugăm să introduci o adresă de email validă." );
    $.validator.addMethod( "bodymessage", function( value, element ) {
        return this.optional( element ) || /^[^'"<>*^]+$/.test( value );
    }, "Mesajul conţine caractere nepermise (',\",*,^,<,>)." );
    $.extend( $.validator.messages, {
        required: "Acest câmp este obligatoriu.",
        remote: "Te rugăm să completezi acest câmp.",
        email: "Te rugăm să introduci o adresă de email validă",
        url: "Te rugăm sa introduci o adresă URL validă.",
        date: "Te rugăm să introduci o dată corectă.",
        dateISO: "Te rugăm să introduci o dată (ISO) corectă.",
        number: "Te rugăm să introduci un număr întreg valid.",
        digits: "Te rugăm să introduci doar cifre.",
        creditcard: "Te rugăm să introduci un numar de carte de credit valid.",
        equalTo: "Te rugăm să reintroduci valoarea.",
        extension: "Te rugăm să introduci o valoare cu o extensie validă.",
        maxlength: $.validator.format( "Te rugăm să nu introduci mai mult de {0} caractere." ),
        minlength: $.validator.format( "Te rugăm să introduci cel puțin {0} caractere." ),
        rangelength: $.validator.format( "Te rugăm să introduci o valoare între {0} și {1} caractere." ),
        range: $.validator.format( "Te rugăm să introduci o valoare între {0} și {1}." ),
        max: $.validator.format( "Te rugăm să introduci o valoare egal sau mai mică decât {0}." ),
        min: $.validator.format( "Te rugăm să introduci o valoare egal sau mai mare decât {0}." )
    } );
});
