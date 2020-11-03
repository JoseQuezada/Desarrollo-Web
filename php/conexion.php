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
		// Conexion Ale
		$this -> servidor  = "localhost";
		$this -> usuario = "root";
		// $this -> password = "Deutschland78a";
		$this -> base = "swpciac";
		$this -> puerto = 3306;

		// Conexion Damian
		$this -> password = "";

        $this->conexion = new mysqli($this->host, $this->usuario, $this->password,$this->base) or die(mysqli_error($this->conexion));


		if (!$this -> conexion) {
			echo "<script>alert('Error en la conexión al servidor');window.location.href='../index.php';</script>";
			exit();
		}


	}

	public function cerrarConexion(){
		mysqli_close($this -> conexion);
	}
}
