<?php
require_once __DIR__ . '/moi-truong.php';

header('Content-Type: application/json; charset=utf-8');

echo json_encode([
    'contractAddress' => $_ENV['CONTRACT_ADDRESS'] ?? ''
]);