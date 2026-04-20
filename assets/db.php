<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '1234';
$dbname = 'cooperativa_db';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Set fetch mode to associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Error de Conexion: " . $e->getMessage());
}

// Funciones Auxiliares para el Frontend
function checkLogin() {
    if(!isset($_SESSION['socio_id'])) {
        header("Location: login.php");
        exit;
    }
}

function isLoggedIn() {
    return isset($_SESSION['socio_id']);
}

function formatCurrency($amount) {
    return "Gs. " . number_format($amount, 0, ',', '.');
}
?>
