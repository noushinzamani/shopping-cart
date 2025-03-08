<?php
require_once '../Cart.php';
header('Content-Type: application/json');

$cart = new Cart();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $items = $cart->getItems();

    // Calculate subtotal
    $subtotal = 0;
    foreach ($items as $item) {
        $subtotal += $item['price'] * $item['quantity'];
    }

    // Calculate taxes
    $GST = $subtotal * 0.05; // 5% GST
    $QST = $subtotal * 0.09975; // 9.975% QST
    $grandTotal = $subtotal + $GST + $QST; // Final total

    // Send structured response
    echo json_encode([
        "items" => $items,
        "subtotal" => number_format($subtotal, 2, '.', ''),
        "GST" => number_format($GST, 2, '.', ''),
        "QST" => number_format($QST, 2, '.', ''),
        "grandTotal" => number_format($grandTotal, 2, '.', '')
    ]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id']) && isset($data['quantity']) && $data['quantity'] >= 0) {
        if ($cart->updateQuantity($data['id'], $data['quantity'])) {
            // Fetch updated cart data after update
            $items = $cart->getItems();
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }

            $GST = $subtotal * 0.05;
            $QST = $subtotal * 0.09975;
            $grandTotal = $subtotal + $GST + $QST;

            echo json_encode([
                "status" => "success",
                "items" => $items,
                "subtotal" => number_format($subtotal, 2, '.', ''),
                "GST" => number_format($GST, 2, '.', ''),
                "QST" => number_format($QST, 2, '.', ''),
                "grandTotal" => number_format($grandTotal, 2, '.', '')
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update quantity."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid input data."]);
    }
}
?>
