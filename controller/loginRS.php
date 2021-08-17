<?php
ini_set("memory_limit", "900M");
date_default_timezone_set('America/Lima');
$_POST = json_decode(file_get_contents("php://input"), true);

$result = array(
    'status' => '-1',
    'msg' => 'Error en el controlador.'
);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["email"]) && isset($_POST["IDaccount"]) && isset($_POST["redSocial"])) {
        require_once('../model/usuario.php');
        require_once('../component/database.php');

        $conexion = new database();
        $usuario = new usuario($conexion->getCurrentConnection());

        $email = trim($_POST['email']);
        $IDaccount = trim($_POST['IDaccount']);
        $redSocial = 'facebook';

        $data = $usuario->loginRS($email,$IDaccount,$redSocial);

        var_dump($data);
    }
}