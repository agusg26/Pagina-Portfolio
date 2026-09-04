<?php
require_once __DIR__ . '/../connect.php';

if (!empty($_POST['btnGuardar'])) {
    if (!empty($_POST['nombre']) && !empty($_POST['anio'])) {
        $nombre = trim($_POST['nombre']);
        $anio = (int)$_POST['anio'];
        $estado = (int)$_POST['estado_id'];

        $sql = "INSERT INTO materias (nombre, estado_id, anio, activo) VALUES (?, ?, ?, 1)";
        $stmt = $conn->prepare($sql);

        $stmt->execute([$nombre, $estado, $anio]);

        header("location:../views/index.php#progreso-carrera");
        exit;
    } else {
        echo "Por favor, complete todos los campos";
    }
}
