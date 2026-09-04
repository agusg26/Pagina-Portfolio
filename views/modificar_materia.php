<?php
require_once __DIR__ . '/../connect.php';
include_once __DIR__ . '/../Controller/editar_materia.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);
$materia = null;
$error_msg = null;

if ($id > 0) {
    try {
        $stmtMateria = $conn->prepare("SELECT * FROM materias WHERE materias_id = ?");
        $stmtMateria->execute([$id]);
        $materia = $stmtMateria->fetch(PDO::FETCH_ASSOC);
        if (!$materia) {
            $error_msg = "No se encontró la materia especificada.";
        }
    } catch (PDOException $e) {
        $error_msg = "Error al consultar la materia: " . $e->getMessage();
    }
} else {
    $error_msg = "ID de materia no válido.";
}

try {
    $sql = "SELECT estado_id, nombre FROM estados ORDER BY estado_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $estados = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $estados = [];
    if (!$error_msg) {
        $error_msg = "Error al cargar los estados: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Materia | Agustín Guerrero</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../Styles/estilos.css">
</head>

<body class="edit-page-wrapper">
    <!-- Header / Navbar -->
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark container py-2">
            <a class="navbar-brand d-flex align-items-center gap-2" href="index.php">
                <i class="bi bi-code-slash text-info"></i>
                <span>Agustín Guerrero</span>
            </a>

            <div class="ms-auto d-flex align-items-center gap-3">
                <a href="index.php#progreso-carrera" class="btn btn-outline-light btn-sm d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill">
                    <i class="bi bi-arrow-left"></i>
                    <span>Volver al Portfolio</span>
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="edit-main-content">
        <div class="container d-flex justify-content-center">
            <?php if ($materia): ?>
                <div class="edit-card">
                    <div class="edit-card-header">
                        <h2>
                            <i class="bi bi-pencil-square text-info"></i>
                            Modificar Materia
                        </h2>
                        <span class="edit-badge">
                            ID: #<?= htmlspecialchars($materia['materias_id']); ?>
                        </span>
                    </div>

                    <form method="POST" id="form-modificar-materia">
                        <div class="edit-card-body">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($materia['materias_id']); ?>">

                            <!-- Nombre de la Materia -->
                            <div class="mb-4 text-start">
                                <label for="nombre_materia" class="form-label">
                                    <i class="bi bi-journal-text text-primary"></i> Nombre de la materia
                                </label>
                                <div class="custom-input-wrapper">
                                    <i class="bi bi-book input-icon"></i>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="nombre_materia" 
                                        name="nombre" 
                                        placeholder="Ej. Programación II" 
                                        value="<?= htmlspecialchars($materia['nombre']); ?>" 
                                        required 
                                        autocomplete="off"
                                    >
                                </div>
                            </div>

                            <!-- Estado -->
                            <div class="mb-4 text-start">
                                <label for="estado_id" class="form-label">
                                    <i class="bi bi-flag text-primary"></i> Estado académico
                                </label>
                                <div class="custom-input-wrapper">
                                    <i class="bi bi-check-circle input-icon"></i>
                                    <select class="form-select" id="estado_id" name="estado_id" required>
                                        <option value="" disabled>Selecciona el estado...</option>
                                        <?php foreach ($estados as $estado): ?>
                                            <option 
                                                value="<?= $estado['estado_id']; ?>"
                                                <?= ($materia['estado_id'] == $estado['estado_id']) ? 'selected' : ''; ?>
                                            >
                                                <?= htmlspecialchars($estado['nombre']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <!-- Año -->
                            <div class="mb-2 text-start">
                                <label for="anio_materia" class="form-label">
                                    <i class="bi bi-calendar-check text-primary"></i> Año de cursada
                                </label>
                                <div class="custom-input-wrapper">
                                    <i class="bi bi-mortarboard input-icon"></i>
                                    <select class="form-select" id="anio_materia" name="anio" required>
                                        <option value="" disabled>Selecciona el año...</option>
                                        <option value="1" <?= ($materia['anio'] == 1) ? 'selected' : ''; ?>>1° Año</option>
                                        <option value="2" <?= ($materia['anio'] == 2) ? 'selected' : ''; ?>>2° Año</option>
                                        <option value="3" <?= ($materia['anio'] == 3) ? 'selected' : ''; ?>>3° Año</option>
                                        <option value="4" <?= ($materia['anio'] == 4) ? 'selected' : ''; ?>>4° Año</option>
                                        <option value="5" <?= ($materia['anio'] == 5) ? 'selected' : ''; ?>>5° Año</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="edit-card-footer">
                            <a href="index.php#progreso-carrera" class="btn-outline-back">
                                <i class="bi bi-x-lg"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn-primary-gradient" name="btnModificar" value="ok">
                                <i class="bi bi-check2-circle"></i>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            <?php else: ?>
                <div class="edit-card text-center p-4">
                    <div class="py-4">
                        <i class="bi bi-exclamation-triangle-fill text-warning display-4 mb-3 d-block"></i>
                        <h4 class="fw-bold text-dark mb-2">No se pudo cargar la materia</h4>
                        <p class="text-muted mb-4">
                            <?= htmlspecialchars($error_msg ?? 'La materia solicitada no existe o fue dada de baja.'); ?>
                        </p>
                        <a href="index.php#progreso-carrera" class="btn-primary-gradient px-4">
                            <i class="bi bi-arrow-left"></i> Volver a Progreso Carrera
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>