<?php
// get_truck_position.php
require_once '../includes/DB.php';
$pdo = getPdo();

$tno = isset($_GET['tno']) ? $_GET['tno'] : '';

header('Content-Type: application/json; charset=utf-8');

if ($tno === '') {
    echo json_encode(['error' => 'missing truck_no']);
    exit;
}

$sql = "SELECT * FROM truck WHERE truck_no = :tno";

$stmt = $pdo->prepare($sql);
$stmt->execute([':tno' => $tno]);
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