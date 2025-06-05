<?php
require_once "conexion.php";

class ProductoCategoriaModel {
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "ecom");
    }

    public function getCategoriasPorProducto($id_producto) {
        $stmt = $this->conn->prepare("SELECT c.* FROM categorias c JOIN producto_categoria pc ON c.id_categoria = pc.id_categoria WHERE pc.id_producto = ?");
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function asignarCategoria($id_producto, $id_categoria) {
        $stmt = $this->conn->prepare("INSERT INTO producto_categoria (id_producto, id_categoria) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_producto, $id_categoria);
        return $stmt->execute();
    }

    public function eliminarCategoriasDeProducto($id_producto) {
        $stmt = $this->conn->prepare("DELETE FROM producto_categoria WHERE id_producto = ? AND id_categoria = ? ");
        $stmt->bind_param("i", $id_producto);
        return $stmt->execute();
    }
}
?>
