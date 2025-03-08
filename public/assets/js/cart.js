document.addEventListener("DOMContentLoaded", function() {
    fetch("/shopping-cart/src/api/cart.php")
        .then(response => response.json())
        .then(data => {
            let cartHtml = "";
            data.forEach(item => {
                cartHtml += `<div>
                    <span>${item.product_name} - $${item.price}</span>
                    <input type="number" value="${item.quantity}" data-id="${item.id}">
                </div>`;
            });
            document.getElementById("cart").innerHTML = cartHtml;
        });

    document.addEventListener("change", function(e) {
        if (e.target.tagName === "INPUT") {
            fetch("/shopping-cart/src/api/cart.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    id: e.target.dataset.id,
                    quantity: e.target.value
                })
            });
        }
    });
});
