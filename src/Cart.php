<?php
require_once 'Database.php';

class Cart {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getItems() {
        $stmt = $this->db->prepare("SELECT * FROM cart_items"); // Updated table name
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateQuantity($id, $quantity) {
        try {
            // Fetch product unit price
            $stmt = $this->db->prepare("SELECT price FROM cart_items WHERE id = ?");
            $stmt->execute([$id]);
            $item = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$item) {
                return false; // Item not found
            }

            $unit_price = $item['price'];
            $new_total_price = $unit_price * $quantity;

            // Update quantity and total price in the database
            $stmt = $this->db->prepare("UPDATE cart_items SET quantity = ?, price = ? WHERE id = ?");
            return $stmt->execute([$quantity, $new_total_price, $id]);
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
