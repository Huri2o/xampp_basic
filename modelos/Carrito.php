<?php
require_once "conexion.php";

class CarritoModel {
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "ecom2");
    }

    public function getAll() {
        $result = $this->conn->query("SELECT * FROM carrito");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByUsuario($id_usuario) {
        $stmt = $this->conn->prepare("SELECT * FROM carrito WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO carrito (id_usuario, id_producto, cantidad) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $data['id_usuario'], $data['id_producto'], $data['cantidad']);
        return $stmt->execute();
    }

    public function update($id_carrito, $cantidad) {
        $stmt = $this->conn->prepare("UPDATE carrito SET cantidad = ? WHERE id_carrito = ?");
        $stmt->bind_param("ii", $cantidad, $id_carrito);
        return $stmt->execute();
    }

    public function delete($id_carrito) {
        $stmt = $this->conn->prepare("DELETE FROM carrito WHERE id_carrito = ?");
        $stmt->bind_param("i", $id_carrito);
        return $stmt->execute();
    }

    public function vaciarCarrito($id_usuario) {
        $stmt = $this->conn->prepare("DELETE FROM carrito WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        return $stmt->execute();
    }
}
?>
