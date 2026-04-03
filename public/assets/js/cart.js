(function ($) {
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
