<?php
require_once '../modelos/Categorias.php';

header('Content-Type: application/json');

$categoria = new CategoriasModel();

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        echo json_encode($categoria->getAll());

        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $categoria->create($data)]);
    


        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(['success' => $categoria->update($data)]);
        
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $data);
        echo json_encode(['success' => $categoria->delete($data['id_categoria'])]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
        break;


}


?>