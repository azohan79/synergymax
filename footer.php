        <footer class="footer">
            <div class="footer__wrapper">
                        <!-- Меню каталога -->
        <ul class="footer__list">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer_catalog',
                'container'      => false,
                'items_wrap'     => '%3$s', // Убираем обертку <ul>
                'walker'         => new Synergymax_Walker_Footer(),
            ));
            ?>
        </ul>

        <!-- Меню для бизнеса -->
        <ul class="footer__list">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer_business',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'walker'         => new Synergymax_Walker_Footer(),
            ));
            ?>
        </ul>

        <!-- Меню для клиентов -->
        <ul class="footer__list">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer_clients',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'walker'         => new Synergymax_Walker_Footer(),
            ));
            ?>
        </ul>

                <a href="#" class="footer__signUp">
                    <div class="footer__signUp-text">Sign Up</div>
                    <div class="footer__signUp-img">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/footer/Union.svg" alt="sign in">
                    </div>                    
                </a>

                <div class="footer__container-1">
                    <h3 class="footer__social-title">Get to know us better in social media</h3>
                    <!-- Меню социальных сетей (с иконками) -->
        <ul class="footer__social">
            <?php
            $social_links = array(
                array('url' => '#', 'icon' => 'X.svg'),
                array('url' => '#', 'icon' => 'Vector (1).svg'),
                array('url' => '#', 'icon' => 'Instagram icon.svg'),
                array('url' => '#', 'icon' => 'tictok.svg'),
                array('url' => '#', 'icon' => 'facebook.svg'),
                array('url' => '#', 'icon' => 'youtube.svg')
            );
            foreach ($social_links as $social) {
                echo '<li class="footer__social-item">
                        <a href="' . esc_url($social['url']) . '" class="footer__social-link">
                            <img src="' . get_template_directory_uri() . '/assets/icons/footer/' . esc_attr($social['icon']) . '" alt="social" class="footer__social-img">
                        </a>
                      </li>';
            }
            ?>
        </ul>
                    <p class="footer__sinergy">Synergy Max S.L. 
                        Calle Mayor 4, Barcelona, 46500                        
                        CIF 000000000
                    </p>
                </div>
                
            </div>

            <div class="footer__works">
                <h4 class="footer__works-title">We work with</h4>
                <div class="footer__works-logos">
                    <?php
                    $payment_methods = array('visa.png', 'mastercard.png', 'maestro.png', 'apple-pay.png', 'google-pay.png', 'diners-club.png', 'discover.png', 'unionPay.png', 'JCB.png');
                    foreach ($payment_methods as $method) {
                        echo '<a href="#" class="footer__works-link">
                                <img src="' . get_template_directory_uri() . '/assets/img/footer/' . $method . '" alt="' . pathinfo($method, PATHINFO_FILENAME) . '">
                              </a>';
                    }
                    ?>
                </div>  
            </div>

            <div class="footer__cellar">
                <div class="footer__cellar-item">
                    <div class="footer__cellar-img">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/icons/footer/copy.png" alt="copy">
                    </div>
                    <p class="footer__cellar-information">
                        Website design & development by <span>MISSOFFDESIGN</span> 
                    </p>    
                </div>
                <!-- Меню сервисных страниц -->
        <ul class="footer__cellar-list">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'footer_services',
                'container'      => false,
                'items_wrap'     => '%3$s',
                'walker'         => new Synergymax_Walker_Footer(),
            ));
            ?>
        </ul>
                <div class="footer__cellar-yare">
                    <span>2024</span>
                    <span>Synergy Max S.L. </span>
                </div>
            </div>
        </footer>
    </div>

    <?php wp_footer(); ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const counters = document.querySelectorAll(".product__item-counter");

    counters.forEach(counter => {
        const minus = counter.querySelector(".product__counter-minus");
        const plus = counter.querySelector(".product__counter-plus");
        const input = counter.querySelector(".product__counter-coll");
        const form = counter.closest(".product__item").querySelector("form");
        const hiddenQuantity = form.querySelector("input[name='quantity']");

        if (minus && plus && input && form && hiddenQuantity) {
            minus.addEventListener("click", function () {
                let value = parseInt(input.value);
                if (value > 1) {
                    input.value = value - 1;
                    hiddenQuantity.value = input.value; // Обновляем скрытое поле
                }
            });

            plus.addEventListener("click", function () {
                let value = parseInt(input.value);
                input.value = value + 1;
                hiddenQuantity.value = input.value; // Обновляем скрытое поле
            });

            input.addEventListener("change", function () {
                if (input.value < 1 || isNaN(input.value)) {
                    input.value = 1;
                }
                hiddenQuantity.value = input.value; // Обновляем скрытое поле
            });

            // При отправке формы передаем актуальное количество
            form.addEventListener("submit", function (e) {
                hiddenQuantity.value = input.value;
            });
        }
    });
});

</script>

</body>
</html
