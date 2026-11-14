<?php
require_once "../../config/koneksi.php";
require_once "../../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    sendJson(405, false, "Method tidak diizinkan");
}

$result = $conn->query(
    "SELECT id, title, category, price, stock, image, description, status, created_at
    FROM tasks
    ORDER BY id DESC"
);

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

sendJson(
    200,
    true,
    "Data task berhasil diambil",
    $tasks
);

