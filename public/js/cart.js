
(function ($) {

    $('.item-quantity').on('change', function (e) {
        let $input = $(this);
        let id = $input.data('id');
        let quantity = $input.val();

        $.ajax({
            url: "/cart/" + id,
            method: 'put',
            data: {
                quantity: quantity,
                _token: csrf_token
            },
            success: function (response) {
                let message = "Product Updated !";
                let cartTotal = response.cartTotal;
                let itemTotal = response.itemTotal;

                showNotificationMessage(message, 'success');
                updateCartSubtotal(cartTotal);
                updateItemTotal(id, itemTotal);

                setTimeout(function () {
                    clearNotificationMessage();
                }, 2000);
            },
            error: function (xhr, status, error) {
                let message = "Error updating product quantity: " + error;
                showNotificationMessage(message, 'error');

                setTimeout(function () {
                    clearNotificationMessage();
                }, 2000);
            }
        });
    });

    function showNotificationMessage(message, type) {
        let notificationContainer = $('#notification-container');
        notificationContainer.html(`<div class="notification ${type}">${message}</div>`);
    }

    function clearNotificationMessage() {
        let notificationContainer = $('#notification-container');
        notificationContainer.empty();
    }

    function updateItemTotal(itemId, itemTotal) {
        let itemTotalElement = $('#item-total-' + itemId);
        itemTotalElement.text(itemTotal);
    }

    $('.remove-item').on('click', function (e) {
        e.preventDefault();

        let id = $(this).data('id');
        let $product = $(`#${id}`);

        $.ajax({
            url: "/cart/" + id,
            method: 'delete',
            data: {
                _token: csrf_token
            },
            success: response => {
                $product.remove();
                let cartTotal = response.cartTotal;
                showNotificationMessage('Product Deleted !', 'success');
                updateCartSubtotal(response.cartTotal);
            }
        });
    });

    function updateCartSubtotal(cartTotal) {
        let cartSubtotalElement = $('#cart-subtotal');
        let youPayElement = $('#you-pay');

        cartSubtotalElement.text(cartTotal);
        youPayElement.text(cartTotal);
    }

    function showNotificationMessage(message, type) {
        let notificationContainer = $('#notification-container');
        notificationContainer.html(`<div class="notification ${type}">${message}</div>`);

        setTimeout(function () {
            notificationContainer.empty();
        }, 2000);
    }

    $('#add-to-cart').on('click', function (e) {
        e.preventDefault();
        var form = $('#cart-form');
        var total = 0;

        $.post(form.attr('action'), form.serialize(), function (response) {
            var list = $('#cart-list');
            list.empty();
            $('#cart-items').text(response.cart.length);
            $('#cart-items2').text(response.cart.length);

            for (var i in response.cart) {
                var item = response.cart[i];
                total += item.quantity * item.product.price;
                list.append(`<li id="${item.id}">
                <a href="javascript:void(0)" class="remove remove-item" title="Remove this item"
                  data-id="${item.id}"><i class="lni lni-close"></i></a>
                <div class="cart-img-head">
                  <a class="cart-img" href=""><img src="${item.product.image_url}" alt="#"></a>
                </div>
                <div class="content">
                  <h4><a href="${item.product.url}">${item.product.name}</a></h4>
                  <p class="quantity">${item.quantity}x - <span class="amount">${item.product.price}</span></p>
                </div>
              </li>`);
            }
            $('.total-amount').text(total);

            // Show notice
            $('#notice').text('Product added to cart !').fadeIn(300).delay(2000).fadeOut(300);
        });
    });

})(jQuery);
