<?php
require_once 'funciones.php';

if (!isset($_GET['paciente_id'])) {
    echo "<p>No se proporcionó un ID de paciente.</p>";
    exit;
}

$id_paciente = intval($_GET['paciente_id']); 

$functions = new funciones();

$paciente = $functions->ObtenerDetallesPaciente($id_paciente);

$fecha_nacimiento =$paciente['fecha_nacimiento'];
$fecha_solo = date("Y-m-d", strtotime($fecha_nacimiento));

if (!$paciente) {
    echo "<p>No se encontró el paciente.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Medicamentos</title>
    <link rel="stylesheet" href="style_formulario.css">
</head>
<body>
    <div class="pacientes-container">
        <h1>Paciente</h1>
        <p><strong>Nombre y Apellido: </strong><?= htmlspecialchars($paciente['nombre'])?> <?= htmlspecialchars($paciente['apellido'])?></p>
        <p><strong>Fecha de Nacimiento: </strong><?= htmlspecialchars($fecha_solo)?></p>
        <p><strong>Género: </strong><?= htmlspecialchars($paciente['genero'])?></p>
        <p><strong>Departamento: </strong><?= htmlspecialchars($paciente['nombre_departamento'])?></p>
    </div>
    <div class="linea"></div>
        <h3>Seleccione Fecha</h3>
        <form action="Medicamentos.php" method="GET">
        <input type="hidden" name="paciente_id" value="<?= htmlspecialchars($id_paciente) ?>">
        
        <label for="fecha_inicio">Fecha inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?= isset($_GET['fecha_inicio']) ? htmlspecialchars($_GET['fecha_inicio']) : '' ?>">
        
        <label for="fecha_fin">Fecha fin:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" value="<?= isset($_GET['fecha_fin']) ? htmlspecialchars($_GET['fecha_fin']) : '' ?>">
        <button type="submit">Filtrar</button>
    </form>

</body>
</html>