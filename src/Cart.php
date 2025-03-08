<?php
require_once 'Database.php';

class Cart {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getItems() {
        $stmt = $this->db->prepare("SELECT * FROM cart_items");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateQuantity($id, $quantity) {
        $stmt = $this->db->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        return $stmt->execute([$quantity, $id]);
    }
}
?>
