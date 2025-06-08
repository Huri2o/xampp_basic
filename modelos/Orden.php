<?php
require_once "conexion.php";

class OrdenModel {
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "ecom");
    }

    public function getAll() {
        $result = $this->conn->query("SELECT * FROM ordenes");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getByUsuario($id_usuario) {
        $stmt = $this->conn->prepare("SELECT * FROM ordenes WHERE id_usuario = ?");
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO ordenes (id_usuario, total, estado) VALUES (?, ?, ?)");
        $stmt->bind_param("ids", $data['id_usuario'], $data['total'], $data['estado']);
        return $stmt->execute();
    }

    public function update($id_orden, $estado) {
        $stmt = $this->conn->prepare("UPDATE ordenes SET estado = ? WHERE id_orden = ?");
        $stmt->bind_param("si", $estado, $id_orden);
        return $stmt->execute();
    }

    public function delete($id_orden) {
        $stmt = $this->conn->prepare("DELETE FROM ordenes WHERE id_orden = ?");
        $stmt->bind_param("i", $id_orden);
        return $stmt->execute();
    }
}
?>
