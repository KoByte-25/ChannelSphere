<?php
// get_truck_position.php
require_once '../includes/DB.php';
$pdo = getPdo();

$oid = isset($_GET['oid']) ? $_GET['oid'] : '';

header('Content-Type: application/json; charset=utf-8');

if ($oid === '') {
    echo json_encode(['error' => 'missing orderId']);
    exit;
}

$sql = "SELECT truck.truck_no, truck.latitude, truck.longitude
        FROM truck
        JOIN delivery ON truck.truck_no = delivery.truck_no
        WHERE delivery.orderId = :oid";

$stmt = $pdo->prepare($sql);
$stmt->execute([':oid' => $oid]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo json_encode(['error' => 'not found']);
    exit;
}

echo json_encode([
    'truck_no' => $row['truck_no'],
    'lat'      => (float)$row['latitude'],
    'lon'      => (float)$row['longitude'],
]);