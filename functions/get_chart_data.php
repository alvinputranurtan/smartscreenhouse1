<?php

header('Content-Type: application/json');
require_once 'config.php';

$period = $_GET['period'] ?? 'hourly';

if ($period === 'hourly') {
    // Data 24 jam terakhir, rata-rata per jam
    $sql = "SELECT 
                DATE_FORMAT(timestamp, '%H:00') as label,
                ROUND(AVG(NULLIF(kelembaban_tanah, 0)), 1) as kelembaban_tanah,
                ROUND(AVG(NULLIF(kelembaban_udara, 0)), 1) as kelembaban_udara,
                ROUND(AVG(NULLIF(suhu_udara, 0)), 1) as suhu_udara,
                COUNT(*) as sample_count
            FROM data 
            WHERE timestamp >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
                AND kelembaban_tanah IS NOT NULL 
                AND kelembaban_udara IS NOT NULL 
                AND suhu_udara IS NOT NULL
            GROUP BY DATE_FORMAT(timestamp, '%Y-%m-%d %H')
            ORDER BY timestamp ASC";
} else {
    // Data 7 hari terakhir, rata-rata per hari
    $sql = "SELECT 
                DATE_FORMAT(timestamp, '%d/%m') as label,
                ROUND(AVG(NULLIF(kelembaban_tanah, 0)), 1) as kelembaban_tanah,
                ROUND(AVG(NULLIF(kelembaban_udara, 0)), 1) as kelembaban_udara,
                ROUND(AVG(NULLIF(suhu_udara, 0)), 1) as suhu_udara,
                COUNT(*) as sample_count
            FROM data 
            WHERE timestamp >= DATE_SUB(NOW(), INTERVAL 7 DAY)
                AND kelembaban_tanah IS NOT NULL 
                AND kelembaban_udara IS NOT NULL 
                AND suhu_udara IS NOT NULL
            GROUP BY DATE_FORMAT(timestamp, '%Y-%m-%d')
            ORDER BY timestamp ASC";
}

$result = $conn->query($sql);
$data = [
    'labels' => [],
    'kelembaban_tanah' => [],
    'kelembaban_udara' => [],
    'suhu_udara' => [],
];

while ($row = $result->fetch_assoc()) {
    $data['labels'][] = $row['label'];
    $data['kelembaban_tanah'][] = (float) $row['kelembaban_tanah'];
    $data['kelembaban_udara'][] = (float) $row['kelembaban_udara'];
    $data['suhu_udara'][] = (float) $row['suhu_udara'];
}

echo json_encode($data);
