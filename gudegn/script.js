document.addEventListener('DOMContentLoaded', function() {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartList = document.getElementById('cart-list');
    const totalPriceElement = document.getElementById('total-price');
    const cartCountElement = document.getElementById('cart-count');
    const btnBayar = document.getElementById('btn-bayar');
    let totalPrice = 0;
    let cartCount = 0;

    // Reset cart count to 0 initially
    document.getElementById('cart-count').textContent = '0';

    document.querySelectorAll('.btn-pesan').forEach(button => {
        button.addEventListener('click', function() {
            const menuItem = this.closest('.menu-item');
            const itemName = menuItem.querySelector('h3').textContent;
            const price = parseInt(menuItem.querySelector('.price').textContent);

            // Check if item already exists in cart
            let cartItem = Array.from(cartList.children).find(item => item.querySelector('.item-name').textContent === itemName);

            if (cartItem) {
                // Increment quantity if item exists
                const quantityElement = cartItem.querySelector('.item-quantity');
                let quantity = parseInt(quantityElement.textContent);
                quantity += 1;
                quantityElement.textContent = quantity;

                // Update total price
                totalPrice += price;
                totalPriceElement.textContent = totalPrice.toLocaleString();
            } else {
                // Create cart item element if it doesn't exist
                cartItem = document.createElement('li');
                cartItem.classList.add('cart-item');
                cartItem.innerHTML = `
                    <span class="item-name">${itemName}</span>
                    <span class="item-price">${price.toLocaleString()}</span>
                    <div class="quantity-controls">
                        <button class="btn-decrease">-</button>
                        <span class="item-quantity">1</span>
                        <button class="btn-increase">+</button>
                    </div>
                `;

                // Add cart item to cart list
                cartList.appendChild(cartItem);

                // Update total price
                totalPrice += price;
                totalPriceElement.textContent = totalPrice.toLocaleString();

                // Update cart count
                cartCount += 1;
                updateCartCount();

                // Show cart items container
                cartItemsContainer.style.display = 'block';

                // Handle increase button click
                cartItem.querySelector('.btn-increase').addEventListener('click', function() {
                    const quantityElement = cartItem.querySelector('.item-quantity');
                    let quantity = parseInt(quantityElement.textContent);
                    quantity += 1;
                    quantityElement.textContent = quantity;

                    // Update total price
                    totalPrice += price;
                    totalPriceElement.textContent = totalPrice.toLocaleString();

                    // Update cart count
                    updateCartCount();
                });

                // Handle decrease button click
                cartItem.querySelector('.btn-decrease').addEventListener('click', function() {
                    const quantityElement = cartItem.querySelector('.item-quantity');
                    let quantity = parseInt(quantityElement.textContent);
                    if (quantity > 1) {
                        quantity -= 1;
                        quantityElement.textContent = quantity;

                        // Update total price
                        totalPrice -= price;
                        totalPriceElement.textContent = totalPrice.toLocaleString();

                        // Update cart count
                        updateCartCount();
                    } else {
                        // Remove item if quantity is 1
                        cartItem.remove();
                        totalPrice -= price;
                        totalPriceElement.textContent = totalPrice.toLocaleString();
                        cartCount -= 1;
                        updateCartCount();

                        if (cartCount === 0) {
                            cartItemsContainer.style.display = 'none';
                        }
                    }
                });
            }
        });
    });

    function updateCartCount() {
        const totalItems = cartItems.reduce((total, item) => total + item.quantity, 0);
        document.getElementById('cart-count').textContent = totalItems.toString();
    }

    // Save total price to localStorage when "Bayar" button is clicked
    btnBayar.addEventListener('click', function() {
        localStorage.setItem('totalPrice', totalPrice);
    });

    // Handle rating click
    document.querySelectorAll('.rating .star').forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-value');
            const stars = this.parentElement.querySelectorAll('.star');
            stars.forEach(s => {
                if (s.getAttribute('data-value') <= rating) {
                    s.classList.add('selected');
                } else {
                    s.classList.remove('selected');
                }
            });
        });
    });

    // Handle rating click
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');
                setRating(value, this.parentElement);
            });
        });

        function setRating(value, parent) {
            const stars = parent.querySelectorAll('.star');
            stars.forEach(star => {
                if (star.getAttribute('data-value') <= value) {
                    star.classList.add('selected');
                } else {
                    star.classList.remove('selected');
                }
            });
        }

        function updateTotalPrice() {
            const cartItems = document.querySelectorAll('#cart-list li');
            let totalPrice = 0;
            cartItems.forEach(item => {
                const price = parseInt(item.getAttribute('data-price'));
                const quantity = parseInt(item.querySelector('.quantity').textContent);
                totalPrice += price * quantity;
            });
            document.getElementById('total-price').textContent = totalPrice.toLocaleString();
            localStorage.setItem('totalPrice', totalPrice);
        }

        document.getElementById('btn-dine-in').onclick = function() {
            updateTotalPrice();
            window.location.href = 'bayar.php';
        };

        document.getElementById('btn-order-online').onclick = function() {
            updateTotalPrice();
            window.location.href = 'bayar.php';
        };
    });
});