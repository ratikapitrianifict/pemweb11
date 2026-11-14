<?php
require_once "../../config/koneksi.php";
require_once "../../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendJson(405, false, "Method tidak diizinkan");
}

$id = (int) ($_POST["id"] ?? 0);

if ($id <= 0) {
    sendJson(400, false, "ID task tidak valid");
}

$check = $conn->prepare(
    "SELECT id FROM tasks WHERE id = ? LIMIT 1"
);
$check->bind_param("i", $id);
$check->execute();

if (!$check->get_result()->fetch_assoc()) {
    sendJson(404, false, "Task tidak ditemukan");
}

$stmt = $conn->prepare(
    "DELETE FROM tasks WHERE id = ?"
);
$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    sendJson(500, false, "Task gagal dihapus");
}

sendJson(200, true, "Task berhasil dihapus");

