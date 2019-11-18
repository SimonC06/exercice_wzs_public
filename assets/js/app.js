require('../css/app.scss');
require('bootstrap');
$ = require('jquery');
global.$ = global.jQuery = $;

//
// Général
//
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});


//
// Fonctions relative à l'ajout d'un produit au panier
//

// Ajout au panier
addToCart = function($productId) {
    let $url = '/produit/add-product';
    let $cartBoxBadge = $('.cart-box-badge');
    let $productQty = $('.prod-qty').html();
    let $message = $('.prod-add-to-cart-message');

    $.ajax({
        url: $url,
        type: 'POST',
        dataType: 'text',
        data:{productId : $productId, productQty : $productQty,
        },
        success: function(data)
        {
            if(data != 0){
                $cartBoxBadge.html(data);
                $message.removeClass();
                $message.addClass('text-success');
                $message.html('Le produit a bien été ajouté.');
            }else{
                $message.removeClass();
                $message.addClass('text-danger');
                $message.html('Une erreur s\'est produite.');
            }
        },
        fail: function(){
            $message.removeClass();
            $message.addClass('text-danger');
            $message.html('Une erreur s\'est produite.');
        }
    });
};

// Ajout d'une unité
addQty = function($productId = 0){
    let $prodQty = $('.prod-qty');
    let $cartPricetotal = $('.cart-price-total');
    let $newCartPrice = 0;

    if($productId > 0)
    {
        $prodQty = $('.prod-qty-id-' + $productId);
        let $newQty = parseInt($prodQty.html()) + 1 ;
        $newCartPrice = updateProductQty($productId , $newQty);
        $cartPricetotal.html($newCartPrice + ' €');
    }

    let $currentValue = parseInt($prodQty.html());
    $prodQty.html($currentValue + 1);
};

// Suppression d'une unité
deleteQty = function($productId = 0){
    let $prodQty = $('.prod-qty');
    let $cartPricetotal = $('.cart-price-total');
    let $newCartPrice = 0;

    if($productId > 0 ){
        $prodQty = $('.prod-qty-id-' + $productId);
        let $newQty = parseInt($prodQty.html()) - 1;
        if($newQty >= 1)
            $newCartPrice = updateProductQty($productId , $newQty);
    }

    let $currentValue = parseInt($prodQty.html());
    if($currentValue > 1){
        $prodQty.html($currentValue - 1);
        $cartPricetotal.html($newCartPrice + ' €');
    }
};

// Suppression d'un produit du panier
deleteProductCart = function($productId) {
    let $url = '/panier/delete/' + $productId;
    let $rowProduct = $('.prod-row-' + $productId);
    let $cartPricetotal = $('.cart-price-total');

    $.ajax({
        url: $url,
        type: 'POST',
        success: function(data)
        {
            if(data != 0){
                $rowProduct.fadeOut();
            }else{
                $rowProduct.html('<td colspan="3" class="border-0">Vous n\'avez aucun produit dans votre panier :\'( .</td>');
            }
            $cartPricetotal.html(data + ' €');
        },
        fail: function(){
            alert('Suppression impossible.')
        },
        async: false
    });
};

// Mise à jour de la quantité dans le panier
updateProductQty = function($productId, $qty){
    let $url = '/panier/update/' + $productId + '/' + $qty;
    let $newPrice = 0;
    $.ajax({
        url: $url,
        type: 'POST',
        dataType: 'text',
        data:{fromCart : 1},
        success: function(data)
        {
            if(data != 0)
                $newPrice = parseFloat(data);
        },
        async: false
    });
    return $newPrice;
};