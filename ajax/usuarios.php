<?php
require_once '../modelos/Usuarios.php';

header('Content-Type: application/json');

$usuario = new UsuarioModel();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        echo json_encode($usuario->getAll());
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $usuario->create($data)]);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $usuario->update($data)]);
        
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $data);
        echo json_encode(['succes' => $usuario->delete($data['id_usuario'])]);
        break;


    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;


}


?>