<?php
require_once "../../config/koneksi.php";
require_once "../../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    sendJson(405, false, "Method tidak diizinkan");
}

$id = (int) ($_GET["id"] ?? 0);

if ($id <= 0) {
    sendJson(400, false, "ID task tidak valid");
}

$stmt = $conn->prepare(
    "SELECT id, title, category, price, stock, image, description, status, created_at
    FROM tasks
    WHERE id = ?
    LIMIT 1"
);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$task = $result->fetch_assoc();

if (!$task) {
    sendJson(404, false, "Task tidak ditemukan");
}

sendJson(
    200,
    true,
    "Detail task berhasil diambil",
    $task
);

