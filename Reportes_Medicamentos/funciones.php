<?php

    require_once 'Connection.php';

    class funciones extends Connection {
        private $connection;

        public function __construct(){
            parent::__construct();
            $this->connection = $this->connect();
        }

        public function EstadoConexion(){
            if($this->connection instanceof PDO){
                return 'Conexión Existosa';
            }else{
                return 'ERROR EN LA CONEXIÓN';
            }
        }

        public function listarMedicos(){
            $sql = 'SELECT id,matricula,nombre, apellido, especialidad FROM medicos';
        
            try{

                $stmt = $this->connection->prepare($sql);
                $stmt->execute();

                $medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                return $medicos;
            }catch(PDOException $e){
                echo 'ERROR: '. $e->getMenssage();
                return [];
            }
        }

        public function ObtenerDetallesMedico($id){
            $sql="SELECT nombre, apellido, especialidad, matricula
                    FROM medicos
                    WHERE id = ?";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id]);
        
            return $stmt->fetch(PDO::FETCH_ASSOC);

        }

        public function ObtenerPacientesPorMedico($id_medico){
            $sql = "SELECT p.id, p.nombre, p.apellido, p.fecha_nacimiento, 
                    g.nombre AS genero, d.nombre_departamento AS departamento
                    FROM pacientes p
                    JOIN medico_pacientes mp ON p.id = mp.rela_paciente
                    LEFT JOIN generos g ON g.id =p.rela_genero
                    LEFT JOIN departamentos d ON d.id=p.rela_departamento
                    WHERE rela_medico=? ";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id_medico]);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function ObtenerDetallesPaciente($id_paciente){
            $sql = "SELECT p.nombre, p.apellido, p.fecha_nacimiento, 
                        g.nombre AS genero, d.nombre_departamento
                        FROM pacientes p
                        JOIN generos g ON p.rela_genero = g.id
                        JOIN departamentos d ON p.rela_departamento = d.id
                        WHERE p.id = ?";

            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id_paciente]);
        
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function ObtenerMedicamentoPorPacienteYFechas($id_paciente, $fecha_inicio, $fecha_fin) {
            $sql = "SELECT m.id_medicamento AS id, 
                           m.nombre_comercial, 
                           m.laboratorio_titular, 
                           rmp.dosis, 
                           rmp.frecuencia
                    FROM medicamentos m
                    JOIN medicamentos_pacientes rmp ON m.id_medicamento = rmp.rela_medicamento
                    WHERE rmp.rela_paciente = ? 
                      AND (rmp.fecha_alta BETWEEN ? AND ? OR rmp.fecha_alta IS NULL)";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->execute([$id_paciente, $fecha_inicio, $fecha_fin]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        

    }

?>