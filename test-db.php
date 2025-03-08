<?php
require_once 'src/Database.php';

try {
    $db = Database::getInstance();
    echo "✅ Database connection successful!";
} catch (Exception $e) {
    echo "❌ Database error: " . $e->getMessage();
}
?>
