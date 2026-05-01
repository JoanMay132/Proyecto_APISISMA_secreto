<?php
class Folio extends Conexion
{
    
    private $contador = 1;
    private $folio;
    private static $conexion;
    private $tabla;
    private $campo;
    private $reinicio;
    private $query;
    function __construct($tabla, $campo, $query = ""){
        self::$conexion = parent::getConexion();
        $this->tabla = $tabla;
        $this->campo = $campo;
        $this->query = $query;
        $this->reinicio =  date("y");

        $this->setFolio();
    }

    private function Check() : bool{
        $query = self::$conexion->query("SELECT MAX(CAST(SUBSTRING($this->campo, 2, LOCATE('/', $this->campo) - 2) AS UNSIGNED)) as $this->campo  FROM $this->tabla WHERE RIGHT($this->campo, 2) = '$this->reinicio' $this->query ");
        $resul = $query->fetch(PDO::FETCH_ASSOC);

        if(count($resul) ==  0){
            
            return false;
        }
        
        $this->contador = (int)str_replace(array("A","/".$this->reinicio), "", $resul["$this->campo"]);
        return true;
    }

    private function setFolio(){
        if($this->Check()){
            $this->contador++;
        }
        $this->folio = "A".$this->contador."/".$this->reinicio;
    }

    public function getFolio() : string{
        return $this->folio;
        

    }

    public function __destruct() {
        self::$conexion = null; // Cierra la conexión cuando el objeto se destruye
    }
   
}


?>