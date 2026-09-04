<?php
if (!empty($_POST['btnModificar'])) {
    if (!empty($_POST['nombre']) && !empty($_POST['estado_id']) && !empty($_POST['anio'])) {
        $id = $_POST['id'];
        $nombre = trim($_POST['nombre']);
        $estado = (int)$_POST['estado_id'];
        $anio = (int)$_POST['anio'];
        $sql = "UPDATE materias SET nombre = ?, estado_id = ?, anio = ? WHERE materias_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$nombre, $estado, $anio, $id]);
        header("location:../views/index.php#progreso-carrera");
        exit;
    }
}
