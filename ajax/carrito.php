<?php
require_once '../modelos/Carrito.php';

header('Content-Type: application/json');

$carrito = new CarritoModel();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        echo json_encode($carrito->getAll());
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $carrito->create($data)]);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $carrito->update($data ['id_carrito'], $data['cantidad'])]);
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $data);
        echo json_encode(['success' => $carrito->delete($data['id_carrito'])]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>