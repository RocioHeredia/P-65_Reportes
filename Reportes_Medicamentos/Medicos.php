<?php
require_once 'funciones.php';
$functions = new funciones();
?>
<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset="UTF-8">
    <title>Médicos</title>
    <link rel="stylesheet" href="style_medicos.css">
</head>
<body>
    <h1 style='text-align: center; margin-top: 20px;'>Médicos</h1>
    <div class='container'>
        <?php
        $medicos = $functions->listarMedicos();
        // var_dump($medicos); //para ver los datos obtenidos con la función
        
        if(!empty($medicos)){
            foreach($medicos as $medico){
                $titulo = 'Dr.';
                
                echo "<div class='card'>";
                echo "<h2>" . $titulo . " ". htmlspecialchars($medico['nombre']). " ". htmlspecialchars($medico['apellido']). "</h2>";
                echo "<p>Especialidad: " . htmlspecialchars($medico['especialidad']). "</p>";
                echo "<p>Matricula: " . htmlspecialchars($medico['matricula']). "</p>";
                echo "<a href='pacientes_medico.php?id=". $medico['id'] . "'>Ver Pacientes</a>";
                echo "</div>";
            }
        }else{
            echo "<p style='text-align: center;  margin-top: 20px;'>No hay médicos disponibles.</p>";
        }
        ?>

    </div>
</body>
</html>
