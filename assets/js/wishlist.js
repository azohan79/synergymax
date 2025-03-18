document.addEventListener("DOMContentLoaded", function () {
    let wishlist = JSON.parse(localStorage.getItem("wishlist")) || [];

    // Обновляет визуальное состояние иконок сердца
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

    // Обработка кликов на иконки сердца
    document.querySelectorAll(".product__item-heart").forEach((heart) => {
        heart.addEventListener("click", function (event) {
            // Предотвращаем всплытие события и действие по умолчанию
            event.stopPropagation();
            event.preventDefault();

            const productId = this.dataset.productId;
            const index = wishlist.indexOf(productId);

            if (index === -1) {
                // Если товара нет в избранном, добавляем его
                wishlist.push(productId);
                this.classList.add("active");
            } else {
                // Если товар уже в избранном, удаляем его
                wishlist.splice(index, 1);
                this.classList.remove("active");
            }

            // Сохраняем обновлённый список избранного в localStorage
            localStorage.setItem("wishlist", JSON.stringify(wishlist));
        });
    });

    // Обновляем визуальное состояние при загрузке страницы
    updateWishlistUI();
});
// jQuery(document).ready(function ($) {
//     $('.product__quantity-item, .product__demonstration-color').on('click', function () {
//         var variationId = $(this).data('variation');

//         $.ajax({
//             url: wc_add_to_cart_params.ajax_url, 
//             type: 'POST',
//             data: {
//                 action: 'get_variation',
//                 variation_id: variationId 
//             },
//             success: function (response) {
//                 if (response.success) {
//                     $('.product__prices-price').html(response.data.price_html);
//                     $('.product__item-title').text(response.data.sku);
//                     $('.product__item-subtitle').text(response.data.barcode);
//                 }
//             }
//         });
//     });
// });
