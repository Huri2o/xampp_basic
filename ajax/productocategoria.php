<?php
require_once '../modelos/ProductoCategoria.php';

header('Content-Type: application/json');

$pc = new ProductoCategoriaModel();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        echo json_encode($pc->getCategoriasPorProducto($data['id_producto']));
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $pc->asignarCategoria($data['id_producto'], $data['id_categoria'])]);
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $data);
        echo json_encode(['success' => $pc->eliminarCategoriasDeProducto($data['id_producto'])]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>
