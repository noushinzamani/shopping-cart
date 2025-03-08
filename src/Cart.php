<?php
require_once 'Database.php';
session_start(); // Start the session

class Cart {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Add item to session cart
    public function addToCart($productId, $quantity) {
        $_SESSION['cart'][$productId] = $quantity;
    }

    public function getItems() {
        $query = "SELECT id, product_name, price, SUM(quantity) as quantity 
                  FROM cart_items 
                  GROUP BY id, product_name, price";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $result;
    }


    // Update quantity in session and database
    public function updateQuantity($id, $quantity) {
        $_SESSION['cart'][$id] = $quantity; // Update session
        $stmt = $this->db->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        return $stmt->execute([$quantity, $id]);
    }
}
?>
