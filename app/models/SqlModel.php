<?php



class SqlModel {

    private $dbh;
    
    public function __construct()
    {
        include ROOT_PATH . "/config/db.inc.php";
        $this->dbh = $dbh;
    }

    public function getToDoList() {

        try {
            $sql = "SELECT id, tarea, responsable, estado, inicio, fin FROM Tareas";
            $query = $this->dbh->query($sql);
            $resultados = $query->fetchAll(PDO::FETCH_ASSOC);

            return $resultados;
        } catch (PDOException $e) {
            echo "Error al descargar tarea: " . $e->getMessage();
        }


    }

    public function agregar($tarea, $responsable, $estado, $inicio, $fin) {
    
        try {
            $sql = "INSERT INTO `Tareas` (`tarea`, `responsable`, `estado`, `inicio`, `fin`) 
            VALUES ('$tarea', '$responsable', '$estado', '$inicio', '$fin')";
            $query = $this->dbh->query($sql);  

            } catch (PDOException $e) {
                echo "Error al agregar tarea: " . $e->getMessage();
            }
        }

        public function eliminar($id) {
    
            try {
                $sql = "DELETE FROM Tareas WHERE `Tareas`.`id` = '$id'";
                $query = $this->dbh->query($sql);   
                $borrado = true;
    
            } catch (PDOException $e) {
                echo "Error al eliminar tarea: " . $e->getMessage();
                $borrado = false;
            }
            return $borrado; 
    
            }

            public function modificar($id, $tarea, $responsable, $estado, $inicio, $fin) {
                try {
                    $sql = "SELECT id, tarea, responsable, estado, inicio, fin FROM Tareas WHERE id = '$id'";
                    $query = $this->dbh->query($sql);
                    $dato = $query->fetchAll(PDO::FETCH_ASSOC);
                    $dato = $dato[0];

                    $existe = true;

                    $newTarea = ($tarea == "") ? $dato["tarea"] : $tarea;
                    $newResponsable = ($responsable == "") ? $dato["responsable"] : $responsable;
                    $newEstado = ($estado == "") ? $dato["estado"] : $estado;
                    $newInicio = ($inicio == "") ? $dato["inicio"] : $inicio;
                    $newFin = ($fin == "") ? $dato["fin"] : $fin;  
                    $sql = "UPDATE Tareas SET tarea = '$newTarea', responsable = '$newResponsable', estado = '$newEstado', inicio = '$newInicio', fin = '$newFin'  WHERE id = '$id'";
                    $query = $this->dbh->query($sql);

                    } catch (PDOException $e) {
                    echo "Estatara no se ha podido modificar " . $e->getMessage();
                    $existe = false;
                }

                return $existe;  
        
            }

        public function borrarLista() {

            try {
                $sql = "TRUNCATE TABLE Tareas";
                $query = $this->dbh->query($sql);   
                $borrado = true;
    
            } catch (PDOException $e) {
                echo "Error al eliminar tarea: " . $e->getMessage();
                $borrado = false;
            }
            return $borrado; 
    
        }
        public function cargarLista() {
            include "data/data.php";
            $sampleData = getSampleData();
            $sql = "TRUNCATE TABLE Tareas";
            $query = $this->dbh->query($sql);  
            
            foreach ($sampleData as $tarea)
            try { 
                $sql = "INSERT INTO `Tareas` (`tarea`, `responsable`, `estado`, `inicio`, `fin`) 
                VALUES ('$tarea[tarea]', '$tarea[responsable]', '$tarea[estado]', '$tarea[inicio]', '$tarea[fin]')";
                $query = $this->dbh->query($sql);      
    
            } catch (PDOException $e) {
                echo "Error al agregar tarea: " . $e->getMessage();
    
            }    
        }

        public function buscar($id, $tarea, $responsable, $estado, $inicio, $fin) {

            try {

                $sql = "SELECT id, tarea, responsable, estado, inicio, fin FROM Tareas";
                $query = $this->dbh->query($sql);
                $datos = $query->fetchAll(PDO::FETCH_ASSOC);

                $busco = ["id"=>$id, "tarea"=>$tarea, "responsable"=>$responsable, "estado"=>$estado, "inicio"=>$inicio, "fin"=>$fin];
                $resultado = [];
                foreach ($datos as $dato) {
                    $j = 0;
                    if ($busco["id"] == "" || $busco["id"] == $dato["id"]) {
                        $j ++;
                    }
                    if ($busco["tarea"] == "" || $busco["tarea"] == $dato["tarea"]) {
                        $j ++;
                    }
                    if ($busco["responsable"] == "" || $busco["responsable"] == $dato["responsable"]) {
                        $j ++;
                    }
                    if ($busco["estado"] == "" || $busco["estado"] == $dato["estado"]) {
                        $j ++;
                    }
                    if ($busco["inicio"] == "" || $busco["inicio"] == $dato["inicio"]) {
                        $j ++;
                    }
                    if ($busco["fin"] == "" || $busco["fin"] == $dato["ifind"]) {
                        $j ++;
                    }
                
                    if ($j == 6) {
                        $resultado [] = $dato;
                    }
                
                }
                
                return $resultado;

        } catch (PDOException $e) {
            echo "Error en la búsqueda: " . $e->getMessage();
        }
    
        }
        

}