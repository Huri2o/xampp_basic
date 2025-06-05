<?php
require_once "conexion.php";

class DetalleOrdenModel {
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "ecom");
    }

    public function getByOrden($id_orden) {
        $stmt = $this->conn->prepare("SELECT * FROM detalle_orden WHERE id_orden = ?");
        $stmt->bind_param("i", $id_orden);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data) {
        $stmt = $this->conn->prepare("INSERT INTO detalle_orden (id_orden, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $data['id_orden'], $data['id_producto'], $data['cantidad'], $data['precio_unitario']);
        return $stmt->execute();
    }

    public function deleteByOrden($id_orden) {
        $stmt = $this->conn->prepare("DELETE FROM detalle_orden WHERE id_orden = ?");
        $stmt->bind_param("i", $id_orden);
        return $stmt->execute();
    }
}
?>
