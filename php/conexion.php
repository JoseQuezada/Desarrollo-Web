<?php
class Conexion
{ 

	private $servidor;
	private $usuario;
	private $base;
	private $puerto;
	private $password;

	public $conexion;

	function __construct()
	{
		
		$this -> servidor  = "localhost";
		$this -> usuario = "root";
		
		$this -> base = "swpcigc";
		$this -> puerto = 3306;

		
		$this -> password = "";

        $this->conexion = new mysqli($this->servidor, $this->usuario, $this->password,$this->base, $this -> puerto) or die(mysqli_error($this->conexion));


		if (!$this -> conexion) {
			echo "<script>alert('Error en la conexión al servidor');window.location.href='../index.php';</script>";
			exit();
		}


	}

	public function cerrarConexion(){
		mysqli_close($this -> conexion);
	}
}
