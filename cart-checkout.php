<?php
/*
Template Name: Cart & Checkout
*/

get_header(); ?>

<div class="container">
    <div class="cart-checkout-page">
        <div class="cart-section">
            <?php echo do_shortcode('[woocommerce_cart]'); ?>
        </div>
        <div class="checkout-section">
            <?php echo do_shortcode('[woocommerce_checkout]'); ?>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function updateCartItemQuantity(key, quantity) {
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    action: 'update_cart_item_quantity',
                    cart_item_key: key,
                    quantity: quantity,
                    security: '<?php echo wp_create_nonce("update-cart-quantity"); ?>'
                },
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        // Обновляем корзину через WooCommerce
                        jQuery('body').trigger('update_checkout');
                        jQuery('body').trigger('wc_fragment_refresh');

                        // Вручную обновляем цену товара и общую стоимость
                        updateCartPrices(key, quantity);
                    } else {
                        alert('Ошибка при обновлении корзины.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }

        function updateCartPrices(cartItemKey, newQuantity) {
            const cartItem = document.querySelector(`.cart_item[data-cart-item-key="${cartItemKey}"]`);
            if (!cartItem) return;

            // Получаем цену за единицу товара из data-атрибута
            const unitPrice = parseFloat(cartItem.querySelector('.basket__item-price').dataset.unitPrice);
            if (isNaN(unitPrice)){
                console.error("Ошибка: unitPrice не является числом", cartItem.dataset.unitPrice);
                return
            };

            // Обновляем цену товара (цена * количество)
            const totalPrice = unitPrice * newQuantity;
            const formattedPrice = `${totalPrice.toFixed(2)} €`; // Форматируем цену
            const priceElement = cartItem.querySelector('.basket__item-price');
            priceElement.textContent = formattedPrice;

            // Обновляем общую стоимость корзины
            updateCartTotal();
        }

        // Функция для обновления общей стоимости корзины
        function updateCartTotal() {
            jQuery.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                data: {
                    action: 'get_cart_total',
                    security: '<?php echo wp_create_nonce("get-cart-total"); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        const cartTotalElement = document.querySelector('.pay__top-name:last-child');
                        if (cartTotalElement) {
                            cartTotalElement.textContent = response.data.cart_total;
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }

        // Обработчик для кнопки "-"
        document.querySelectorAll(".basket__item-minus").forEach(function(minusButton) {
            minusButton.addEventListener("click", function() {
                const countElement = this.nextElementSibling;
                let count = parseInt(countElement.textContent);
                if (count > 1) {
                    countElement.textContent = count - 1;
                    const cartItemKey = this.closest('.cart_item').dataset.cartItemKey;
                    updateCartItemQuantity(cartItemKey, count - 1);
                }
            });
        });

        // Обработчик для кнопки "+"
        document.querySelectorAll(".basket__item-plus").forEach(function(plusButton) {
            plusButton.addEventListener("click", function() {
                const countElement = this.previousElementSibling;
                let count = parseInt(countElement.textContent);
                countElement.textContent = count + 1;
                const cartItemKey = this.closest('.cart_item').dataset.cartItemKey;
                updateCartItemQuantity(cartItemKey, count + 1);
            });
        });
        const checkbox = document.getElementById('agreeCheckbox');
        const button = document.getElementById('checkoutButton');

        checkbox.addEventListener('change', function () {
            button.disabled = !this.checked;
        });
    });
</script>

<?php get_footer(); ?>