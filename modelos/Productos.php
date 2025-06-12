<?php
require_once "../config/conexion.php";

class ProductoModel {
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "ecom2");
    }

    public function getAll() {
        $result = $this->conn->query("SELECT * FROM productos");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO productos (nombre_producto, descripcion, precio, stock, id_usuario) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdii", $data['nombre_producto'], $data['descripcion'], $data['precio'], $data['stock'], $data['id_usuario']);
        return $stmt->execute();
    }

    public function update($data) {
        $stmt = $this->conn->prepare("UPDATE productos SET nombre_producto=?, descripcion=?, precio=?, stock=?, id_usuario=? WHERE id_producto=?");
        $stmt->bind_param("ssdiis", $data['nombre_producto'], $data['descripcion'], $data['precio'], $data['stock'], $data['id_usuario'], $data['id_producto']);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM productos WHERE id_producto=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

/*     public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM productos WHERE id_producto=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    } */
}
?>
