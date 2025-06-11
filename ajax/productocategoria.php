<?php
require_once '../modelos/ProductoCategoria.php';

header('Content-Type: application/json');

$productoCategoria = new ProductoCategoriaModel();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        echo json_encode($productoCategoria->getAll());
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $productoCategoria->create($data)]);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $productoCategoria->update($data)]);
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $data);
        echo json_encode(['success' => $productoCategoria->delete($data['id_producto'])]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>