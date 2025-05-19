<?php
require_once 'conexion.php';
header('Content-Type: application/json');
$logFile = 'login.log';

// Validar permisos de escritura
if (!file_exists($logFile)) {
    if (!is_writable(__DIR__)) {
        echo json_encode(["succes" => false, "message" => "No hay permisos"]);
        exit;
    }
}

// Función para guardar log
function guardarLog($usuario, $estado)
{
    global $logFile;
    $fecha = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'N/A';
    $navegador = $_SERVER['HTTP_USER_AGENT'] ?? 'N/A';
    $entrada = "[$fecha] IP: [$ip] - Usuario: [$usuario] - Estado: [$estado] Navegador: [$navegador]\n";
    file_put_contents($logFile, $entrada, FILE_APPEND);
}

// Leer JSON
$input = json_decode(file_get_contents('php://input'), true);

// Verificar que sea POST y que se reciban datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $input) {
    $nombre = $conexion->real_escape_string($input['nombre'] ?? '');
    $pass = $conexion->real_escape_string($input['pass'] ?? '');

    $sql = "SELECT * FROM usuarios WHERE nombre = '$nombre' AND contrasena = '$pass'";
    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows === 1) {
        guardarLog($nombre, "Éxito");
        echo json_encode(["succes" => true, "message" => "Bienvenido, $nombre"]);
    } else {
        guardarLog($nombre, "Fallo");
        echo json_encode(["succes" => false, "message" => "Acceso denegado"]);
    }
} else {
    // Asegura que exista $nombre, aunque sea vacío
    $nombre = $input['nombre'] ?? 'desconocido';
    guardarLog($nombre, "Error de datos");
    echo json_encode(["succes" => false, "message" => "Acceso denegado, revise los datos"]);
}
