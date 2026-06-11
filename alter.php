<?php
require 'assets/db.php';
try {
    $pdo->exec("ALTER TABLE socios MODIFY COLUMN estado ENUM('activo', 'inactivo', 'pendiente') DEFAULT 'pendiente'");
    echo "OK";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
