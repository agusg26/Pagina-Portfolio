<?php
require_once "connect.php";
if (!empty($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "UPDATE materias SET activo = 0 WHERE materias_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    header("location:index.php#progreso-carrera");
    exit;
}

