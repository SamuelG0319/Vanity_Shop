<?php
require_once('dbconn.php');

// Endpoint para obtener información del producto
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_product_info') {
    // Verificar si el usuario tiene un company_code válido
    session_start();
    $code = null;

    if (isset($_SESSION['company_code']) && $_SESSION['company_code'] !== null) {
        $code = $_SESSION['company_code'];
    }

    // Obtener el código del producto desde la solicitud
    $productCode = isset($_GET['productCode']) ? $_GET['productCode'] : null;

    if ($code !== null && $productCode !== null) {
        // Consultar la base de datos para obtener la información del producto
        try {
            $query = "SELECT * FROM products WHERE product_code = :productCode";
            $stmt = $dbconn->prepare($query);
            $stmt->bindParam(':productCode', $productCode, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                $response = array('status' => 'success', 'price' => $row['price'], 'stock' => $row['stock']);
            } else {
                $response = array('status' => 'error', 'message' => 'Product not found');
            }
        } catch (PDOException $e) {
            $response = array('status' => 'error', 'message' => 'Database error');
        }
    } else {
        $response = array('status' => 'error', 'message' => 'Invalid company code or product code');
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
