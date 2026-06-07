<?php
// owntracks.php

// 1) Load PDO connection
require_once '../includes/DB.php';  // adjust this path for your project
$pdo = getPdo();                    // your existing function returning PDO

// 2) Read raw JSON from request body
$json = file_get_contents('php://input');

// Optional: log every payload to a file for debugging
file_put_contents(
    __DIR__ . '/owntracks_log.txt',
    date('Y-m-d H:i:s') . ' ' . $json . PHP_EOL,
    FILE_APPEND
);

$data = json_decode($json, true);

if ($data === null) {
    http_response_code(400);
    echo "Invalid JSON";
    exit;
}

// 3) Basic validation: must have lat, lon, tst
if (!isset($data['lat'], $data['lon'], $data['tst'])) {
    http_response_code(400);
    echo "Missing lat/lon/tst";
    exit;
}

$lat = (float)$data['lat'];
$lon = (float)$data['lon'];
$tst = (int)$data['tst'];          // Unix timestamp

// 4) Get Tracker ID (tid) – 2-char ID from OwnTracks
$tid = isset($data['tid']) ? trim($data['tid']) : 'OT'; // default if missing

// 5) Get Device ID
// OwnTracks doesn’t always send a standard "device" key in JSON;
// depending on setup, device info can be in topic or extra fields.
// For now we look for common possibilities and fall back to something safe.
$deviceId = 'unknown';

if (isset($data['device'])) {
    $deviceId = trim($data['device']);
} elseif (isset($data['deviceId'])) {
    $deviceId = trim($data['deviceId']);
} elseif (isset($data['topic'])) {
    // Example topic could be "owntracks/user/123456"
    // Try to use the last part as deviceId.
    $parts = explode('/', $data['topic']);
    $deviceId = trim(end($parts));
}

// 6) Build car ID as tid + deviceId, e.g. KT + 123456 = KT123456
$truckNo = $tid . $deviceId;

// 7) Insert into DB
$sql = "UPDATE truck set longitude = :lon, latitude = :lat where truck_no = :tno";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'lon' => $lon,
    'lat' => $lat,
    'tno' => $truckNo
]);

echo "OK";
