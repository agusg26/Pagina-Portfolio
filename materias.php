<?php
require_once __DIR__ . '/connect.php';

try {
    // Consulta para obtener las materias finalizadas (Aprobadas / estado_id = 3)
    $sql = "SELECT m.materias_id, m.nombre, m.anio, m.activo,e.nombre AS estado 
            FROM materias m 
            INNER JOIN estados e ON m.estado_id = e.estado_id 
            WHERE m.estado_id = 3 AND m.activo = 1
            ORDER BY m.anio ASC, m.materias_id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $materias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $materias = [];
    $error_msg = $e->getMessage();
}
?>

<div class="table-responsive mt-4">
    <button class="btn btn-outline-light" style="margin-bottom: 10px;" id="btn-editar" type="button">Editar</button>
    <table class="table table-hover table-bordered table-striped shadow-sm align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th scope="col" style="width: 10%;">#</th>
                <th scope="col" class="text-start">Materia</th>
                <th scope="col" style="width: 20%;">Año</th>
                <th scope="col" style="width: 25%;">Estado</th>
                <th scope="col" class="col-oculta" style="width: 25%;">Eliminar</th>
                <th scope="col" class="col-oculta" style="width: 25%;">Editar</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($materias)): ?>
                <?php foreach ($materias as $index => $materia): ?>
                    <tr id="fila-<?php echo $materia['materias_id']; ?>">
                        <th scope="row" class="text-center"><?php echo $index + 1; ?></th>
                        <td class="fw-semibold text-start"><?php echo htmlspecialchars($materia['nombre']); ?></td>
                        <td class="text-center">
                            <span class="badge bg-secondary"><?php echo htmlspecialchars($materia['anio']); ?>° Año</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success px-3 py-2">
                                <?php echo htmlspecialchars($materia['estado']); ?>
                            </span>
                        </td>
                        <!--Botones ocultos-->
                        <td class="col-oculta text-center">
                            <a type="button" class="btn btn-danger"
                                href="eliminar_materia.php?id=<?= $materia['materias_id']; ?>">
                                Eliminar</a>
                        </td>
                        <td class="col-oculta text-center">
                            <button type="button" class="btn btn-primary"
                                href="materias.php?id=<?= $materia['materias_id']; ?>">
                                Editar</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center text-muted py-3">
                        <?php echo isset($error_msg) ? "Error al consultar la base de datos: " . htmlspecialchars($error_msg) : "No hay materias finalizadas registradas."; ?>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Modal Flotante: Agregar Materia -->
<div class="col-oculta" id="modal-agregar-materia" class="modal-overlay-blur" aria-hidden="true" role="dialog">
    <div class="modal-card-float">
        <div class="modal-card-header">
            <h5>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-journal-plus" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 5.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V10a.5.5 0 0 1-1 0V8.5H6a.5.5 0 0 1 0-1h1.5V6a.5.5 0 0 1 .5-.5z" />
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z" />
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z" />
                </svg>
                Agregar Materia
            </h5>
        </div>
        <form action="agregar_materia.php" method="POST" id="form-agregar-materia">
            <div class="modal-card-body">
                <div class="mb-3 text-start">
                    <label for="nombre_materia" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre_materia" name="nombre" placeholder="Ej. Programación II" required autocomplete="off">
                </div>
                <div class="mb-3 text-start">
                    <label for="anio_materia" class="form-label">Año</label>
                    <select class="form-select" id="anio_materia" name="anio" required>
                        <option value="" selected disabled>Selecciona el año...</option>
                        <option value="1">1° Año</option>
                        <option value="2">2° Año</option>
                        <option value="3">3° Año</option>
                        <option value="4">4° Año</option>
                        <option value="5">5° Año</option>
                    </select>
                </div>
                <input type="hidden" name="estado_id" value="3">
            </div>
            <div class="modal-card-footer">
                <button type="submit" class="btn btn-primary d-inline-flex align-items-center gap-2"
                    name="btnGuardar" value="ok">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>