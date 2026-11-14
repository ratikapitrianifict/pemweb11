<?php
require_once "../config/response.php";

sendJson(
    200,
    true,
    "Task API aktif",
    [
        "module" => "API Fundamentals",
        "version" => "1.0"
    ]
);

