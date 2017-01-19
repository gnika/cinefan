
var sendPanier = function() {
    var idProduct = $(this).attr('id');
    if(idProduct.indexOf('addid') !== -1){
        var id= idProduct.replace('addid', '');
        var quantity = 1;
    }
    else{
        var id= idProduct.replace('remvid', '');
        var quantity = -1;
    }

    $.ajax({
        method: "GET",
        url: "/fr/movie/buy/"+id+"/"+quantity,
    })
        .done(function( msg ) {

            if($('.totalPanier').length>0) {
                price = $('.price' + id).html();
                total = $('.total' + id).html();


                $('.quantity' + id).html(msg);
                $('.totalPrice' + id).html(msg * price);
                totalPanier = parseInt($('.totalPanier').html(), 10);
                $('.totalPanier').html(totalPanier + (quantity * price));
                if (msg == 0)
                    $('.ligne' + id).remove();

                $('.totalPriceNav').html(totalPanier + (quantity * price));
            }else{
                price =  parseInt($('.specialPrice').html(), 10);
                $('.totalPriceNav').html(price + ( parseInt($('.totalPriceNav').html(), 10)));

                alert('Le film a été ajouté au panier');
            }

        });

};

$( ".add,.remv" ).on( "click", sendPanier );