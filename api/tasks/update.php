<?php
require_once "../../config/koneksi.php";
require_once "../../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendJson(405, false, "Method tidak diizinkan");
}

$id = (int) ($_POST["id"] ?? 0);
$title = trim($_POST["title"] ?? "");
$description = trim($_POST["description"] ?? "");
$status = trim($_POST["status"] ?? "pending");

if ($id <= 0 || $title === "") {
    sendJson(400, false, "ID dan title wajib valid");
}

if (!in_array($status, ["pending", "done"], true)) {
    sendJson(400, false, "Status tidak valid");
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
    "UPDATE tasks
    SET title = ?, description = ?, status = ?
    WHERE id = ?"
);
$stmt->bind_param(
    "sssi",
    $title,
    $description,
    $status,
    $id
);

if (!$stmt->execute()) {
    sendJson(500, false, "Task gagal diperbarui");
}

sendJson(200, true, "Task berhasil diperbarui");

