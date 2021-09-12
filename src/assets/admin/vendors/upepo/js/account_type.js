/*jshint esversion: 6 */
// Account types

$(document).ready(function(){
    let $persoana_juridica = $("#pers_juridica");
    let $persoana_fizica = $("#pers_fizica");
    let $cont = $("#account_type");
    $cont.change(function(){
        switch( $cont.val() ){
            case '0': $persoana_fizica.show();
                $persoana_juridica.hide();
                break;
            case '1': $persoana_fizica.hide();
                $persoana_juridica.show();
                break;
        }
    });
    let type = $cont.val();
    if( type == 1){
        $persoana_fizica.hide();
        $persoana_juridica.show();
    }
});
