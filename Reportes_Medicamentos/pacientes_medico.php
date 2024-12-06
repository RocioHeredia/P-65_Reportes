<?php
require_once 'funciones.php';

if (!isset($_GET['id'])) {
    echo "<p>No se proporcionó un ID de médico.";
}

$id_medico = intval($_GET['id']); 

$functions = new funciones();

$medico = $functions->ObtenerDetallesMedico($id_medico);

if (!$medico) {
   echo "<p>No se encontró el médico.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pacientes del Doctor</title>
    <link rel="stylesheet" href="style_pacientes.css">
</head>
<body>
    <h1><strong>Dr. </strong><?= htmlspecialchars($medico['nombre']) ?> <?= htmlspecialchars($medico['apellido']) ?></h1>
    <p><strong>Especialidad:</strong><?= htmlspecialchars($medico['especialidad']) ?></p>
    <p><strong>Matricula:</strong><?= htmlspecialchars($medico['matricula']) ?></p>
    <h3>Pacientes:</h3>
    <div class="pacientes-container">
        <?php
        $pacientes = $functions->ObtenerPacientesPorMedico($id_medico);
        //var_dump($pacientes); //para ver los datos obtenidos con la función
        if (!empty ($pacientes)) {
            foreach($pacientes as $paciente){
                $fecha_nacimiento = $paciente['fecha_nacimiento'];
                $fecha_solo = date("Y-m-d", strtotime($fecha_nacimiento));
                
                echo "<div class='paciente'>";
                echo "<div class='info-paciente'>";
                echo "<strong>Nombre: </strong>" . htmlspecialchars($paciente['nombre']). " ". htmlspecialchars($paciente['apellido']). "<br>";
                echo "<strong>Fecha de Nacimiento: </strong>" . htmlspecialchars($fecha_solo). "</br>";
                echo "<strong>Género: </strong>" . htmlspecialchars($paciente['genero']). "</br>";
                echo "<strong>Departamento: </strong>" . htmlspecialchars($paciente['departamento']). "</br>";
                echo "</div>";
                echo "<form action='Ver_Medicamentos.php' method='GET'>";
                echo "<input type='hidden' name='paciente_id' value='" . htmlspecialchars($paciente['id']) . "'>";                
                echo "<button type='submit' class='boton'>Ver Medicamentos</button>";
                echo "</form>";
                echo "</div>";
            
            }
        }else {
            echo "<p>No hay pacientes para este médico.</p>";
        }
        ?>
    </div>
</body>

</html>