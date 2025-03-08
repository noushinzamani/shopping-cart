<?php
require_once '../Cart.php';
header('Content-Type: application/json');

$cart = new Cart();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($cart->getItems());
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if ($cart->updateQuantity($data['id'], $data['quantity'])) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }
}
?>
