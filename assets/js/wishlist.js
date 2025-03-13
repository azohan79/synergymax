document.addEventListener("DOMContentLoaded", function () {
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

    function updateWishlistUI() {
        document.querySelectorAll(".product__item-heart").forEach((heart) => {
            const productId = heart.dataset.productId;
            if (wishlist.includes(productId)) {
                heart.classList.add("active");
            } else {
                heart.classList.remove("active");
            }
        });
    }

    document.querySelectorAll(".product__item-heart").forEach((heart) => {
        heart.addEventListener("click", function () {
            const productId = this.dataset.productId;
            const index = wishlist.indexOf(productId);

            if (index === -1) {
                wishlist.push(productId);
                this.classList.add("active");
            } else {
                wishlist.splice(index, 1);
                this.classList.remove("active");
            }

            localStorage.setItem("wishlist", JSON.stringify(wishlist));
        });
    });

    updateWishlistUI();
});

jQuery(document).ready(function ($) {
    $('.product__quantity-item, .product__demonstration-color').on('click', function () {
        var variationId = $(this).data('variation');

        $.ajax({
            url: wc_ajax_url.toString().replace('%%endpoint%%', 'get_variation'),
            type: 'POST',
            data: {
                variation_id: variationId
            },
            success: function (response) {
                if (response.success) {
                    $('.product__prices-price').html(response.data.price_html);
                    $('.product__item-title').text(response.data.sku);
                    $('.product__item-subtitle').text(response.data.barcode);
                }
            }
        });
    });
});
