<?php
require '../config.php';

// Handle POST request to update quantity
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['id']) && isset($data['quantity'])) {
        $id = intval($data['id']);
        $quantity = intval($data['quantity']);

        if ($quantity > 0) {
            $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
            $stmt->bind_param("ii", $quantity, $id);
            $stmt->execute();
            $stmt->close();
        } else {
            $stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Fetch cart items
$result = $conn->query("SELECT id, product_name, price, quantity FROM cart_items");
$cartItems = [];
$subtotal = 0;

while ($row = $result->fetch_assoc()) {
    $row['price'] = $row['price'] * $row['quantity']; // Update price based on quantity
    $subtotal += $row['price'];
    $cartItems[] = $row;
}

$GST = round($subtotal * 0.05, 2);
$QST = round($subtotal * 0.09975, 2);
$grandTotal = round($subtotal + $GST + $QST, 2);

// Return JSON response
echo json_encode([
    "status" => "success",
    "items" => $cartItems,
    "subtotal" => number_format($subtotal, 2),
    "GST" => number_format($GST, 2),
    "QST" => number_format($QST, 2),
    "grandTotal" => number_format($grandTotal, 2)
]);

$conn->close();
?>
