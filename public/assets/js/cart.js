document.addEventListener("DOMContentLoaded", function () {
    fetchCart();

    function fetchCart() {
        fetch("/shopping-cart/src/api/cart.php")
            .then(response => response.json())
            .then(data => {
                console.log("Cart API Response:", data); // Debugging

                let cartContainer = document.getElementById("cart");
                let cartSummary = document.querySelector(".checkout-panel");

                if (!cartContainer || !cartSummary) {
                    console.error("Cart elements not found in HTML.");
                    return;
                }

                let cartHtml = "";

                if (!data.items || data.items.length === 0) {
                    cartHtml = "<p>No items in cart.</p>";
                    cartSummary.innerHTML = `
                        <p>Subtotal: $0.00</p>
                        <p>GST (5%): $0.00</p>
                        <p>QST (9.975%): $0.00</p>
                        <strong>Grand Total: $0.00</strong>
                    `;
                } else {
                    cartHtml += `<table>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>`;

                    data.items.forEach(item => {
                        cartHtml += `<tr data-id="${item.id}" class="cart-item">
                            <td>${item.product_name}</td>
                            <td class="price">$${parseFloat(item.price).toFixed(2)}</td>
                            <td>
                                <input type="number" value="${item.quantity}" data-id="${item.id}" class="quantity-input" min="1">
                            </td>
                        </tr>`;
                    });

                    cartHtml += `</table>`;

                    cartSummary.innerHTML = `
                        <p>Subtotal: $${data.subtotal}</p>
                        <p>GST (5%): $${data.GST}</p>
                        <p>QST (9.975%): $${data.QST}</p>
                        <strong>Grand Total: $${data.grandTotal}</strong>
                    `;
                }

                cartContainer.innerHTML = cartHtml;

                document.querySelectorAll(".quantity-input").forEach(input => {
                    input.addEventListener("change", function () {
                        let newQuantity = parseInt(this.value);
                        let productId = this.dataset.id;

                        if (isNaN(newQuantity) || newQuantity < 1) {
                            this.value = 1;
                            newQuantity = 1;
                        }

                        updateQuantity(productId, newQuantity);
                    });
                });
            })
            .catch(error => console.error("Error fetching cart:", error));
    }

    function updateQuantity(productId, quantity) {
        fetch("/shopping-cart/src/api/cart.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ id: productId, quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                fetchCart();
            } else {
                alert("Error updating cart: " + data.message);
            }
        })
        .catch(error => console.error("Error updating quantity:", error));
    }
});
