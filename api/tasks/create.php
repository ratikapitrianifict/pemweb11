<?php
require_once "../../config/koneksi.php";
require_once "../../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendJson(405, false, "Method tidak diizinkan");
}

$title = trim($_POST["title"] ?? "");
$description = trim($_POST["description"] ?? "");
$status = trim($_POST["status"] ?? "pending");

$allowedStatus = ["pending", "done"];

if ($title === "") {
    sendJson(400, false, "Title wajib diisi");
}

if (!in_array($status, $allowedStatus, true)) {
    sendJson(400, false, "Status tidak valid");
}

$stmt = $conn->prepare(
    "INSERT INTO tasks (title, description, status)
    VALUES (?, ?, ?)"
);
$stmt->bind_param(
    "sss",
    $title,
    $description,
    $status
);

if (!$stmt->execute()) {
    sendJson(500, false, "Task gagal dibuat");
}

sendJson(
    201,
    true,
    "Task berhasil dibuat",
    ["id" => $stmt->insert_id]
);

