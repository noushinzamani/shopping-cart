document.addEventListener("DOMContentLoaded", function () {
    fetchCart();

    function fetchCart() {
        fetch("/shopping-cart/src/api/cart.php")
            .then(response => response.json())
            .then(data => {
                console.log("Cart API Response:", data);

                let cartContainer = document.getElementById("cart");
                if (!cartContainer) {
                    console.error("Cart container not found.");
                    return;
                }

                let cartHtml = "";

                if (!data.items || data.items.length === 0) {
                    cartHtml = "<p>No items in cart.</p>";
                } else {
                    cartHtml += `<table>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>`;

                    data.items.forEach(item => {
                        cartHtml += `<tr>
                            <td>${item.product_name}</td>
                            <td>$${item.price}</td>
                            <td>
                                <input type="number" value="${item.quantity}" data-id="${item.id}" class="quantity-input" min="0">
                            </td>
                        </tr>`;
                    });

                    cartHtml += `</table>`;
                }

                cartContainer.innerHTML = cartHtml;

                // Update the summary
                document.getElementById("subtotal").innerHTML = `Subtotal: $${data.subtotal}`;
                document.getElementById("GST").innerHTML = `GST (5%): $${data.GST}`;
                document.getElementById("QST").innerHTML = `QST (9.975%): $${data.QST}`;
                document.getElementById("grandTotal").innerHTML = `<strong>Grand Total: $${data.grandTotal}</strong>`;

                // Attach event listeners to quantity inputs
                document.querySelectorAll(".quantity-input").forEach(input => {
                    input.addEventListener("change", function () {
                        let newQuantity = parseInt(this.value);
                        let productId = this.dataset.id;

                        if (isNaN(newQuantity) || newQuantity < 0) {
                            this.value = 0; // Set to 0 if invalid
                            newQuantity = 0;
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
                fetchCart(); // Refresh the cart after update
            } else {
                alert("Error updating cart: " + data.message);
            }
        })
        .catch(error => console.error("Error updating quantity:", error));
    }
});
