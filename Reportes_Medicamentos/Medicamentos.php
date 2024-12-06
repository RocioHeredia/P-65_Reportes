<?php
require_once 'funciones.php';

if (!isset($_GET['paciente_id'], $_GET['fecha_inicio'], $_GET['fecha_fin'])) {
    echo "<p>Falta información para mostrar los datos.</p>";
    exit;
}

$id_paciente = intval($_GET['paciente_id']);
$fecha_inicio = $_GET['fecha_inicio'];
$fecha_fin = $_GET['fecha_fin'];

$functions = new funciones();

$paciente = $functions->ObtenerDetallesPaciente($id_paciente);
$fecha_nacimiento =$paciente['fecha_nacimiento'];
$fecha_solo = date("Y-m-d", strtotime($fecha_nacimiento));

if (!$paciente) {
    echo "<p>No se encontró el paciente.</p>";
    exit;
}

$medicamentos = $functions->ObtenerMedicamentoPorPacienteYFechas($id_paciente, $fecha_inicio, $fecha_fin);
//var_dump($medicamentos);

if (!$medicamentos) {
    echo "<p>No se encontraron los medicamentos entre esas fechas.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Medicamentos del Paciente</title>
    <link rel="stylesheet" href="style_medicamentos.css">
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
        <h3>Medicamentos</h3>
        <table class="medicamentos-table">
            <thead>
                <tr>
                    <th>Medicamento</th>
                    <th>Laboratorio</th>
                    <th>Dosis</th>
                    <th>Frecuencia</th>
                </tr>
            </thead>
            <tbody>
                <div class="Medicamento-container">
                    <?php
                    if (!empty($medicamentos)){
                        foreach($medicamentos as $medicamento){
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($medicamento['nombre_comercial']) . "</td>";
                            echo "<td>" . htmlspecialchars($medicamento['laboratorio_titular']) . "</td>";
                            echo "<td>" . htmlspecialchars($medicamento['dosis']) . "</td>";
                            echo "<td>" . htmlspecialchars($medicamento['frecuencia']) . "</td>";
                            echo "</tr>";
                        }
                    }else{
                        echo "<tr><td colspan='4'>No hay medicamentos registrados para este Pacientes</td></tr>";
                    }
                    ?>
            </tbody>
        </table>
    </body>
</html>