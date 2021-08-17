<?php
class mysql_login{
    protected $servidor;
    protected $usuario;
    protected $contrasenia;
    protected $basedatos;
    protected $puerto;

    public function __construct(){

		$this->servidor="localhost";
        $this->usuario="root";
        $this->contrasenia="AVJ8MS,u?$&$";
        $this->basedatos="social_media";
        $this->puerto=3306;//3306
    }
}
?>