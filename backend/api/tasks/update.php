<?php
require_once "../../config/koneksi.php";
require_once "../../config/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    sendJson(405, false, "Method tidak diizinkan");
}

$id = (int) ($_POST["id"] ?? 0);
$title = trim($_POST["title"] ?? "");
$category = trim($_POST["category"] ?? "");
$price = isset($_POST["price"]) ? (int)$_POST["price"] : null;
$stock = isset($_POST["stock"]) ? (int)$_POST["stock"] : null;
$description = trim($_POST["description"] ?? "");
$status = trim($_POST["status"] ?? "");

if ($id <= 0 || $title === "") {
    sendJson(400, false, "ID dan title/nama produk wajib valid");
}

$check = $conn->prepare(
    "SELECT id, category, price, stock, description, status FROM tasks WHERE id = ? LIMIT 1"
);
$check->bind_param("i", $id);
$check->execute();
$current = $check->get_result()->fetch_assoc();

if (!$current) {
    sendJson(404, false, "Produk tidak ditemukan");
}

$category = ($category !== "") ? $category : $current["category"];
$price = ($price !== null) ? $price : $current["price"];
$stock = ($stock !== null) ? $stock : $current["stock"];
$description = ($description !== "") ? $description : $current["description"];
$status = ($status !== "") ? $status : $current["status"];

$stmt = $conn->prepare(
    "UPDATE tasks
    SET title = ?, category = ?, price = ?, stock = ?, description = ?, status = ?
    WHERE id = ?"
);
$stmt->bind_param(
    "ssiissi",
    $title,
    $category,
    $price,
    $stock,
    $description,
    $status,
    $id
);

if (!$stmt->execute()) {
    sendJson(500, false, "Gagal memperbarui produk");
}

sendJson(200, true, "Produk berhasil diperbarui");

