<?php
require_once "conexion.php";

class DetalleOrdenModel {
    private $conn;

    public function __construct()
    {
        $this->conn = new mysqli("localhost", "root", "", "ecom2");
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

    public function update($data)
    {
        $stmt = $this->conn->prepare("UPDATE detalle_orden SET id_orden=?, id_producto=?, cantidad=?, precio_unitario=? WHERE id_detalle=?");
        $stmt->bind_param("iiidi", $data['id_orden'], $data['id_producto'], $data['cantidad'], $data['precio_unitario'], $data['id_detalle']);
        return $stmt->execute();
    }
    public function delete($id_orden) {
        $stmt = $this->conn->prepare("DELETE FROM detalle_orden WHERE id_orden = ?");
        $stmt->bind_param("i", $id_orden);
        return $stmt->execute();
    }
}
?>
