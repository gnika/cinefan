
var countChecked = function() {
    var n = $( "input:checked" ).length;
    // alert( n + (n === 1 ? " is" : " are") + " checked!" );
    var selected = [];
    $( "input:checked" ).each(function() {
        selected.push($(this).attr('value'));
    });

    $.ajax({
        method: "POST",
        url: "/fr/search/ajax",
        data: { noms: selected }
    })
        .done(function( msg ) {
            $('.renduListe').html('');
            var rendu ='';
            for (var i = 0; i < msg.length; i++){
                obj = msg[i];
                rendu+= '<tr><td>'+obj.title+'</td><td></td><td></td><td></td><td></td><td></td></tr>';
                $('.renduListe').html(rendu);
            }
        });

};

$( "input[type=checkbox]" ).on( "click", countChecked );