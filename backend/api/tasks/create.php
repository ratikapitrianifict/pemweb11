<?php
require_once "../../config/koneksi.php";
require_once "../../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendJson(405, false, "Method tidak diizinkan");
}

$title = trim($_POST["title"] ?? "");
$category = trim($_POST["category"] ?? "Elektronik");
$price = (int)($_POST["price"] ?? 0);
$stock = (int)($_POST["stock"] ?? 0);
$image = trim($_POST["image"] ?? "");
$description = trim($_POST["description"] ?? "");
$status = trim($_POST["status"] ?? "ready");

if ($image === "") {
    $image = "https://placehold.co/600x360?text=" . urlencode($title);
}

if ($title === "") {
    sendJson(400, false, "Product / Title wajib diisi");
}

$stmt = $conn->prepare(
    "INSERT INTO tasks (title, category, price, stock, image, description, status)
    VALUES (?, ?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param(
    "ssiisss",
    $title,
    $category,
    $price,
    $stock,
    $image,
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

