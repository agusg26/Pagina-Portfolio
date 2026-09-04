<?php
require_once __DIR__ . '/../connect.php';
if (!empty($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "UPDATE materias SET activo = 0 WHERE materias_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    header("location:../views/index.php#progreso-carrera");
    exit;
}

