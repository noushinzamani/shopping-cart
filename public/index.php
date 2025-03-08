<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script defer src="assets/js/cart.js"></script>
</head>
<body>
    <div class="page-container">
        <!-- Shopping Cart -->
        <div class="container">
            <h2>Shopping Cart</h2>
            <div id="cart"><!-- Cart items will be loaded here --></div>
            
            <a href="https://fortnine.ca/en/" class="continue-shopping">Continue Shopping</a>
        </div>

        <!-- Checkout Summary -->
        <div class="checkout-panel">
            <h3>Cart Summary</h3>
            <p id="subtotal">Subtotal: $0.00</p>
            <p id="GST">GST (5%): $0.00</p>
            <p id="QST">QST (9.975%): $0.00</p>
            <p class="total"><strong id="grandTotal">Grand Total: $0.00</strong></p>
            <button class="proceed-checkout" onclick="window.location.href='https://fortnine.ca/en/checkout/cart/'">Proceed to Checkout</button>
        </div>
    </div>
</body>
</html>
