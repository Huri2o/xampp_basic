<?php
require_once "conexion.php";

class ProductoCategoriaModel {
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "ecom2");
    }

    public function getAll() {
        $result = $this->conn->query("SELECT * FROM producto_categoria");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO producto_categoria (id_producto, id_categoria) VALUES (?, ?)");
        $stmt->bind_param("ii", $data['id_producto'], $data['id_categoria']);
        return $stmt->execute();
    }

    public function update($data) {
        $stmt = $this->conn->prepare("UPDATE producto_categoria SET id_categoria=? WHERE id_producto=?");
        $stmt->bind_param("ii", $data['id_categoria'], $data['id_producto']);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM producto_categoria WHERE id_producto=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM producto_categoria WHERE id_producto=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>